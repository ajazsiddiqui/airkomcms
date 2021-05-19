<?php

namespace Masters\Form;

use Laminas\Form\Form;

class ContactedTypeForm extends Form
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
                'name' => 'status',
                'options' => [
                    'label' => 'Status',
                    'value_options' => [
                        'checked_value' => '1',
                        'unchecked_value' => '0',
                    ],
                ],
                'type' => 'Checkbox',
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
