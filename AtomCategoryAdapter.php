<?php

require_once 'StandardAtomAdapter.php';

class AtomCategoryAdapter extends StandardAtomAdapter {

	public function getLabel() {
		return $this->_getAttribute(AtomNS::LABEL_ATTRIBUTE);
	}
	
	public function getScheme() {
		return $this->_getAttribute(AtomNS::SCHEME_ATTRIBUTE);
	}
	
	public function getTerm() {
		return $this->_getAttribute(AtomNS::TERM_ATTRIBUTE);
	}
	
	public function setLabel($value) {
		$this->_setAttribute(AtomNS::LABEL_ATTRIBUTE, $value);
	}
	
	public function setScheme($value) {
		$this->_setAttribute(AtomNS::SCHEME_ATTRIBUTE, $value);
	}
	
	public function setTerm($value) {
		$this->_setAttribute(AtomNS::TERM_ATTRIBUTE, $value);
	}
	
	public function __construct($data, $data_is_url=false) {
		parent::__construct(AtomNS::CATEGORY_ELEMENT, $data, $data_is_url);
	}
}