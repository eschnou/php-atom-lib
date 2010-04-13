<?php

require_once 'AtomExtensionManager.php';
require_once 'AtomAdaptorBasic.php';

class AtomAdapterException extends Exception { }

abstract class BaseAtomAdapter implements IAtomCommonAttributes{
	
	protected $_atomNode;
	
	public function __construct($adapterType,$data,$data_is_url=false) {
		if (is_string($data)) { 
			$this->_atomNode = new SimpleXMLElement($data,null,$data_is_url);
		}
		else if ($data instanceof SimpleXMLElement) { 
			$this->_atomNode = $data;
		}
		else { 		
			throw new AtomAdapterException("Invalid Data Type");
		}
		if ($this->_atomNode->getName() != $adapterType) { //check whether $this->_atomNode is the appropriate XML Object, e.g. atom entry node for AtomEntryAdapter
			throw new AtomAdapterException("Invalid XML Object");
		}
	}
	
	public function __get($name) {
        $method = 'get' . $name;
        return $this->$method();
	}
	
	public function __set($name, $value) {
		$method = 'set' . $name;
		$this->$method($value);
	}
	
	public function getBase() {
		return (string)$this->_atomNode->attributes()->base;
	}
	
	public function getLang() {
		return (string)$this->_atomNode->attributes()->lang;
	}
	
	public function getContent() { // I'll handle the HTML and XHTML type for text and content construct later
		return trim((string)$this->_atomNode);
	}
	
	public function setContent($value) { // I'll handle the HTML and XHTML type for text and content construct later
		$this->_atomNode[0] = $value;
	}
	
	//depecrated at this moment
	public function fetchChild($atomAdapter, $atomNode, $adapterType="") {
		try {
			if ($adapterType == "") {
				$result = new $atomAdapter($atomNode);
			} 
			else {
				$result = new $atomAdapter($adapterType, $atomNode);
			}
		}
		catch (AtomAdapterException $e) {
			return null;
		}
		return $result;
	}
	
	protected function _settleAttribute($attribute) {
		if (!isset($this->_atomNode->attributes()->$attribute)) {
			$this->_atomNode->addAttribute($attribute,'');
		}
	}
}