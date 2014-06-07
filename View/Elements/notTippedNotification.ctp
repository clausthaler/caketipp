<?php 
if (!isset($matchesNotTipped)) {
  $matchesNotTipped = array();
} 
if (!isset($questionsNotTipped)) {
  $questionsNotTipped = array();
} 
$count = 0;
if (count($matchesNotTipped) > 0) {
  $count = count($matchesNotTipped);
}
if (count($questionsNotTipped) > 0) {
  $count = $count + count($questionsNotTipped);
}
print_r($count);
?> 
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell"></i>
    <span class="navbar-visible-collapsed">&nbsp;<?php echo __('Notifications'); ?>&nbsp;</span>
    <?php if ($count > 0) { ?>
      <span class="badge badge-primary"><?php echo $count ?></span>
    <?php } ?>
  </a>
  <?php if ($count > 0) { ?>
    <ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">
    <?php if (count($matchesNotTipped) > 0) { ?>
              <li class="nav-header">
                <div class="pull-left">
                  Notifications
                </div>

                <div class="pull-right">
                  <a href="javascript:;">Mark as Read</a>
                </div>
              </li>
      <li>
        <a href="/entertipps" class="noticebar-item">
          <span class="noticebar-item-image">
            <i class="fa fa-bullseye text-success"></i>
          </span>
          <span class="noticebar-item-body">
            <strong class="noticebar-item-title"><?php echo __('Missing tipps') ?></strong>
            <span class="noticebar-item-text"><?php echo __("There are %s matches within the next 7 days that you haven't tipped yet. You better do now.", count($matchesNotTipped)) ?></span>
          </span>
        </a>
      </li>
    <?php } ?>
    <?php if (count($questionsNotTipped) > 0) { ?>
      <li>
        <a href="/enterbonus" class="noticebar-item">
          <span class="noticebar-item-image">
            <i class="fa fa-bullseye text-success"></i>
          </span>
          <span class="noticebar-item-body">
            <strong class="noticebar-item-title"><?php echo __('Missing bonus tipps') ?></strong>
            <span class="noticebar-item-text"><?php echo __("There are %s questions within the next 7 days that you haven't tipped yet. You better do now.", count($questionsNotTipped)) ?></span>
          </span>
        </a>
      </li>
    <?php } ?>
    </ul>
  <?php } ?>

</li>