<?php
App::uses('AppModel', 'Model');
/**
 * Match Model
 *
 * @property team_id1 $team_id1
 * @property team_id2 $team_id2
 */
class Match extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */

  public $belongsTo = array(
    'Team1' => array(
        'className' => 'Team',
        'foreignKey' => 'team1_id'
    ),
    'Team2' => array(
        'className' => 'Team',
        'foreignKey' => 'team2_id'
    ),
    'Group' => array(
        'className' => 'Group',
        'foreignKey' => 'group_id'
    ),
    'Round' => array(
        'className' => 'Round',
        'foreignKey' => 'round_id'
    ),
  );
  
  public $hasMany = array(
    'Tipp' => array(
        'className' => 'Tipp',
        'foreignKey' => 'match_id',
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
