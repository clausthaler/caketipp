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
    <?php echo $this->element('menu', array("active" => "users")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u>Tipper</u></h3>

           
            <!-- start: Content -->
            <!--row -->         
            <?php 
                echo $this->Form->create($model, array('action' => 'index',
                    'class' => 'form-inline',
                    'role' => 'form'));
                echo __d('users', 'Filter');
                echo $this->Form->input('username', array(
                    'label' => false,
                    'class' => 'form-control input-sm',
                    'div' => array('class' => 'form-group'),
                    'type' => 'text',
                    'placeholder' => __d('users', 'Username')
                ));
                echo '&nbsp;';
                echo $this->Form->input('email', array(
                    'label' => false,
                    'class' => 'form-control input-sm',
                    'div' => array('class' => 'form-group'),
                    'type' => 'text',
                    'placeholder' => __d('users', 'Email')
                ));
                echo '&nbsp;';
                echo '&nbsp;';
                echo $this->Form->button(__d('users', 'Search'), array(
                    'type' => 'submit',
                    'escape' => true,
                    'class' => 'btn btn-primary btn-xs'
                ));
                echo $this->Form->end();
            ?>
            <br>
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('username', __d('users', 'Username')); ?></th>
                        <th><?php echo $this->Paginator->sort('has_paid', __('paid')); ?></th>
                        <th><?php echo $this->Paginator->sort('email', __d('users', 'Email')); ?></th>
                        <th><?php echo $this->Paginator->sort('email_verified', __d('users', 'Email verified')); ?></th>
                        <th><?php echo $this->Paginator->sort('active'); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                </thead>   
                <tbody>
                    <?php
                        $i = 0;
                        foreach ($users as $user):
                            $class = null;
                        if ($i++ % 2 == 0) {
                            $class = ' class="altrow"';
                        }
                    ?>
                    <tr<?php echo $class;?>>
                        <td>
                            <?php echo $user[$model]['username']; ?>
                        </td>
                        <td>
                            <?php if ($user[$model]['has_paid'] == 1) {
                                echo '<span class="badge badge-success demo-element">' . __d('users', 'Yes') . '</span>';
                            } else {
                                echo '<span class="badge badge-danger demo-element">' . __d('users', 'No') . '</span>';
                            } ?>
                        </td>
                        <td>
                            <?php echo $user[$model]['email']; ?>
                        </td>
                        <td>
                            <?php if ($user[$model]['email_verified'] == 1) {
                                echo '<span class="badge badge-success demo-element">' . __d('users', 'Yes') . '</span>';
                            } else {
                                echo '<span class="badge badge-danger demo-element">' . __d('users', 'No') . '</span>';
                            } ?>
                        </td>
                        <td>
                            <?php if ($user[$model]['active'] == 1) {
                                echo '<span class="badge badge-success demo-element">' . __d('users', 'Yes') . '</span>';
                            } else {
                                echo '<span class="badge badge-danger demo-element">' . __d('users', 'No') . '</span>';
                            } ?>
                        </td>
                        <td class="actions">
                          <?php 
                            echo $this->Html->link(__('Edit'), array(
                              'action' => 'edit', 
                              $user['User']['id']),
                              array('class' => 'btn btn-xs btn-info')
                            ); 
                            echo '&nbsp;';
                            echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']),
                              array('class' => 'btn btn-xs btn-danger'), __('Are you sure you want to delete user %s?', $user['User']['username']));
                          ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>                                 
                </tbody>
            </table>
              <?php
              $params = $this->Paginator->params();
              if ($params['pageCount'] > 1) {
              ?>
              <div class="dataTables_paginate paging_bootstrap">
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
                  <?php echo $this->Html->link(__d('users', 'Add Users'), array('admin' => true, 'action'=>'add'),
                      array('class' => 'btn btn-sm btn-success'));?>
              </div>
          </div> <!-- /.tab-pane -->
        </div> <!-- /.tab-content -->
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->