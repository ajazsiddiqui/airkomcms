<?php

namespace Cards\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Cards\Entity\Cards;
use User\Entity\User;
use Cards\Form\GalleryForm;

class GalleryController extends AbstractActionController 
{
    private $entityManager;
    private $ExtranetUtilities;
    private $GalleryManager;

    public function __construct($entityManager, $ExtranetUtilities, $GalleryManager)
    {
        $this->entityManager = $entityManager;
        $this->ExtranetUtilities = $ExtranetUtilities;
        $this->GalleryManager = $GalleryManager;
    }

    public function indexAction() 
    {
        // Get the list of already saved files.
        $files = $this->GalleryManager->getSavedFiles();
        
        // Render the view template.
        return new ViewModel([
            'files'=>$files
        ]);
    }
	
	public function fileAction() 
    {
        // Get the file name from GET variable.
        $fileName = $this->params()->fromQuery('name', '');

        // Check whether the user needs a thumbnail or a full-size image.
        $isThumbnail = (bool)$this->params()->fromQuery('thumbnail', false);
    
        // Get path to image file.
        $fileName = $this->GalleryManager->getImagePathByName($fileName);
        
        if($isThumbnail) {
        
            // Resize the image.
            $fileName = $this->GalleryManager->resizeImage($fileName);
        }
                
        // Get image file info (size and MIME type).
        $fileInfo = $this->GalleryManager->getImageFileInfo($fileName);        
        if ($fileInfo===false) {
            // Set 404 Not Found status code
            $this->getResponse()->setStatusCode(404);            
            return;
        }
                
        // Write HTTP headers.
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: " . $fileInfo['type']);        
        $headers->addHeaderLine("Content-length: " . $fileInfo['size']);
            
        // Write file content.
        $fileContent = $this->GalleryManager->getImageFileContent($fileName);
        if($fileContent!==false) {                
            $response->setContent($fileContent);
        } else {        
            // Set 500 Server Error status code.
            $this->getResponse()->setStatusCode(500);
            return;
        }
        
        if($isThumbnail) {
            // Remove temporary thumbnail image file.
            unlink($fileName);
        }
        
        // Return Response to avoid default view rendering.
        return $this->getResponse();
    }    
	
	 public function uploadAction() 
    {
        // Create the form model.
        $form = new GalleryForm();
        
        // Check if user has submitted the form.
        if($this->getRequest()->isPost()) {
            
            // Make certain to merge the files info!
            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            
            // Pass data to form.
            $form->setData($data);
                
            // Validate form.
            if($form->isValid()) {
                    
                // Move uploaded file to its destination directory.
                $data = $form->getData();
                    
                // Redirect the user to "Image Gallery" page.
                return $this->redirect()->toRoute('gallery');
            }                        
        } 
        
        // Render the page.
        return new ViewModel([
                     'form' => $form
                 ]);
    }
}
