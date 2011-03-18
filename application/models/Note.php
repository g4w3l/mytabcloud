<?php

class Application_Model_Note
{
	// Attributs
	protected $_string;
	protected $_fret;
	protected $_beat;
	protected $_tab;
	
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
            throw new Exception('Invalid note property');
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
            throw new Exception('Invalid note property');
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
	
	
	public function getString() { return $this->_string; }
	public function setString($string) {
		$this->_string = (int)$string;
		return $this;
	}
	
	public function getFret() { return $this->_fret; }
	public function setFret($fret) {
		$this->_fret = (int)$fret;
		return $this;
	}
	
	public function getBeat() { return $this->_beat; }
	public function setBeat($beat) {
		$this->_beat = (int)$beat;
		return $this;
	}
	
	public function getTab() { return $this->_tab; }
	public function setTab($tab) {
		$this->_tab = (int)$tab;
		return $this;
	}

}

