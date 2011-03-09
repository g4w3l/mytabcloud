<?php

class Application_Model_Tab
{
    // Attributs
    protected $_id;
    protected $_artist;
    protected $_title;
    protected $_nbStrings;
    protected $_content;
    protected $_user;
    
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
            throw new Exception('Invalid tab property');
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
            throw new Exception('Invalid tab property');
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
	
	public function getArtist() { return $this->_artist; }
	public function setArtist($artist) {
		$this->_artist = $artist;
		return $this;
	}
	
	public function getTitle() { return $this->_title; }
	public function setTitle($title) {
		$this->_title = $title;
		return $this;
	}
	
	public function getNbStrings() { return $this->_nbStrings; }
	public function setNbStrings($nbStrings) {
		$this->_nbStrings = (int)$nbStrings;
		return $this;
	}
	
	public function getContent() { return $this->_content; }
	public function setContent($content) {
		$this->_content = $content;
		return $this;
	}
	
	public function getUser() { return $this->_user; }
	public function setUser($user) {
		$this->_user = (int)$user;
		return $this;
	}

}

