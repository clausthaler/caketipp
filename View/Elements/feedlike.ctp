<?php 
$likers = Hash::extract( $feed['Like'], '{n}.user_id');
if (array_search($this->Session->read('Auth.User.id'), $likers) !== false) {
  $liker = true;
} else {
  $liker = false;
}
?>
<span id="commentlike-<?php echo $feed['Feed']['id'] ?>">
  <?php if ($liker) { ?>
    <span class="pull-left"><i class="fa fa-thumbs-up"></i> <?php echo count($feed['Like']) ?> </span>
  <?php } else { ?>
    <a class="pull-left" href="javascript:tippspiel_admin.togglelike(<?php echo $feed['Feed']['id'] ?>);"> <i class="fa fa-thumbs-up"></i></a> 
  <?php } ?>
</span>


