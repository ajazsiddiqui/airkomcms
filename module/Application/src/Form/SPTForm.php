<?php

namespace Application\Form;

use Laminas\Form\Form;

class SPTForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addElements();
    }

    public function addElements()
    {
		$this->add(['name' => 'stage', 'options' => ['label' => 'Stage'], 'type' => 'Select']);
		$this->add(['name' => 'propect_name', 'options' => ['label' => 'Propect Name'], 'type' => 'Select']);
		$this->add(['name' => 'lead_source', 'options' => ['label' => 'Lead Source'], 'type' => 'Select']);
		$this->add(['name' => 'executive', 'options' => ['label' => 'Executive'], 'type' => 'Select']);
		$this->add(['name' => 'offer_no', 'options' => ['label' => 'Offer No'], 'type' => 'Text']);
		$this->add(['name' => 'sales_stage', 'options' => ['label' => 'Sales Stage'], 'type' => 'Select']);
		$this->add(['name' => 'product_series', 'options' => ['label' => 'Product Series'], 'type' => 'Select']);
		$this->add(['name' => 'product_model', 'options' => ['label' => 'Product Model'], 'type' => 'Select']);
		$this->add(['name' => 'actual_product', 'options' => ['label' => 'Actual Product'], 'type' => 'Select']);
		$this->add(['name' => 'forecasted_booking_value', 'options' => ['label' => 'Forecasted Booking Value'], 'type' => 'Text']);
		$this->add(['name' => 'discount_offered', 'options' => ['label' => 'Discount Offered'], 'type' => 'Text']);
		$this->add(['name' => 'quanitity', 'options' => ['label' => 'Quanitity'], 'type' => 'Number']);
		$this->add(['name' => 'expected_close_date', 'options' => ['label' => 'Expected Close Date'], 'type' => 'Text']);
		$this->add(['name' => 'expected_month', 'options' => ['label' => 'Expected Month', 'value_options'=>['0'=>'Select','1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December']], 'type' => 'Select']);
	$this->add(['name' => 'close_probability', 'options' => ['label' => 'Close Probability'], 'type' => 'Select']);
		$this->add(['name' => 'next_action', 'options' => ['label' => 'Next Action'], 'type' => 'Select']);
		$this->add(['name' => 'last_contacted_date', 'options' => ['label' => 'Last Contacted Date'], 'type' => 'Text']);
		$this->add(['name' => 'remarks', 'options' => ['label' => 'Remarks'], 'type' => 'Text']);
		$this->add(['name' => 'contacted_type', 'options' => ['label' => 'Contacted Type'], 'type' => 'Select']);
		$this->add(['name' => 'contact', 'options' => ['label' => 'Contact'], 'type' => 'Text']);

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
