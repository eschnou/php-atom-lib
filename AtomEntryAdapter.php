<?php
require_once 'AtomSourceAdapter.php';
require_once 'AtomContentAdapter.php';

class AtomEntryAdapter extends AtomSourceAdapter {
	protected $_published;
	protected $_content;
	protected $_summary;
	
	public function getContent() {
		return $this->_content;
	}
	
	public function getPublished() {
		return $this->_published;
	}
	
	public function getSummary() {
		return $this->_summary;
	}
	
	public function setContent($value) {
		if (!isset($this->_content)) {
			$published = $this->_addElement(AtomNS::NAMESPACE, AtomNS::CONTENT_ELEMENT, $value);
			$this->_content = new AtomContentAdapter($published);
			return;
		}
		$this->_content->value = $value;
	}
	
	public function setPublished($value) {
		if (!isset($this->_published)) {
			$published = $this->_addElement(AtomNS::NAMESPACE, AtomNS::PUBLISHED_ELEMENT, $value);
			$this->_published = new AtomDateConstructAdapter(AtomNS::PUBLISHED_ELEMENT, $published);
			return;
		}
		$this->_published->value = $value;
	}
	
	public function setSummary($value) {
		if (!isset($this->_summary)) {
			$summary = $this->_addElement(AtomNS::NAMESPACE, AtomNS::SUMMARY_ELEMENT, $value);
			$this->_summary = new AtomTextConstructAdapter(AtomNS::SUMMARY_ELEMENT, $summary);
			return;
		}
		$this->_summary->value = $value;
	}
	
	public function __construct($data, $data_is_url=false) {
		parent::__construct(AtomNS::ENTRY_ELEMENT, $data, $data_is_url);
		//$this->_init();
	}
	
	protected function _init() {
		parent::_init();
		
		if ($this->_element[AtomNS::PUBLISHED_ELEMENT][0]) {
			$this->_published = new AtomDateConstructAdapter(AtomNS::PUBLISHED_ELEMENT, $this->_element[AtomNS::PUBLISHED_ELEMENT][0]);
		}
	
		if ($this->_element[AtomNS::CONTENT_ELEMENT][0]) {
			$this->_content = new AtomContentAdapter($this->_element[AtomNS::CONTENT_ELEMENT][0]);
		}
	
		if ($this->_element[AtomNS::SUMMARY_ELEMENT][0]) {
			$this->_summary = new AtomTextConstructAdapter(AtomNS::SUMMARY_ELEMENT, $this->_element[AtomNS::SUMMARY_ELEMENT][0]);
		}
		
		
	}
}