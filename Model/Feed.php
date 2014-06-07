<?php
App::uses('AppModel', 'Model');
/**
 * Feed Model
 *
 * @property User $User
 * @property Feed $ParentFeed
 * @property Feedlike $Feedlike
 * @property Feed $ChildFeed
 */
class Feed extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'text';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentFeed' => array(
			'className' => 'Feed',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Feedlike' => array(
			'className' => 'Feedlike',
			'foreignKey' => 'feed_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ChildFeed' => array(
			'className' => 'Feed',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
