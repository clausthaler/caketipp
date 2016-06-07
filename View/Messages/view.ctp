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
        <div style="margin-bottom: 30px;">
        <?php 
          if (isset($neighbors['prev']['Message'])) {
            echo $this->Html->link('<< ' . substr($neighbors['prev']['Message']['title'], 0, 30) . ' ...' , array(
              'action' => 'view', 
              $neighbors['prev']['Message']['id']),
              array('class' => 'pull-left')
            );
          }
        ?>
        <?php 
          if (isset($neighbors['next']['Message'])) {
            echo $this->Html->link(substr($neighbors['next']['Message']['title'], 0, 30) . ' ...' . ' >>', array(
              'action' => 'view', 
              $neighbors['next']['Message']['id']),
              array('class' => 'pull-right')
            );
          }
        ?>
        </div>
        <div class="message-item">
          <h3 class="content-title"><u><?php echo h($message['Message']['title']) ?></u></h3>
          <div class="message-body">
            <?php echo $message['Message']['text'];  ?>
          </div>
          <div class="message-footer">
            <?php echo $this->element('messagelike', array('message' => $message));  ?>
            <span class="pull-right"><i class="fa fa-clock-o"></i> 
            <?php echo $message['User']['username']; ?> am <?php
              $date = DateTime::createFromFormat('Y-m-d H:i:s', $message['Message']['created']);
              echo $date->format('d.m. H:i')
            ?>
            </span>
          </div>
        </div>
        <br>
        <h4><?php echo __('Comments'); ?></h3>
        <div id="commentbox" class="share-widget clearfix">
          <div class="row">
            <div class="col-md-9">
            <?php 
              echo $this->Form->create('Feed', array(
                'action' => 'add',
                'id' => 'CommentAddForm'
              )); 
              echo $this->Form->textarea('text', array(
                'rows' => 1,
                'label' => false,
                'class' => 'form-control',
                'div' => false,
                'placeholder' => __("What do you think about this message..."),
                'id' => 'commentBox'
              ));
              echo $this->Form->input('message_id', array(
                'value' => $message['Message']['id'],
                'type' => 'text',
                'div' => false,
                'label' => false,
                'style' => 'display:none;'));
            ?>
            </div>
            <div class="col-md-3">
            <?php
              echo $this->Form->button(__('Post'), array(
                'type' => 'submit',
                'escape' => true,
                'class' => 'btn btn-primary'
              )); 
            ?>
            </div>
            <?php echo $this->Form->end();  ?>
          </div>
        </div> <!-- /.share-widget -->
        <div class="comments">
        <?php foreach ($message['Feed'] as $key => $feed): ?>
          <div class="feed-item" id="feed-<?php echo $feed['id'] ?>">
            <div class="feed-content">
              <ul class="icons-list">
                <li><a href="javascript:;"><?php echo $feed['User']['username'] ?></a> &nbsp;
                  <?=h($feed['text']); ?> 
                </li>
              </ul>
            </div> <!-- /.feed-content -->
            <?php $id = String::uuid(); ?>
            <div class="feed-actions" id="<?php echo $id ?>">
              <span class="pull-right"><i class="fa fa-clock-o"></i>
              <?php 
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $feed['created']);
                $diff = time() - $date->getTimestamp();
                if ($diff < 3600) {
                  echo 'vor ' . round($diff / 60, 0) . ' Min.';
                } elseif ($diff < 84000) {
                  echo 'vor ' . round($diff / 3600, 0) . ' Std.';
                } else {
                  echo 'vor ' . round($diff / 8400, 0) . ' Tagen';
                }
              ?>
              </span> 
              <?php 
                $likers = Hash::extract( $feed['Like'], '{n}.user_id');
                if (array_search($this->Session->read('Auth.User.id'), $likers) !== false) {
                  $liker = true;
                } else {
                  $liker = false;
                }
              ?>
              <span id="commentlike-<?php echo $feed['id'] ?>">
                <span class="pull-left"><i class="fa fa-thumbs-up"></i> <?php echo count($feed['Like']) ?> </span>
                <a class="pull-left" href="javascript:tippspiel_admin.togglelike(<?php echo $feed['id'] ?>);"> 
                <?php 
                  if ($liker) {
                    echo __("don't like");
                  } else {
                    echo __("like it") ;     
                  }
                ?>
                </a> 
              </span>
            </div> <!-- /.feed-actions -->
          </div> <!-- /.feed-item -->
        <?php endforeach; ?>
        </div> <!-- /.comments -->
      </div> <!-- /.col -->
      <div class="col-md-3">
        <?php 
          $feeds = $this->requestAction('feeds/stream' ); 
          echo $this->element('feedstream', array('feeds' => $feeds));
        ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$("#CommentAddForm").submit(function(e) {
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
      console.log($('#commentBox').val());
    if ( $('#commentBox').val() != '' ) {    
      $.ajax({
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) {
          $( "div.comments" ).after( data );
          $('#commentBox').val('')
            //data: return data from server
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert( "Request failed: " + textStatus );
        }
      });
    }
    e.preventDefault(); //STOP default action
//    e.unbind(); //unbind. to stop multiple form submit.
});
$( document ).ready(function() {

});
</script>
