<?php

require_once 'BaseActivityExtension.php';

class ActivityVerbExtension extends BaseActivityExtension {
	const TAG_NAME = 'verb';
	
	public function __construct($data) {
		parent::__construct($data,self::TAG_NAME);
	}	
}