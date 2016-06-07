<div class="mainnav">
    <div class="container">
    </div> <!-- /.container -->
</div>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-sm-push-8 layout-sidebar">
        <div class="portlet">
          <h4 class="portlet-title">
            <u><?php echo __('Login'); ?></u>
          </h4>

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
                <small><?php echo $this->Html->link(__d('users', 'I forgot my password'), '/reset_password'); ?></small>
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
            <?php echo $this->Html->link(__('Create an account'), '/register', array('class' => 'btn btn-secondary btn-block btn-lg')); ?>
        </div> <!-- /.portlet -->
      </div> <!-- /.layout-sidebar -->
      <div class="col-sm-8 col-sm-pull-4 layout-main">
        <h2><?php echo __('Welcome to our EM 2016 tipp game') ?></h2>
          <br>

          <h4 class="content-title"><u>General Questions</u></h4>

          <p>
            <?php echo __('This is a private tipping game for the world cup. If you have been invited, you are welcome to take part.') ?>
          </p>
          <p>
            <?php echo __('Allthough this is a fun oriented private tipping game there are a couple of rules found here:') ;
            ?>
          </p>
          <p>
            <?php 
            echo '&nbsp;' . $this->html->link(__('Rules'), '/pages/agb')
            ?>
          </p>
          <p>
            <?php echo __("If you don't want or can't agree to theese rules, please don't sign up.") ?>
          </p>
          <br>
          <h3>
            <?php echo __("Enjoy the game, have fun and Good Luck!") ?>
          </h3>


        </div> <!-- /.col -->

      </div> <!-- /.row -->

    </div> <!-- /.container -->

  </div>