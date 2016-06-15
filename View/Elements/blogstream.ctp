<?php 
  if (isset($feeds['paging'])) {
    $paging = $feeds['paging'];
    unset($feeds['paging']);
  } else {
    $paging = false;
  }
?>

<?php foreach ($feeds as $key => $feed) {  ?>
  <div class="feed-item" id="feed-<?php echo $feed['Feed']['id'] ?>">


    <div class="feed-icon bg-tertiary userinfo-modal" data-user="<?php echo $feed['User']['username']?>">
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
      <p><a href="javascript:;"  class="userinfo-modal" data-user="<?php echo $feed['User']['username']?>"><?php echo $feed['User']['username'] ?></a></p>
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
          <p><a href="javascript:;"  class="userinfo-modal" data-user="<?php echo $comment['User']['username']?>"><?php echo $comment['User']['username'] ?></a></p>
        </div> <!-- /.feed-subject -->

        <div class="feed-content">
          <?=h($comment['text']); ?> 
        </div> <!-- /.feed-content -->

      </div> <!-- /.feed-item -->
    <?php } ?>
    <p id="<?php echo $id?>" style='margin-bottom:0'>
      <a href="javascript:tippspiel_admin.showblogcommentbox({feed:'<?php echo $feed['Feed']['id'] ?>', target: '<?php echo $id?>'});"> <?php echo __('comment it') ?></a>
    </p>
  </div> <!-- /.feed-item -->
<?php } ?>

<?php
  $params = $this->Paginator->params();
  if ($paging) {
?>
  <div class="pagination pagination-centered">
      <ul class="pagination">
      <?php
        if ( $paging['Feed']['prevPage'] == 1) {
          echo '<li class="prev"><a rel="prev" onclick="tippspiel_admin.loadStreamPage(' . ($paging['Feed']['page'] - 1) . ');">Vorherige</a></li>';
        } else {
          echo '<li class="prev disabled"><a onclick="return false;">Vorherige</a></li>';
        }
        if ( $paging['Feed']['nextPage'] == 1) {
          echo '<li class="next"><a rel="next" onclick="tippspiel_admin.loadStreamPage(' . ($paging['Feed']['page'] + 1) . ');" >Nächste</a></li>';
        } else {
          echo '<li class="next disabled"><a onclick="return false;">Nächste</a></li>';
        }
        ?>

      </ul>
  </div>
<?php } ?>

<div id="shoutboxholder" style="display: none;">
  <div class="row shoutboxtemplate">
    <?php 
      echo $this->Form->create('Feed', array(
        'action' => 'blogadd'
      )); 
    ?>
    <div class="col-md-9">
    <?php 
        echo $this->Form->textarea('text', array(
            'rows' => 1,
            'label' => false,
            'class' => 'form-control shouttext',
            'div' => false,
            'placeholder' => __("Share what you've been up to...")
          ));
        echo $this->Form->input('parent_id', array(
          'type' => 'text',
          'class' => 'ModalFeedId',
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
        'class' => 'btn btn-primary btn-sm'
        )); 
    ?>
    </div>
    <?php echo $this->Form->end();  ?>
  </div>
</div>