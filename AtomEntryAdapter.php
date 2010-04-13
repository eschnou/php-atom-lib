<?php
require_once 'FeedSkeleton.php';



class AtomEntryAdapter extends FeedSkeleton {
	const TAG_NAME = 'entry';
	
	protected $_published;
	
	protected function _init() {
		parent::_init();
		//$this->_published = $this->fetchChild('AtomDateConstructAdapter', $this->_atomNode->published, 'published');
		$this->_published = new AtomDateConstructAdapter('published', &$this->_atomNode->published);
	}
	
	public function __construct($data, $data_is_url=false) {
		parent::__construct(self::TAG_NAME, $data, $data_is_url);
		
		$this->_init();
	}
	
	public function getPublished() {
		return $this->_published;
	}
}