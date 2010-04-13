<?php

require_once 'BaseAtomAdapter.php';

class AtomLinkAdapter extends BaseAtomAdapter {
	const TAG_NAME = 'link';
	
	public function __construct($data, $data_is_url=false) {
		parent::__construct(self::TAG_NAME, $data, $data_is_url);
	}
	
	public function getHref() {
		return (string)$this->_atomNode->attributes()->href;
	}
	
	public function getRel() {
		return (string)$this->_atomNode->attributes()->rel;
	}
	
	public function getType() {
		return (string)$this->_atomNode->attributes()->type;
	}
	
	public function getHreflang() {
		return (string)$this->_atomNode->attributes()->hreflang;
	}
	
	public function getTitle() {
		return (string)$this->_atomNode->attributes()->title;
	}
	
	public function getLength() {
		return (string)$this->_atomNode->attributes()->length;
	}
	
	public function setHref($value) {
		$this->_settleAttribute('href');
		$this->_atomNode->attributes()->href = $value;
	}
	
	public function setRel($value) {
		$this->_settleAttribute('rel');
		$this->_atomNode->attributes()->rel = $value;
	}
	
	public function setType($value) {
		$this->_settleAttribute('type');
		$this->_atomNode->attributes()->type = $value;
	}
	
	public function setHreflang($value) {
		$this->_settleAttribute('hreflang');
		$this->_atomNode->attributes()->hreflang = $value;
	}
	
	public function setTitle($value) {
		$this->_settleAttribute('title');
		$this->_atomNode->attributes()->title = $value;
	}
	
	public function setLength($value) {
		$this->_settleAttribute('length');
		$this->_atomNode->attributes()->length = $value;
	}
}