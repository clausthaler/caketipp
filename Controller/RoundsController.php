<?php
App::uses('AppController', 'Controller');
/**
 * Rounds Controller
 *
 * @property Round $Round
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RoundsController extends AppController {


/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Round','Match','Group');


/**
 * 
 */
	public function admin_games () {
		$this->Round->recursive = 0;
		$this->set('rounds', $this->Paginator->paginate());
		$matches = $this->Match->find('all', array('fields' => array(
			'Match.id', 
			'Match.name', 
			'Match.datetime', 
			'Match.group_id',
			'Match.round_id')));
		$lrounds = $this->Round->find('list');
		$groups = $this->Group->find('list');
		$this->set(compact('matches', 'lrounds', 'groups'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Round->recursive = 0;
		$this->set('rounds', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Round->exists($id)) {
			throw new NotFoundException(__('Invalid round'));
		}
		$options = array('conditions' => array('Round.' . $this->Round->primaryKey => $id));
		$this->set('round', $this->Round->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Round->create();
			if ($this->Round->save($this->request->data)) {
				$this->Session->setFlash(__('The round has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The round could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Round->exists($id)) {
			throw new NotFoundException(__('Invalid round'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Round->save($this->request->data)) {
				$this->Session->setFlash(__('The round has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The round could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Round.' . $this->Round->primaryKey => $id));
			$this->request->data = $this->Round->find('first', $options);
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
		$this->Round->id = $id;
		if (!$this->Round->exists()) {
			throw new NotFoundException(__('Invalid round'));
		}

    $matches = $this->Match->find('all',
      array('conditions' => array(
        'Match.round_id' => $id)));
    if (!empty($matches)) {
      $this->Session->setFlash(__('The round has matches already.'));
      return $this->redirect(array('action' => 'index'));
    }

		if ($this->Round->delete()) {
			$this->Session->setFlash(__('The round has been deleted.'));
		} else {
			$this->Session->setFlash(__('The round could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
