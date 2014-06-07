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
    <?php echo $this->element('menu', array("active" => "rounds")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __('Add round'); ?></u></h3>
            <?php
            echo $this->Form->create('Round', array(
              'action' => 'edit',
              'id' => 'EditForm',
              'class' => 'form-horizontal',
              'role' => 'form'
            )); 
            echo $this->Form->input('id');
            ?>
            <div class="form-group">
              <?php echo $this->Form->label('Round.name', __('Name'), 'col-md-3'); ?>
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
              <?php echo $this->Form->label('Round.shortname', __('Shortname'), 'col-md-3'); ?>
              <div class="col-md-7">
                <?php 
                  echo $this->Form->input('shortname', array(
                    'label' => false,
                    'class' => 'form-control',
                    'div' => false,
                    'placeholder' => __('Shortname'),
                    'tabindex' => '2'
                  ));
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-7 col-md-push-3">
              <?php echo $this->Form->input('bonus', array(
                'div' => array('class' => 'checkbox'),
                'type' => 'checkbox',
                'label' => __('Bonus yes/no'),
                'tabindex' => '3')); 
              ?>
              </div> <!-- /.col -->
            </div> <!-- /.form-group -->
            <div class="form-group">
              <?php echo $this->Form->label('Round.created', __('created'), 'col-md-3'); ?>
              <div class="col-md-7">
                <p class="form-control-static"><?php echo h(date("d.m.y H:i:s", strtotime($this->data['Round']['created']))); ?></p>
              </div>
            </div>
            <div class="form-group">
              <?php echo $this->Form->label('Round.modified', __('modified'), 'col-md-3'); ?>
              <div class="col-md-7">
                <p class="form-control-static"><?php echo h(date("d.m.y H:i:s", strtotime($this->data['Round']['modified']))); ?></p>
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


<!-- start: Main Menu -->
<?php
    echo $this->element('main_menu', array(
	    "active" => "rounds"
    ));
?>
<!-- end: Main Menu -->

            
<!-- start: Content -->
<div id="content" class="col-sm-11">
	<div class="box">
		<?php
		echo $this->Form->create('Round', array(
			'action' => 'edit',
			'id' => 'EditForm',
			'class' => 'form-horizontal',
			'role' => 'form'
		)); 
		echo $this->Form->input('id');
		?>
		<div class="form-group">
			<?php echo $this->Form->label('Round.name', __('Name'), 'control-label'); ?>
			<div class="controls">
				<?php 
					echo $this->Form->input('name', array(
						'label' => false,
						'class' => 'form-control',
						'div' => array(
							'class' => 'input-group col-sm-4'),
						'placeholder' => __('Name')
					));
				?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $this->Form->label('Round.shortname', __('Shortname'), 'control-label'); ?>
			<div class="controls">
				<?php 
					echo $this->Form->input('shortname', array(
						'label' => false,
						'class' => 'form-control',
						'div' => array(
							'class' => 'input-group col-sm-4'),
						'placeholder' => __('Shortname')
					));
				?>
			</div>
		</div>
		<div class="form-group">
			<div class="controls">
				<?php 
					echo $this->Form->input('bonus', array(
						'type' => 'checkbox',
						'label' => array('text' => __('Bonus yes/no'),
							'class' => 'checkbox')));
				?>
			</div>
		 </div>
		<div class="form-group">
		<?php
			echo $this->Form->button(__('Save'), array(
    			'type' => 'submit',
    			'escape' => true,
    			'class' => 'btn btn-primary')); ?>
			<button class="btn" onclick="window.location.href='<?php echo Router::url(array('controller'=>'Rounds', 'action'=>'admin_index'))?>'">Cancel</button>
		<?php
    		echo $this->Form->end(); 
    	?>
		</div>
	</div>
</div>