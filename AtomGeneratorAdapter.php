<?php

require_once 'StandardAtomAdapter.php';

class AtomGeneratorAdapter extends StandardAtomAdapter {
	
	public function getUri() {
		return $this->_getAttribute(AtomNS::URI_ATTRIBUTE);
	}
	
	public function getVersion() {
		return $this->_getAttribute(AtomNS::VERSION_ATTRIBUTE);
	}
	
	public function setUri($value) {
		$this->_setAttribute(AtomNS::URI_ATTRIBUTE, $value);
	}
	
	public function setVersion($value) {
		$this->_setAttribute(AtomNS::VERSION_ATTRIBUTE, $value);
	}
	
	public function __construct($data, $data_is_url=false) {
		parent::__construct(AtomNS::GENERATOR_ELEMENT, $data, $data_is_url);
	}
}