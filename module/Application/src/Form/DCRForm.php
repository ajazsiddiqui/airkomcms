<?php

namespace Application\Form;

use Laminas\Form\Form;

class DCRForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addElements();
    }

    public function addElements()
    {
		$this->add(['name' => 'visit_date', 'options' => ['label' => 'Visit Date', ], 'type' => 'Text']);
		$this->add(['name' => 'start_period', 'options' => ['label' => 'Start Period', ], 'type' => 'Text']);
		$this->add(['name' => 'end_period', 'options' => ['label' => 'End Period', ], 'type' => 'Text']);
		$this->add(['name' => 'dcr_no', 'options' => ['label' => 'Dcr No', ], 'type' => 'Text']);
		$this->add(['name' => 'travel_type', 'options' => ['label' => 'Travel Type', ], 'type' => 'Select']);
		$this->add(['name' => 'call_type', 'options' => ['label' => 'Call Type', ], 'type' => 'Select']);
		$this->add(['name' => 'call_count', 'options' => ['label' => 'Call Count', ], 'type' => 'Number']);
		$this->add(['name' => 'contact_id', 'options' => ['label' => 'Contact', ], 'type' => 'Select']);
		$this->add(['name' => 'product_series', 'options' => ['label' => 'Product Series', ], 'type' => 'Select']);
		$this->add(['name' => 'product_model', 'options' => ['label' => 'Product Model', ], 'type' => 'Select']);
		$this->add(['name' => 'product_id', 'options' => ['label' => 'Actual Product', ], 'type' => 'Select']);
		$this->add(['name' => 'quanitity', 'options' => ['label' => 'Quanitity', ], 'type' => 'Number']);
		$this->add(['name' => 'order_value', 'options' => ['label' => 'Order Value', ], 'type' => 'Text']);
		$this->add(['name' => 'sales_stage', 'options' => ['label' => 'Sales Stage', ], 'type' => 'Select']);
		$this->add(['name' => 'next_action', 'options' => ['label' => 'Next Action', ], 'type' => 'Select']);
		$this->add(['name' => 'remarks', 'options' => ['label' => 'Remarks', ], 'type' => 'Text']);
		$this->add(['name' => 'Bike_km_reading_start', 'options' => ['label' => 'Bike KM Reading Start', ], 'type' => 'Number']);
		$this->add(['name' => 'bike_km_reading_end', 'options' => ['label' => 'Bike KM Reading End', ], 'type' => 'Number']);
		$this->add(['name' => 'distance_travelled', 'options' => ['label' => 'Distance Travelled', ], 'type' => 'Text']);
		$this->add(['name' => 'amount_one', 'options' => ['label' => 'Amount One', ], 'type' => 'Text']);
		$this->add(['name' => 'travel_mode', 'options' => ['label' => 'Travel Mode', ], 'type' => 'Select']);
		$this->add(['name' => 'amount_two', 'options' => ['label' => 'Amount Two', ], 'type' => 'Text']);



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
