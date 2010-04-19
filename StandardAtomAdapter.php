<?php

require_once 'SimpleAtomAdapter.php';

class StandardAtomAdapter extends SimpleAtomAdapter {

	protected function _getAttribute($attribute, $namespace=null) {
		return (string)$this->_atomNode->attributes($namespace)->$attribute;
	}
	
	protected function _setAttribute($attribute, $value, $namespace=null) {
		if ($value !== null)
		{
			if (!isset($this->_atomNode->attributes($namespace)->$attribute)) {
				$this->_atomNode->addAttribute($attribute, $value, $namespace);
				return;
			}
			
			$this->_atomNode->attributes($namespace)->$attribute = $value;
		}
	}
}