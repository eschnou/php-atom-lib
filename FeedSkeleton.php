<?php

require_once 'ExtendableAtomAdapter.php';
require_once 'AtomTextConstructAdapter.php';
require_once 'AtomIdAdapter.php';
require_once 'AtomLinkAdapter.php';
require_once 'AtomPersonConstructAdapter.php';
require_once 'AtomDateConstructAdapter.php';

class FeedSkeleton extends ExtendableAtomAdapter  {
	protected $_title;
	protected $_id;
	protected $_link;
	protected $_author;
	protected $_updated;
	
	protected function _init() {
		//$this->_title = $this->fetchChild('AtomTextConstructAdapter', $this->_atomNode->title, 'title');
		$this->_title = new AtomTextConstructAdapter('title', &$this->_atomNode->title);		
		
		//$this->_id = $this->fetchChild('AtomIdAdapter', $this->_atomNode->id);
		$this->_id = new AtomIdAdapter(&$this->_atomNode->id);
		
		$this->_link = array();
		foreach ($this->_atomNode->link as $link) {
			//$this->_link[] = $this->fetchChild('AtomLinkAdapter', $link);
			$this->_link[] = new AtomLinkAdapter(&$link);
		}
		
		$this->_author = array();
		foreach ($this->_atomNode->author as $author) {
			//$this->_author[] = $this->fetchChild('AtomPersonConstructAdapter', $author, 'author');
			$this->_author[] = new AtomPersonConstructAdapter('author', &$author);
		}
		
		//$this->_updated = $this->fetchChild('AtomDateConstructAdapter', $this->_atomNode->updated, 'updated');
		$this->_updated = new AtomDateConstructAdapter('updated',&$this->_atomNode->updated);
	}
	
	public function __construct($adapterType, $data, $data_is_url=false) {
		parent::__construct($adapterType, $data, $data_is_url);
		$this->_init();
	}

	public function getTitle() {
		return $this->_title; 
	}
	
	public function getId() {
		return $this->_id;
	}
	
	public function getLink() {
		return $this->_link;
	}
	
	public function getAuthor() {
		return $this->_author;
	}
	
	public function getUpdated() {
		return $this->_updated;
	}	
	
	public function addAuthor() {
		$newAuthor = $this->_atomNode->addChild('author');
		return $this->_author[] = new AtomPersonConstructAdapter('author', $newAuthor);
	}
	
	public function addLink() {
		$newLink = $this->_atomNode->addChild('link');
		return $this->_link[] = new AtomLinkAdapter($newLink);
	}
}