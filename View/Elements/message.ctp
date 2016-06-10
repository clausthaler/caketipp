<?php 
	if (!isset($class)) {
		$class = 'success';
	}
?>
<div class="content">
  <div class="alert alert-<?php echo $class?>">
    <a aria-hidden="true" href="#" data-dismiss="alert" class="close">×</a>
    <strong><?php echo h($message); ?></strong>
  </div>
</div>
