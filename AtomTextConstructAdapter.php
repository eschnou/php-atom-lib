<?php

require_once 'StandardAtomAdapter.php';

class AtomTextConstructAdapter extends StandardAtomAdapter {
	
	public function getType() {
		return $this->_getAttribute(AtomNS::TYPE_ATTRIBUTE);
	}
	
	public function setType($value) {
		$this->_setAttribute(AtomNS::TYPE_ATTRIBUTE, $value);
	}
}