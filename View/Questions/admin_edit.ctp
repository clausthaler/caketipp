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
    <?php echo $this->element('menu', array("active" => "questions")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __('Edit question'); ?></u></h3>
            <?php
            echo $this->Form->create('Question', array(
              'action' => 'edit',
              'id' => 'EditForm',
              'class' => 'form-horizontal',
              'role' => 'form'
            )); 
            echo $this->Form->input('id');
            ?>
            <div class="form-group">
              <?php echo $this->Form->label('Question.name', __('Name'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('name', array(
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __('Name'),
                    'tabindex' => '1'
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Question.text', __('Text'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('text', array(
                    'type' => 'textarea',
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __('Text'),
                    'tabindex' => '2'
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Question.points', __('Points'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('points', array(
                    'type' => 'text',
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __('Points'),
                    'tabindex' => '2'
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Question.due', __('Date'), 'col-md-3'); ?>
              <div class="col-md-7">
                <div class="row">
                  <div class="col-xs-4">
                  <?php 
                    echo $this->Form->input('Question.due.date', array(
                      'label' => false,
                      'type' => 'text',
                      'class' => 'form-control',
                      'div' => array(
                        'class' => 'input-group')
                    ));
                  ?>
                  </div>
                  <div class="col-xs-3">
                  <?php
                    echo $this->Form->input('Question.due.time', array(
                      'type' => 'text',
                      'label' => false,
                      'class' => 'form-control',
                      'div' => array(
                        'class' => 'input-group')
                    ));
                  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-7 col-md-push-3">
              <?php echo $this->Form->input('isfixed', array(
                'div' => array('class' => 'checkbox'),
                'type' => 'checkbox',
                'label' => __('fixed'),
                'tabindex' => '3')); 
              ?>
              </div> <!-- /.col -->
            </div> <!-- /.form-group -->

            <div class="form-group">
              <div class="col-md-7 col-md-push-3">
                <?php
                  echo $this->Form->button(__('Save'), array(
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
                        'controller' => 'questions',
                        'action' => 'index',
                        'admin' => true)
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