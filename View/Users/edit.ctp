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
    <?php echo $this->element('menu', array("active" => "profile")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __d('users', 'Profile'); ?></u></h3>

            <?php
              echo $this->Form->create('User', array(
                'action' => 'edit',
                'id' => 'EditForm',
                'class' => 'form-horizontal',
                'role' => 'form',
                'type' => 'file'
              )); ?>
        
              <div class="form-group">
                <label class="col-md-3" for="UserName"><?php echo __d('users', 'Userame') ?></label>
                <div class="col-md-7">
                  <p class="form-control-static"><?php echo $this->request->data['User']['username'] ?></p>
                </div>
              </div>
              <?php 
                echo $this->Form->input('email', array(
                  'label' => array('class' => 'col-md-3',
                    'text' => __d('users', 'Email')),
                  'class' => 'form-control',
                  'tabindex' => '2',
                  'div' => array('class' => 'form-group'),
                  'type' => 'email',
                  'required' => false,
                  'placeholder' => __d('users', 'Email'),
                  'between'=>'<div class="col-md-7">',
                  'after'=>'</div>'));
                echo $this->Form->input('name', array(
                  'label' => array('class' => 'col-md-3',
                    'text' => __d('users', 'Name')),
                  'class' => 'form-control',
                  'tabindex' => '3',
                  'div' => array('class' => 'form-group'),
                  'required' => false,
                  'placeholder' => __d('users', 'Name'),
                  'between'=>'<div class="col-md-7">',
                  'after'=>'</div>'));
              ?>
              <div class="form-group">
                <label for="UserName" class="col-md-3"><?php echo __('Image'); ?></label>
                <div class="col-md-7">
                <?php
                  echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $this->request->data['User']['photo_dir'] .  DS . $this->request->data['User']['photo']
                    , array('style' => 'width:100%'));
                  echo $this->Form->input('User.photo', 
                    array(
                      'type' => 'file',
                      'label' => false)); 
                  echo $this->Form->input('User.photo_dir', array('type' => 'hidden'));
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
                  'tabindex' => '5')); 
                ?>
                <?php echo $this->Form->input('recieve_reminders', array(
                  'div' => array('class' => 'checkbox'),
                  'type' => 'checkbox',
                  'label' => __('I want to get email reminders for outstanding tipps.'),
                  'tabindex' => '6')); 
                ?>
                </div> <!-- /.col -->
              </div> <!-- /.form-group -->
              <?php 
              if (Configure::read('mode') == 1) {
                echo $this->Form->input('currentdatetime', array(
                'label' => array('class' => 'col-md-3',
                  'text' => __('Current Datetime')),
                'class' => 'form-control',
                'tabindex' => '7',
                'div' => array('class' => 'form-group'),
                'type' => 'text',
                'required' => false,
                'between'=>'<div class="col-md-7">',
                'after'=>'</div>'));
              }
              ?>

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
                        #, 'type' => 'reset'
                      )
                    );
                    ?>
                  </div> <!-- /.col -->
                </div>
              </div>
              <?php
              echo $this->Form->end();
            ?>
          </div> <!-- /.tab-pane -->
        </div> <!-- /.tab-content -->
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->