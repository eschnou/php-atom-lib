<?php

require_once 'BaseActivityExtension.php';
require_once 'ActivityObjectTypeExtension.php';

class ActivityObjectExtension extends BaseActivityExtension {
	const TAG_NAME        = 'object';
	
	protected $_objectType;
	
	protected function _init() {
		$this->_objectType = array();
		foreach ($this->_atomNode->children(BaseActivityExtension::ACTIVITY_NS) as $child) {
			switch ($child->getName()) {
				case BaseActivityExtension::OBJECT_TYPE: {
					$this->_objectType[] = new ActivityObjectTypeExtension($child);
					break;
				}
			}
		}
	}
	
	public function getContent() { }
	public function setContent($value) { }
	
	public function __construct($data) {
		parent::__construct($data,self::TAG_NAME);
		
		$this->_init();
	}
	
	public function getObjectType() {	
		return $this->_objectType;	
	}
	
	public function addObjectType() {
		$newObjectType = $this->_atomNode->addChild('activity:object-type',null,BaseActivityExtension::ACTIVITY_NS);
		return $this->_objectType[] = new ActivityObjectTypeExtension($newObjectType);
	}
}