<?php 
  if (isset($feeds['paging'])) {
    $paging = $feeds['paging'];
    unset($feeds['paging']);
  } else {
    $paging = false;
  }

?>
<div id="feedStream">
<div id="shoutbox" class="share-widget clearfix">
  <div class="row">
    <div class="col-md-9">
      <?php 
        echo $this->Form->create('Feed', array(
          'action' => 'add',
          'id' => 'FeedAddForm'
        )); 
        echo $this->Form->textarea('text', array(
            'id' => 'shouttext',
            'rows' => 1,
            'label' => false,
            'class' => 'form-control',
            'div' => false,
            'placeholder' => __("Share what you've been up to...")
          ));
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

<?php foreach ($feeds as $key => $feed) {  ?>
  <div class="feed-item" id="feed-<?php echo $feed['Feed']['id'] ?>">
    <div class="feed-content">
      <ul class="icons-list">
        <li><a href="javascript:;"><?php echo $feed['User']['username'] ?></a> &nbsp;
          <?php if ($feed['Feed']['message_id'] != '') {
            echo __('has commented message') . substr($feed['Message']['title'], 0, 20) . '...' ;
          }
          ?>
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
            print_r($diff);
            if ($diff < 3600) {
              echo 'vor ' . round($diff / 60, 0) . ' Min.';
            } elseif ($diff < 84000) {
              echo 'vor ' . round($diff / 3600, 0) . ' Std.';
            } else {
              echo 'vor ' . round($diff / 84000, 0) . ' Tagen';
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
        'action' => 'add'
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
</div>


<script type="text/javascript">
$("#FeedAddForm").submit(function(e) {
    var postData = $(this).serializeArray();
    var formURL = $(this).attr("action");
      console.log($('#shouttext').val());
    if ( $('#shouttext').val() != '' ) {    
      $.ajax({
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) {
          $( "#shoutbox" ).after( data );
          $('#shouttext').val('')
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
