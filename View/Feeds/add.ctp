<div class="feeds form">
<?php echo $this->Form->create('Feed'); ?>
	<fieldset>
		<legend><?php echo __('Add Feed'); ?></legend>
	<?php
		echo $this->Form->input('text');
		echo $this->Form->input('user_id');
		echo $this->Form->input('parent_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Feeds'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Feeds'), array('controller' => 'feeds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Feed'), array('controller' => 'feeds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Feedlikes'), array('controller' => 'feedlikes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feedlike'), array('controller' => 'feedlikes', 'action' => 'add')); ?> </li>
	</ul>
</div>
