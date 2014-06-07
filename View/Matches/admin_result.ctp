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
    <div class="layout layout-main-right layout-stack-sm">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "matches")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __('Enter match result'); ?></u></h3>

            <?php
            echo $this->Form->create('Match', array(
              'action' => 'result',
              'id' => 'ResultForm',
              'class' => 'form-horizontal',
              'role' => 'form',
              'onsubmit'=>'return confirm("' . __('Are you sure you want to submit the result and calculate tipps  for match %s?', $this->data['Match']['name']) . '");'
            )); 
            echo $this->Form->input('id');
            ?>
            <div class="form-group">
              <?php echo $this->Form->label('Match.group_id', __('Group'), 'col-md-3'); ?>
                <div class="col-md-7">
                  <p class="form-control-static"><?php echo $this->data['Group']['name'] ?></p>
                </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Match.round_id', __('Round'), 'col-md-3'); ?>
                <div class="col-md-7">
                  <p class="form-control-static"><?php echo $this->data['Round']['name'] ?></p>
                </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Match.name', __('Name'), 'col-md-3'); ?>
                <div class="col-md-7">
                  <p class="form-control-static"><?php echo $this->data['Match']['name'] ?></p>
                </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Match.date', __('Date'), 'col-md-3'); ?>
                <div class="col-md-7">
                  <p class="form-control-static"><?php  echo date("D, d.m.Y H:i", strtotime($this->data['Match']['datetime']));  ?></p>
                </div>
            </div>

            <div class="form-group">
              <?php echo $this->Form->label('Match.result', __('Result'), 'col-md-3'); ?>
              <div class="row col-md-7">
                <div class="col-xs-2">
                <?php 
                  echo $this->Form->select('points_team1', Configure::read('MatchResults'),
                    array(
                      'label' => false,
                      'div' => false)); 
                ?>
                </div>
                <div class="col-xs-1">
                  <span>:</span>
                </div>
                <div class="col-xs-2">
                <?php 
                  echo $this->Form->select('points_team2', Configure::read('MatchResults'),
                    array(
                      'label' => false,
                      'div' => false)); 
                ?>
                </div>
                <div class="col-xs-2">
                <?php 
                  echo $this->Form->select('extratime', Configure::read('MatchOverTime'),
                    array(
                      'empty' => false,
                      'label' => false,
                      'div' => false
                    )); 
                ?>
                </div>
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