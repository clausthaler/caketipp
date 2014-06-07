<?php
App::uses('Ladder', 'Model');

/**
 * Ladder Test Case
 *
 */
class LadderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ladder',
		'app.group',
		'app.match',
		'app.team',
		'app.round',
		'app.tipp',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ladder = ClassRegistry::init('Ladder');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ladder);

		parent::tearDown();
	}

}
