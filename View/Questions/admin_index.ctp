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
    <?php echo $this->element('menu', array("active" => "questions")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <!-- start: Content -->
            <h3 class="content-title"><u><?php echo __('Questions'); ?></u></h3>
            <table class="table table-condensed" cellpadding="0" cellspacing="0">
              <tr>
                  <th><?php echo $this->Paginator->sort('name', __('Name')); ?></th>
                  <th><?php echo $this->Paginator->sort('points', __('Points')); ?></th>
                  <th><?php echo $this->Paginator->sort('isfixed', __('Fixed')); ?></th>
                  <th><?php echo $this->Paginator->sort('due', __('due')); ?></th>
                  <th class="actions"><?php echo __('Actions'); ?></th>
              </tr>
              <?php foreach ($questions as $question): ?>
              <tr>
                <td><?php echo $question['Question']['name'] ?></td>
                <td><?php echo $question['Question']['points'] ?></td>
                <td>
                <?php echo $this->Form->checbox('bonus', array(
                    'div' => false,
                    'type' => 'checkbox',
                    'label' => false,
                    'checked' => ($question['Question']['isfixed'] == 1 ? true : false),
                    'disabled' => 'disabled')); 
                ?>
				        </td>
                <td>
                <?php 
                    echo __(date("D", $question['Question']['due'])) . ', ';
                    echo date("d.m.Y", $question['Question']['due']); 
                    echo '&nbsp;<small>' . date("H:i", $question['Question']['due']) . ' </small>'; 
                ?>
                </td>
                <td class="actions">
                <?php
                if ($question['Question']['due'] < strtotime($this->Session->read('currentdatetime')) && empty($question['Question']['team_id'])) {
                    echo $this->Html->link(__('Enter Result'), array(
                        'action' => 'result', 
                        $question['Question']['id']),
                        array('class' => 'btn btn-xs btn-success')
                    );
                } else {
                  echo $this->Html->link(__('Edit'), array(
                      'action' => 'edit', 
                      $question['Question']['id']),
                      array('class' => 'btn btn-xs btn-info')
                  );
                  echo '&nbsp;';
                  echo $this->Form->postLink(
                      __('Delete'), array(
                          'action' => 'delete', 
                          $question['Question']['id']
                      ),
                      array('class' => 'btn btn-xs btn-danger'), 
                      __('Are you sure you want to delete # %s?', $question['Question']['id'])); 
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
            <?php echo $this->Html->link(__('New Question'),
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