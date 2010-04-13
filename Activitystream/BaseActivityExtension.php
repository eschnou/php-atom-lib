<?php

class ActivityExtensionException extends Exception {
	
}

class BaseActivityExtension { //might be generalized into more general class e.g. BaseExtension (later)
	const ACTIVITY_NS 		= 'http://activitystrea.ms/spec/1.0/';
	const OBJECT_TYPE       = 'object-type';
	const VERB     			= 'verb';
	const OBJECT   			= 'object';
	
	protected $_atomNode;
	
	public function __construct(SimpleXMLElement $data, $extensionType) {
		$this->_atomNode = $data;
		
		if ($this->_atomNode->getName() != $extensionType) { //check whether $this->_atomNode is the appropriate XML Object, e.g. atom entry node for ActivityEntryExtension
			throw new ActivityExtensionException("Invalid XML Object");
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
	
	public function getContent() {
		return trim((string)$this->_atomNode);
	}
	
	public function setContent($value) {
		$this->_atomNode[0] = $value;
	}
}
