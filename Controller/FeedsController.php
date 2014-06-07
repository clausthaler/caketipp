<?php
App::uses('AppController', 'Controller');
/**
 * Feeds Controller
 *
 * @property Feed $Feed
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FeedsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Feed->recursive = 0;
		$this->set('feeds', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Feed->exists($id)) {
			throw new NotFoundException(__('Invalid feed'));
		}
		$options = array('conditions' => array('Feed.' . $this->Feed->primaryKey => $id));
		$this->set('feed', $this->Feed->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Feed->create();
			if ($this->Feed->save($this->request->data)) {
				$this->Session->setFlash(__('The feed has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The feed could not be saved. Please, try again.'));
			}
		}
		$users = $this->Feed->User->find('list');
		$parentFeeds = $this->Feed->ParentFeed->find('list');
		$this->set(compact('users', 'parentFeeds'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Feed->exists($id)) {
			throw new NotFoundException(__('Invalid feed'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Feed->save($this->request->data)) {
				$this->Session->setFlash(__('The feed has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The feed could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Feed.' . $this->Feed->primaryKey => $id));
			$this->request->data = $this->Feed->find('first', $options);
		}
		$users = $this->Feed->User->find('list');
		$parentFeeds = $this->Feed->ParentFeed->find('list');
		$this->set(compact('users', 'parentFeeds'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Feed->id = $id;
		if (!$this->Feed->exists()) {
			throw new NotFoundException(__('Invalid feed'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Feed->delete()) {
			$this->Session->setFlash(__('The feed has been deleted.'));
		} else {
			$this->Session->setFlash(__('The feed could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
