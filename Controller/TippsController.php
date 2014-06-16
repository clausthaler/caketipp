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
    'Tipp',
    'Match', 
    'Round', 
    'Team', 
    'Group', 
    'User',
    'Question');


/**
 * tippenter method
 *
 * @return void
 */
  public function entertipps($id = null) {
	  if ($this->request->is('post')) {
      $tippmatches = $this->Match->find('list', array(
        'conditions' => array(
          'Match.id' => array_keys($this->request->data['Tipp'])),
        'fields' => array('id', 'due')));
      // validate the entries and clean up the array
      $tippErrors = array();
      foreach ($this->request->data['Tipp'] as $matchid => $tippresult) {
        if (!isset($tippmatches[$matchid]) || $tippmatches[$matchid] < strtotime($this->Session->read('currentdatetime'))) {
          unset($this->request->data['Tipp'][$matchid]);
        } else {
          if (!is_numeric($tippresult['points1']) && !is_numeric($tippresult['points2'])) {
            unset($this->request->data['Tipp'][$matchid]);
          } else {
            if (!is_numeric($tippresult['points1']) || !is_numeric($tippresult['points2'])) {
              array_push($tippErrors, $matchid);
              unset($this->request->data['Tipp'][$matchid]);
            }
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
        $this->Session->setFlash(__('Tipp could not be saved. Please correct errors and try again. Tipps are shown like they are saved at the moment'));
      }
	  }
    
    if ($id == null) {
      $id = 1;
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
    $matches = $this->Match->find(
      'all', array(
        'conditions' => array(
          'Match.round_id' => $id)
        , 'order' => array(
          'Match.round_id', 
          'Match.datetime')));
    $this->set('matches', $matches);
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
     return $users = $this->User->query('select * from (select a.id "id", a.username "username", (select sum(b.points) from tipps b where a.id = b.user_id) "sum" from users a
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
      $roundselected = 'overview';

      $rounds['bonus'] = __('Bonus');
  
      $this->User->recursive = -1;
      $users = $this->User->find('list', array('fields' => array('id', 'username')));
      $tipps = array();
      foreach ($users as $id => $user) {
        $select = 'select ';
        foreach ($rounds as $key => $round) {
          if ($key == 'bonus') {
            $select = $select . '(select sum(points) from tipps where user_id = "' . $id . '" and type = 1) as "' . $round . '", ';
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
        $toM = $this->Tipp->query("select max(id) as 'lastgame' from matches where round_id = " . $tipproundid . " and kickoff < " . time() );
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
}
