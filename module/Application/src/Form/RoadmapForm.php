<?php

namespace Application\Form;

use Laminas\Form\Form;

class RoadmapForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addElements();
    }

    public function addElements()
    {
		$this->add(['name' => 'week', 'options' => ['label' => 'Week', 'value_options'=>['0'=>'Select Week','1'=>'Week 1','2'=>'Week 2','3'=>'Week 3','4'=>'Week 4']], 'type' => 'Select']);
		$this->add(['name' => 'market_segment', 'options' => ['label' => 'Market Segment', ], 'type' => 'Select']);
		$this->add(['name' => 'prospect_name', 'options' => ['label' => 'Prospect Name', ], 'type' => 'Text']);
		$this->add(['name' => 'prospect_city', 'options' => ['label' => 'Prospect City', ], 'type' => 'Text']);
		$this->add(['name' => 'propspect_machine', 'options' => ['label' => 'Propspect Machine', ], 'type' => 'Text']);
		$this->add(['name' => 'product_series', 'options' => ['label' => 'Product Series', ], 'type' => 'Select']);
		$this->add(['name' => 'product_model', 'options' => ['label' => 'Product Model', ], 'type' => 'Select']);
		$this->add(['name' => 'product', 'options' => ['label' => 'Product', ], 'type' => 'Select']);
		$this->add(['name' => 'next_action', 'options' => ['label' => 'Next Action', ], 'type' => 'Select']);
		$this->add(['name' => 'expected_quanitity', 'options' => ['label' => 'Expected Quanitity', ], 'type' => 'Number']);
		$this->add(['name' => 'expected_potential_order_value', 'options' => ['label' => 'Expected Potential Order Value', ], 'type' => 'Text']);



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
