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
?> 

<li class="dropdown navbar-notification">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bell navbar-notification-icon"></i>
    <span class="visible-xs-inline">&nbsp;<?php // echo __('Notifications'); ?>&nbsp;</span>
    <?php if ($count > 0) { ?>
      <b class="badge badge-primary"><?php echo $count ?></b>
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
            <span class="noticebar-item-text"><?php echo __("There are %s matches within the next days that you haven't tipped yet. You better do now.", count($matchesNotTipped)) ?></span>
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
            <span class="noticebar-item-text"><?php echo __("There are %s bonus questions that you haven't tipped yet. What are you waiting for?", count($questionsNotTipped)) ?></span>
          </span>
        </a>
      </li>
    <?php } ?>
    </ul>
  <?php } ?>

</li>