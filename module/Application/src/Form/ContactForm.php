<?php

namespace Application\Form;

use Laminas\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addElements();
    }

    public function addElements()
    {
		$this->add(
            [
                'name' => 'name',
                'options' => [
                    'label' => 'Name',
                ],
                'type' => 'Text',
            ]
        );
        $this->add(
            [
                'name' => 'designation',
                'options' => [
                    'label' => 'Designation',
                ],
                'type' => 'Text',
            ]
        );
        $this->add(
            [
                'name' => 'company',
                'options' => [
                    'label' => 'Company',
                ],
                'type' => 'Text',
            ]
        );
        $this->add(
            [
                'name' => 'city',
                'options' => [
                    'label' => 'City',
                ],
                'type' => 'Text',
            ]
        );
        $this->add(
            [
                'name' => 'address',
                'options' => [
                    'label' => 'Address',
                ],
                'type' => 'Text',
            ]
        );
        $this->add(
            [
                'name' => 'telephone',
                'options' => [
                    'label' => 'Telephone',
                ],
                'type' => 'Text',
            ]
        );
        $this->add(
            [
                'name' => 'email',
                'options' => [
                    'label' => 'Email',
                ],
                'type' => 'email',
            ]
        );
        $this->add(
            [
                'name' => 'website',
                'options' => [
                    'label' => 'Website',
                ],
                'type' => 'Text',
            ]
        );


        $this->add(
            [
                'name' => 'created_by',
                'type' => 'hidden',
            ]
        );

        $this->add(
            [
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => 'Submit',
                    'id' => 'submitbutton',
                    'class' => 'btn btn-success',
                ],
            ]
        );
    }
}
