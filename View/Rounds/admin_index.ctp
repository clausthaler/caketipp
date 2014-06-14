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
    <?php echo $this->element('menu', array("active" => "rounds")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __('Rounds'); ?></u></h3>

            <!-- start: Content -->
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th><?php echo $this->Paginator->sort('id'); ?></th>
                  <th><?php echo $this->Paginator->sort('name'); ?></th>
                  <th><?php echo $this->Paginator->sort('groupstage'); ?></th>
                  <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
              </thead>   
              <tbody>
                <?php foreach ($rounds as $round): ?>
                <tr>
                  <td><?php echo h($round['Round']['id']); ?>&nbsp;</td>
                  <td><?php echo h($round['Round']['name']); ?>&nbsp;</td>
                  <td>
                  <?php echo $this->Form->checbox('groupstage', array(
                    'div' => false,
                    'type' => 'checkbox',
                    'label' => false,
                    'checked' => ($round['Round']['groupstage'] == 1 ? true : false),
                    'disabled' => 'disabled')); 
                  ?>
                  </td>
                  <td class="actions">
                    <?php echo $this->Html->link(__('Edit'), array(
                      'action' => 'edit', $round['Round']['id']),
                      array('class' => 'btn btn-xs btn-info')
                      ); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $round['Round']['id']),
                      array('class' => 'btn btn-xs btn-danger'), __('Are you sure you want to delete round %s?', $round['Round']['name'])); ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
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
              <?php echo $this->Html->link(__('New Round'),
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