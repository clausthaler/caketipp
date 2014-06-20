<div class="messages view">
<h2><?php echo __('Message'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($message['Message']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($message['Message']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Text'); ?></dt>
		<dd>
			<?php echo h($message['Message']['text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($message['User']['username'], array('controller' => 'users', 'action' => 'view', $message['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($message['Message']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($message['Message']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($message['Message']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Message'), array('action' => 'edit', $message['Message']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Message'), array('action' => 'delete', $message['Message']['id']), null, __('Are you sure you want to delete # %s?', $message['Message']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Messages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Message'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Feeds'), array('controller' => 'feeds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feed'), array('controller' => 'feeds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Likes'), array('controller' => 'likes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Like'), array('controller' => 'likes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Feeds'); ?></h3>
	<?php if (!empty($message['Feed'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Text'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Message Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($message['Feed'] as $feed): ?>
		<tr>
			<td><?php echo $feed['id']; ?></td>
			<td><?php echo $feed['text']; ?></td>
			<td><?php echo $feed['user_id']; ?></td>
			<td><?php echo $feed['parent_id']; ?></td>
			<td><?php echo $feed['message_id']; ?></td>
			<td><?php echo $feed['created']; ?></td>
			<td><?php echo $feed['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'feeds', 'action' => 'view', $feed['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'feeds', 'action' => 'edit', $feed['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'feeds', 'action' => 'delete', $feed['id']), null, __('Are you sure you want to delete # %s?', $feed['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Feed'), array('controller' => 'feeds', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Likes'); ?></h3>
	<?php if (!empty($message['Like'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Feed Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Message Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($message['Like'] as $like): ?>
		<tr>
			<td><?php echo $like['id']; ?></td>
			<td><?php echo $like['feed_id']; ?></td>
			<td><?php echo $like['user_id']; ?></td>
			<td><?php echo $like['message_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'likes', 'action' => 'view', $like['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'likes', 'action' => 'edit', $like['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'likes', 'action' => 'delete', $like['id']), null, __('Are you sure you want to delete # %s?', $like['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Like'), array('controller' => 'likes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
