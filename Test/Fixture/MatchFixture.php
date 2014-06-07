<?php
/**
 * MatchFixture
 *
 */
class MatchFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'datetime' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'stage_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'team_id1' => array('type' => 'integer', 'null' => true, 'default' => null),
		'team_id2' => array('type' => 'integer', 'null' => true, 'default' => null),
		'points_team1' => array('type' => 'integer', 'null' => true, 'default' => '-1'),
		'points_team2' => array('type' => 'integer', 'null' => true, 'default' => '-1'),
		'isfinished' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'aftertime' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'penalties' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'datetime' => '2014-04-12 04:09:15',
			'stage_id' => 1,
			'group_id' => 1,
			'team_id1' => 1,
			'team_id2' => 1,
			'points_team1' => 1,
			'points_team2' => 1,
			'isfinished' => 1,
			'aftertime' => 1,
			'penalties' => 1
		),
	);

}
