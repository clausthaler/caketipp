<?php
App::uses('AppModel', 'Model');
/**
 * Tipp Model
 *
 * @property Match $Match
 * @property User $User
 */
class Tipp extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'match_id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Match' => array(
			'className' => 'Match',
			'foreignKey' => 'match_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
