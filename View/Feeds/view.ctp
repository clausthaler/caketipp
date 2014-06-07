<div class="feeds view">
<h2><?php echo __('Feed'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Text'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($feed['User']['username'], array('controller' => 'users', 'action' => 'view', $feed['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Feed'); ?></dt>
		<dd>
			<?php echo $this->Html->link($feed['ParentFeed']['text'], array('controller' => 'feeds', 'action' => 'view', $feed['ParentFeed']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Feed'), array('action' => 'edit', $feed['Feed']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Feed'), array('action' => 'delete', $feed['Feed']['id']), null, __('Are you sure you want to delete # %s?', $feed['Feed']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Feeds'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feed'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Feeds'), array('controller' => 'feeds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Feed'), array('controller' => 'feeds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Feedlikes'), array('controller' => 'feedlikes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feedlike'), array('controller' => 'feedlikes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Feedlikes'); ?></h3>
	<?php if (!empty($feed['Feedlike'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Feed Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($feed['Feedlike'] as $feedlike): ?>
		<tr>
			<td><?php echo $feedlike['id']; ?></td>
			<td><?php echo $feedlike['feed_id']; ?></td>
			<td><?php echo $feedlike['user_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'feedlikes', 'action' => 'view', $feedlike['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'feedlikes', 'action' => 'edit', $feedlike['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'feedlikes', 'action' => 'delete', $feedlike['id']), null, __('Are you sure you want to delete # %s?', $feedlike['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Feedlike'), array('controller' => 'feedlikes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Feeds'); ?></h3>
	<?php if (!empty($feed['ChildFeed'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Text'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($feed['ChildFeed'] as $childFeed): ?>
		<tr>
			<td><?php echo $childFeed['id']; ?></td>
			<td><?php echo $childFeed['text']; ?></td>
			<td><?php echo $childFeed['user_id']; ?></td>
			<td><?php echo $childFeed['parent_id']; ?></td>
			<td><?php echo $childFeed['created']; ?></td>
			<td><?php echo $childFeed['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'feeds', 'action' => 'view', $childFeed['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'feeds', 'action' => 'edit', $childFeed['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'feeds', 'action' => 'delete', $childFeed['id']), null, __('Are you sure you want to delete # %s?', $childFeed['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Feed'), array('controller' => 'feeds', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
