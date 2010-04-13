<?php

require_once 'BaseAtomAdapter.php';

class AtomTextConstructAdapter extends BaseAtomAdapter {
	
	public function __construct($adapterType, &$data, $data_is_url=false) {
		parent::__construct($adapterType, $data, $data_is_url);
	}
	
	public function getType() {
		return (string)$this->_atomNode->attributes()->type;
	}
	
	public function setType($value) {
		$this->_settleAttribute('type');		
		$this->_atomNode->attributes()->type = $value;
	}
}