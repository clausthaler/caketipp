<?php
App::uses('AppController', 'Controller');
/**
 * Matches Controller
 *
 * @property Match $Match
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MatchesController extends AppController {

/**
 * 
 */
  public $uses = array('Match', 'Round', 'Team', 'Group', 'Ladder', 'User', 'Tipp');

  public $paginate = array(
      'limit' => 20,
      'order' => array(
          'Match.isfinished' => 'asc',
          'Match.kickoff' => 'asc'
      )
  );

  public function beforeFilter()  {
    parent::beforeFilter();
    $this->Auth->allow('matchupdate');
  }

  public function array_orderby() {
    $args = func_get_args();
    $data = array_shift($args);

    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
  }

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
    $this->Paginator->settings = $this->paginate;
		$this->Match->recursive = 0;
		$rounds = $this->Match->Round->find('list', array(
      'fields'=> array('id','shortname')));
		$this->set(compact('rounds'));

    $this->set(compact('data'));
		$this->set('matches', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Match->exists($id)) {
			throw new NotFoundException(__('Invalid match'));
		}
		$options = array('conditions' => array('Match.' . $this->Match->primaryKey => $id));
		$this->set('match', $this->Match->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Match->create();


			$date = date_create_from_format('d.m.Y H:i', $this->request->data['Match']['date'] . ' ' . $this->request->data['Match']['time']);
			$this->request->data['Match']['datetime'] = $date->format('Y-m-d H:i:s');

			if ($this->Match->save($this->request->data)) {
				$this->Session->setFlash(__('The match has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The match could not be saved. Please, try again.'));
			}
		}
		$groups = $this->Match->Group->find('list');
		$team1s = $team2s = $this->Match->Team1->find('list');;
		$rounds = $this->Match->Round->find('list');
		$this->set(compact('team1s', 'team2s', 'groups', 'rounds'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Match->exists($id)) {
			throw new NotFoundException(__('Invalid match'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if (isset($this->request->data['Match']['date'])) {
				$date = date_create_from_format('d.m.Y H:i', $this->request->data['Match']['date'] . ' ' . $this->request->data['Match']['time']);
				$this->request->data['Match']['datetime'] = $date->format('Y-m-d H:i:s');
			}

			if ($this->Match->save($this->request->data)) {
				$this->Session->setFlash(__('The match has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The match could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Match.' . $this->Match->primaryKey => $id));
			$this->request->data = $this->Match->find('first', $options);
			$this->request->data['Match']['date'] = date('d.m.Y', strtotime($this->request->data['Match']['datetime']));
			$this->request->data['Match']['time'] = date('H:i', strtotime($this->request->data['Match']['datetime']));
		}
		$groups = $this->Match->Group->find('list');
		$team1s = $team2s = $this->Match->Team1->find('list');;

		$rounds = $this->Match->Round->find('list');
		$this->set(compact('team1s', 'team2s', 'groups', 'rounds'));
	}

/**
 * admin_result method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
  public function admin_result($id = null) {
    $checkmatch = $this->Match->findById($id);
    if (empty($checkmatch)) {
      throw new NotFoundException(__('Invalid match'));
    } 
    #elseif ($checkmatch['Match']['isfinished'] == 1) {
    #  $this->Session->setFlash(__('The result for this match has already been entered.'));
    #  return $this->redirect(array('action' => 'index'));
    #}
    if ($this->request->is(array('post', 'put'))) {
      // todo: resulted matches should not be overwritten
      foreach ($this->request->data['Match'] as $key => $value) {
        if (!$key == 'id' || !$key == 'points_team1' || !$key == 'points_team2') {
          unset($this->request->data['Match'][$key]);
        }
      }

      if ($this->Match->save($this->request->data)) {
        // calculate tipps
        $realGoals1 = $this->request->data['Match']['points_team1'];
        $realGoals2 = $this->request->data['Match']['points_team2'];
        $tipps = $this->Match->Tipp->recursive = -1;
        $tipps = $this->Match->Tipp->find('all', array('conditions' => array('Tipp.match_id' => $this->request->data['Match']['id'])));
        foreach ($tipps as $key => $tipp) {
          $tippGoals1 = $tipp['Tipp']['points_team1'];
          $tippGoals2 = $tipp['Tipp']['points_team2'];
          // completely correct score?
          $points = 0;
          if ($realGoals1 == $tippGoals1 && $realGoals2 == $tippGoals2) {
            $points = 30;
          } elseif (min(1, max(-1, $tippGoals1 - $tippGoals2)) == min(1, max(-1, $realGoals1 - $realGoals2))) {
            $points = 12;
  
            //additional points for difference in total score
            switch (abs(($tippGoals1 - $tippGoals2) - ($realGoals1 - $realGoals2))) {
            case 0:
              $points = $points + 8;
              break;
            case 1:
              $points = $points + 4;
              break;
            case 2:
              $points = $points + 2;
              break;
            case 3:
              $points = $points + 1;
              break;
            }
  
            // additional points for difference in team score
            switch (abs($tippGoals1 - $realGoals1) + abs($tippGoals2 - $realGoals2)) {
            case 0:
              $points = $points + 8;
              break;
            case 1:
              $points = $points + 4;
              break;
            case 2:
              $points = $points + 2;
              break;
            case 3:
              $points = $points + 1;
              break;
            }
          }
          $tipp['Tipp']['points'] = $points;
          $this->Match->Tipp->save($tipp);
        }

        if ($checkmatch['Round']['groupstage'] == 1) {
          // recalculate group table
          $this->Match->recursive = -1;
          $match = $this->Match->findById($id);
          $groupid = $match['Match']['group_id'];
          $groupteams = $this->Team->find('list', array('conditions' => array('Team.group_id' => $groupid)));
          // prepare working array
          $arrladder = array();
          foreach ($groupteams as $key => $groupteam) {
            $arrgt = array(
              'group_id' => $groupid,
              'type' => 'real',
              'pos' => 0,
              'team_id' => $key,
              'matches' => 0,
              'points' => 0,
              'goodgoals' => 0,
              'badgoals' => 0,
              'goaldif' => 0,
              'won' => 0,
              'draw' => 0,
              'lost' => 0);
            $arrladder[$key] = $arrgt;
          }
          $groupmatches = $this->Match->find('all', 
            array('conditions' => array(
              'Match.group_id' => $groupid,
              'Match.kickoff <' => strtotime($this->Session->read('currentdatetime')))));
          foreach ($groupmatches as $key => $gmatch) {
            $team1_id = $gmatch['Match']['team1_id'];
            $team2_id = $gmatch['Match']['team2_id'];
            //goals
            $arrladder[$team1_id]['goodgoals'] =  $arrladder[$team1_id]['goodgoals'] + $gmatch['Match']['points_team1'];
            $arrladder[$team2_id]['goodgoals'] =  $arrladder[$team2_id]['goodgoals'] + $gmatch['Match']['points_team2'];
            $arrladder[$team1_id]['badgoals'] =  $arrladder[$team1_id]['badgoals'] + $gmatch['Match']['points_team2'];
            $arrladder[$team2_id]['badgoals'] =  $arrladder[$team2_id]['badgoals'] + $gmatch['Match']['points_team1'];
            $arrladder[$team1_id]['goaldif'] =  $arrladder[$team1_id]['goodgoals'] - $arrladder[$team1_id]['badgoals'];
            $arrladder[$team2_id]['goaldif'] =  $arrladder[$team2_id]['goodgoals'] - $arrladder[$team2_id]['badgoals'];
            //matches
            $arrladder[$team1_id]['matches']++;
            $arrladder[$team2_id]['matches']++;
            //points, won, drw, lost
            if ($gmatch['Match']['points_team1'] == $gmatch['Match']['points_team2']) {
              // let's call it a draw
              $arrladder[$team1_id]['points']++;
              $arrladder[$team2_id]['points']++;
              $arrladder[$team1_id]['draw']++;
              $arrladder[$team2_id]['draw']++;
            } elseif ($gmatch['Match']['points_team1'] > $gmatch['Match']['points_team2']) {
              // team 1 won
              $arrladder[$team1_id]['points'] = $arrladder[$team1_id]['points'] + 3;
              $arrladder[$team1_id]['won']++;
              $arrladder[$team2_id]['lost']++;
            } else {
              // team 2 won
              $arrladder[$team2_id]['points'] = $arrladder[$team2_id]['points'] + 3;
              $arrladder[$team2_id]['won']++;
              $arrladder[$team1_id]['lost']++;
            }
          }
          $arrladder = $this->array_orderby($arrladder, 'points', SORT_DESC, 'goaldif', SORT_DESC, 'goodgoals', SORT_DESC);
          $this->Ladder->deleteAll(array(
            'Ladder.group_id' => $groupid,
            'Ladder.type' => 'real' ), false);
          foreach ($arrladder as $poskey => $newlader) {
            $this->Ladder->create();
            $newLadder['Ladder'] = $newlader;
            $newLadder['Ladder']['pos'] = $poskey + 1;
            $this->Ladder->save($newLadder);
          }
        }

        $this->Session->setFlash(__('The match has been saved and tipps have been calculated.'));
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The match could not be saved. Please, try again.'));
      }
    } else {
      $options = array('conditions' => array('Match.' . $this->Match->primaryKey => $id));
      $this->request->data = $this->Match->find('first', $options);
      $this->request->data['Match']['date'] = date('d.m.Y', $this->request->data['Match']['kickoff']);
      $this->request->data['Match']['time'] = date('H:i', $this->request->data['Match']['kickoff']);
    }
    $groups = $this->Match->Group->find('list');
    $team1s = $team2s = $this->Match->Team1->find('list');;

    $rounds = $this->Match->Round->find('list');
    $this->set(compact('team1s', 'team2s', 'groups', 'rounds'));
  }

/**
 * admin_index method
 *
 * @return void
 */
  public function schedule() {
    $this->layout = 'default_new';
    $this->Team->recursive = -1;
    $this->Group->recursive = -1;
    $this->Round->recursive = -1;
  	$teams = $this->Team->find('all', array('fields' => array('id', 'name', 'iconurl')));
  	$rounds = $this->Round->find('all', array('fields' => array('id', 'name', 'shortname')));
  	$groups = $this->Group->find('all', array('fields' => array('id', 'name', 'shortname')));
  	$this->set(compact('teams', 'groups', 'rounds'));
    $this->Match->recursive = -1;
    $this->set('matches', $this->Match->find(
      'all', array('order' => array('Match.round_id', 'Match.datetime'))));
  }

/**
 * admin_index method
 *
 * @return void
 */
  public function grouptables($username = null) {
    if (!$username) {
      $user['User'] = $this->Auth->user();
    } else {
      $options = array('conditions' => array('User.username' => $username));
      $user = $this->User->find('first', $options);
      if (empty($user)) {
        exit();
      }
    }

    $this->Group->recursive = -1;
    $groups = $this->Group->find('all', array('fields' => array('id', 'name', 'shortname')));

    $this->Team->recursive = -1;
    $teams = $this->Team->find('all', array(
      'fields' => array('id', 'name', 'iconurl', 'group_id'),
      'conditions' => array('group_id' => Hash::extract($groups, '{n}.Group.id'))));


    $this->User->recursive = -1;
    $users = $this->User->find('list', array('fields' => array('username', 'username')));
    $this->set(compact('teams', 'groups', 'users','user'));
    $this->Match->recursive = -1;
    $matches = $this->Match->find(
      'all', 
      array('order' => array(
        'Match.round_id', 
        'Match.datetime'),
        'conditions' => array('group_id' => Hash::extract($groups, '{n}.Group.id'))));
    ;
    $this->set('matches', $matches); 

    // find matches that cannot be tipped not to show future tipps of other tippers
    $this->Match->recursive = -1;
    $limitmatches = $this->Match->find(
      'all', 
      array('order' => array(
        'Match.round_id', 
        'Match.datetime'),
        'conditions' => array(
          'group_id' => Hash::extract($groups, '{n}.Group.id'),
          'due <' => strtotime($this->Session->read('currentdatetime'))))
    );
    if ($this->Auth->user('id') == $user['User']['id']) {
      $limitmatches = $matches;
    }
    

    $this->Tipp->recursive = -1;
    $tipps = $this->Tipp->find('all',
      array(
        'order' => 'Tipp.match_id',
        'conditions' => array(
          'Tipp.match_id' => Hash::extract($limitmatches, '{n}.Match.id'),
          'Tipp.user_id' => $user['User']['id'])));
    $this->set('tipps', $tipps);

    $this->Ladder->recursive = -1;
    $tippladders = $this->Ladder->find(
      'all', 
      array('order' => array(
        'Ladder.group_id', 
        'Ladder.points desc',
        'Ladder.goodgoals - Ladder.badgoals desc',
        'Ladder.goodgoals desc'),
        'conditions' => array(
          'Ladder.type' => 'tipp',
          'Ladder.user_id' => $user['User']['id'])));
    $this->set('tippladders', $tippladders);


    $this->Ladder->recursive = -1;
    $ladders = $this->Ladder->find(
      'all', 
      array('order' => array(
        'Ladder.group_id', 
        'Ladder.points desc',
        'Ladder.goodgoals - Ladder.badgoals desc',
        'Ladder.goodgoals desc'),
        'conditions' => array('type' => 'real')));
    $this->set('ladders', $ladders);
  }




/**
 * admin_index method
 *
 * @return void
 */
  public function checktipps($days = null) {
    if (!$days) {
      $days = 2;
    }
    $nextMatches = $this->Match->query("SELECT * FROM matches a  WHERE a.due <= UNIX_TIMESTAMP() + " . $days * 86400 . 
      " AND a.kickoff >= UNIX_TIMESTAMP() AND a.isfixed = 1 AND NOT EXISTS (SELECT 'X' FROM tipps b " .
      " WHERE b.user_id = '" . $this->Auth->user('id') . "' " .
      " AND a.id = b.match_id);");

    if ($this->request->is('requested')) {
      return $nextMatches;
    } else {
      $this->set('nextMatches', $nextMatches);
    }
  }

/**
 * admin_index method
 *
 * @return void
 */



  public function nextmatches($nbr = null) {
    if (!$nbr) {
      $nbr = 5;
    }
    $this->Match->recursive = 0;
    $nextMatches = $this->Match->find('all', array(
      'conditions' => array('Match.kickoff >' => strtotime($this->Session->read('currentdatetime'))),
      'order' => 'Match.kickoff',
      'limit' => $nbr));
    $this->Tipp->recursive = -1;
    $tipps = $this->Tipp->find(
      'all', array(
        'conditions' => array(
          'Tipp.type' => 0,
          'Tipp.match_id' => Hash::extract($nextMatches, '{n}.Match.id'),
          'Tipp.user_id' => $this->Auth->user('id'))));
    if ($this->request->is('requested')) {
      return array('nextmatches' => $nextMatches,
                    'tipps' => $tipps);
    } else {
      $this->set('nextMatches', $nextMatches);
      $this->set('tipps', $tipps);
    }
  }

  public function openresults() {
//    if ($this->request->is('requested')) {
      $this->Match->recursive = 0;
      $currentMatches = $this->Match->find('all', array(
        'conditions' => array(
          'Match.kickoff <' => strtotime($this->Session->read('currentdatetime')),
          'Match.isfinished <>' => 1),
        'order' => 'Match.kickoff'));
      $this->render = false;
        return $currentMatches;
//    }
//    die();
  }

  public function test() {
        // get all tippers that want to be reminded
#    $users = $this->User->find('list', array(
#      'conditions' => array('recieve_reminders' => 1, 'active' => 1),
#      'fields' => array('username', 'email', 'id')));
#    print_r($users);
    // get all matches that are due on the next day
    $matches = $this->Match->find('list', array(
      'conditions' => array(
        'due <' => (strtotime($this->Session->read('currentdatetime')) + 1 * 86400), 
        'due >' => strtotime($this->Session->read('currentdatetime'))),
      'fields' => array('id')));
    print_r($matches);
  }

  public function matchupdate($filename = null) {
    if ($json =  json_decode(file_get_contents('/var/www/push.tipp4fun.eu/' . $filename), true)) {
      $checkmatch = $this->Match->findById($json['Id'] );
      if (empty($checkmatch)) {
          die();
      }

      if (substr($json['Updates'],0,15) == '[status:[TIMED:') {
        // game has begun -> set result to 0:0
        if (is_numeric($checkmatch['Match']['points_team1']) || is_numeric($checkmatch['Match']['points_team2']) || $checkmatch['Match']['is_fixed'] <> 1) {
          die();
        } else {
          $data = array('Match' => array(
            'id' => $json['Id'],
            'points_team1' => 0,
            'points_team2' => 0
            ));
          $this->log('game ' . $json['Id'] . ' has begun');
          $this->updateresult($checkmatch, $data);
        }
        die();
      }
      if (substr($json['Updates'],0,15) == '[status:[IN_PLA') {
        // game is finished -> change game status
        if (!is_numeric($checkmatch['Match']['points_team1']) || !is_numeric($checkmatch['Match']['points_team2'])) {
          die();
        } else {
          $data = array('Match' => array(
            'id' => $json['Id'],
            'isfinished' => 1
            ));
          $this->log('game ' . $json['Id'] . ' is finished');
          $this->log($data);
          $this->updateresult($checkmatch, $data);
          die();
        }
      }

      if (substr($json['Updates'],0,15) == '[goalsAwayTeam:') {
        $parts = explode(':', $json['Updates']);
        $newscore = rtrim(array_pop($parts), ']');
        $data = array('Match' => array(
          'id' => $json['Id'],
          'points_team2' => intval($newscore)
        ));
        $this->log('away team goal');
        $this->updateresult($checkmatch, $data);
        die();
      }

      if (substr($json['Updates'],0,15) == '[goalsHomeTeam:') {
        // home team goal -> change result accordingly
        $parts = explode(':', $json['Updates']);
        $newscore = rtrim(array_pop($parts), ']');
        $data = array('Match' => array(
          'id' => $json['Id'],
          'points_team1' => intval($newscore)
        ));
        $this->log('home team goal');
        $this->updateresult($checkmatch, $data);
        die();
      }

      die();
    }
  }

  private function updateresult($checkmatch = null, $data = null) {
    if ($checkmatch == null || $data == null) {
      die();
    }
    if ($this->Match->save($data)) {
        // calculate tipps
      $realGoals1 = $data['Match']['points_team1'];
      $realGoals2 = $data['Match']['points_team2'];
      foreach ($checkmatch['Tipp'] as $key => $tipp) {
        $tippGoals1 = $tipp['Tipp']['points_team1'];
        $tippGoals2 = $tipp['Tipp']['points_team2'];
        // completely correct score?
        $points = 0;
        if ($realGoals1 == $tippGoals1 && $realGoals2 == $tippGoals2) {
          $points = 30;
        } elseif (min(1, max(-1, $tippGoals1 - $tippGoals2)) == min(1, max(-1, $realGoals1 - $realGoals2))) {
          $points = 12;
  
          //additional points for difference in total score
          switch (abs(($tippGoals1 - $tippGoals2) - ($realGoals1 - $realGoals2))) {
            case 0:
              $points = $points + 8;
              break;
            case 1:
              $points = $points + 4;
              break;
            case 2:
              $points = $points + 2;
              break;
            case 3:
              $points = $points + 1;
              break;
          }
  
            // additional points for difference in team score
          switch (abs($tippGoals1 - $realGoals1) + abs($tippGoals2 - $realGoals2)) {
            case 0:
              $points = $points + 8;
              break;
            case 1:
              $points = $points + 4;
              break;
            case 2:
              $points = $points + 2;
              break;
            case 3:
              $points = $points + 1;
              break;
          }
        }
        $tipp['Tipp']['points'] = $points;
        $this->Match->Tipp->save($tipp);
      }

      if ($checkmatch['Round']['groupstage'] == 1) {
        // recalculate group table
        $groupteams = $this->Team->find('list', array('conditions' => array('Team.group_id' => $checkmatch['Match']['group_id'])));
        // prepare working array
        $arrladder = array();
        foreach ($groupteams as $key => $groupteam) {
          $arrgt = array(
            'group_id' => $checkmatch['Match']['group_id'],
            'type' => 'real',
            'pos' => 0,
            'team_id' => $key,
            'matches' => 0,
            'points' => 0,
            'goodgoals' => 0,
            'badgoals' => 0,
            'goaldif' => 0,
            'won' => 0,
            'draw' => 0,
            'lost' => 0);
          $arrladder[$key] = $arrgt;
        }
        $groupmatches = $this->Match->find('all', 
          array('conditions' => array(
            'Match.group_id' => $checkmatch['Match']['group_id'])));
        foreach ($groupmatches as $key => $gmatch) {
          $team1_id = $gmatch['Match']['team1_id'];
          $team2_id = $gmatch['Match']['team2_id'];
          //goals
          $arrladder[$team1_id]['goodgoals'] =  $arrladder[$team1_id]['goodgoals'] + $gmatch['Match']['points_team1'];
          $arrladder[$team2_id]['goodgoals'] =  $arrladder[$team2_id]['goodgoals'] + $gmatch['Match']['points_team2'];
          $arrladder[$team1_id]['badgoals'] =  $arrladder[$team1_id]['badgoals'] + $gmatch['Match']['points_team2'];
          $arrladder[$team2_id]['badgoals'] =  $arrladder[$team2_id]['badgoals'] + $gmatch['Match']['points_team1'];
          $arrladder[$team1_id]['goaldif'] =  $arrladder[$team1_id]['goodgoals'] - $arrladder[$team1_id]['badgoals'];
          $arrladder[$team2_id]['goaldif'] =  $arrladder[$team2_id]['goodgoals'] - $arrladder[$team2_id]['badgoals'];
          //matches
          $arrladder[$team1_id]['matches']++;
          $arrladder[$team2_id]['matches']++;
          //points, won, drw, lost
          if ($gmatch['Match']['points_team1'] == $gmatch['Match']['points_team2']) {
            // let's call it a draw
            $arrladder[$team1_id]['points']++;
            $arrladder[$team2_id]['points']++;
            $arrladder[$team1_id]['draw']++;
            $arrladder[$team2_id]['draw']++;
          } elseif ($gmatch['Match']['points_team1'] > $gmatch['Match']['points_team2']) {
            // team 1 won
            $arrladder[$team1_id]['points'] = $arrladder[$team1_id]['points'] + 3;
            $arrladder[$team1_id]['won']++;
            $arrladder[$team2_id]['lost']++;
          } else {
            // team 2 won
            $arrladder[$team2_id]['points'] = $arrladder[$team2_id]['points'] + 3;
            $arrladder[$team2_id]['won']++;
            $arrladder[$team1_id]['lost']++;
          }
        }
        $arrladder = $this->array_orderby($arrladder, 'points', SORT_DESC, 'goaldif', SORT_DESC, 'goodgoals', SORT_DESC);
        $this->Ladder->deleteAll(array(
          'Ladder.group_id' => $groupid,
          'Ladder.type' => 'real' ), false);
        foreach ($arrladder as $poskey => $newlader) {
          $this->Ladder->create();
          $newLadder['Ladder'] = $newlader;
          $newLadder['Ladder']['pos'] = $poskey + 1;
          $this->Ladder->save($newLadder);
        }
      }
    }
  }
}
