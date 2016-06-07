<?php
App::uses('AppController', 'Controller');
/**
 * Timelines Controller
 *
 * @property Timeline $Timeline
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TimelinesController extends AppController {

  public $uses = array('Timeline', 'Group', 'Match', 'Tipp', 'Round', 'User', 'Question', 'Usertimeline');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Timeline->recursive = 0;
		$this->set('timelines', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Timeline->exists($id)) {
			throw new NotFoundException(__('Invalid timeline'));
		}
		$options = array('conditions' => array('Timeline.' . $this->Timeline->primaryKey => $id));
		$this->set('timeline', $this->Timeline->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Timeline->create();
			if ($this->Timeline->save($this->request->data)) {
				$this->Session->setFlash(__('The timeline has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The timeline could not be saved. Please, try again.'));
			}
		}
		$matches = $this->Timeline->Match->find('list');
		$groups = $this->Timeline->Group->find('list');
		$questions = $this->Timeline->Question->find('list');
		$this->set(compact('matches', 'groups', 'questions'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Timeline->exists($id)) {
			throw new NotFoundException(__('Invalid timeline'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Timeline->save($this->request->data)) {
				$this->Session->setFlash(__('The timeline has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The timeline could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Timeline.' . $this->Timeline->primaryKey => $id));
			$this->request->data = $this->Timeline->find('first', $options);
		}
		$matches = $this->Timeline->Match->find('list');
		$groups = $this->Timeline->Group->find('list');
		$questions = $this->Timeline->Question->find('list');
		$this->set(compact('matches', 'groups', 'questions'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Timeline->id = $id;
		if (!$this->Timeline->exists()) {
			throw new NotFoundException(__('Invalid timeline'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Timeline->delete()) {
			$this->Session->setFlash(__('The timeline has been deleted.'));
		} else {
			$this->Session->setFlash(__('The timeline could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

  public function admin_initialize () {
    $timelines = $this->Timeline->find('all');
    if (!empty($timelines)) {
      die('timelien is allready set');
      # code...
    }

    $this->Round->recursive = 0;
    $rounds = $this->Round->find('all',
      array(
        'order' => array('id')));
    foreach ($rounds as $key => $round) {
      $this->Match->recursive = 0;
      $roundmatches = $this->Match->find('all',
        array(
          'conditions' => array('Match.round_id' => $round['Round']['id']),
          'order' => array('kickoff')));
      foreach ($roundmatches as $key => $match) {
        $this->Timeline->create();
        $newTimeline['Timeline'] = array(
            'type' => 0, 
            'match_id' => $match['Match']['id'],
            'name' => $match['Team1']['iso'] . '-' . $match['Team2']['iso'],
            'finished' => $match['Match']['isfinished']);
        $this->Timeline->save($newTimeline);
        print_r(array(
          'Timeline' => array(
            'type' => 0, 
            'match_id' => $match['Match']['id'],
            'name' => $match['Team1']['iso'] . '-' . $match['Team2']['iso'],
            'finished' => $match['Match']['isfinished'])));
      }
      if ($round['Round']['groupstage'] == 1) {
        $this->Group->recursive = -1;
        $roundgroups = $this->Group->find('all',
          array(
            'conditions' => array('Group.round_id' => $round['Round']['id']),
            'order' => array('id')));
        foreach ($roundgroups as $key => $group) {
          $opengroupmatches = $this->Match->find('first',
            array(
            'conditions' => array(
              'Match.group_id' => $group['Group']['id'],
              'Match.isfinished <>' => 1)));
          if (empty($opengroupmatches)) {
            $finished = 1;
          } else {
            $finished = 0;
          }
          $this->Timeline->create();
          $newTimeline['Timeline'] = array(
            'type' => 2, 
            'group_id' => $group['Group']['id'],
            'name' => $group['Group']['shortname'],
            'finished' => $finished);
          $this->Timeline->save($newTimeline);
        }
      }
    }
    $this->Question->recursive = -1;
    $questions = $this->Question->find('all',
      array(
        'order' => array('Question.id')));
    foreach ($questions as $key => $question) {
      if ($question['Question']['team_id']) {
        $finished = 1;
      } else {
        $finished = 0;
      }
      $this->Timeline->create();
      $newTimeline['Timeline'] = array(
        'type' => 1, 
        'question_id' => $question['Question']['id'],
        'name' => $question['Question']['name'],
        'finished' => $finished);
      $this->Timeline->save($newTimeline);
    }
  }

  public function admin_initusertimelines() {
    $this->Timeline->recursive = -1;
    $timelines = $this->Timeline->find('all', array('order' => 'Timeline.id'));
    $timelines = Hash::combine($timelines, '{n}.Timeline.id', '{n}.Timeline');

    $this->User->recursive = -1;
    $users = $this->User->find('list', array('fields' => array('id', 'username')));
    foreach ($users as $userid => $user) {

      $lasttimeline = 0;
      $userpoints = 0;
      foreach ($timelines as $key => $entry) {
        $tipppoints = 0;
        switch ($entry['type']) {
          case 0:
            if ($entry['finished'] == 1) {
              $this->Tipp->recursive = -1;
              $tipp = $this->Tipp->find('first',
                array('conditions' => array(
                  'Tipp.user_id' => $userid,
                  'Tipp.match_id' => $entry['match_id'],
                  'Tipp.type' => 0)));
              if (!empty($tipp)) {
                $tipppoints = $tipp['Tipp']['points'];
                $userpoints = $userpoints + $tipppoints;
              }
              $this->Usertimeline->create();
              $newTimeline['Usertimeline'] = array(
                'timeline_id' => $key, 
                'user_id' => $userid,
                'points' => $tipppoints,
                'points_total' => $userpoints);
              $this->Usertimeline->save($newTimeline);
            }
            break;
          case 1:
            if ($entry['finished'] == 1) {
              $this->Tipp->recursive = -1;
              $tipp = $this->Tipp->find('first',
                array('conditions' => array(
                  'Tipp.user_id' => $userid,
                  'Tipp.question_id' => $entry['question_id'],
                  'Tipp.type' => 1)));
              if (!empty($tipp)) {
                $tipppoints = $tipp['Tipp']['points'];
                $userpoints = $userpoints + $tipppoints;
              }
              $this->Usertimeline->create();
              $newTimeline['Usertimeline'] = array(
                'timeline_id' => $key, 
                'user_id' => $userid,
                'points' => $tipppoints,
                'points_total' => $userpoints);
              $this->Usertimeline->save($newTimeline);
            }
            break;
          case 2:
            $this->Tipp->recursive = -1;
            $tipp = $this->Tipp->find('first',
              array('conditions' => array(
                'Tipp.user_id' => $userid,
                'Tipp.group_id' => $entry['group_id'],
                'Tipp.type' => 2)));
            if (!empty($tipp)) {
              $tipppoints = $tipp['Tipp']['points'];
              $userpoints = $userpoints + $tipppoints;
            }
            $this->Usertimeline->create();
            $newTimeline['Usertimeline'] = array(
              'timeline_id' => $key, 
              'user_id' => $userid,
              'points' => $tipppoints,
              'points_total' => $userpoints);
            $this->Usertimeline->save($newTimeline);
            break;
        }
      }
    }
    $this->render = false;
  }

  public function admin_calculatepositions() {
    $this->Timeline->recursive = -1;
    $timelines = $this->Timeline->find('all', array('order' => 'Timeline.id'));
    $timelines = Hash::combine($timelines, '{n}.Timeline.id', '{n}.Timeline');

    foreach ($timelines as $key => $entry) {
      if ($entry['finished'] == 1) {
        $this->Usertimeline->recursive = -1;
        $usertimelines = $this->Usertimeline->find('all',
          array(
            'conditions' => array('Usertimeline.timeline_id' => $key),
            'order' => array('Usertimeline.points_total desc')));
        $maxpoints = $usertimelines[0]['Usertimeline']['points_total'];
  
        $position = 1;
        $lastpoints = 0;
        $count = 0;
        foreach ($usertimelines as $id => $userentry) {
          $userentry['Usertimeline']['difftotop'] = $maxpoints - $userentry['Usertimeline']['points_total'];
          $count ++;
          if ($userentry['Usertimeline']['points_total'] != $lastpoints) {
            $position = $count;
          }
          $userentry['Usertimeline']['position'] = $position;
          $lastpoints = $userentry['Usertimeline']['points_total'];
          $this->Usertimeline->save($userentry);
        }
      }
    }
    $this->render = false;
  }
}


