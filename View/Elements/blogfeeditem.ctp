<div class="feed-item" id="feed-<?php echo $feed['Feed']['id'] ?>">
    <div class="feed-icon bg-tertiary">
      <?php
      if (!empty($feed['User']['photo'])) {
        if (file_exists(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $feed['User']['photo_dir'] .  DS . 'small_' . $feed['User']['photo'])) {
            echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $feed['User']['photo_dir'] .  DS . 'small_' . $feed['User']['photo'], array('style' => 'max-width:30px; max-height:30px;'));
        } else {
            echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $feed['User']['photo_dir'] .  DS .  $feed['User']['photo'], array('style' => 'max-width:30px; max-height:30px;'));
        }
      } else {
        echo '<i class="fa fa-lightbulb-o"></i>';
      }
      ?>
    </div> <!-- /.feed-icon -->

    <div class="feed-subject">
      <span class="pull-right"><i class="fa fa-clock-o" style="padding-left:20px"></i>
          <?php 
            $id = String::uuid();
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $feed['Feed']['created']);
            $diff = strtotime($this->Session->read('currentdatetime')) - $date->getTimestamp();
            if ($diff < 3600) {
              echo 'vor ' . round($diff / 60, 0) . ' Min.';
            } elseif ($diff < 84000) {
              echo 'vor ' . round($diff / 3600, 0) . ' Std.';
            } else {
              echo 'vor ' . round($diff / 84000, 0) . ' Tagen';
            }
          ?>
          <?php echo $this->element('feedlike', array('feed' => $feed));  ?>
        </span> 
      <p><a href="javascript:;"><?php echo $feed['User']['username'] ?></a></p>
    </div> <!-- /.feed-subject -->

    <div class="feed-content">
          <?php if ($feed['Feed']['message_id'] != '') {
            echo __('has commented message') . substr($feed['Message']['title'], 0, 20) . '...' ;
          }
          echo $feed['Feed']['text'];
          ?>
    </div> <!-- /.feed-content -->

    <?php foreach ($feed['ChildFeed'] as $ckey => $comment) {  ?>
      <div class="feed-comment">        
        <div class="feed-subject">
          <span class="pull-right"><i class="fa fa-clock-o" style="padding-left:20px"></i>
              <?php 
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $comment['created']);
                $diff = strtotime($this->Session->read('currentdatetime')) - $date->getTimestamp();
                if ($diff < 3600) {
                  echo 'vor ' . round($diff / 60, 0) . ' Min.';
                } elseif ($diff < 84000) {
                  echo 'vor ' . round($diff / 3600, 0) . ' Std.';
                } else {
                  echo 'vor ' . round($diff / 84000, 0) . ' Tagen';
                }
              ?>
              <?php echo $this->element('feedlike', array(
                'feed' => array('Feed' => $comment, 'Like' => $comment['Like'])));  
              ?>
          </span> 
          <p><a href="javascript:;"><?php echo $comment['User']['username'] ?></a></p>
        </div> <!-- /.feed-subject -->

        <div class="feed-content">
          <?=h($comment['text']); ?> 
        </div> <!-- /.feed-content -->

      </div> <!-- /.feed-comment -->
    <?php } ?>
    <p id="<?php echo $id?>" >
      <a href="javascript:tippspiel_admin.showblogcommentbox({feed:'<?php echo $feed['Feed']['id'] ?>', target: '<?php echo $id?>'});"> <?php echo __('comment it') ?></a>
    </p>
</div> <!-- /.feed-item -->
