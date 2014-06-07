<?php $this->set('bodyClass', 'account-bg'); ?>
<div class="account-wrapper">

  <div class="account-body">

  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
    <h3><?php echo __('Welcome back to WM Tipp.'); ?></h3>

    <h5><?php echo __('Good luck with your tipps!'); ?></h5>

    <?php
      echo $this->Form->create('User', array(
        'action' => 'login',
        'id' => 'LoginForm',
        'class' => 'form account-form',
        'role' => 'form',
        'parsley' => true
      )); 

      echo $this->Form->input('email', array(
        'label' => __d('users', 'Email'),
        'class' => 'form-control',
        'div' => array('class' => 'form-group'),
        'type' => 'email',
        'tabindex' => '1',
        'placeholder' => __d('users', 'Email')));
      echo $this->Form->input('password', array(
        'label' => __d('users', 'Password'),
        'class' => 'form-control',
        'div' => array('class' => 'form-group'),
        'type' => 'password',
        'tabindex' => '2',
        'placeholder' => __d('users', 'Password'))); ?>

      <div class="form-group clearfix">
        <div class="pull-left">         
          <label class="checkbox-inline">
            <?php echo $this->Form->input('remember_me', array(
              'div' => false,
              'type' => 'checkbox',
              'label' => false,
              'tabindex' => '3')); 
            ?>
            <small><?php echo __d('users' , 'Remember Me'); ?></small>
          </label>
        </div>

        <div class="pull-right">
          <small><?php echo $this->Html->link(__d('users', 'I forgot my password'), array('action' => 'reset_password')); ?></small>
        </div>
      </div> <!-- /.form-group -->
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-lg" tabindex="4">
          Login &nbsp; <i class="fa fa-play-circle"></i>
        </button>
      </div> <!-- /.form-group -->

      <?php
      echo $this->Form->end();
      ?>

  </div> <!-- /.account-body -->

  <div class="account-footer">
    <p>
      
      <?php
        echo __("Don't have an account?") . '&nbsp;'; 
        echo $this->Html->link(
            __d('users', 'Create an Account!'),
            '/register');
      ?>
    </p>
  </div> <!-- /.account-footer -->

</div> <!-- /.account-wrapper -->