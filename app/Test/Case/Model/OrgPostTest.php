<?php
App::uses('OrgPost', 'Model');

/**
 * OrgPost Test Case
 *
 */
class OrgPostTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.org_post'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OrgPost = ClassRegistry::init('OrgPost');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrgPost);

		parent::tearDown();
	}

}
