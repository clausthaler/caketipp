<div class="mainnav">
  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
</div> <!-- /.mainnav -->
<div class="content">
  <div class="container">
    <div class="row">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "teams")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __('Teams'); ?></u></h3>

            <!-- start: Content -->
            <table class="table table-condensed">
              <thead>
                <tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('iconurl'); ?></th>
					<th><?php echo $this->Paginator->sort('group_id'); ?></th>
                </tr>
              </thead>   
              <tbody>
                <?php foreach ($teams as $team): ?>
				<tr>
					<td>
						<?php echo $this->Html->link($team['Team']['id'], array(
                      'action' => 'edit', $team['Team']['id'])
                      ); ?></td>
					<td>
						<?php echo $this->Html->link($team['Team']['name'], array(
                      'action' => 'edit', $team['Team']['id'])
                      ); ?></td>
					<td>
						<?php
						echo $this->Html->image('flags/' . $team['Team']['iconurl']) ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($team['Group']['name'], array(
							'controller' => 'groups',
                      'action' => 'edit', $team['Group']['id'])
                      ); ?></td>
				</tr>
				<?php endforeach; ?>
              </tbody>
            </table>
            <div class="actions">
              <?php echo $this->Html->link(__('New Team'),
                array('action' => 'add'),
                array('class' => 'btn btn-sm btn-success')); 
              ?>
            </div>
          </div> <!-- /.tab-pane -->
        </div> <!-- /.tab-content -->
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->
