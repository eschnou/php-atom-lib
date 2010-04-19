<?php

require_once 'SimpleActivityExtension.php';

class ActivityObjectExtension extends AtomEntryAdapter {
	
	protected $_objectType;
	
	public function addObjectType() {
		$newObjectType = $this->_addElement(ActivityNS::NAMESPACE, ActivityNS::OBJECT_TYPE_ELEMENT);
		return $this->_objectType[] = new SimpleActivityExtension($newObjectType, ActivityNS::OBJECT_TYPE_ELEMENT);
	}
	
	public function getObjectType() {	
		return $this->_objectType;	
	}
	
	public function __construct(SimpleXMLElement $data, $extensionType) {		
	
		$this->_atomNode = $data;
		
		if ($this->_atomNode->getName() != $extensionType) {
			throw new ActivityExtensionException("Invalid XML Object");
		}
		
		$this->_prefix = $this->_getPrefix(ActivityNS::NAMESPACE);
		if ($this->_prefix === null) {
			$this->_prefix = 'activity';
		}
		
		$this->_fetchChilds(AtomNS::NAMESPACE);
		$this->_fetchChilds(ActivityNS::NAMESPACE);
		
		$this->_init();
	}
	
	protected function _init() {
		parent::_init();
		
		$this->_objectType = array();
		if (isset($this->_element[ActivityNS::OBJECT_TYPE_ELEMENT])) {
			foreach ($this->_element[ActivityNS::OBJECT_TYPE_ELEMENT] as $objectType) {
				$this->_objectType[] = new SimpleActivityExtension($objectType, ActivityNS::OBJECT_TYPE_ELEMENT);
			}
		}
	}
}