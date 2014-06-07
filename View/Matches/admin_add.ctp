<?php 
	$this->Html->script('bootstrap-datepicker.min', array('block' => 'scriptBottom'));
	$this->Html->scriptBlock('
		$(".datepicker").datepicker({format:"dd.mm.yyyy"});
	', array('block' => 'scriptBottom'));	

?>

<!-- start: Main Menu -->
<?php
    echo $this->element('main_menu', array(
	    "active" => "matches"
    ));
?>
<!-- end: Main Menu -->

            
<!-- start: Content -->
<div id="content" class="col-sm-11">
	<div class="box">
		<?php
		echo $this->Form->create('Match', array(
			'action' => 'add',
			'id' => 'AddForm',
			'class' => 'form-horizontal',
			'role' => 'form'
		)); 
		?>
		<div class="form-group">
			<?php echo $this->Form->label('Match.team1_id', __('Team 1'), 'control-label'); ?>
			<div class="controls">
				<div class="col-xs-6 col-md-2">
				<?php 
					echo $this->Form->input('team1_id', array(
						'empty' => __('Choose one'),
						'label' => false,
						'class' => 'form-control MatchTeamName',
						'div' => array(
							'class' => 'input-group'),
							'placeholder' => __('Team 1')
					));
				?>
				</div>
				<div class="col-xs-6 col-md-2">
				<?php 
					echo $this->Form->input('team2_id', array(
						'empty' => __('Choose one'),
						'label' => false,
						'class' => 'form-control MatchTeamName',
						'div' => array(
							'class' => 'input-group'),
							'placeholder' => __('Team 2')
					));
				?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<?php echo $this->Form->label('Match.name', __('Name'), 'control-label'); ?>
			<div class="controls">
				<div class="input-group col-sm-4">
				<?php 
					echo $this->Form->input('name', array(
						'label' => false,
						'class' => 'form-control',
						'div' => false,
						'type' => 'text',
						'placeholder' => __('Name')
					));
				?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<?php echo $this->Form->label('Match.date', __('Date'), 'control-label'); ?>
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
			<?php echo $this->Form->label('Match.group_id', __('Group'), 'control-label'); ?>
			<div class="controls">
				<?php 
					echo $this->Form->input('group_id', array(
						'empty' => __('Choose one'),
						'label' => false,
						'class' => 'form-control',
						'div' => array(
							'class' => 'input-group col-sm-4'),
						'placeholder' => __('Group')
					));
				?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $this->Form->label('Match.round_id', __('Round'), 'control-label'); ?>
			<div class="controls">
				<?php 
					echo $this->Form->input('round_id', array(
						'label' => false,
						'class' => 'form-control',
						'div' => array(
							'class' => 'input-group col-sm-4'),
						'placeholder' => __('Round')
					));
				?>
			</div>
		</div>

		<div class="form-group">
			<div class="controls">
				<?php 
					echo $this->Form->input('isfixed', array(
						'type' => 'checkbox',
						'label' => array('text' => __('fixed'),
							'class' => 'checkbox')));
				?>
			</div>
		</div>
		<div class="form-group">
		<?php
			echo $this->Form->button(__('Save'), array(
    			'type' => 'submit',
    			'escape' => true,
    			'class' => 'btn btn-primary')); 
			echo '&nbsp;';
			echo $this->Html->link(__('Cancel'),
        		array('action' => 'admin_index'),
        		array('class' => 'btn')); 
    	?>
		<?php
    		echo $this->Form->end(); 
    	?>
		</div>
	</div>
</div>