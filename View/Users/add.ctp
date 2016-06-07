<?php $this->set('bodyClass', 'account-bg'); ?>
<div class="account-wrapper">

  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>

  <div class="account-body">
    <h3><?php echo __('Welcome to EM Tipp.'); ?></h3>

    <h5><?php echo __('Sing up and have fun. No strings attached!'); ?></h5>

    <?php
      echo $this->Form->create('User', array(
        'action' => 'add',
        'id' => 'AddForm',
        'class' => 'form account-form',
        'role' => 'form',
        'data-validate' => 'parsley',
        'parsley' => true,
        'inputDefaults' => array(
          'div' => array('class' => 'form-group'),
          'class' => 'form-control'
    )
      )); 
      echo $this->Form->input('username', array(
        'label' => __d('users', 'Username'),
        'type' => 'text',
        'tabindex' => '1',
        'placeholder' => __d('users', 'Username')));
      echo $this->Form->input('email', array(
        'label' => __d('users', 'Email'),
        'type' => 'email',
        'tabindex' => '2',
        'placeholder' => __d('users', 'Email')));
      echo $this->Form->input('recieve_emails', array(
          'type' => 'checkbox',
          'class' => '',
          'label' => array('text' => __('Admins are allowed to send emails.'),
            'class' => 'checkbox-inline'),
          'tabindex' => '3')); 

      echo $this->Form->input('recieve_reminders', array(
          'type' => 'checkbox',
          'class' => '',
          'label' => array('text'=> __('I want to get email reminders for outstanding tipps.'),
            'class' => 'checkbox-inline'),
          'tabindex' => '4'));
      echo $this->Form->input('password', array(
        'label' => __d('users', 'Password'),
        'type' => 'password',
        'tabindex' => '3',
        'placeholder' => __d('users', 'Password')));
      echo $this->Form->input('temppassword', array(
        'label' =>  __d('users', 'Password (confirm)'),
        'type' => 'password',
        'tabindex' => '4',
        'data-parsley-equalto' => '#UserPassword',
        'placeholder' => __d('users', 'Password (confirm)')));
      $tosLink = $this->Html->link(__d('users', 'Terms of Service'), array('controller' => 'pages', 'action' => 'display', 'agb'), array('target'=>'_blank'));
      echo $this->Form->input('tos', array(
          'type' => 'checkbox',
          'tabindex' => '5',
          'class' => '',
          'label' => array('text' => __d('users', 'I have read and agreed to ') . $tosLink,
            'class' => 'checkbox-inline'))); 
      ?>
      <div class="form-group">
        <button type="submit" class="btn btn-secondary btn-block btn-lg" tabindex="6">
          <?php echo __d('users', 'Register'); ?> &nbsp; <i class="fa fa-play-circle"></i>
        </button>
      </div> <!-- /.form-group -->
    <?php
      echo $this->Form->end();
    ?>

  </div> <!-- /.account-body -->

  <div class="account-footer">
    <p>
      <?php echo __('Already have an account?') . '&nbsp;'; ?>
      <?php 
        echo $this->Html->link(
          'Login',
          '/login',
          array('class' => 'btn')
        );
      ?>
    </p>
  </div> <!-- /.account-footer -->
</div> <!-- /.account-wrapper -->
