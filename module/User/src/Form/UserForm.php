<?php

namespace User\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\InputFilter\ArrayInput;
use Laminas\InputFilter as IFilter;
use Laminas\InputFilter\InputFilter;
use User\Validator\UserExistsValidator;

/**
 * This form is used to collect user's email, full name, password and status. The form
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, user
 * enters password, in 'update' scenario he/she doesn't enter password.
 */
class UserForm extends Form
{
    protected $_dir;
    /**
     * Scenario ('create' or 'update').
     *
     * @var string
     */
    private $scenario;

    /**
     * Entity manager.
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Current user.
     *
     * @var User\Entity\User
     */
    private $user;

    /**
     * Constructor.
     *
     * @param mixed      $dir
     * @param mixed      $scenario
     * @param null|mixed $entityManager
     * @param null|mixed $user
     */
    public function __construct($dir, $scenario = 'create', $entityManager = null, $user = null)
    {
        // Define form name
        parent::__construct('user-form');

        $this->_dir = $dir;
        $this->setAttribute('enctype', 'multipart/form-data');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->user = $user;

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        $profilepic = new Element\File('profile_pic');
        $profilepic->setLabel('Profile Image')
            ->setAttribute('required', false)
        ;
        $this->add($profilepic);

        // Add "email" field
        $this->add(
            [
                'type' => 'text',
                'name' => 'email',
                'options' => [
                    'label' => 'E-mail',
                ],
            ]
        );

        // Add "full_name" field
        $this->add(
            [
                'type' => 'text',
                'name' => 'full_name',
                'options' => [
                    'label' => 'Full Name',
                ],
            ]
        );
		
		 // Add "designation" field
        $this->add(
            [
                'type' => 'text',
                'name' => 'designation',
                'options' => [
                    'label' => 'Designation',
                ],
            ]
        );

        // Add "contact_no" field
        $this->add(
            [
                'type' => 'text',
                'name' => 'contact_no',
                'options' => [
                    'label' => 'Contact',
                ],
            ]
        );

        // Add "user_type" field
        $this->add(
            [
                'type' => 'select',
                'name' => 'user_type',
                'options' => [
                    'label' => 'User Type',
                ],
            ]
        );

        if ('create' == $this->scenario) {
            // Add "password" field
            $this->add(
                [
                    'type' => 'password',
                    'name' => 'password',
                    'options' => [
                        'label' => 'Password',
                    ],
                ]
            );

            // Add "confirm_password" field
            $this->add(
                [
                    'type' => 'password',
                    'name' => 'confirm_password',
                    'options' => [
                        'label' => 'Confirm password',
                    ],
                ]
            );
        }

        // Add "status" field
        $this->add(
            [
                'type' => 'select',
                'name' => 'status',
                'options' => [
                    'label' => 'Status',
                    'value_options' => [
                        1 => 'Active',
                        2 => 'Retired',
                    ],
                ],
            ]
        );

        // Add "roles" field
        $this->add(
            [
                'type' => 'select',
                'name' => 'roles',
                'attributes' => [
                    'multiple' => 'multiple',
                ],
                'options' => [
                    'label' => 'Role(s)',
                ],
            ]
        );
		
		// Add "branch" field
        $this->add(
            [
                'type' => 'select',
                'name' => 'branch',
                'options' => [
                    'label' => 'Branch',
                ],
            ]
        );

        // Add the Submit button
        $this->add(
            [
                'type' => 'submit',
                'name' => 'submit',
                'attributes' => [
                    'value' => 'Create',
                ],
            ]
        );
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "email" field
        $inputFilter->add(
            [
                'name' => 'email',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 128,
                        ],
                    ],
                    [
                        'name' => 'EmailAddress',
                        'options' => [
                            'allow' => \Laminas\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck' => false,
                        ],
                    ],
                    [
                        'name' => UserExistsValidator::class,
                        'options' => [
                            'entityManager' => $this->entityManager,
                            'user' => $this->user,
                        ],
                    ],
                ],
            ]
        );

        // Add input for "full_name" field
        $inputFilter->add(
            [
                'name' => 'full_name',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 512,
                        ],
                    ],
                ],
            ]
        );

        if ('create' == $this->scenario) {
            // Add input for "password" field
            $inputFilter->add(
                [
                    'name' => 'password',
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 6,
                                'max' => 64,
                            ],
                        ],
                    ],
                ]
            );

            // Add input for "confirm_password" field
            $inputFilter->add(
                [
                    'name' => 'confirm_password',
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'Identical',
                            'options' => [
                                'token' => 'password',
                            ],
                        ],
                    ],
                ]
            );
        }

        // Add input for "status" field
        $inputFilter->add(
            [
                'name' => 'status',
                'required' => true,
                'filters' => [
                    ['name' => 'ToInt'],
                ],
                'validators' => [
                    ['name' => 'InArray', 'options' => ['haystack' => [1, 2]]],
                ],
            ]
        );

        // Add input for "roles" field
        $inputFilter->add(
            [
                'class' => ArrayInput::class,
                'name' => 'roles',
                'required' => true,
                'filters' => [
                    ['name' => 'ToInt'],
                ],
                'validators' => [
                    ['name' => 'GreaterThan', 'options' => ['min' => 0]],
                ],
            ]
        );

        $fileInput = new IFilter\FileInput('profile_pic');
        $fileInput->setRequired(false);
        $fileInput->getValidatorChain()
            ->attachByName('filesize', ['max' => '10048000'])
            ->attachByName('filemimetype', ['mimeType' => 'image/png, image/x-png, image/jpeg'])
        ;
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            [
                'target' => $this->_dir,
                'randomize' => true,
            ]
        );
        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }
}
