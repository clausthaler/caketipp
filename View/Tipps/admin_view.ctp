<div class="tipps view">
<h2><?php echo __('Tipp'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tipp['Tipp']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Match'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tipp['Match']['name'], array('controller' => 'matches', 'action' => 'view', $tipp['Match']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($tipp['User']['username'], array('controller' => 'users', 'action' => 'view', $tipp['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Points Team1'); ?></dt>
		<dd>
			<?php echo h($tipp['Tipp']['points_team1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Points Team2'); ?></dt>
		<dd>
			<?php echo h($tipp['Tipp']['points_team2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tipp['Tipp']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tipp['Tipp']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tipp'), array('action' => 'edit', $tipp['Tipp']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tipp'), array('action' => 'delete', $tipp['Tipp']['id']), null, __('Are you sure you want to delete # %s?', $tipp['Tipp']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipps'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipp'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Matches'), array('controller' => 'matches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Match'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
