<?php

require_once 'BaseAtomAdapter.php';

class AtomIdAdapter extends BaseAtomAdapter {
	const TAG_NAME = 'id';
	
	public function __construct($data, $data_is_url=false) {
		parent::__construct(self::TAG_NAME, $data, $data_is_url);
	}
}