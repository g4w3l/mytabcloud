<?php

class Application_Model_Tab
{
    // Attributs
    protected $_id;
    protected $_artist;
    protected $_title;
    protected $_nbStrings;
    protected $_content;
	protected $_capo;
	protected $_tuning;
	protected $_description;
	protected $_instrument;
	protected $_instrumentname;
    protected $_user;
	protected $_username;
	protected $_visibility;
	protected $_lastBeat;
	protected $_created;
	    
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
	
	public function getDescription() { return $this->_description; }
	public function setDescription($description) {
		$this->_description = $description;
		return $this;
	}
	
	public function getInstrument() { return $this->_instrument; }
	public function setInstrument($instrument) {
		$this->_instrument = $instrument;
		return $this;
	}
	
	public function getInstrumentName() { return $this->_instrumentname; }
	public function setInstrumentName($instrumentname) {
		$this->_instrumentname = $instrumentname;
		return $this;
	}
	
	public function getContent() { return $this->_content; }
	public function setContent($content) {
		$this->_content = $content;
		return $this;
	}
	
	public function getContentAsAnArray() {
		$contentArray = array();		
		$count = (int)($this->getLastBeat()+NB_BEATS-($this->getLastBeat()%NB_BEATS));
		for ($string = 0 ; $string < $count ; $string++) {
			for($beat = 0 ; $beat < ((int)$this->getLastBeat())+NB_BEATS-($this->getLastBeat()%NB_BEATS) ; $beat++) {
				$contentArray[$string][$beat] = "";
			}
		}
		
		foreach($this->getContent() as $note) {
			$contentArray[$note->getString()][$note->getBeat()] = $note->getFret();
		}
		
		return $contentArray;
	}
	
	public function getUser() { return $this->_user; }
	public function setUser($user) {
		$this->_user = (int)$user;
		return $this;
	}
	
	public function getUserName() { return $this->_username; }
	public function setUserName($username) {
		$this->_username = $username;
		return $this;
	}
	
	public function getVisibility() { return $this->_visibility; }
	public function setVisibility($visibility) {
		$this->_visibility = $visibility;
		return $this;
	}

	public function getLastBeat() { return $this->_lastBeat; }
	public function setLastBeat($lastBeat) {
		$this->_lastBeat = $lastBeat;
		return $this;
	}
	
	public function getCreated() { return $this->_created; }
	public function setCreated($created) {
		$this->_created = $created;
		return $this;
	}
}

