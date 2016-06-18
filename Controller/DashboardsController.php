<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
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
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class DashboardsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
    public $name = 'Dashboards';

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array('Match', 'Feed', 'Tipp');


/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
    public function index() {
      $this->set('title_for_layout', 'User Dashboard');
    }

    public function home() {
      $this->layout = 'default_new';
      $this->set('title_for_layout', 'User Dashboard');

      $date = new DateTime;
      $date->setTimestamp(time());
      $date->setTime( 0, 0, 0);
      $fromkickoff = $date->getTimestamp();
      $date->setTime( 23, 59, 0);
      $tokickoff = $date->getTimestamp();

      $this->Match->recursive = -1;
      $matches = $this->Match->find(
        'all', array(
          'fields' => array('id', 'kickoff'),
          'conditions' => array(
            'Match.kickoff BETWEEN ? AND ?' => array($fromkickoff, $tokickoff)), 
          'order' => array('Match.datetime')));
      $matchlist = Hash::extract( $matches, '{n}.Match.kickoff');

      if (time() > $matchlist[0] && time() < ($matchlist[count($matchlist) -1 ] + 7200)) {      
        $this->set('show', 'matches');
      } else {
        $this->set('show', 'ranking');
      }
    }
}
