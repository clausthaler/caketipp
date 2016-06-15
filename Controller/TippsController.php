<?php
App::uses('AppController', 'Controller');
/**
 * Tipps Controller
 *
 * @property Tipp $Tipp
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TippsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');



  public $uses = array(
    'Ladder',
    'Tipp',
    'Match', 
    'Round', 
    'Team', 
    'Group', 
    'User',
    'Question',
    'Timeline',
    'Usertimeline');

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
 * tippenter method
 *
 * @return void
 */
  public function entertipps($id = null) {
    $this->layout = 'default_new';

	  if ($this->request->is('post')) {
      if (isset($this->request->data['Tipp'])) {
        $tippmatches = $this->Match->find('list', array(
          'conditions' => array(
            'Match.id' => array_keys($this->request->data['Tipp'])),
          'fields' => array('id', 'due')));
        // validate the entries and clean up the array
        $tippErrors = array();
        foreach ($this->request->data['Tipp'] as $matchid => $tippresult) {
          // check if match due is over
          if (!isset($tippmatches[$matchid]) 
            || $tippmatches[$matchid] < strtotime($this->Session->read('currentdatetime'))
            || !is_numeric($tippresult['points1']) && !is_numeric($tippresult['points2'])
            ) {
            unset($this->request->data['Tipp'][$matchid]);
          } else {
            // check tipp results are valid
            if (!is_numeric($tippresult['points1']) || !is_numeric($tippresult['points2'])) {
              array_push($tippErrors, $matchid);
              unset($this->request->data['Tipp'][$matchid]);
            }
          }
        }
        // delete all valid tipps from database
        $this->Tipp->deleteAll(array(
          'Tipp.user_id' => $this->Auth->user('id'),
          'Tipp.match_id' => array_keys($this->request->data['Tipp']) ), false);
        // insert new tipps
        foreach ($this->request->data['Tipp'] as $matchid => $tippresult) {
          $this->Tipp->create();
          $newTipp = array(
            'Tipp' => array(
              'match_id' => $matchid, 
              'user_id' => $this->Auth->user('id'),
              'points_team1' => $tippresult['points1'],
              'points_team2' => $tippresult['points2']));
          if (!$this->Tipp->save($newTipp)) {
            array_push($tippErrors, $matchid);
          }
        }
        if (empty($tippErrors) ) {
          $this->Session->setFlash(__('Tipp saved successfully.'));
        } else {
          $this->Session->setFlash(__('Not all Tipps could be saved. Please correct errors and try again. Tipps are shown like they are saved at the moment'), 'default' , array('class' => 'warning'));
        }
      }

	  }
    
    if ($id == null) {
      // show actual round
      $this->Match->recursive = -1;
      $nextmatch = $this->Match->find('first', array(
        'conditions' => array('Match.due >' => strtotime($this->Session->read('currentdatetime'))), 
        'fields' => array('Match.round_id'),
        'order' => array('Match.due asc')));
      if (isset($nextmatch['Match']['round_id'])) {
        $id = $nextmatch['Match']['round_id'];
      } else {
        $id = 1;
      }
    }

    $this->Team->recursive = -1;
    $this->Group->recursive = -1;
    $this->Round->recursive = -1;
    $this->Match->recursive = -1;
    $this->Tipp->recursive = -1;
  	$teams = $this->Team->find('all', array('fields' => array('id', 'name', 'iconurl')));
  	$rounds = $this->Round->find('all', array('fields' => array('id', 'name', 'shortname')));
  	$groups = $this->Group->find('all', array('fields' => array('id', 'name', 'shortname')));
  	$this->set(compact('teams', 'groups', 'rounds'));
    $roundstotipp = Hash::extract($this->Match->query('select distinct round_id from matches where due >' . strtotime($this->Session->read('currentdatetime')) . ' order by round_id'), '{n}.matches.round_id');
    foreach ($roundstotipp as $round => $roundid) {
      $matches2tipp[$roundid] = $this->Match->find(
        'all', array(
          'conditions' => array(
            'Match.round_id' => $roundid,
            'Match.due >' => strtotime($this->Session->read('currentdatetime'))
          ),
          'order' => array(
            'Match.round_id', 
            'Match.datetime')));
    }
    $matches = $this->Match->find(
        'all', array(
          'conditions' => array(
            'Match.due >' => strtotime($this->Session->read('currentdatetime'))
          ),
          'fields' => array('id'),
          'order' => array(
            'Match.round_id', 
            'Match.datetime')));
    $this->set('matches2tipp', $matches2tipp);
    $this->set('roundId', $id);
    $this->set('tipps', $this->Tipp->find(
      'all', array(
        'conditions' => array(
          'Tipp.type' => 0,
          'Tipp.match_id' => Hash::extract( $matches, '{n}.Match.id'),
          'Tipp.user_id' => $this->Auth->user('id')))));
  }

/**
 * tippenter method
 *
 * @return void
 */
  public function enterbonus() {
    $this->Team->recursive = -1;
    $teams = $this->Team->find('list', array(
      'fields' => array('id', 'name'),
      'conditions' => array('Team.iso <>' => null)));
    if ($this->request->is('post')) {
      // validate the entries and clean up the array
      $tippErrors = array();
      foreach ($this->request->data['Question'] as $questionid => $tipp) {
        if (!isset($teams[$tipp])) {
          unset($this->request->data['Question'][$questionid]);
          array_push($tippErrors, $tipp);
        }
      }
      // delete all valid tipps from database
      $this->Tipp->deleteAll(array(
        'Tipp.type' => 1,
        'Tipp.user_id' => $this->Auth->user('id'),
        'Tipp.question_id' => array_keys($this->request->data['Question']) ), false);
      // insert new tipps
      foreach ($this->request->data['Question'] as $questionid => $tipp) {
        $this->Tipp->create();
        $newTipp = array(
          'Tipp' => array(
            'question_id' => $questionid, 
            'user_id' => $this->Auth->user('id'),
            'type' => 1,
            'team_id' => $tipp));
        if (!$this->Tipp->save($newTipp)) {
          array_push($tippErrors, $matchid);
        }
      }
      if (empty($tippErrors) ) {
        $this->Session->setFlash(__('Tipps saved successfully.'));
      } else {
        $this->Session->setFlash(__('Tipps could not be saved. Please correct errors and try again. Tipps are shown like they are saved at the moment'));
      }
    }
    $this->Question->recursive = -1;
    $this->Tipp->recursive = -1;
    $this->set(compact('teams'));
    $questions = $this->Question->find('all');

    $this->set('questions', $questions);
    $this->set('tipps', $this->Tipp->find(
      'all', array(
        'conditions' => array(
          'Tipp.question_id' => Hash::extract( $questions, '{n}.Question.id'),
          'Tipp.user_id' => $this->Auth->user('id')))));
  }


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Tipp->recursive = 0;
		$this->set('tipps', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Tipp->exists($id)) {
			throw new NotFoundException(__('Invalid tipp'));
		}
		$options = array('conditions' => array('Tipp.' . $this->Tipp->primaryKey => $id));
		$this->set('tipp', $this->Tipp->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Tipp->create();
			if ($this->Tipp->save($this->request->data)) {
				$this->Session->setFlash(__('The tipp has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tipp could not be saved. Please, try again.'));
			}
		}
		$matches = $this->Tipp->Match->find('list');
		$users = $this->Tipp->User->find('list');
		$this->set(compact('matches', 'users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Tipp->exists($id)) {
			throw new NotFoundException(__('Invalid tipp'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tipp->save($this->request->data)) {
				$this->Session->setFlash(__('The tipp has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tipp could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tipp.' . $this->Tipp->primaryKey => $id));
			$this->request->data = $this->Tipp->find('first', $options);
		}
		$matches = $this->Tipp->Match->find('list');
		$users = $this->Tipp->User->find('list');
		$this->set(compact('matches', 'users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Tipp->id = $id;
		if (!$this->Tipp->exists()) {
			throw new NotFoundException(__('Invalid tipp'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tipp->delete()) {
			$this->Session->setFlash(__('The tipp has been deleted.'));
		} else {
			$this->Session->setFlash(__('The tipp could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * 
 */
  public function fake() {
    exit();
    require_once '../vendor/autoload.php';

    // use the factory to create a Faker\Generator instance
    $faker = Faker\Factory::create();
    $matches = $this->Match->find('list', array(
      'fields' => array('id', 'name'),
      'conditions' => array('Match.isfixed' => 1)));
    $users = $this->User->find('list', array(
      'fields' => array('id', 'name')));

    foreach ($matches as $matchkey => $match) {
      foreach ($users as $userkey => $user) {
        $newTipp = array('Tipp' => array(
            'match_id' => $matchkey,
            'user_id' => $userkey,
            'type' => 0,
            'points_team1' => rand(0,7),
            'points_team2' => rand(0,7),
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
            ));
        $this->Tipp->create();
        if ($this->Tipp->save($newTipp)) {
          print_r($this->Tipp->id);
        }
      }
    }
    exit();
  }


  public function ranking() {
    if ($this->request->is('requested')) {
     return $users = $this->User->query('select * from (select a.id "id", a.username "username", a.photo "photo", a.photo_dir "photo_dir", (select sum(b.points) from tipps b where a.id = b.user_id) "sum" from users a
order by sum desc) c');
    } else {
      $this->Round->recursive = -1;
      $rounds = $this->Round->find('all', array('fields' => array('id', 'name', 'groupstage', 'shortname', 'slug')));
      $selrounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round'); 
      $rounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round.shortname'); 

      $this->Group->recursive = -1;
      $groups = $this->Group->find('all', array(
        'fields' => array('id', 'name', 'shortname', 'slug', 'round_id')));
      $roundgroups = Hash::combine($groups, '{n}.Group.id', '{n}.Group', '{n}.Group.round_id'); 
      $groups = Hash::combine($groups, '{n}.Group.id', '{n}.Group'); 


      // generate the round select values
      $roundsselarr = array('overview' => __('Ranking'));
      foreach ($selrounds as $rkey => $round) {
        if ($round['groupstage'] == 1) {
          $roundsselarr[$rkey] =  __($round['name']) . ' ' .  __('all');
          foreach ($roundgroups[$rkey] as $gkey => $rgroup) {
            $roundsselarr[$rkey . '-' . $gkey] =  '  ' . __($round['name']) . ' ' .  __($rgroup['name']);
          }
        } else {
          $roundsselarr[$rkey] =  __($round['name']);
        }
      }
      $roundsselarr['bonus'] = __('Bonus questions');
      $roundsselarr['timeline'] = __('Ranking timeline');

      $roundselected = 'overview';

      $rounds['groupbonus'] = __('Group bonus');
      $rounds['bonus'] = __('Bonus questions');
  
      $this->User->recursive = -1;
      $users = $this->User->find('list', array('fields' => array('id', 'username')));
      $tipps = array();
      foreach ($users as $id => $user) {
        $select = 'select ';
        foreach ($rounds as $key => $round) {
          if ($key == 'bonus') {
            $select = $select . '(select sum(points) from tipps where user_id = "' . $id . '" and type = 1) as "' . $round . '", ';
          } elseif ($key == 'groupbonus') {
              $select = $select . '(select sum(points) from tipps where user_id = "' . $id . '" and type = 2) as "' . $round . '", ';
          } else {
            $select = $select . '(select sum(points) from tipps where user_id = "' . $id . '" and match_id in (select id from matches where round_id = '. $key . ')) as "' . $round . '", ';
          }
        }
        $select = $select . 'sum(points) as "total" from tipps where user_id = "' . $id . '"';
        $usertipps = $this->User->query($select);
        $tipps[$id] = $usertipps[0][0];
      }
  
      $tipps = Hash::sort($tipps, '{s}.total', 'desc');
      $this->set('users', $users);
      $this->set('rounds', $rounds);
      $this->set('tipps', $tipps);
      $this->set('roundsselarr', $roundsselarr);
      $this->set('roundselected', $roundselected);
    }
  }


  public function toptipps() {
    if ($this->request->is('requested')) {
      // find last 5 matches
      $this->Match->recursive = -1;
      $matches = $this->Match->find(
        'all', array(
          'fields' => array('id','name','points_team1','points_team2','extratime'),
          'conditions' => array(
            'isfinished' => 1), 
          'order' => array('Match.datetime desc'),
          'limit' => 5));
      $matchlist = Hash::extract( $matches, '{n}.Match.id');

      $this->Tipp->recursive = 1;
      return $toptipps = $this->Tipp->find(
        'all', array(
          'conditions' => array(
            'Tipp.match_id' => $matchlist),
          'order' => 'points desc',
          'limit' => 10));
    }
  }  
  /**
   * 
   */
  public function overview() {
    $this->Round->recursive = -1;
    $rounds = $this->Round->find('all', array('fields' => array('id', 'name', 'groupstage', 'shortname', 'slug')));
    if (isset($this->params['named']['round']) && array_key_exists($this->params['named']['round'], Hash::combine($rounds, '{n}.Round.id'))) {
      $tipproundid = $this->params['named']['round'];
    } else {
      // todo: set current round according to date
      $tipproundid = $rounds[0]['Round']['id'];
    }
    $rounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round'); 

    $this->Group->recursive = -1;
    $groups = $this->Group->find('all', array(
      'fields' => array('id', 'name', 'shortname', 'slug', 'round_id')));
    $roundgroups = Hash::combine($groups, '{n}.Group.id', '{n}.Group', '{n}.Group.round_id'); 
    $groups = Hash::combine($groups, '{n}.Group.id', '{n}.Group'); 

    $this->Team->recursive = -1;
    $teams = $this->Team->find('all', array('fields' => array('id', 'name', 'iconurl', 'iso')));
    $teams = Hash::combine($teams, '{n}.Team.id', '{n}.Team'); 

    $this->User->recursive = -1;
    $users = $this->User->find('all', array('fields' => array('id', 'username')));
    $users = Hash::combine($users, '{n}.User.id', '{n}.User'); 

    // generate the round select values
    $roundsselarr = array('overview' => __('Ranking'));
    foreach ($rounds as $rkey => $round) {
      if ($round['groupstage'] == 1) {
        $roundsselarr[$rkey] =  __($round['name']) . ' ' .  __('all');
        foreach ($roundgroups[$rkey] as $gkey => $rgroup) {
          $roundsselarr[$rkey . '-' . $gkey] =  '  ' . __($round['name']) . ' ' .  __($rgroup['name']);
        }
      } else {
        $roundsselarr[$rkey] =  __($round['name']);
      }
    }
    $roundsselarr['bonus'] = __('Bonus questions');
    $roundsselarr['timeline'] = __('Ranking timeline');

    // get the matches and tipps for the round
    $conditions = array('Match.round_id' => $tipproundid);
    if (isset($this->params['named']['group'])) {
      $conditions['Match.group_id'] = $this->params['named']['group'];
      $roundselected = $tipproundid . '-' . $this->params['named']['group'];
    } else {
      $roundselected = '' . $tipproundid;
    }

    // generate the from and to match select list
    $this->Match->recursive = -1;
    $fromtomatches = $this->Match->find(
      'list', array(
        'fields' => array('id','name'),
        'conditions' => $conditions, 
        'order' => array('Match.datetime')));
    if (isset($this->params['named']['from_match'])) {
      $conditions['Match.id >='] = $this->params['named']['from_match'];
      $frommatch = $this->params['named']['from_match'];
    } else {
      $frommatch = false;
    }
    if (isset($this->params['named']['to_match'])) {
      $conditions['Match.id <='] = $this->params['named']['to_match'];
      $tomatch = $this->params['named']['to_match'];
    } else {
      if ($tipproundid == 1) {
//  Don't know why I limited to  and kickoff < " . time()
//        $toM = $this->Tipp->query("select max(kickoff) as 'lastgame' from matches where round_id = " . $tipproundid . " and kickoff < " . time() );
        $toM = $this->Tipp->query("select max(kickoff) as 'lastgame' from matches where round_id = " . $tipproundid );
        $tomatch = $toM[0][0]['lastgame'];
        $conditions['Match.id <='] = $tomatch;
      } else {
        $tomatch = false;
      }
    }

    // get all matches according to conditions 
    $this->Match->recursive = -1;
    $matches = $this->Match->find(
      'all', array(
        'fields' => array('id','name','kickoff', 'due', 'group_id','team1_id', 'team2_id','round_id','points_team1','points_team2','extratime', 'isfinished'),
        'conditions' => $conditions, 
        'order' => array('Match.datetime')));
    $this->set('matches', $matches);
      $matchlist = Hash::extract( $matches, '{n}.Match.id');

    foreach ($users as $userid => $user) {
      $this->Tipp->recursive = -1;
      $usertipps = $this->Tipp->find(
      'all', array(
        'conditions' => array(
          'Tipp.match_id' => $matchlist,
          'Tipp.user_id' => $userid)));    
      $users[$userid]['Tipps'] = Hash::combine($usertipps, '{n}.Tipp.match_id', '{n}.Tipp');
      $total = $this->Tipp->find('first', array('conditions' => array(
          'Tipp.match_id' => $matchlist,
          'Tipp.user_id' => $userid),
          'fields'=>array('SUM(Tipp.points) as total')));
      $users[$userid]['roundtotal'] = $total[0]['total'];
        # code...
    }
    $users = Hash::sort($users, '{s}.roundtotal', 'desc');

    $this->set('matches', $matches);
    $this->set('users', $users);
    $this->set(compact('teams', 'groups', 'matchlist', 'rounds', 'roundsselarr', 'tipproundid', 'fromtomatches', 'roundselected', 'frommatch', 'tomatch'));
  }

  public function statistics($username = null) {
    if (!$username) {
      $user['User'] = $this->Auth->user();
    } else {
      $options = array('conditions' => array('User.username' => $username));
      $user = $this->User->find('first', $options);
      if (empty($user)) {
        exit();
      }
    }

    $maxdifftotop = $this->Usertimeline->query('select max(difftotop) as "maxdiff" from usertimelines where user_id = "' . $user['User']['id'] . '";');
    if (!empty($maxdifftotop)) {
      $maxdiff = $maxdifftotop[0][0]['maxdiff'];
    } else {
      $maxdiff = 0;
    }

    $usertimelines = $this->Usertimeline->find('all',
      array(
        'fields' => array('timeline_id', 'position', 'points', 'points_total', 'difftotop'),
        'conditions' => array('Usertimeline.user_id' => $user['User']['id'])
        ));
    $this->set(compact('usertimelines', 'maxdiff'));

    $this->User->recursive = -1;
    $users = $this->User->find('list', array('fields' => array('username', 'username')));
    $usercount = count($users);
#    $users = Hash::extract($users, '{s}'); 

    $tipps = $this->Tipp->query('select result, count(*) as "count" from (select CASE WHEN points_team2 > points_team1 THEN CONCAT(CONCAT(points_team2, " : "), points_team1) WHEN points_team2 > points_team1 THEN CONCAT(CONCAT(points_team1, " : "), points_team2) ELSE CONCAT(CONCAT(points_team1, " : "), points_team2) END as "result", points from tipps where user_id = "' . $user['User']['id'] . '" and type = 0) a group by result order by result desc');

    $tipphits = $this->Tipp->query('select x.type, count(*) as "count" from (select CONCAT(CONCAT(b.points_team1, " : "), b.points_team2) as "result", CONCAT(CONCAT(a.points_team1, " : "), a.points_team2) as "tipp" ,CASE WHEN a.points_team1 = b.points_team1 and a.points_team2 = b.points_team2 THEN "Ergebnis" WHEN a.points_team1 - a.points_team2 = b.points_team1 - b.points_team2 THEN "Tordifferenz" WHEN a.points_team1 > a.points_team2 and b.points_team1 > b.points_team2 or a.points_team1 < a.points_team2 and b.points_team1 < b.points_team2 THEN "Tendenz" ELSE "daneben" END as "type" from tipps a, matches b where a.user_id = "' . $user['User']['id'] . '" and a.match_id = b.id and a.type = 0 and b.isfinished = 1) x group by type order by count');

    $resultsTipps = $this->Tipp->query('select result, count(*) as "count", sum(points) as "points", sum(points) / count(*) as "average" from (select CASE WHEN points_team2 > points_team1 THEN CONCAT(CONCAT(points_team2, " : "), points_team1) WHEN points_team2 > points_team1 THEN CONCAT(CONCAT(points_team1, " : "), points_team2) ELSE CONCAT(CONCAT(points_team1, " : "), points_team2) END as "result", points from tipps where user_id = "' . $user['User']['id'] . '" and type = 0 and match_id in (select id from matches where isfinished = 1)) a group by result order by result desc');

    $countries = $this->Tipp->query('select * from (select x.country, sum(x.points) as "pointstotal", (sum(x.points) / count(*)) as "pointspergame" from (select a.name as "country", c.points as "points" from teams a, matches b, tipps c where (a.id = b.team1_id or a.id = b.team2_id) and b.isfinished = 1 and b.id = c.match_id and c.user_id = "' . $user['User']['id'] . '") x group by x.country order by sum(x.points) desc limit 10) x order by 2 asc;');
    $this->set(compact('resultsTipps', 'tipps', 'countries', 'users', 'user', 'tipphits', 'usercount'));



  }

  public function bonusquestions() {
    $possibleanswers = array(
      '1' => array('139'),     // Weltmeister
      '2' => array('1469')      // Torschütze
      );

    $this->Round->recursive = -1;
    $rounds = $this->Round->find('all', array('fields' => array('id', 'name', 'groupstage', 'shortname', 'slug')));
    $selrounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round'); 
    $rounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round.shortname'); 

    $this->Group->recursive = -1;
    $groups = $this->Group->find('all', array(
      'fields' => array('id', 'name', 'shortname', 'slug', 'round_id')));
    $roundgroups = Hash::combine($groups, '{n}.Group.id', '{n}.Group', '{n}.Group.round_id'); 
    $groups = Hash::combine($groups, '{n}.Group.id', '{n}.Group'); 


    // generate the round select values
    $roundsselarr = array('overview' => __('Ranking'));
    foreach ($selrounds as $rkey => $round) {
      if ($round['groupstage'] == 1) {
        $roundsselarr[$rkey] =  __($round['name']) . ' ' .  __('all');
        foreach ($roundgroups[$rkey] as $gkey => $rgroup) {
          $roundsselarr[$rkey . '-' . $gkey] =  '  ' . __($round['name']) . ' ' .  __($rgroup['name']);
        }
      } else {
        $roundsselarr[$rkey] =  __($round['name']);
      }
    }
    $roundselected = 'bonus';
    $roundsselarr['timeline'] = __('Ranking timeline');

    $roundsselarr['bonus'] = __('Bonus');
  

    $this->Tipp->unbindModel(
        array('belongsTo' => array('Match'))
    );    
    $tipps = $this->Tipp->find('all',
      array(
        'conditions' => array('Tipp.type' => 1),
        'order' => array('lower(User.username)', 'Tipp.question_id')));
    $tipps = Hash::combine($tipps, '{n}.Tipp.question_id', '{n}.Tipp', '{n}.User.username'); 

    $this->User->recursive = -1;
    $users = $this->User->find('all', array('fields' => array('id', 'username'), 'order' => array('lower(User.username)')));
    $users = Hash::combine($users, '{n}.User.id', '{n}.User'); 

    $this->Team->recursive = -1;
    $teams = $this->Team->find('all', array('fields' => array('id', 'name', 'iconurl', 'iso')));
    $teams = Hash::combine($teams, '{n}.Team.id', '{n}.Team'); 

    $this->Question->recursive = -1;
    $questions = $this->Question->find('all', array('fields' => array('id', 'name', 'text', 'points', 'team_id')));
    $questions = Hash::combine($questions, '{n}.Question.id', '{n}.Question'); 
    
    $this->set(compact('questions', 'teams', 'users', 'possibleanswers'));
    $this->set('tipps', $tipps);
    $this->set('rounds', $rounds);
    $this->set('roundsselarr', $roundsselarr);
    $this->set('roundselected', $roundselected);
  }

  public function admin_generategrouptables() {
    $this->User->recursive = -1;
    $users = $this->User->find('all', array('fields' => array('id', 'username'), 'order' => array('lower(User.username)')));
    foreach ($users as $key => $user) {
      $userid = $user['User']['id'];
      $this->Group->recursive = -1;
      $groups = $this->Group->find('list', array(
        'fields' => array('id'),
        'conditions' => array('round_id' => 1)));
      foreach ($groups as $group) {
        // get all group team first
        $this->Team->recursive = -1;
        $groupteams = $this->Team->find('list', array('conditions' => array('Team.group_id' => $group)));

        // next get the group matches
        $this->Match->recursive = -1;
        $groupmatches = $this->Match->find('all', array(
          'fields' => array('id'),
          'conditions' => array('group_id' => $group)));
        $groupmatches = Hash::extract($groupmatches, '{n}.Match.id'); 

        // and than all users tipps for this group matches
        $this->Tipp->recursive = 0;
        $this->Tipp->unbindModel(
          array('belongsTo' => array('User'))
        );    
        $usertipps = $this->Tipp->find('all', array(
          'conditions' => array(
            'Tipp.match_id' => $groupmatches,
            'Tipp.user_id' => $userid)));

        // prepare working array
        $arrladder = array();
        foreach ($groupteams as $key => $groupteam) {
          $arrgt = array(
            'group_id' => $group,
            'user_id' => $userid,
            'type' => 'tipp',
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

        // calculate all tipps to build a ladder
        foreach ($usertipps as $key => $usertipp) {
          $team1_id = $usertipp['Match']['team1_id'];
          $team2_id = $usertipp['Match']['team2_id'];
          //goals
          $arrladder[$team1_id]['goodgoals'] =  $arrladder[$team1_id]['goodgoals'] + $usertipp['Tipp']['points_team1'];
          $arrladder[$team2_id]['goodgoals'] =  $arrladder[$team2_id]['goodgoals'] + $usertipp['Tipp']['points_team2'];
          $arrladder[$team1_id]['badgoals'] =  $arrladder[$team1_id]['badgoals'] + $usertipp['Tipp']['points_team2'];
          $arrladder[$team2_id]['badgoals'] =  $arrladder[$team2_id]['badgoals'] + $usertipp['Tipp']['points_team1'];
         $arrladder[$team1_id]['goaldif'] =  $arrladder[$team1_id]['goodgoals'] - $arrladder[$team1_id]['badgoals'];
          $arrladder[$team2_id]['goaldif'] =  $arrladder[$team2_id]['goodgoals'] - $arrladder[$team2_id]['badgoals'];
          //matches
          $arrladder[$team1_id]['matches']++;
          $arrladder[$team2_id]['matches']++;
          //points, won, drw, lost
          if ($usertipp['Tipp']['points_team1'] == $usertipp['Tipp']['points_team2']) {
           // let's call it a draw
            $arrladder[$team1_id]['points']++;
            $arrladder[$team2_id]['points']++;
            $arrladder[$team1_id]['draw']++;
            $arrladder[$team2_id]['draw']++;
          } elseif ($usertipp['Tipp']['points_team1'] > $usertipp['Tipp']['points_team2']) {
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

        // write the ladder
        $this->Ladder->deleteAll(array(
          'Ladder.group_id' => $group,
          'Ladder.type' => 'tipp',
          'Ladder.user_id' =>  $userid), false);

        foreach ($arrladder as $poskey => $newlader) {
          $this->Ladder->create();
          $newLadder['Ladder'] = $newlader;
          $this->Ladder->save($newLadder);
        }
      }
    }
  }

  public function timeline() {
      $this->Round->recursive = -1;
      $rounds = $this->Round->find('all', array('fields' => array('id', 'name', 'groupstage', 'shortname', 'slug')));
      $selrounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round'); 
      $rounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round.shortname'); 

      $this->Group->recursive = -1;
      $groups = $this->Group->find('all', array(
        'fields' => array('id', 'name', 'shortname', 'slug', 'round_id')));
      $roundgroups = Hash::combine($groups, '{n}.Group.id', '{n}.Group', '{n}.Group.round_id'); 
      $groups = Hash::combine($groups, '{n}.Group.id', '{n}.Group'); 


      // generate the round select values
      $roundsselarr = array('overview' => __('Ranking'));
      foreach ($selrounds as $rkey => $round) {
        if ($round['groupstage'] == 1) {
          $roundsselarr[$rkey] =  __($round['name']) . ' ' .  __('all');
          foreach ($roundgroups[$rkey] as $gkey => $rgroup) {
            $roundsselarr[$rkey . '-' . $gkey] =  '  ' . __($round['name']) . ' ' .  __($rgroup['name']);
          }
        } else {
          $roundsselarr[$rkey] =  __($round['name']);
        }
      }
      $roundsselarr['bonus'] = __('Bonus questions');
      $roundselected = 'overview';

      $rounds['groupbonus'] = __('Group bonus');
      $rounds['bonus'] = __('Bonus questions');
  
      $this->User->recursive = -1;
      $users = $this->User->find('list', array('fields' => array('id', 'username')));

      $this->Timeline->recursive = -1;
      $timelines = $this->Timeline->find('all',
        array(
          'fields' => array('Timeline.id'),
          'conditions' => array('Timeline.finished' => 1)));

      $usertimelines = $this->Usertimeline->find('all',
        array(
          'fields' => array('timeline_id', 'position', 'points', 'points_total', 'difftotop', 'user_id'),
          'conditions' => array('Usertimeline.timeline_id' => Hash::extract( $timelines, '{n}.Timeline.id')),
          'order' => array('Usertimeline.timeline_id', 'Usertimeline.points_total desc')
          ));
      $usertimelines = Hash::combine($usertimelines, '{n}.Usertimeline.timeline_id', '{n}.Usertimeline', '{n}.Usertimeline.user_id');

      $this->set('usertimelines', $usertimelines);
      $this->set('users', $users);
      $this->set('rounds', $rounds);
      $this->set('roundsselarr', $roundsselarr);
      $this->set('roundselected', $roundselected);
  }

/**
 * admin_index method
 *
 * @return void
 */
  public function tipptables() {
    $this->layout = 'default_new';
    $this->Group->recursive = 1;
    $groups = $this->Group->find('all', array('fields' => array('id', 'name', 'shortname')));
    $this->Team->recursive = -1;
    $teams = $this->Team->find('all', array(
      'fields' => array('id', 'name', 'iconurl'),
      'conditions' => array('group_id >=' => 1)));
    $teams = Hash::combine($teams, '{n}.Team.id', '{n}.Team');



    foreach ($groups as $key => $group) {
      $groupid = $group['Group']['id'];
      $this->Tipp->recursive = -1;
      $tipps = $this->Tipp->find('all',
        array(
        'order' => 'Tipp.match_id',
        'conditions' => array(
          'Tipp.match_id' => Hash::extract($group['Match'], '{n}.id'),
          'Tipp.user_id' => $this->Auth->user('id'))));
      $matches = Hash::combine($group['Match'], '{n}.id', '{n}');
      $groups[$key]['Tipp'] = Hash::combine($tipps, '{n}.Tipp.match_id', '{n}.Tipp');

      // calculate tipp table
      $arrladder = array();
      foreach ($group['Team'] as $groupteam) {
        $arrgt = array(
          'group_id' => $groupteam['group_id'],
          'pos' => 0,
          'team_id' => $groupteam['id'],
          'matches' => 0,
          'points' => 0,
          'goodgoals' => 0,
          'badgoals' => 0,
          'goaldif' => 0,
          'won' => 0,
          'draw' => 0,
          'lost' => 0);
        $arrladder[$groupteam['id']] = $arrgt;
      }
      foreach ($groups[$key]['Tipp'] as $tipp) {
        $team1_id = $matches[$tipp['match_id']]['team1_id'];
        $team2_id = $matches[$tipp['match_id']]['team2_id'];
        //goals
        $arrladder[$team1_id]['goodgoals'] =  $arrladder[$team1_id]['goodgoals'] + $tipp['points_team1'];
        $arrladder[$team2_id]['goodgoals'] =  $arrladder[$team2_id]['goodgoals'] + $tipp['points_team2'];
        $arrladder[$team1_id]['badgoals'] =  $arrladder[$team1_id]['badgoals'] + $tipp['points_team2'];
        $arrladder[$team2_id]['badgoals'] =  $arrladder[$team2_id]['badgoals'] + $tipp['points_team1'];
        $arrladder[$team1_id]['goaldif'] =  $arrladder[$team1_id]['goodgoals'] - $arrladder[$team1_id]['badgoals'];
        $arrladder[$team2_id]['goaldif'] =  $arrladder[$team2_id]['goodgoals'] - $arrladder[$team2_id]['badgoals'];
        //matches
        $arrladder[$team1_id]['matches']++;
        $arrladder[$team2_id]['matches']++;
        //points, won, drw, lost
        if ($tipp['points_team1'] == $tipp['points_team2']) {
          // let's call it a draw
          $arrladder[$team1_id]['points']++;
          $arrladder[$team2_id]['points']++;
          $arrladder[$team1_id]['draw']++;
          $arrladder[$team2_id]['draw']++;
        } elseif ($tipp['points_team1'] > $tipp['points_team2']) {
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
      $groups[$key]['Ladder'] =$arrladder;

    }

    $this->set(compact('teams', 'groups'));
  }
}