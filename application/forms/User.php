<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
		$this->setName('signup');
		
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
				 
		$password_confirm = new Zend_Form_Element_Password('password_confirm');
		$password_confirm->setLabel('Password (confirm)')
				 ->setRequired(true)
				 ->addFilter('StripTags')
				 ->addFilter('StringTrim')
				 ->addValidator('NotEmpty')
				 ->addValidator('Identical', false, array('token' => 'password'));
				 
		$mail = new Zend_Form_Element_Text('mail');
		$mail->setLabel('E-Mail Address')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('EmailAddress');
		
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Name')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
			  
		$this->addElement($login)
			 ->addElement($password)	
			 ->addElement($password_confirm)
			 ->addElement($mail)		
			 ->addElement($name)
			 ->addElement('submit','submit', array (
				'ignore'		=> true,
				'label'			=> 'Signup'));
    }


}

