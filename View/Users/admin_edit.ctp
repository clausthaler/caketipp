<div class="mainnav">
  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
</div> <!-- /.mainnav -->
<div class="content">
  <div class="container">
    <div class="layout layout-main-right layout-stack-sm">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "users")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __d('users', 'Edit User'); ?></u></h3>

            <?php
              echo $this->Form->create('User', array(
                'action' => 'admin_edit',
                'id' => 'EditForm',
                'class' => 'form-horizontal',
                'role' => 'form'
              )); 
               echo $this->Form->input('id');
                ?> 
            <div class="form-group">
              <?php echo $this->Form->label('User.username', __d('users', 'Username'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('username', array(
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __d('users', 'Username')
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('User.email', __d('users', 'E-mail (used as login)'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('email', array(
                    'label' => false,
                    'type' => 'email',
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __d('users', 'Email'),
                    'error' => array('isValid' => __d('users', 'Must be a valid email address'),
                    'isUnique' => __d('users', 'An account with that email already exists')))
                  );
                ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3"><?php echo __('Notifications'); ?></label>
              <div class="col-md-7">
              <?php echo $this->Form->input('recieve_emails', array(
                'div' => array('class' => 'checkbox'),
                'type' => 'checkbox',
                'label' => __('Admins are allowed to send emails.'),
                'tabindex' => '3')); 
              ?>
              <?php echo $this->Form->input('recieve_reminders', array(
                'div' => array('class' => 'checkbox'),
                'type' => 'checkbox',
                'label' => __('I want to get email reminders for outstanding tipps.'),
                'tabindex' => '4')); 
              ?>
              </div> <!-- /.col -->
            </div> <!-- /.form-group -->
            <div class="form-group">
              <label class="col-md-3"><?php echo __('Settings'); ?></label>
              <div class="col-md-7">
                <?php echo $this->Form->input('is_admin', array(
                  'div' => array('class' => 'checkbox'),
                  'type' => 'checkbox',
                  'label' => __('Is Admin'),
                  'tabindex' => '3')); 
                ?>
                <?php echo $this->Form->input('active', array(
                  'div' => array('class' => 'checkbox'),
                  'type' => 'checkbox',
                  'label' => __('active'),
                  'tabindex' => '3')); 
                ?>
                <?php echo $this->Form->input('has_paid', array(
                  'div' => array('class' => 'checkbox'),
                  'type' => 'checkbox',
                  'label' => __('has paid'),
                  'tabindex' => '3')); 
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
                  echo '&nbsp;';
                  echo $this->Html->link(__d('users', 'Reset password'), '/admin/users/passwordreset/' . $this->data['User']['id']);
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