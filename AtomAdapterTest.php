<?php

require_once 'PHPUnit/Framework.php';
require_once 'AtomFeedAdapter.php';
require_once 'Activitystream/ActivityExtensionFactory.php';

class AtomAdapterTest extends PHPUnit_Framework_TestCase {
	private $_atomNode;
	private $_feed;
	private $_xManager;
	
	protected function setUp() {
		$this->_atomNode = new SimpleXMLElement('activity.xml', null, true);
		$this->_feed = new AtomFeedAdapter($this->_atomNode);
		$this->_xManager = AtomExtensionManager::getInstance();
	}
	
	
	/**
     * @expectedException AtomAdapterException
     */
	public function testInvalidDataType() {
		$feed = new AtomFeedAdapter(5);
	}
	
	public function testFeedContents() {
		$this->assertEquals($this->_feed->content				, null);
		$this->assertEquals($this->_feed->id->content			, 'http://localhost:8080/resources/timezones');
		$this->assertEquals($this->_feed->title->content		, 'Time Zones');
		$this->assertEquals($this->_feed->title->type			, 'text');
		$this->assertEquals($this->_feed->link[0]->href			, 'http://localhost:8080/resources/timezones');
		$this->assertEquals($this->_feed->link[0]->rel			, 'self');
		$this->assertEquals($this->_feed->link[0]->title		, null);
		$this->assertEquals($this->_feed->link[0]->hreflang		, null);
		$this->assertEquals($this->_feed->link[0]->type			, null);
		$this->assertEquals($this->_feed->link[0]->length		, null);
		$this->assertEquals($this->_feed->author[0]->name		, 'sandra');
		$this->assertEquals($this->_feed->author[0]->uri		, 'sandra.com');
		$this->assertEquals($this->_feed->author[0]->email		, 'sandra@sandra.com');
		$this->assertEquals($this->_feed->updated->content		, null);
		$this->assertEquals(count($this->_feed->entry)			, 4);
	}
	
	public function testEntryContents() {
		$this->assertEquals($this->_feed->entry[0]->id->content			, 'tag:versioncentral.example.org,2009:/commit/1643245');
		$this->assertEquals($this->_feed->entry[0]->title->content		, 'Geraldine committed a change to yate');
		$this->assertEquals($this->_feed->entry[0]->link[0]->href		, 'http://versioncentral.example.org/geraldine/yate/commit/1643245');
		$this->assertEquals($this->_feed->entry[0]->link[0]->type		, 'text/html');
		$this->assertEquals($this->_feed->entry[0]->link[0]->rel		, 'alternate');	
		$this->assertEquals($this->_feed->entry[0]->link[0]->length		, null);	
		$this->assertEquals($this->_feed->entry[0]->link[0]->title		, null);	
		$this->assertEquals($this->_feed->entry[0]->link[0]->hreflang	, null);	
		$this->assertEquals($this->_feed->entry[0]->published->content	, '2009-06-01T12:54:00Z');	
		$this->assertEquals($this->_feed->entry[0]->updated->content	, null);
		$this->assertEquals($this->_feed->entry[0]->author[0]->name		, null);	
		$this->assertEquals($this->_feed->entry[0]->author[0]->uri		, null);
		$this->assertEquals($this->_feed->entry[0]->author[0]->email	, null);

		$this->assertEquals($this->_feed->entry[1]->author[0]->name		, 'Geraldine');	
		$this->assertEquals($this->_feed->entry[1]->author[0]->uri		, 'http://example.com/geraldine');
		$this->assertEquals($this->_feed->entry[1]->author[0]->email	, null);	
	}
	
	/**
     * @expectedException ExtensionManagerException
     */
	public function testNoActivityEntryAdapter() {
		$this->_activityEntry[0] = $this->_feed->entry[0]->getExtension('http://activitystrea.ms/spec/1.0/');
	}
	
	/**
     * @expectedException ExtensionFactoryException
     */
	public function testNoActivityFeedAdapter() {
		$this->_xManager->registerExtensionAdapter(new ActivityExtensionFactory());
		$feedEntry = $this->_feed->getExtension('http://activitystrea.ms/spec/1.0/');
	}
	
	public function testSetFeedContents() {
		$this->_feed->id->content 		= 'Changed Feed Id';
		$this->_feed->title->content 	= 'Changed Feed Title';
		$this->_feed->title->type		= 'Changed Feed Title Type';
		$this->_feed->link[0]->href		= 'Changed Feed Link Href';
		$this->_feed->link[0]->rel		= 'Changed Feed Link Rel';
		$this->_feed->link[0]->title	= 'Changed Feed Link Title';
		$this->_feed->link[0]->hreflang	= 'Changed Feed Link Hreflang';
		$this->_feed->link[0]->type		= 'Changed Feed Link Type';
		$this->_feed->link[0]->length	= 'Changed Feed Link Length';
		$this->_feed->author[0]->name	= 'Changed Feed Author Names';
		$this->_feed->author[0]->uri	= 'Changed Feed Author Uri';
		$this->_feed->author[0]->email	= 'Changed Feed Author Email';
		$this->_feed->updated->content	= 'Changed Feed Updated';
		
		$newAuthor = $this->_feed->addAuthor();
		$newAuthor->name				= 'New Feed Author Name';
		$newAuthor->email				= 'New Feed Author Email';
		$newAuthor->uri					= 'New Feed Author Uri';
		
		$newLink = $this->_feed->addLink();
		$newLink->href					= 'New Feed Link Href';
		$newLink->rel					= 'New Feed Link Rel';
		$newLink->title					= 'New Feed Link Title';
		
		$this->assertEquals($this->_feed->id->content			, 'Changed Feed Id');
		$this->assertEquals($this->_feed->title->content		, 'Changed Feed Title');
		$this->assertEquals($this->_feed->title->type			, 'Changed Feed Title Type');
		$this->assertEquals($this->_feed->link[0]->href			, 'Changed Feed Link Href');
		$this->assertEquals($this->_feed->link[0]->rel			, 'Changed Feed Link Rel');
		$this->assertEquals($this->_feed->link[0]->title		, 'Changed Feed Link Title');
		$this->assertEquals($this->_feed->link[0]->hreflang		, 'Changed Feed Link Hreflang');
		$this->assertEquals($this->_feed->link[0]->type			, 'Changed Feed Link Type');
		$this->assertEquals($this->_feed->link[0]->length		, 'Changed Feed Link Length');
		$this->assertEquals($this->_feed->author[0]->name		, 'Changed Feed Author Names');
		$this->assertEquals($this->_feed->author[0]->uri		, 'Changed Feed Author Uri');
		$this->assertEquals($this->_feed->author[0]->email		, 'Changed Feed Author Email');
		$this->assertEquals($this->_feed->updated->content		, 'Changed Feed Updated');
		$this->assertEquals(count($this->_feed->entry)			, 4);
		
		$this->assertEquals($this->_feed->author[1]->name		, 'New Feed Author Name');
		$this->assertEquals($this->_feed->author[1]->email		, 'New Feed Author Email');
		$this->assertEquals($this->_feed->author[1]->uri		, 'New Feed Author Uri');
		
		$this->assertEquals($this->_feed->link[1]->href			, 'New Feed Link Href');
		$this->assertEquals($this->_feed->link[1]->rel			, 'New Feed Link Rel');
		$this->assertEquals($this->_feed->link[1]->title		, 'New Feed Link Title');
		$this->assertEquals($this->_feed->link[1]->hreflang		, null);
		$this->assertEquals($this->_feed->link[1]->type			, null);
		$this->assertEquals($this->_feed->link[1]->length		, null);
		
	}
	
	public function testSetEntryContents() {
		$this->_feed->entry[0]->id->content 		= 'Changed Entry Id';
		$this->_feed->entry[0]->title->content 		= 'Changed Entry Title';
		$this->_feed->entry[0]->link[0]->href		= 'Changed Entry Link Href';
		$this->_feed->entry[0]->link[0]->type		= 'Changed Entry Link Type';
		$this->_feed->entry[0]->link[0]->rel		= 'Changed Entry Link Rel';
		$this->_feed->entry[0]->link[0]->length		= 'Changed Entry Link Length';
		$this->_feed->entry[0]->link[0]->title		= 'Changed Entry Link Title';
		$this->_feed->entry[0]->link[0]->hreflang	= 'Changed Entry Link Hreflang';
		$this->_feed->entry[0]->published->content	= 'Changed Entry Published';
		$this->_feed->entry[0]->updated->content	= 'Changed Entry Updated';
		
		//the author for the first entry is not exist at this moment, maybe it's better to throw new exception later
		$this->_feed->entry[0]->author[0]->name		= 'Changed Entry Author Name';
		$this->_feed->entry[0]->author[0]->uri		= 'Changed Entry Author Uri';
		$this->_feed->entry[0]->author[0]->email	= 'Changed Entry Author Email';
		
		$this->_feed->entry[1]->author[0]->name		= 'Changed Entry1 Author Name';
		$this->_feed->entry[1]->author[0]->uri		= 'Changed Entry1 Author Uri';
		$this->_feed->entry[1]->author[0]->email	= 'Changed Entry1 Author Email';
		
		$newEntryLink = $this->_feed->entry[0]->addLink();
		$newEntryLink->href					= 'New Entry Link Href';
		$newEntryLink->rel					= 'New Entry Link Rel';
		$newEntryLink->title				= 'New Entry Link Title';
		
		$this->assertEquals($this->_feed->entry[0]->id->content			, 'Changed Entry Id');
		$this->assertEquals($this->_feed->entry[0]->title->content		, 'Changed Entry Title');
		$this->assertEquals($this->_feed->entry[0]->link[0]->href		, 'Changed Entry Link Href');
		$this->assertEquals($this->_feed->entry[0]->link[0]->type		, 'Changed Entry Link Type');
		$this->assertEquals($this->_feed->entry[0]->link[0]->rel		, 'Changed Entry Link Rel');	
		$this->assertEquals($this->_feed->entry[0]->link[0]->length		, 'Changed Entry Link Length');	
		$this->assertEquals($this->_feed->entry[0]->link[0]->title		, 'Changed Entry Link Title');	
		$this->assertEquals($this->_feed->entry[0]->link[0]->hreflang	, 'Changed Entry Link Hreflang');	
		$this->assertEquals($this->_feed->entry[0]->published->content	, 'Changed Entry Published');	
		$this->assertEquals($this->_feed->entry[0]->updated->content	, 'Changed Entry Updated');
		$this->assertEquals($this->_feed->entry[0]->author[0]->name		, null);	
		$this->assertEquals($this->_feed->entry[0]->author[0]->uri		, null);
		$this->assertEquals($this->_feed->entry[0]->author[0]->email	, null);
		
		$newEntryAuthor = $this->_feed->entry[0]->addAuthor();
		$newEntryAuthor->name	= 'New Entry Author Name';
		$newEntryAuthor->email	= 'New Entry Author Email';
		$newEntryAuthor->uri	= 'New Entry Author Uri';
		
		$this->assertEquals($this->_feed->entry[0]->author[0]->name		, 'New Entry Author Name');	
		$this->assertEquals($this->_feed->entry[0]->author[0]->uri		, 'New Entry Author Uri');
		$this->assertEquals($this->_feed->entry[0]->author[0]->email	, 'New Entry Author Email');

		$this->assertEquals($this->_feed->entry[1]->author[0]->name		, 'Changed Entry1 Author Name');	
		$this->assertEquals($this->_feed->entry[1]->author[0]->uri		, 'Changed Entry1 Author Uri');
		$this->assertEquals($this->_feed->entry[1]->author[0]->email	, 'Changed Entry1 Author Email');
		
		$this->assertEquals($this->_feed->entry[0]->link[1]->href		, 'New Entry Link Href');
		$this->assertEquals($this->_feed->entry[0]->link[1]->rel		, 'New Entry Link Rel');
		$this->assertEquals($this->_feed->entry[0]->link[1]->title		, 'New Entry Link Title');
		$this->assertEquals($this->_feed->entry[0]->link[1]->hreflang	, null);
		$this->assertEquals($this->_feed->entry[0]->link[1]->type		, null);
		$this->assertEquals($this->_feed->entry[0]->link[1]->length		, null);			
	}
	
	public function testActivityEntryContents() {
		
		$this->_activityEntry[0] = $this->_feed->entry[0]->getExtension('http://activitystrea.ms/spec/1.0/');
		
		$this->assertEquals($this->_activityEntry[0]->content								, null);
		$this->assertEquals($this->_activityEntry[0]->verb[0]->content						, 'http://activitystrea.ms/schema/1.0/post');
		$this->assertEquals($this->_activityEntry[0]->verb[1]->content						, 'http://versioncentral.example.org/activity/commit');
		$this->assertEquals($this->_activityEntry[0]->object[0]->content					, null);
		$this->assertEquals($this->_activityEntry[0]->object[0]->objectType[0]->content		, 'http://versioncentral.example.org/activity/changeset');
		$this->assertEquals($this->_activityEntry[0]->object[1]								, null);
		
		$newEntryVerb[0] = $this->_activityEntry[0]->addVerb();
		$newEntryVerb[0]->content = 'New Activity Entry Verb';
		$this->assertEquals($this->_activityEntry[0]->verb[2]->content						, 'New Activity Entry Verb');
		
		$newEntryObject 			= $this->_activityEntry[0]->addObject();
		$newEntryObjectObjectType 	= $newEntryObject->addObjectType();
		$newEntryObjectObjectType->content = 'New Activity Entry Object Object Type';
		$this->assertEquals($this->_activityEntry[0]->object[1]->objectType[0]->content		, 'New Activity Entry Object Object Type');
		
		$newEntryAuthor = $this->_feed->entry[0]->addAuthor();
		$newEntryAuthor->name	= 'New Entry Author Name';
		$newEntryAuthor->email	= 'New Entry Author Email';
		$newEntryAuthor->uri	= 'New Entry Author Uri';
		
		$this->_activityAuthor[0] = $this->_feed->entry[0]->author[0]->getExtension('http://activitystrea.ms/spec/1.0/');
		$this->assertEquals($this->_activityAuthor[0]->objectType[0]						, null);
		
		$newAuthorObjectType 			= $this->_activityAuthor[0]->addObjectType();
		$newAuthorObjectType->content 	= 'New Author Object Type Content';
		$this->assertEquals($this->_activityAuthor[0]->ObjectType[0]->content				, 'New Author Object Type Content');
				
		$this->_activityAuthor[1] = $this->_feed->entry[1]->author[0]->getExtension('http://activitystrea.ms/spec/1.0/');
		$this->assertEquals($this->_activityAuthor[1]->ObjectType[0]->content				, 'http://activitystrea.ms/schema/1.0/person');
	
		$this->_activityEntry[1] = $this->_feed->entry[1]->getExtension('http://activitystrea.ms/spec/1.0/');
		
		$this->assertEquals($this->_activityEntry[1]->content								, null);
		$this->assertEquals($this->_activityEntry[1]->verb[0]								, null);
		$this->assertEquals($this->_activityEntry[1]->object[0]->content					, null);
		$this->assertEquals($this->_activityEntry[1]->object[0]->objectType[0]->content		, 'http://activitystrea.ms/schema/1.0/photo');
		$this->assertEquals($this->_activityEntry[1]->object[0]->objectType[1]->content		, 'http://activitystrea.ms/schema/1.0/image');
		$this->assertEquals($this->_activityEntry[1]->object[1]->objectType[0]->content		, 'http://activitystrea.ms/schema/1.0/image');

		$newEntryVerb[1] = $this->_activityEntry[1]->addVerb();
		$newEntryVerb[1]->content = 'New Activity Entry Verb1';
		$this->assertEquals($this->_activityEntry[1]->verb[0]->content						, 'New Activity Entry Verb1');
	}
}
//
//$feed = new SimpleXMLElement('activity.xml', null, true);
//$f = new AtomFeedAdapter($feed);
//
//$newAuthor = $f->entry[0]->addAuthor();
//$newAuthor->name = 'new';
//