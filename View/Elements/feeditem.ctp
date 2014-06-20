  <div class="feed-item" id="feed-<?php echo $feed['Feed']['id'] ?>">
    <div class="feed-content">
      <ul class="icons-list">
        <li><a href="javascript:;"><?php echo $feed['User']['username'] ?></a> &nbsp;
          <?=h($feed['Feed']['text']); ?> 
        </li>
      </ul>
    </div> <!-- /.feed-content -->
    <?php $id = String::uuid(); ?>
    <div class="feed-actions" id="<?php echo $id ?>">
        <span class="pull-right"><i class="fa fa-clock-o"></i>
          <?php 
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $feed['Feed']['created']);
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
        <?php echo $this->element('feedlike', array('feed' => $feed));  ?>
        <a class="pull-left" href="javascript:tippspiel_admin.showcommentbox({feed:'<?php echo $feed['Feed']['id'] ?>', target:'<?php echo $id; ?>'});"> <?php echo __('comment it') ?></a>
    </div> <!-- /.feed-actions -->
    <?php foreach ($feed['ChildFeed'] as $ckey => $comment) {  ?>
      <?php $id = String::uuid(); ?>
      <div class="feed-comment">
        <div class="feed-content">
          <ul class="icons-list">
            <li><a href="javascript:;"><?php echo $comment['User']['username'] ?></a> &nbsp;
              <?=h($comment['text']); ?> 
            </li>
          </ul>
        </div> <!-- /.feed-content -->
        <div class="feed-actions" id="<?php echo $id ?>">
          <span class="pull-right"><i class="fa fa-clock-o"></i>
            <?php 
              $date = DateTime::createFromFormat('Y-m-d H:i:s', $comment['created']);
              $diff = time() - $date->getTimestamp();
              if ($diff < 3600) {
                if (round($diff / 60, 0) == 0) {
                  echo __('jetzt');
                } else {
                  echo 'vor ' . round($diff / 60, 0) . ' Min.';
                }
              } elseif ($diff < 84000) {
                echo 'vor ' . round($diff / 3600, 0) . ' Std.';
              } else {
                echo 'vor ' . round($diff / 8400, 0) . ' Tagen';
              }
            ?>
          </span> 
          <?php echo $this->element('feedlike', array(
          'feed' => array('Feed' => $comment, 'Like' => $comment['Like'])));  ?>
        <a class="pull-left" href="javascript:tippspiel_admin.showcommentbox({feed:'<?php echo $feed['Feed']['id'] ?>', target:'<?php echo $id; ?>'});"> <?php echo __('comment it') ?></a>
        </div> <!-- /.feed-actions -->
      </div> <!-- /.feed-item -->
    <?php } ?>
  </div> <!-- /.feed-item -->