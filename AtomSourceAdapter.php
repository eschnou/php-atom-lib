<?php

require_once 'ExtensibleAtomAdapter.php';
require_once 'SimpleAtomAdapter.php';
require_once 'AtomTextConstructAdapter.php';
require_once 'AtomLinkAdapter.php';
require_once 'AtomPersonConstructAdapter.php';
require_once 'AtomDateConstructAdapter.php';
require_once 'AtomCategoryAdapter.php';

class AtomSourceAdapter extends ExtensibleAtomAdapter  {
	protected $_author;
	protected $_category;
	protected $_id;
	protected $_link;
	protected $_title;
	protected $_updated;
	
	public function addAuthor() {
		$newAuthor = $this->_addElement(AtomNS::NAMESPACE, AtomNS::AUTHOR_ELEMENT);
		return $this->_author[] = new AtomPersonConstructAdapter(AtomNS::AUTHOR_ELEMENT, $newAuthor);
	}
	
	public function addCategory() {
		$newCategory = $this->_addElement(AtomNS::NAMESPACE, AtomNS::CATEGORY_ELEMENT);
		return $this->_category[] = new AtomCategoryAdapter($newCategory);
	}
	
	public function addLink() {
		$newLink = $this->_addElement(AtomNS::NAMESPACE, AtomNS::LINK_ELEMENT);
		return $this->_link[] = new AtomLinkAdapter($newLink);
	}
	
	public function getAuthor() {
		return $this->_author;
	}
	
	public function getCategory() {
		return $this->_category;
	}
	
	public function getId() {
		return $this->_id;
	}
	
	public function getLink() {
		return $this->_link;
	}

	public function getTitle() {
		return $this->_title; 
	}
	
	public function getUpdated() {
		return $this->_updated;
	}
	
	public function setId($value) {
		if (!isset($this->_id)) {
			$id = $this->_addElement(AtomNS::NAMESPACE, AtomNS::ID_ELEMENT, $value);
			$this->_id = new SimpleAtomAdapter(AtomNS::ID_ELEMENT, $id);
			return;
		}
		$this->_id->value = $value;
	}
	
	public function setTitle($value) {
		if (!isset($this->_title)) {
			$title = $this->_addElement(AtomNS::NAMESPACE, AtomNS::TITLE_ELEMENT, $value);
			$this->_title = new AtomTextConstructAdapter(AtomNS::TITLE_ELEMENT, $title);
			return;
		}
		$this->_title->value = $value;
	}
	
	public function setUpdated($value) {
		if (!isset($this->_updated)) {
			$updated = $this->_addElement(AtomNS::NAMESPACE, AtomNS::UPDATED_ELEMENT, $value);
			$this->_updated = new AtomDateConstructAdapter(AtomNS::UPDATED_ELEMENT, $updated);
			return;
		}
		$this->_updated->value = $value;
	}
	
	public function __construct($adapterType, $data, $data_is_url=false) {
		parent::__construct($adapterType, $data, $data_is_url);
		$this->_init();
	}
	
	protected function _init() {
		
		if (isset($this->_element[AtomNS::TITLE_ELEMENT][0])) {
			$this->_title = new AtomTextConstructAdapter(AtomNS::TITLE_ELEMENT, $this->_element[AtomNS::TITLE_ELEMENT][0]);	
		}	
		
		if (isset($this->_element[AtomNS::ID_ELEMENT][0])) {
			$this->_id = new SimpleAtomAdapter(AtomNS::ID_ELEMENT, $this->_element[AtomNS::ID_ELEMENT][0]);
		}
		
		$this->_link = array();
		if (isset($this->_element[AtomNS::LINK_ELEMENT])) {
			foreach ($this->_element[AtomNS::LINK_ELEMENT] as $link) {
				$this->_link[] = new AtomLinkAdapter($link);
			}
		}
		
		$this->_category = array();
		if (isset($this->_element[AtomNS::CATEGORY_ELEMENT])) {
			foreach ($this->_element[AtomNS::CATEGORY_ELEMENT] as $category) {
				$this->_category[] = new AtomCategoryAdapter($category);
			}
		}
		
		$this->_author = array();
		if (isset($this->_element[AtomNS::AUTHOR_ELEMENT])) {
			foreach ($this->_element[AtomNS::AUTHOR_ELEMENT] as $author) {
				$this->_author[] = new AtomPersonConstructAdapter(AtomNS::AUTHOR_ELEMENT, $author);
			}
		}
		
		if (isset($this->_element[AtomNS::UPDATED_ELEMENT][0])) {
			$this->_updated = new AtomDateConstructAdapter(AtomNS::UPDATED_ELEMENT,$this->_element[AtomNS::UPDATED_ELEMENT][0]);
		}
	}
}