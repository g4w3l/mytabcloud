<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
		
		$this->addElement('text', 'login', array (
				'label' 		=> 'Login',
				'required'		=> true,
				'filters'		=> array('StripTags','StringTrim'),
				'validators'	=> array('NotEmpty')
			)			
		);
    }


}

