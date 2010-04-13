<?php 

require_once 'BaseAtomAdapter.php';

class ExtendableAtomAdapter extends BaseAtomAdapter {

	public function getExtension($namespace) {
		return AtomExtensionManager::getInstance()->getExtensionAdapter($this->_atomNode, $namespace);
	}
	
	public function getContent() { } //all content from extendable atom adapter should be empty
	public function setContent($value) { } //editing the content of extendable atom adaptor is not possible
}