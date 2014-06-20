<?php
App::uses('AppController', 'Controller');
/**
 * Messages Controller
 *
 * @property Message $Message
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MessagesController extends AppController {

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Security->csrfUseOnce = false;
  }

  public $components = array(
    'Security' => array(
        'csrfUseOnce' => false
    )
  );

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Message->recursive = 0;
		$this->set('messages', $this->Paginator->paginate());
	}


/**
 * blog method
 *
 * @return void
 */
	public function blog() {
	  $this->Paginator->settings = array(
    	'limit' => 3,
    	'order' => array('Message.created' => 'DESC')
  	);
		$this->Message->recursive = 1;
		$this->set('messages', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
    $this->Message->recursive = 2;
		$this->set('message', $this->Message->find('first', $options));
    $neighbors = $this->Message->find(
        'neighbors',
        array('field' => 'id', 'value' => $id)
    );
    $this->set('neighbors', $neighbors);
	}

  public function like($id = null) {
    if ($this->request->is('ajax')) {
      if (!$this->Message->exists($id)) {
        throw new NotFoundException(__('Invalid feed'));
      }
      $this->Message->Like->recursive = -1;
      $mylike = $this->Message->Like->find('first', array('conditions' => array('Like.message_id' => $id, 'Like.user_id' => $this->Auth->user('id'))));
      if (empty($mylike)) {
        // like the feed
        $this->Message->Like->create();
        $this->Message->Like->save(array('Like' => array('message_id' => $id, 'user_id' => $this->Auth->user('id'))));
      } else {
        // unlike the feed
        $this->Message->Like->deleteAll(array('Like.user_id' => $this->Auth->user('id'), 'Like.message_id' => $id));
      }
      $options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
      $this->Message->unbindModel(
        array(
          'hasMany' => array('Feed'),
          'belongsTo' => array('User', 'Message'))
      );
      $message = $this->Message->find('first', $options);
      $this->set('message', $message);
      $this->render('/Elements/messagelike');
    }
  }

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Message->recursive = 0;
		$this->set('messages', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
		$this->set('message', $this->Message->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_new() {
		if ($this->request->is('post')) {
			$this->Message->create();
			$this->request->data['Message']['user_id'] = $this->Auth->user('id');
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'));
				return $this->redirect(array('action' => 'edit', $this->Message->id));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		}
		$users = $this->Message->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'));
        return $this->redirect(array('action' => 'edit', $id));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
			$this->request->data = $this->Message->find('first', $options);
		}
		$users = $this->Message->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Message->delete()) {
			$this->Session->setFlash(__('The message has been deleted.'));
		} else {
			$this->Session->setFlash(__('The message could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
