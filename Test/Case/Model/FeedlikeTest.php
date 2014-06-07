<?php
App::uses('Feedlike', 'Model');

/**
 * Feedlike Test Case
 *
 */
class FeedlikeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.feedlike',
		'app.feed',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Feedlike = ClassRegistry::init('Feedlike');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Feedlike);

		parent::tearDown();
	}

}
