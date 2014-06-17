<div class="mainnav">
  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
</div> <!-- /.mainnav -->
<div class="content">
  <div class="container">
    <div class="layout layout-main-right layout-stack-sm">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "matches")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <!-- start: Content -->
            <h3 class="content-title"><u><?php echo __('Matches'); ?></u></h3>
            <table class="table table-condensed" cellpadding="0" cellspacing="0">
              <tr>
                  <th><?php echo $this->Paginator->sort('kickoff', __('Date')); ?></th>
                  <th><?php echo $this->Paginator->sort('team1_id',__('Team 1')); ?></th>
                  <th>-</th>
                  <th><?php echo $this->Paginator->sort('team2_id', __('Team 2')); ?></th>
                  <th><?php echo $this->Paginator->sort('group_id'); ?></th>
                  <th ><?php echo $this->Paginator->sort('round_id'); ?></th>
                  <th colspan="3"><?php echo __('Result'); ?></th>
                  <th class="actions"><?php echo __('Actions'); ?></th>
              </tr>
              <?php foreach ($matches as $match): ?>
              <tr>
                <td>
                <?php 
                    echo __(date("D", $match['Match']['kickoff'])) . ', ';
                    echo date("d.m", $match['Match']['kickoff']); 
                    echo '&nbsp;<small>' . date("H:i", $match['Match']['kickoff']) . ' </small>'; 
                ?>
                </td>
                <td>
                <?php 
                    if (!empty($match['Team1']['iconurl'])) {
                      echo $this->Html->image($match['Team1']['iconurl']);
                    }
                    echo "&nbsp;";
                    echo $this->Html->link($match['Team1']['name'], array('controller' => 'teams', 'action' => 'view',  $match['Team1']['id'])); 
                ?>
                </td>
                <td>-</td>
                <td>
                <?php 
                    if (!empty($match['Team1']['iconurl'])) {
                      echo $this->Html->image($match['Team2']['iconurl']);
                    }
                    echo "&nbsp;";
                    echo $this->Html->link($match['Team2']['name'], array('controller' => 'teams', 'action' => 'view',  $match['Team2']['id'])); 
                ?>
                </td>
                <td>
                <?php echo $this->Html->link($match['Group']['shortname'], array('controller' => 'groups', 'action' => 'view  ', $match['Group']['id'])); ?>
                </td>
                <td>
                <?php echo h($match['Round']['shortname']); ?>
                </td>
                <td style="text-align:right">
                <?php 
                    if ($match['Match']['points_team1'] == -1) {
                      echo '-';
                    } else {
                      echo h($match['Match']['points_team1']);
                    } 
                ?>
                </td>
                <td>:</td>
                <td style="text-align:left">
                <?php 
                    if ($match['Match']['points_team2'] == -1) {
                      echo '-';
                    } else {
                      echo h($match['Match']['points_team2']);
                    } 
                  if ($match['Match']['extratime'] != 0) {
                    if ($match['Match']['extratime'] == 1) {
                      echo '&nbsp;' . __('ot');
                    }
                    if ($match['Match']['extratime'] == 2) {
                      echo '&nbsp;' . __('pen');
                    }
                  }
                ?>
                </td>
                <td class="actions">
                <?php
                if ($match['Match']['isfinished'] != 1) {
                  if ($match['Match']['kickoff'] < time()) {
                    echo $this->Html->link(__('Enter Result'), array(
                        'action' => 'result', 
                        $match['Match']['id']),
                        array('class' => 'btn btn-xs btn-success')
                    );
                  } else {
                    if (!$match['Match']['isfixed'] == 1) {
                      echo $this->Html->link(__('Edit'), array(
                          'action' => 'edit', 
                          $match['Match']['id']),
                          array('class' => 'btn btn-xs btn-info')
                      );
                      echo '&nbsp;';
                      echo $this->Form->postLink(
                          __('Delete'), array(
                              'action' => 'delete', 
                              $match['Match']['id']
                          ),
                          array('class' => 'btn btn-xs btn-danger'), 
                          __('Are you sure you want to delete # %s?', $match['Match']['id'])); 
                    }
                    echo '&nbsp;';                    
                  }
                } else {
                      echo $this->Html->link(__('Edit result'), array(
                          'action' => 'result', 
                          $match['Match']['id']),
                          array('class' => 'btn btn-xs btn-danger')
                      );                      
                }
                ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </table>

            <?php
              $params = $this->Paginator->params();
              if ($params['pageCount'] > 1) {
            ?>
              <div class="pagination pagination-centered">
                  <ul class="pagination">
                  <?php
                      echo $this->Paginator->prev(__('Previous'), array(
                          'class' => 'prev',
                          'tag' => 'li',
                           'escape' => false
                      ), '<a onclick="return false;">' . __('Previous') . '</a>', array(
                          'class' => 'prev disabled',
                          'tag' => 'li',
                          'escape' => false
                      ));
                      echo $this->Paginator->numbers(array(
                          'separator' => '',
                          'tag' => 'li',
                          'currentClass' => 'active',
                          'currentTag' => 'a'
                      ));
                      echo $this->Paginator->next(__('Next'), array(
                          'class' => 'next',
                          'tag' => 'li',
                          'escape' => false
                      ), '<a onclick="return false;">' . __('Next') . '</a>', array(
                          'class' => 'next disabled',
                          'tag' => 'li',
                          'escape' => false
                      )); ?>
                  </ul>
              </div>
            <?php } ?>

            <div class="actions">
            <?php echo $this->Html->link(__('New Match'),
                array('action' => 'add'),
                array('class' => 'btn btn-sm btn-success')); 
            ?>
            </div>
            <!-- /.Content -->

          </div> <!-- /.tab-pane -->
        </div> <!-- /.tab-content -->
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->