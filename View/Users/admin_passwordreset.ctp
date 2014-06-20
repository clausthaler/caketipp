<div class="mainnav">
  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
</div> <!-- /.mainnav -->
<div class="content">
  <div class="container">
    <div class="row">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "users")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __d('users', 'Edit User'); ?></u></h3>

            <?php
              echo $this->Form->create('User', array(
                'action' => 'passwordreset',
                'admin' => true,
                'id' => 'PasswordResetForm',
                'class' => 'form-horizontal',
                'role' => 'form'
              )); 
               echo $this->Form->input('id');
            ?> 
            <div class="form-group">
              <?php echo $this->Form->label('User.password', __d('users', 'Password'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('password', array(
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'password',
                    'div' => false,
                    'placeholder' => __d('users', 'Password')
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('User.temppassword', __d('users', 'Password (confirm)'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('temppassword', array(
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'password',
                    'div' => false,
                    'placeholder' => __d('users', 'Password (confirm)')
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-7 col-md-push-3">
                <?php
                  echo $this->Form->button(__d('users', 'Save'), array(
                    'type' => 'submit',
                    'escape' => true,
                    'class' => 'btn btn-primary'
                    )); 
                  echo '&nbsp;';
                  echo $this->Form->button(
                    __d('users', 'Cancel'), 
                    array(
                      'formaction' => Router::url(
                      array(
                        'controller' => 'dashboards',
                        'action' => 'index')
                      ),
                      'class' => 'btn btn-default'
                    )
                  );
                ?>
              </div> <!-- /.col -->
            </div>
            <?php echo $this->Form->end(); ?>
          </div> <!-- /.tab-pane -->
        </div> <!-- /.tab-content -->
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->