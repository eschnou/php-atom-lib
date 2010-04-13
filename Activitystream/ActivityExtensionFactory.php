<?php
require_once './AtomAdaptorBasic.php';
require_once 'ActivityEntryExtension.php';
require_once 'ActivityObjectExtension.php';
require_once 'ActivityObjectTypeExtension.php';
require_once 'ActivityAuthorExtension.php';

class ActivityExtensionFactory implements IAtomExtensionFactory {

	public function adapt(SimpleXMLElement $atomNode) {
		switch ($atomNode->getName()) {
			case ActivityEntryExtension::TAG_NAME:
				return new ActivityEntryExtension($atomNode);
				break;
			case ActivityObjectTypeExtension::TAG_NAME:
				return new ActivityObjectTypeExtension($atomNode);
				break;
			case ActivityObjectExtension::TAG_NAME:
				return new ActivityObjectExtension($atomNode);
				break;
			case ActivityAuthorExtension::TAG_NAME:
				return new ActivityAuthorExtension($atomNode);
				break;
			default:
				throw new ExtensionFactoryException('No Adaptor Available for '.$atomNode->getName().' element!');
		}
	}
	
	public function getNamespace() {
		return BaseActivityExtension::ACTIVITY_NS;
	}
}