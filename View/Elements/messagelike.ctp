<?php 
$likers = Hash::extract( $message['Like'], '{n}.user_id');
if (array_search($this->Session->read('Auth.User.id'), $likers) !== false) {
  $liker = true;
} else {
  $liker = false;
}
?>
<span id="messagelike-<?php echo $message['Message']['id'] ?>">
  <span class="pull-left"><i class="fa fa-thumbs-up"></i> <?php echo count($message['Like']) ?> </span>
  <a class="pull-left" href="javascript:tippspiel_admin.toggleMessagelike(<?php echo $message['Message']['id'] ?>);"> 
  <?php 
    if ($liker) {
      echo __("don't like");
    } else {
      echo __("like it") ;     
    }
  ?>
  </a> 
</span>
