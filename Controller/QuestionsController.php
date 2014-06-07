<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class QuestionsController extends AppController {

	public $uses = array('Question', 'Tipp');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Question->recursive = 0;
		$this->set('questions', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Invalid question'));
		}
		$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
		$this->set('question', $this->Question->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$date = explode('.', $this->request->data['Question']['due']['date']);
			$time = explode(':', $this->request->data['Question']['due']['time']);
			$this->request->data['Question']['due'] = mktime($time[0], $time[1], 0, $date[1], $date[0], $date[2]);
			$this->Question->create();
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		}
		$teams = $this->Question->Team->find('list');
		$this->set(compact('teams'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Invalid question'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$date = explode('.', $this->request->data['Question']['due']['date']);
			$time = explode(':', $this->request->data['Question']['due']['time']);
			$this->request->data['Question']['due'] = mktime($time[0], $time[1], 0, $date[1], $date[0], $date[2]);
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
			$this->request->data = $this->Question->find('first', $options);
      $date['date'] = date('d.m.Y', $this->request->data['Question']['due']);
      $date['time'] = date('H:i', $this->request->data['Question']['due']);
      $this->request->data['Question']['due'] = $date;
		}
		$teams = $this->Question->Team->find('list');
		$this->set(compact('teams'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Question->id = $id;
    $tipps = $this->Tipp->find('all',
      array('conditions' => array(
        'Tipp.question_id' => $id)));
    if (!empty($tipps)) {
      $this->Session->setFlash(__('The question has been tipped already.'));
      return $this->redirect(array('action' => 'index'));
    }
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Question->delete()) {
			$this->Session->setFlash(__('The question has been deleted.'));
		} else {
			$this->Session->setFlash(__('The question could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


/**
 * admin_index method
 *
 * @return void
 */
  public function checktipps($days = null) {
    if (!$days) {
      $days = 7;
    }
    $nextQuestions = $this->Question->query("SELECT * FROM questions a WHERE a.due <= UNIX_TIMESTAMP() + " . $days * 86400 . 
      " AND a.due >= UNIX_TIMESTAMP() AND  NOT EXISTS (SELECT 'X' FROM tipps b " .
      " WHERE b.user_id = '" . $this->Auth->user('id') . "' " .
      " AND b.type = 1 AND a.id = b.question_id);");

    if ($this->request->is('requested')) {
      return $nextQuestions;
    } else {
      $this->set('nextQuestions', $nextQuestions);
    }
  }
}
