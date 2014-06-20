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
      <?php echo $this->element('menu', array("active" => "blog")); ?>
      <!-- end: Main Menu -->
      <div class="col-md-6 col-sm-8 layout-main">
        <?php foreach ($messages as $message): ?>
          <div class="message-item">
            <h3 class="content-title"><u>
            <?php 
               echo $this->Html->link($message['Message']['title'], array(
                      'action' => 'view', 
                      $message['Message']['id']));
            ?>
            </u></h3>
            <div class="message-body">
              <?php echo substr($message['Message']['text'], 0, 400) . '....';  ?>
            </div>
            <div class="message-footer">
              <span class="pull-left"><i class="fa fa-thumbs-up"></i> <?php echo count($message['Like']) ?>   </span>
              <span class="pull-left"><i class="fa fa-comment-o"></i> <?php echo count($message['Feed']) ?></span>
              <span class="pull-right"><i class="fa fa-clock-o"></i> 
              <?php echo $message['User']['username']; ?> am <?php
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $message['Message']['created']);
                echo $date->format('d.m. H:i')
              ?>
              </span>
            </div>
            <div>
              <?php 
                echo $this->Html->link(__('Read'), array(
                      'action' => 'view', 
                      $message['Message']['id']),
                      array('class' => 'btn btn-sm btn-info')
                );
              ?>
            </div>

          </div>
        <?php endforeach; ?>
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


      </div>
      <div class="col-md-3">
        <?php 
          $feeds = $this->requestAction('feeds/stream' ); 
          echo $this->element('feedstream', array('feeds' => $feeds));
        ?>
      </div>
    </div>
  </div>
</div>
