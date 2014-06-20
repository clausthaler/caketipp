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
    <?php echo $this->element('menu', array("active" => "messages")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <!-- start: Content -->
            <h3 class="content-title"><u><?php echo __('Messages'); ?></u></h3>
            <table class="table table-condensed" cellpadding="0" cellspacing="0">
              <tr>
                  <th><?php echo $this->Paginator->sort('title', __('Title')); ?></th>
                  <th><?php echo $this->Paginator->sort('author', __('Author')); ?></th>
                  <th><?php echo $this->Paginator->sort('published', __('published')); ?></th>
                  <th class="actions"><?php echo __('Actions'); ?></th>
              </tr>
              <?php
               foreach ($messages as $message): ?>
              <tr>
                <td><?php echo $message['Message']['title'] ?></td>
                <td><?php echo $message['User']['username'] ?></td>
                <td><?php 
                  if ($message['Message']['published'] != 0) {
                    echo date('d.m.Y', $message['Message']['published']);
                  } else {
                    echo __('unpublished');
                  }
                  ?>
                </td>
                <td class="actions">
                <?php 
                  echo $this->Html->link(__('Edit'), array(
                      'action' => 'edit', 
                      $message['Message']['id']),
                      array('class' => 'btn btn-xs btn-info')
                  );
                  echo '&nbsp;';
                  echo $this->Form->postLink(
                      __('Delete'), array(
                          'action' => 'delete', 
                          $message['Message']['id']
                      ),
                      array('class' => 'btn btn-xs btn-danger'), 
                      __('Are you sure you want to message # %s?', $message['Message']['id'])); 

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
            <?php echo $this->Html->link(__('New Message'),
                array('action' => 'new'),
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