<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class GroupsController extends AppController {

  public $uses = array('Group', 'Match', 'Tipp', 'Ladder', 'User');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Group->recursive = 0;
		$this->set('groups', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
		$this->set('group', $this->Group->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}
		}
		$rounds = $this->Match->Round->find('list');
		$this->set(compact('rounds'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$rounds = $this->Match->Round->find('list');
			$this->set(compact('rounds'));
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
    $this->request->onlyAllow('post', 'delete');
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}

    $matches = $this->Match->find('all',
      array('conditions' => array(
        'Match.group_id' => $id)));
    if (!empty($matches)) {
      $this->Session->setFlash(__('The group has matches already.'));
      return $this->redirect(array('action' => 'index'));
    }
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('The group has been deleted.'));
		} else {
			$this->Session->setFlash(__('The group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
  public function admin_generategroupbonus() {
    $this->User->recursive = -1;
    $users = $this->User->find('all', array('fields' => array('id', 'username'), 'order' => array('lower(User.username)')));
    foreach ($users as $key => $user) {
      $userid = $user['User']['id'];
      $this->Group->recursive = -1;
      $groups = $this->Group->find('all', array('fields' => array('id', 'name', 'shortname')));

      $this->Match->recursive = -1;
      $matches = $this->Match->find(
        'all', 
        array('order' => array(
          'Match.round_id', 
          'Match.datetime'),
          'conditions' => array('group_id' => Hash::extract($groups, '{n}.Group.id'))));

      $this->Tipp->recursive = -1;
      $tipps = $this->Tipp->find('all',
        array(
          'order' => 'Tipp.match_id',
          'conditions' => array(
            'Tipp.match_id' => Hash::extract($matches, '{n}.Match.id'),
            'Tipp.user_id' => $user['User']['id'])));

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

      $this->Ladder->recursive = -1;
      $ladders = $this->Ladder->find(
        'all', 
        array('order' => array(
          'Ladder.group_id', 
          'Ladder.points desc',
          'Ladder.goodgoals - Ladder.badgoals desc',
          'Ladder.goodgoals desc'),
          'conditions' => array('type' => 'real')));

      $matches = Hash::combine($matches, '{n}.Match.id', '{n}.Match', '{n}.Match.group_id');
      $tipps = Hash::combine($tipps, '{n}.Tipp.match_id', '{n}.Tipp');
      $ladders = Hash::combine($ladders, '{n}.Ladder.id', '{n}.Ladder', '{n}.Ladder.group_id');
      $tippladders = Hash::combine($tippladders, '{n}.Ladder.id', '{n}.Ladder', '{n}.Ladder.group_id');

      foreach ($groups as $groupkey => $group) {
        $groupid = $group['Group']['id']; 
        $ladders[$groupid] = Hash::combine($ladders[$groupid], '{n}.team_id', '{n}'); 
        $tippladders[$groupid] = Hash::combine($tippladders[$groupid], '{n}.team_id', '{n}'); 

        $pos = 1;
        foreach ($ladders[$groupid] as $ladderkey => $ladder) {
          $ladders[$groupid][$ladderkey]['pos'] = $pos++;
        }

        $points = array(
                    'pos' => 0,
                    'points' => 0,
                    'diff' => 0
                    );
        $pos = 1;
        foreach ($tippladders[$groupid] as $tippladderkey => $tippladder) {
          $tippladders[$groupid][$tippladderkey]['pos'] = $pos++;
          if ($tippladders[$groupid][$tippladderkey]['pos'] == $ladders[$groupid][$tippladderkey]['pos']) {
            $points['pos'] = $points['pos'] + 4;
          }
          if ($tippladders[$groupid][$tippladderkey]['points'] == $ladders[$groupid][$tippladderkey]['points']) {
            $points['points'] = $points['points'] + 2;
          }
          if (($tippladders[$groupid][$tippladderkey]['goodgoals'] - $tippladders[$groupid][$tippladderkey]['badgoals']) == ($ladders[$groupid][$tippladderkey]['goodgoals'] - $ladders[$groupid][$tippladderkey]['badgoals'])) {
            $points['diff'] = $points['diff'] + 1;
          }
        }
        $this->Tipp->deleteAll(array(
          'Tipp.user_id' => $userid,
          'Tipp.group_id' =>  $groupid,
          'Tipp.type' =>  2), false);
        $this->Tipp->create();
        $newTipp = array(
          'Tipp' => array(
            'group_id' =>  $groupid,
            'points_team1' =>  0, 
            'points_team2' =>  0, 
            'user_id' => $userid,
            'type' =>  2,
            'points' =>  $points['pos'] + $points['points'] + $points['diff']));
        $this->Tipp->save($newTipp);
      }
    }
  }
}
