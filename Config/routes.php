<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
#    Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
  Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/dashboard', array('controller' => 'dashboards', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
  Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
  Router::connect('/regeln', array('controller' => 'pages', 'action' => 'display', 'regeln'));
	Router::connect('/rules', array('controller' => 'pages', 'action' => 'display', 'rules'));
  Router::connect('/schedule', array('controller' => 'matches', 'action' => 'schedule'));
  Router::connect('/grouptables', array('controller' => 'matches', 'action' => 'grouptables'));
  Router::connect('/tippabgabe', array('controller' => 'tipps', 'action' => 'entertipps'));
  Router::connect('/entertipps/*', array('controller' => 'tipps', 'action' => 'entertipps'));
  Router::connect('/enterbonus', array('controller' => 'tipps', 'action' => 'enterbonus'));
  Router::connect('/ranking', array('controller' => 'tipps', 'action' => 'ranking'));
  Router::connect('/blog', array('controller' => 'messages', 'action' => 'blog'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
    Router::connect('/users', array('controller' => 'users'));
    Router::connect('/profile', array('controller' => 'users', 'action' => 'edit'));
    Router::connect('/reset_password', array('controller' => 'users', 'action' => 'reset_password'));
    Router::connect('/users/index/*', array('controller' => 'users'));
    Router::connect('/users/:action/*', array('controller' => 'users'));
    Router::connect('/users/users/:action/*', array('controller' => 'users'));
    Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
    Router::connect('/register', array('controller' => 'users', 'action' => 'add'));

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
