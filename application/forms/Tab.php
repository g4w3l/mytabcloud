<?php

class Application_Form_Tab extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
		$this->setName('tabcreate');
		
		$artist = new Zend_Form_Element_Text('artist');
		$artist->setLabel('Artist')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
			  
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
			  
		$description = new Zend_Form_Element_Text('description');
		$description->setLabel('Description')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
		
		$nbStrings = new Zend_Form_Element_Text('nb_strings');
		$nbStrings->setLabel('Nb Strings')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty')
			  ->addValidator('Int')
			  ->addValidator(new Zend_Validate_GreaterThan(0));
			  
		$capo = new Zend_Form_Element_Text('capo');
		$capo->setLabel('Nb Strings')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty')
			  ->addValidator('Int');
			  			  
		$this->addElement($artist)
			 ->addElement($title)	
			 ->addElement($description)
			 ->addElement($nbStrings)		
			 ->addElement($capo);
    }


}

