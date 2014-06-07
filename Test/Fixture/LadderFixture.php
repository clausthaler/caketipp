<?php
/**
 * LadderFixture
 *
 */
class LadderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'real', 'length' => 5, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'pos' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'team_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'matches' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'points' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'goodgoals' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'badgoals' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'won' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'draw' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'lost' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'group_id' => 1,
			'type' => 'Lor',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'pos' => 1,
			'team_id' => 1,
			'matches' => 1,
			'points' => 1,
			'goodgoals' => 1,
			'badgoals' => 1,
			'won' => 1,
			'draw' => 1,
			'lost' => 1
		),
	);

}
