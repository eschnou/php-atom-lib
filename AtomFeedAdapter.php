<?php
require_once 'FeedSkeleton.php';
require_once 'AtomEntryAdapter.php';


class AtomFeedAdapter extends FeedSkeleton  {
	const TAG_NAME = 'feed';
	
	protected $_entry;
	
	protected function _init() {
		parent::_init();
		$this->_entry = array();
		foreach ($this->_atomNode->entry as $entry) {
			//$this->_entry[] = $this->fetchChild('AtomEntryAdapter', $entry);
			$this->_entry[] = new AtomEntryAdapter(&$entry);
		}	
	}
	
	public function __construct($data, $data_is_url=false) {
		parent::__construct(self::TAG_NAME, $data, $data_is_url);
		$this->_init();
	}
	
	public function getEntry() {
		return $this->_entry;
	}
}