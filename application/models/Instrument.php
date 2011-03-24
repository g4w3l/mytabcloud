<?php

class Application_Model_Instrument
{
    // Attributs
    protected $_id;
    protected $_name;
    
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
	 * Setter g�n�rique
	 */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid instrument property');
        }
        $this->$method($value);
    }
 
 	/**
	 * Getter g�n�rique
	 */
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid tab property');
        }
        return $this->$method();
    }    
    
    /**
	 * Initialisation � partir d'un tableau de donn�es
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
	
	public function getName() { return $this->_name; }
	public function setName($name) {
		$this->_name = $name;
		return $this;
	}
			
}

