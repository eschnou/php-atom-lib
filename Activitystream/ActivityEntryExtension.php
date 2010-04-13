<?php

require_once 'BaseActivityExtension.php';
require_once 'ActivityVerbExtension.php';
require_once 'ActivityObjectExtension.php';

class ActivityEntryExtension extends BaseActivityExtension {
	const TAG_NAME = 'entry';
	
	protected $_verb;
	protected $_object;
	
	protected function _init() {
		$this->_verb = array();
		$this->_object = array();
		
		foreach ($this->_atomNode->children(BaseActivityExtension::ACTIVITY_NS) as $child) {
			switch ($child->getName()) {
				case BaseActivityExtension::VERB: {
					$this->_verb[] = new ActivityVerbExtension($child);
					break;
				}
				case BaseActivityExtension::OBJECT: {
					$this->_object[] = new ActivityObjectExtension($child);
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
	
	public function getVerb() {	
		return $this->_verb;	
	}
	
	public function getObject() {
		return $this->_object;
	}
	
	public function addVerb() {
		$newVerb = $this->_atomNode->addChild('activity:verb', null, BaseActivityExtension::ACTIVITY_NS);
		return $this->_verb[] = new ActivityVerbExtension($newVerb);
	}
	
	public function addObject() {
		$newObject = $this->_atomNode->addChild('activity:object', null, BaseActivityExtension::ACTIVITY_NS);
		return $this->_object[] = new ActivityObjectExtension($newObject);
	}
}