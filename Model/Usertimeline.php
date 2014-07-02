<?php
App::uses('AppModel', 'Model');
/**
 * Usertimeline Model
 *
 * @property Timeline $Timeline
 * @property User $User
 */
class Usertimeline extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Timeline' => array(
			'className' => 'Timeline',
			'foreignKey' => 'timeline_id',
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
