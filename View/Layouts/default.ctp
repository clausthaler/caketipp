<?php
/**
 *
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'WM 2014 Tippspiel');
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<head>
    <title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
    </title>

  	<?php echo $this->Html->charset(); ?>
    <meta name="description" content="EM Tippspiel von Ralf Dannhauer">
    <meta name="author" content="Ralf Dannhauer">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">


    <?php
        echo $this->Html->meta('icon');

        //<!-- Font Awesome CSS -->
        echo $this->Html->css('font-awesome.min');

        //<!-- Bootstrap CSS -->
        echo $this->Html->css('bootstrap.min');

        //<!-- App CSS -->
        echo $this->Html->css('mvpready-admin');
        echo $this->Html->css('custom');
        echo $this->Html->css('parsley');

        //<!-- Load jQuery upfront -->
        echo $this->Html->script('libs/jquery.min');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
  <!-- Favicon -->
  <link rel="shortcut icon" href="favicon.ico">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
</head>
<body class="<?php echo $bodyClass; ?>">
  <div id="wrapper">
    <header class="navbar" role="banner">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="fa fa-cog"></i>
          </button>
          <a href="/" class="navbar-brand navbar-brand-img">
            <?php echo $this->Html->image('logo.png', $options = array('alt' => 'WM Tipppsiel')); ?> 
          </a>

          <?php if($this->Session->check('Auth.User')) { ?>
            <ul class="nav navbar-nav noticebar navbar-left">

              <!--  notifications -->
              <?php echo $this->element('notTippedNotification', array(
                "matchesNotTipped" => $this->requestAction('/matches/checktipps/5'),
                "questionsNotTipped" => $this->requestAction('/questions/checktipps/17')
              ));  ?> 
            </ul>
          <?php  } ?>
        </div> <!-- /.navbar-header -->
        <nav class="collapse navbar-collapse" role="navigation">

          <ul class="nav navbar-nav navbar-right">    



          <?php if ($this->Session->read('Auth.User.role') == 'admin') { ?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                <span>Admin&nbsp;</span>
                <i class="fa fa-caret-down navbar-caret"></i>
              </a>


            <ul class="dropdown-menu" role="menu">
            <li >
              <a href="/admin/matches">
              <i class="fa fa-dollar"></i> 
              &nbsp;&nbsp;<?php echo __('Matches');?>
              </a>
            </li>
            <li >
              <a href="/admin/users">
              <i class="fa fa-user"></i> 
              &nbsp;&nbsp;<?php echo __('Users');?>
              </a>
            </li>
            <li >
              <a href="/admin/groups">
              <i class="fa fa-lock"></i> 
              &nbsp;&nbsp;<?php echo __('Groups');?>
              </a>
            </li>
            <li >
              <a href="/admin/rounds">
              <i class="fa fa-bullhorn"></i> 
              &nbsp;&nbsp;<?php echo __('Rounds');?>
              </a>
            </li>
            <li >
              <a href="/admin/questions">
              <i class="fa fa-question"></i> 
              &nbsp;&nbsp;<?php echo __('Questions');?>
              </a>
            </li>
            </ul>
            </li>
          <?php } ?>




            <?php if($this->Session->check('Auth.User')) { ?>
            <li class="dropdown">
              <?php if ($this->Session->read('Config.language') != 'eng') { ?>
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                <?php echo $this->Html->image('de.gif'); ?>
                <i class="fa fa-caret-down navbar-caret"></i>
              </a>
              <?php } else { ?>
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                <?php echo $this->Html->image('gb.gif'); ?>
                <i class="fa fa-caret-down navbar-caret"></i>
              </a>
              <?php } ?>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="/users/switchLang/deu">
                    <?php echo $this->Html->image('de.gif'); ?>
                      &nbsp;&nbsp;Deutsch
                  </a>
                </li>
                <li>
                  <a href="/users/switchLang/eng">
                    <?php echo $this->Html->image('gb.gif'); ?>
                    &nbsp;&nbsp;English
                  </a>
                </li>
              </ul>
            </li>
            <li class="dropdown navbar-profile">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                <?php echo $this->Html->image($this->Gravatar->get_gravatar($this->Session->read('Auth.User.email')), array('alt' => $this->Session->read('Auth.User.username'), 'class' => 'navbar-profile-avatar')); ?>
                <span><?php echo $this->Session->read('Auth.User.username'); ?> &nbsp;</span>
              </a>

              <ul class="dropdown-menu" role="menu">

                <li>
                  <a href="/profile">
                    <i class="fa fa-user"></i> 
                    &nbsp;&nbsp;My Profile
                  </a>
                </li>

                <li class="divider"></li>

                <li>
                  <a href="/logout">
                    <i class="fa fa-sign-out"></i> 
                  &nbsp;&nbsp;Logout
                  </a>
                </li>

              </ul>
            </li>
            <?php } else { ?>
              <?php if ($this->params['controller'] != 'users' || $this->params['action'] != 'login') { ?>
                <li>
                  <a href="/login"><?php echo __('Login'); ?></a>
                </li>    
              <?php } ?>
              <?php if ($this->params['controller'] != 'users' || $this->params['action'] != 'add') { ?>
                <li>
                  <a href="/register"><?php echo __('Register'); ?></a>
                </li>    
              <?php } ?>
              <?php if ($this->params['controller'] != 'pages' || $this->params['action'] != 'display') { ?>
                <li>
                  <a href="/">Home</a>
                </li>    
              <?php } ?>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                <?php echo $this->Html->image('de.gif'); ?>
                <i class="fa fa-caret-down navbar-caret"></i>
              </a>


            <ul class="dropdown-menu" role="menu">
            <li>
              <a href="/users/switchLang/deu">
                <?php echo $this->Html->image('de.gif'); ?>
                    &nbsp;&nbsp;Deutsch
              </a>
            </li>
            <li>
              <a href="/users/switchLang/eng">
                <?php echo $this->Html->image('gb.gif'); ?>
                &nbsp;&nbsp;English
              </a>
            </li>
            </ul>
            </li>

            <?php } ?>
          </ul>
        </nav>
      </div> <!-- /.container -->
    </header>
    <div class="mainnav ">
      <div class="container">  
        <?php 
          echo $this->Session->flash('flash', array('element' => 'message'));
          echo $this->Session->flash('auth', array('element' => 'message'));
        ?>
      </div> <!-- /.container -->
    </div><!-- /.mainnav -->
    <div class="content">

    <?php echo $this->fetch('content'); ?>

    </div> <!-- /#content -->

  </div> <!-- /#wrapper -->

  <footer class="footer">
    <div class="container">
      <p class="pull-left">&nbsp;<a href="/imprint"><?php echo __('Imprint'); ?></a></p>
      <p class="text-center">Copyright &copy; 2016 Ralf Dannhauer.</p>
    </div>
  </footer>
  <a id="back-to-top" href="#top" style="display: block;"><i class="fa fa-chevron-up"></i></a>
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Core JS -->
  <?php
    //<!-- Bootstrap core JavaScript
    //================================================== -->
    //<!-- Core JS -->
    //echo $this->Html->script('libs/jquery.min');
    echo $this->Html->script('libs/bootstrap.min');
    //<!-- Plugins JS -->
    echo $this->Html->script('libs/jquery.slimscroll.min');
    echo $this->Html->script('plugins/parsley/parsley2');
    echo $this->Html->script('plugins/parsley/i18n/de');

    //<!-- App JS -->
    echo $this->Html->script('mvpready-core');
    echo $this->Html->script('mvpready-helpers');
    echo $this->Html->script('tippspiel-app');
    echo $this->fetch('scriptBottom');
  ?>
</body>
</html>