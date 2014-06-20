<?php 
  $this->Html->script('bootstrap-datepicker.min', array('block' => 'scriptBottom'));
  $this->Html->scriptBlock('
    $(".datepicker").datepicker({format:"dd.mm.yyyy"});
  ', array('block' => 'scriptBottom')); 

?>
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
    <?php echo $this->element('menu', array("active" => "matches")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __('Edit match'); ?></u></h3>

            <?php
            echo $this->Form->create('Match', array(
              'action' => 'edit',
              'id' => 'EditForm',
              'class' => 'form-horizontal',
              'role' => 'form'
            )); 
            echo $this->Form->input('id');
            ?>
            <div class="form-group">
              <label class="col-md-3"><?php echo __('Teams'); ?></label>
              <div class="row col-md-7">
                <div class="col-xs-5">
                <?php 
                  echo $this->Form->input('team1_id', array(
                    'label' => false,
                    'class' => 'form-control MatchTeamName',
                    'div' => false
                  ));
                ?>
                </div>
                <div class="col-xs-1">
                  <span>:</span>
                </div>
                <div class="col-xs-5">
                <?php 
                  echo $this->Form->input('team2_id', array(
                    'label' => false,
                    'class' => 'form-control MatchTeamName',
                    'div' => false
                  ));
                ?>
                </div>
              </div>
            </div>


            <div class="form-group">
              <?php
                echo $this->Form->label('Match.name', __('Name'), 'col-md-3');
                echo $this->Form->input('name', array(
                  'label' => false,
                  'class' => 'form-control',
                  'div' => array('class' => 'col-md-7'),
                  'type' => 'text',
                  'placeholder' => __('Name')
                ));
              ?>
            </div>        
            <div class="form-group">
              <?php echo $this->Form->label('Match.date', __('Date'), 'col-md-3'); ?>
              <div class="controls">
                <div class="col-xs-6 col-md-2">
                <?php 
                  echo $this->Form->input('date', array(
                    'label' => false,
                    'class' => 'form-control datepicker',
                    'div' => array(
                      'class' => 'input-group'),
                      'placeholder' => __('Date')
                  ));
                ?>
                </div>
                <div class="col-xs-6 col-md-2">
                <?php 
                  echo $this->Form->input('time', array(
                    'label' => false,
                    'class' => 'form-control',
                    'div' => array(
                      'class' => 'input-group'),
                      'placeholder' => __('Time')
                  ));
                ?>
                </div>
              </div>
            </div>
        
            <div class="form-group">
              <?php
               echo $this->Form->label('Match.group_id', __('Group'), 'col-md-3');
               echo $this->Form->input('group_id', array(
                'empty' => __('Choose one'),
                'label' => false,
                'class' => 'form-control',
                'div' => array('class' => 'col-md-4'),
                'placeholder' => __('Group')
              ));
              ?>
            </div>
            <div class="form-group">
              <?php 
                echo $this->Form->label('Match.round_id', __('Round'), 'col-md-3');
                echo $this->Form->input('round_id', array(
                  'label' => false,
                  'class' => 'form-control',
                  'div' => array('class' => 'col-md-4'),
                  'placeholder' => __('Round')
                ));
              ?>
            </div>
            <div class="form-group">
              <div class="col-md-7 col-md-push-3">
                <?php 
                  echo $this->Form->input('isfixed', array(
                    'type' => 'checkbox',
                    'label' => array('text' => __('fixed'),
                      'class' => 'checkbox')));
                ?>
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