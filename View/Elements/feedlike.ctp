<?php 
$likers = Hash::extract( $feed['Like'], '{n}.user_id');
if (array_search($this->Session->read('Auth.User.id'), $likers) !== false) {
  $liker = true;
} else {
  $liker = false;
}
if ($liker) { ?>
<span class="pull-left"><i class="fa fa-thumbs-up"></i> <?php echo count($feed['Like']) ?> </span>
<?php } else { ?>
<a href="javascript:tippspiel_admin.togglelike(<?php echo $feed['Feed']['id'] ?>);" class="pull-left"><i class="fa fa-thumbs-up"></i> <?php echo count($feed['Like']) ?></a>
<?php } ?>