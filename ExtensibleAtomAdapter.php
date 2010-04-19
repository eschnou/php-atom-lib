<?php 

require_once 'BaseAtomAdapter.php';
require_once 'AtomExtensionManager.php';

class ExtensibleAtomAdapter extends BaseAtomAdapter { //I think I have to add setElement method
	
	protected $_element;
	
	public function addNamespace($prefix, $namespace) {
		$this->_atomNode->addAttribute($prefix.':temp',null,$namespace);
		unset($this->_atomNode->attributes($namespace)->temp);
	}

	public function getExtension($namespace) {
		return AtomExtensionManager::getInstance()->getExtensionAdapter($this->_atomNode, $namespace);
	}
	
	public function __construct($adapterType, $data, $data_is_url=false) {
		parent::__construct($adapterType, $data, $data_is_url);
		
		$this->_fetchChilds(AtomNS::NAMESPACE);
	}
	
	protected function _addElement($namespace, $tagName, $value=null) {
		$prefix = "";
		$ns 	= null;
		if ($this->_prefix != "") {
			$prefix = $this->_prefix.":";
			$ns 	= $namespace; 
		}
		return $this->_atomNode->addChild($prefix.$tagName, $value, $ns);
	}
	
	protected function _fetchChilds($namespace) {
		foreach($this->_atomNode->children($namespace) as $children) {
			$this->_element[$children->getName()][] = $children;
		}
	}
}