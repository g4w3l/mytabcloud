<?php

class Application_Form_Search extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
		$this->setName('searchform');

		$formname = new Zend_Form_Element_Hidden('formname');
		$formname->setValue($this->getName());

		// Element Login
		$q = new Zend_Form_Element_Text('q');
		$q->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
			  
					  
		$this->addElement($formname)
			 ->addElement($q);
    }


}

