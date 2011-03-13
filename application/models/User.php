<?php

class Application_Model_User
{
	// Attribut de l'objet
	protected $_id;
	protected $_login;
	protected $_mail;
	protected $_password;
	protected $_name;
	protected $_created;
	protected $_role;
	
	// Mapper
	protected $_mapper;
	
	/**
	 * Constructeur
	 */
	public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
 	/**
	 * Setter générique
	 */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }
 
 	/**
	 * Getter générique
	 */
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        return $this->$method();
    }
	
	/**
	 * Initialisation à partir d'un tableau de données
	 */
	public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
            	// Appel dynamique au setter
                $this->$method($value);
            }
        }
        return $this;
    }
	
	public function getId() { return $this->_id; }
	public function setId($id) {
		$this->_id = (int)$id;
		return $this;
	}
	
	public function getLogin() { return $this->_login; }
	public function setLogin($login) {
		$this->_login = (string)$login;
		return $this;
	}
	
	public function getMail() { return $this->_mail; }
	public function setMail($mail) {
		$this->_mail = (string)$mail;
		return $this;
	}
	
	public function getPassword() { return $this->_password; }
	public function setPassword($password) {
		$this->_password = (string)$password;
		return $this;
	}
	
	public function getName() { return $this->_name; }
	public function setName($name) {
		$this->_name = (string)$name;
		return $this;
	}
	
	public function getCreated() { return $this->_created; }
	public function setCreated($created) {
		$this->_created = $created;
		return $this;
	}
	
	public function getRole() { return $this->_role; }
	public function setRole($role) {
		$this->_role = $role;
		return $this;
	}
}

