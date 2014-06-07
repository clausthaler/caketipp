<!-- start: Main Menu -->
<?php
    echo $this->element('main_menu', array(
        "active" => "rounds"
    ));
?>
<!-- end: Main Menu -->

<?php 



foreach ($matches as $key => $match) {
    echo $this->Form->radio($match['Match']['id'], Set::combine($rounds, '{n}.Round.id', '{n}.Round.name'));
}

?>
            
<!-- start: Content -->
<div id="content" class="col-sm-11">
    <h2><?php echo __('Rounds'); ?></h2>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>   
        <tbody>
            <?php foreach ($rounds as $round): ?>
            <tr>
                <td><?php echo h($round['Round']['id']); ?>&nbsp;</td>
                <td><?php echo h($round['Round']['name']); ?>&nbsp;</td>
                <td><?php echo h($round['Round']['created']); ?>&nbsp;</td>
                <td><?php echo h($round['Round']['modified']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $round['Round']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $round['Round']['id']), null, __('Are you sure you want to delete # %s?', $round['Round']['id'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<div class="pagination pagination-centered">
    <ul class="pagination">
        <li>
            <a href="table.html#">Prev</a>
        </li>
        <li class="active">
            <a href="table.html#">1</a>
        </li>
        <li>
            <a href="table.html#">2</a>
        </li>
        <li>
            <a href="table.html#">3</a>
        </li>
        <li>
            <a href="table.html#">4</a>
        </li>
        <li>
            <a href="table.html#">Next</a>
        </li>
    </ul>
</div>  
    <?php
    echo $this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>  </p>
    <div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Round'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Matches'), array('controller' => 'matches', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Match'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
    </ul>
</div>
</div>
