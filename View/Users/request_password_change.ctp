<?php $this->set('bodyClass', 'account-bg'); ?>
<div class="account-wrapper">

  <div class="account-body">

  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
    <h2><?php echo __d('users', 'Forgot your password?'); ?></h2>
    <p><?php echo __d('users', 'Please enter the email you used for registration and you\'ll get an email with further instructions.'); ?></p>

    <?php
      echo $this->Form->create($model, array(
        'url' => array(
          'admin' => false,
          'action' => 'reset_password'),
        'class' => 'form account-form',
        'role' => 'form'));
      echo $this->Form->input('email', array(
        'label' => array('class' => 'placeholder-hidden',
          'text' => __d('users', 'Your Email')),
        'class' => 'form-control',
        'div' => array('class' => 'form-group'),
        'type' => 'text',
        'tabindex' => '1',
        'placeholder' => __d('users', 'Your Email')));
    ?>


      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-lg" tabindex="3">
          <?php echo __d('users', 'Submit'); ?> &nbsp; <i class="fa fa-play-circle"></i>
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