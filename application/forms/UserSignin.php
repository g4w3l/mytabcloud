<?php

class Application_Form_UserSignin extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
		$this->setName('signin');
		
		$formname = new Zend_Form_Element_Hidden('formname');
		$formname->setValue($this->getName());
		
		// Element Login
		$login = new Zend_Form_Element_Text('login');
		$login->setLabel('Login')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
			  
		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('Password')
				 ->setRequired(true)
				 ->addFilter('StripTags')
				 ->addFilter('StringTrim')
				 ->addValidator('NotEmpty');
		
		$this->addElement($formname)
			 ->addElement($login)
			 ->addElement($password)
			 ->addElement('submit','submit', array (
				'ignore'		=> true,
				'label'			=> 'Sign in'));
    }


}

