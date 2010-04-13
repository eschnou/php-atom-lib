<?php

require_once 'BaseActivityExtension.php';

class ActivityObjectTypeExtension extends BaseActivityExtension {
	const TAG_NAME = 'object-type';
	
	public function __construct($data) {
		parent::__construct($data,self::TAG_NAME);
	}
}