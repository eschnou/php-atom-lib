<?php

class ExtensionFactoryException extends Exception { }

interface IAtomExtensionFactory {
	public function adapt(SimpleXMLElement $domObj);
	public function getNamespace();
}