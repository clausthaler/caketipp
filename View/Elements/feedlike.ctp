<?php 
$likers = Hash::extract( $feed['Like'], '{n}.user_id');
if (array_search($this->Session->read('Auth.User.id'), $likers) !== false) {
  $liker = true;
} else {
  $liker = false;
}
?>
<span id="commentlike-<?php echo $feed['Feed']['id'] ?>">
  <span class="pull-left"><i class="fa fa-thumbs-up"></i> <?php echo count($feed['Like']) ?> </span>
  <a class="pull-left" href="javascript:tippspiel_admin.togglelike(<?php echo $feed['Feed']['id'] ?>);"> 
  <?php 
    if ($liker) {
      echo __("don't like");
    } else {
      echo __("like it") ;     
    }
  ?>
  </a> 
</span>
