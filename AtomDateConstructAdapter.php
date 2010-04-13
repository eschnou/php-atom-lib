<?php

require_once 'BaseAtomAdapter.php';

class AtomDateConstructAdapter extends BaseAtomAdapter {
	
	public function __construct($adapterType, $data, $data_is_url=false) {
		parent::__construct($adapterType, $data, $data_is_url);
	}
}