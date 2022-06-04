<?php

namespace Application\Form;

use Laminas\Form\Form;

class SPTCloseForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addElements();
		$this->setFilters();
    }

    public function addElements()
    {
		$this->add(['name' => 'stage', 'options' => ['label' => 'Stage'], 'type' => 'Select']);
		$this->add(['name' => 'propect_name', 'options' => ['label' => 'Propect Name'], 'type' => 'Select']);
		$this->add(['name' => 'closed_date', 'options' => ['label' => 'Closed Date'], 'type' => 'Text']);

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
	
	public function setFilters()
    {
        $this->getInputFilter()->get('stage')->setRequired(false);
        $this->getInputFilter()->get('propect_name')->setRequired(false);
    }
}
