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
		$this->Feed->recursive = 0;
		$this->set('feeds', $this->Paginator->paginate());
	}


/**
 * index getstream
 *
 * @return void
 */
	public function stream() {
    $this->Feed->recursive = 2;
    $this->Paginator->settings = array(
        'conditions' => array('Feed.parent_id ' => null),
        'limit' => 10,
        'order' => array('Feed.created' => 'DESC')
    );
    $feeds = $this->Paginator->paginate('Feed');
    $feeds['paging'] = $this->request->params['paging'];
    if ($this->request->is('requested')) {
      return $feeds;
    } else {
      $this->set('feeds', $feeds);
      $this->render('/Elements/feedstream');
    }
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
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
  public function like($id = null) {
    if ($this->request->is('ajax')) {
      if (!$this->Feed->exists($id)) {
        throw new NotFoundException(__('Invalid feed'));
      }
      $this->Feed->Like->recursive = -1;
      $mylike = $this->Feed->Like->find('first', array('conditions' => array('Like.feed_id' => $id, 'Like.user_id' => $this->Auth->user('id'))));
      if (empty($mylike)) {
        // like the feed
        $this->Feed->Like->create();
        $this->Feed->Like->save(array('Like' => array('feed_id' => $id, 'user_id' => $this->Auth->user('id'))));
      } else {
        // unlike the feed
        $this->Feed->Like->deleteAll(array('Like.user_id' => $this->Auth->user('id'), 'Like.feed_id' => $id));
      }
      $options = array('conditions' => array('Feed.' . $this->Feed->primaryKey => $id));
      $this->Feed->unbindModel(
        array(
          'hasMany' => array('ChildFeed'),
          'belongsTo' => array('User', 'Message'))
      );
      $feed = $this->Feed->find('first', $options);
      $this->set('feed', $feed);
      $this->render('/Elements/feedlike');
    }
  }

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
      $this->Feed->create();
			if ($this->request->is('ajax')) {
        $this->request->data['Feed']['user_id'] = $this->Auth->user('id'); 
        if ($this->Feed->save($this->request->data)) {
          $this->Feed->recursive = 2;
          if (isset($this->request->data['Feed']['parent_id'])) {
            //parent id set -> return the complete feed with comments
            $this->set('feed', $this->Feed->read(null, $this->request->data['Feed']['parent_id']));
          } else {
            $this->set('feed', $this->Feed->read(null, $this->Feed->id));
          }
          $this->render('/Elements/feeditem');
        }
      } else {
        if ($this->Feed->save($this->request->data)) {
          $this->Session->setFlash(__('The feed has been saved.'));
          return $this->redirect(array('action' => 'index'));
        } else {
          $this->Session->setFlash(__('The feed could not be saved. Please, try again.'));
        }
      }
		}
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
