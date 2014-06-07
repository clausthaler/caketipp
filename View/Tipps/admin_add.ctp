<div class="tipps form">
<?php echo $this->Form->create('Tipp'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Tipp'); ?></legend>
	<?php
		echo $this->Form->input('match_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('points_team1');
		echo $this->Form->input('points_team2');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tipps'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Matches'), array('controller' => 'matches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Match'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
