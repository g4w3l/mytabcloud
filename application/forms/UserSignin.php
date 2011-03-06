<?php

class Application_Form_UserSignin extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
		$this->setName('signin');
		
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
				 ->addValidator('NotEmpty')
				 ->addValidator('StringLength', false, array(6,15));
		
		$this->addElement($login)
			 ->addElement($password)
			 ->addElement('submit','submit', array (
				'ignore'		=> true,
				'label'			=> 'Sign in'));
    }


}

