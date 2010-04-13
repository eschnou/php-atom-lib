<?php

require_once 'ExtendableAtomAdapter.php';

class AtomPersonConstructAdapter extends ExtendableAtomAdapter {
	protected $_name;
	protected $_uri;
	protected $_email;
	
	public function __construct($adapterType, $data, $data_is_url=false) {
		parent::__construct($adapterType, $data, $data_is_url);
	}
	
	public function getName() {
		return (string)$this->_atomNode->name;
	}
	
	public function getUri() {
		return (string)$this->_atomNode->uri;
	}
	
	public function getEmail() {
		return (string)$this->_atomNode->email;
	}
	
	protected function _settleElement($object) {
		if (!isset($object)) {
			$this->_atomNode->addAttribute($attribute,'');
		}
	}
	
	public function setName($value) {
		$this->_atomNode->name = $value;
	}
	
	public function setUri($value) {
		$this->_atomNode->uri = $value;
	}
	
	public function setEmail($value) {
		$this->_atomNode->email = $value;
	}
}