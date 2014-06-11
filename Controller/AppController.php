<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
    * Components
    *
    * @var array
    */
    public $components = array(
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'dashboards',
                'action' => 'index'
            ),
            'logoutRedirect' => '/',
            'loginAction' => '/login',
            'authError' => 'Did you really think you are allowed to see that?'
        ),
        'Session',
        'Cookie',
        'Paginator',
        'Security',
        'Email',
        'RequestHandler',
        'DebugKit.Toolbar',
        'Search.Prg',
        'RememberMe'
    );

    public $helpers = array(
        'Html',
        'Form' => array('className' => 'ParsleyHelper.ParsleyForm'),
        'Session',
        'Time',
        'Text',
        'Gravatar'
    );

    /**
     * publically accessible controllers - all methods are allowed by all
     */
    public function beforeFilter() {

      // set session current date time for testing when in testmode
      if (Configure::read('mode') == 1) {
        if (!$this->Session->check('currentdatetime')) {
          $this->Session->write('currentdatetime', date ('Y-m-d H:i' , time()));
        }
      }
      $this->set('bodyClass', '');
      $this->Auth->authenticate = array(
        'Form' => array(
            'fields' => array(
              'username' => 'email',
                'password' => 'password'),
                'userModel' => 'User',
                'scope' => array(
                  $this->modelClass . '.active' => 1,
                  $this->modelClass . '.email_verified' => 1)));
      if ($this->Session->check('Config.language')) {
        Configure::write('Config.language', $this->Session->read('Config.language'));
      } else {
        Configure::write('Config.language', 'deu');
      }
    }
}
