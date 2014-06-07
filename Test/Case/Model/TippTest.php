<?php
App::uses('Tipp', 'Model');

/**
 * Tipp Test Case
 *
 */
class TippTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tipp',
		'app.match',
		'app.team',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tipp = ClassRegistry::init('Tipp');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tipp);

		parent::tearDown();
	}

}
