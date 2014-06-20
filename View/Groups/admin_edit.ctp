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
    <?php echo $this->element('menu', array("active" => "groups")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __('Edit group'); ?></u></h3>
            <?php
            echo $this->Form->create('Group', array(
              'action' => 'edit',
              'id' => 'EditForm',
              'class' => 'form-horizontal',
              'role' => 'form'
            )); 
            echo $this->Form->input('id');
            ?>
            <div class="form-group">
              <?php echo $this->Form->label('Group.name', __('Name'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('name', array(
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __('Name')
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Group.shortname', __('Shortname'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('shortname', array(
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __('Shortname')
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Group.round_id', __('Round'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('round_id', array(
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __('Round')
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Group.created', __('created'), 'col-md-3'); ?>
              <div class="col-md-7">
                <p class="form-control-static"><?php echo h(date("d.m.y H:i:s", strtotime($this->data['Group']['created']))); ?></p>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Group.modified', __('modified'), 'col-md-3'); ?>
              <div class="col-md-7">
                <p class="form-control-static"><?php echo h(date("d.m.y H:i:s", strtotime($this->data['Group']['modified']))); ?></p>
              </div>
            </div>
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
                        'controller' => 'groups',
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