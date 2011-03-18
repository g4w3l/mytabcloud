<?php

class Application_Model_TabPreset
{
    // Attributs
    protected $_id;
    protected $_name;
    protected $_nbStrings;
	protected $_capo;
	protected $_tuning;
    
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
            throw new Exception('Invalid tab property');
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
		
	public function getNbStrings() { return $this->_nbStrings; }
	public function setNbStrings($nbStrings) {
		$this->_nbStrings = (int)$nbStrings;
		return $this;
	}
	
	public function getCapo() { return $this->_capo; }
	public function setCapo($capo) {
		$this->_capo = (int)$capo;
		return $this;
	}
	
	public function getTuning() { return $this->_tuning; }
	public function setTuning($tuning) {
		$this->_tuning = $tuning;
		return $this;
	}
	
}

