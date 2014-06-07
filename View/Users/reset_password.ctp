<?php $this->set('bodyClass', 'account-bg'); ?>
<div class="account-wrapper">

  <div class="account-body">

  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
    <h3><?php echo __d('users', 'Reset your password'); ?></h3>


    <?php
	    echo $this->Form->create($model, array(
				'url' => array(
				'action' => 'reset_password',
        'class' => 'form account-form',
        'role' => 'form',
				$token)));

      echo $this->Form->input('new_password', array(
        'label' => array('class' => 'placeholder-hidden',
          'text' => __d('users', 'New Password')),
        'class' => 'form-control',
        'div' => array('class' => 'form-group'),
        'type' => 'password',
        'tabindex' => '1',
        'placeholder' => __d('users', 'New Password'))); 
      echo $this->Form->input('confirm_password', array(
        'label' => array('class' => 'placeholder-hidden',
          'text' => __d('users', 'Confirm')),
        'class' => 'form-control',
        'div' => array('class' => 'form-group'),
        'type' => 'password',
        'tabindex' => '2',
        'placeholder' => __d('users', 'Confirm'))); 
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