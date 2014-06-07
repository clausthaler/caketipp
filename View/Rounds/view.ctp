<div class="rounds view">
<h2><?php echo __('Round'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($round['Round']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($round['Round']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Slug'); ?></dt>
		<dd>
			<?php echo h($round['Round']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shortname'); ?></dt>
		<dd>
			<?php echo h($round['Round']['shortname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bonus'); ?></dt>
		<dd>
			<?php echo h($round['Round']['bonus']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($round['Round']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($round['Round']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Round'), array('action' => 'edit', $round['Round']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Round'), array('action' => 'delete', $round['Round']['id']), null, __('Are you sure you want to delete # %s?', $round['Round']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Rounds'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Round'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Matches'), array('controller' => 'matches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Match'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Matches'); ?></h3>
	<?php if (!empty($round['Match'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Datetime'); ?></th>
		<th><?php echo __('Stage Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Team Id1'); ?></th>
		<th><?php echo __('Team Id2'); ?></th>
		<th><?php echo __('Round Id'); ?></th>
		<th><?php echo __('Points Team1'); ?></th>
		<th><?php echo __('Points Team2'); ?></th>
		<th><?php echo __('Isfinished'); ?></th>
		<th><?php echo __('Aftertime'); ?></th>
		<th><?php echo __('Penalties'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($round['Match'] as $match): ?>
		<tr>
			<td><?php echo $match['id']; ?></td>
			<td><?php echo $match['name']; ?></td>
			<td><?php echo $match['datetime']; ?></td>
			<td><?php echo $match['stage_id']; ?></td>
			<td><?php echo $match['group_id']; ?></td>
			<td><?php echo $match['team1_id']; ?></td>
			<td><?php echo $match['team2_id']; ?></td>
			<td><?php echo $match['round_id']; ?></td>
			<td><?php echo $match['points_team1']; ?></td>
			<td><?php echo $match['points_team2']; ?></td>
			<td><?php echo $match['isfinished']; ?></td>
			<td><?php echo $match['aftertime']; ?></td>
			<td><?php echo $match['penalties']; ?></td>
			<td><?php echo $match['created']; ?></td>
			<td><?php echo $match['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'matches', 'action' => 'view', $match['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'matches', 'action' => 'edit', $match['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'matches', 'action' => 'delete', $match['id']), null, __('Are you sure you want to delete # %s?', $match['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Match'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
