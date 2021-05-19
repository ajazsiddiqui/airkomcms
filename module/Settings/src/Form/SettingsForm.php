<?php

namespace Settings\Form;

use Laminas\Form\Form;

class SettingsForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addElements();
    }

    public function addElements()
    {
        $this->add(['name' => 'company_name', 'options' => ['label' => 'Company'], 'type' => 'Text']);
        $this->add(['name' => 'company_brief', 'options' => ['label' => 'Company Brief'], 'type' => 'Textarea']);
        $this->add(['name' => 'contact', 'options' => ['label' => 'Corporate Contact'], 'type' => 'Text']);
        $this->add(['name' => 'email', 'options' => ['label' => 'Corporate Email'], 'type' => 'Text']);

        
        $this->add(['name' => 'page_title', 'options' => ['label' => 'Page Title'], 'type' => 'Text']);
        $this->add(['name' => 'page_keywords', 'options' => ['label' => 'Page Keywords'], 'type' => 'Text']);
        $this->add(['name' => 'page_description', 'options' => ['label' => 'Page Description'], 'type' => 'Text']);
        $this->add(['name' => 'distance_travel_percentage', 'options' => ['label' => 'Distance Travel Percentage'], 'type' => 'Text']);

        $this->add(['name' => 'name_emailer', 'options' => ['label' => 'Name of Emailer', 'disable_inarray_validator' => true], 'type' => 'Text']);
        $this->add(['name' => 'email_emailer', 'options' => ['label' => 'Email of Emailer', 'disable_inarray_validator' => true], 'type' => 'Email']);
        
        $this->add(['name' => 'sms_enabled', 'options' => ['label' => 'SMS Enabled', 'value_options' => ['0' => 'No',    '1' => 'Yes']], 'type' => 'Select']);
        $this->add(['name' => 'sms_api', 'options' => ['label' => 'SMS API'], 'type' => 'Text']);
        $this->add(['name' => 'sendgrid_api', 'options' => ['label' => 'Sendgrid API'], 'type' => 'Text']);
        
        $this->add(['name' => 'created_by', 'type' => 'Hidden']);
        $this->add(['name' => 'submit',    'attributes' => ['type' => 'submit', 'value' => 'Submit', 'id' => 'submitbutton', 'class' => 'btn btn-success']]);
    }
}
