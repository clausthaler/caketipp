<?php
/**
 * TippFixture
 *
 */
class TippFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'match_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'points_team1' => array('type' => 'integer', 'null' => true, 'default' => null),
		'points_team2' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'match_id' => 1,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'points_team1' => 1,
			'points_team2' => 1,
			'created' => '2014-05-12 02:39:19',
			'modified' => '2014-05-12 02:39:19'
		),
	);

}
