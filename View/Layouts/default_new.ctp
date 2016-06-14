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

$cakeDescription = __d('cake_dev', 'EM 2016 Tippspiel');
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="EM Tippspiel von Ralf Dannhauer">
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
    echo $this->Html->css('summernote');
    echo $this->Html->css('mvpready-admin.new');
    echo $this->Html->css('custom');


    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->Html->script('libs/jquery.min');
    echo $this->fetch('script');
    ?>
  <!-- Favicon -->
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="<?php echo $bodyClass; ?>">
  <div id="wrapper">
    <header class="navbar navbar-inverse" role="banner">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="fa fa-cog"></i>
          </button>
          <a href="/" class="navbar-brand navbar-brand-img">
            <?php echo $this->Html->image('logo.png', $options = array('alt' => 'EM Tipppsiel')); ?> 
          </a>
        </div> <!-- /.navbar-header -->

        <nav class="collapse navbar-collapse" role="navigation">
          <?php if($this->Session->check('Auth.User')) { ?>
            <ul class="nav navbar-nav noticebar navbar-left">

              <!--  notifications -->
              <?php echo $this->element('notTippedNotification', array(
                "matchesNotTipped" => $this->requestAction('/matches/checktipps/5'),
                "questionsNotTipped" => $this->requestAction('/questions/checktipps/17')
              ));  ?> 
            </ul>
          <?php  } ?>
          <ul class="nav navbar-nav navbar-right">    
            <?php if($this->Session->check('Auth.User')) { ?>
            <li>
              <a href="/users/switchLang/deu">
                <?php echo $this->Html->image('de.gif'); ?>
              </a>
            </li>
            <li>
              <a href="/users/switchLang/eng">
                <?php echo $this->Html->image('gb.gif'); ?>
              </a>
            </li>
            <li>
              <a href="/rules">
                <?php echo __('Rules'); ?>
              </a>
            </li>
            <li class="dropdown navbar-profile">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                <?php 
                  if (!file_exists(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $this->Session->read('Auth.User.id') .  DS . 'small_' . $this->Session->read('Auth.User.photo'))) {
                    echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $this->Session->read('Auth.User.id') .  DS . 'small_' . $this->Session->read('Auth.User.photo'), array('alt' => $this->Session->read('Auth.User.username'), 'class' => 'navbar-profile-avatar')); 
                  }
                ?>
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
            <?php } ?>
          </ul>
        </nav>
      </div> <!-- /.container -->

    </header>
    <div class="mainnav">
      <!-- start: Main Menu -->
      <?php echo $this->element('mainmenu', array("active" => "dashboard")); ?>
      <!-- end: Main Menu -->

      <?php 
        echo $this->Session->flash('flash', array('element' => 'message'));
        echo $this->Session->flash('auth', array('element' => 'message'));
      ?>
    </div> <!-- /.mainnav -->


    <?php echo $this->fetch('content'); ?>

  </div> <!-- /#wrapper -->

  <footer class="footer">
    <div class="container">
      <p class="pull-left">Copyright &copy; 2016 Ralf Dannhauer.</p>
      <p class="pull-right"><a href="/imprint"><?php echo __('Imprint'); ?></a></p>
    </div>
  </footer>


  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Core JS -->
  <?php
    //<!-- Bootstrap core JavaScript
    //================================================== -->
    //<!-- Core JS -->
    echo $this->Html->script('libs/bootstrap.min');
    //<!-- Plugins JS -->
    echo $this->Html->script('libs/jquery.slimscroll');
    echo $this->Html->script('plugins/parsley/parsley2');
    echo $this->Html->script('plugins/parsley/i18n/de');

    //<!-- App JS -->
    echo $this->Html->script('mvpready-core');
    echo $this->Html->script('mvpready-helpers');
    echo $this->Html->script('tippspiel-app');
    echo $this->Html->script('summernote.min');
    echo $this->fetch('scriptBottom');
  ?>
</body>
</html>