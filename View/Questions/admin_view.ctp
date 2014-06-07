<div class="questions view">
<h2><?php echo __('Question'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($question['Question']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($question['Question']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Text'); ?></dt>
		<dd>
			<?php echo h($question['Question']['text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team'); ?></dt>
		<dd>
			<?php echo $this->Html->link($question['Team']['name'], array('controller' => 'teams', 'action' => 'view', $question['Team']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($question['Question']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($question['Question']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Question'), array('action' => 'edit', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Question'), array('action' => 'delete', $question['Question']['id']), null, __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Teams'), array('controller' => 'teams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Team'), array('controller' => 'teams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipps'), array('controller' => 'tipps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipp'), array('controller' => 'tipps', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Tipps'); ?></h3>
	<?php if (!empty($question['Tipp'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Match Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Points Team1'); ?></th>
		<th><?php echo __('Points Team2'); ?></th>
		<th><?php echo __('Points'); ?></th>
		<th><?php echo __('Points Total'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Team Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Question Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($question['Tipp'] as $tipp): ?>
		<tr>
			<td><?php echo $tipp['id']; ?></td>
			<td><?php echo $tipp['match_id']; ?></td>
			<td><?php echo $tipp['user_id']; ?></td>
			<td><?php echo $tipp['points_team1']; ?></td>
			<td><?php echo $tipp['points_team2']; ?></td>
			<td><?php echo $tipp['points']; ?></td>
			<td><?php echo $tipp['points_total']; ?></td>
			<td><?php echo $tipp['type']; ?></td>
			<td><?php echo $tipp['team_id']; ?></td>
			<td><?php echo $tipp['group_id']; ?></td>
			<td><?php echo $tipp['question_id']; ?></td>
			<td><?php echo $tipp['created']; ?></td>
			<td><?php echo $tipp['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'tipps', 'action' => 'view', $tipp['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'tipps', 'action' => 'edit', $tipp['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'tipps', 'action' => 'delete', $tipp['id']), null, __('Are you sure you want to delete # %s?', $tipp['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Tipp'), array('controller' => 'tipps', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
