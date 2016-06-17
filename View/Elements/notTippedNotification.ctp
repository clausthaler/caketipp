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
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell navbar-notification-icon"></i>
    <span class="visible-xs-inline">&nbsp;<?php // echo __('Notifications'); ?>&nbsp;</span>
    <?php if ($count > 0) { ?>
      <b class="badge badge-primary"><?php echo $count ?></b>
    <?php } ?>
  </a>
  <?php if ($count > 0) { ?>
    <div class="dropdown-menu">
      <div class="dropdown-header">&nbsp;Notifications</div>
      <div class="notification-list">
        <?php if (count($matchesNotTipped) > 0) { ?>
        <a href="/entertipps" class="notification">
          <span class="notification-icon"><i class="fa fa-cloud-upload text-primary"></i></span>
          <span class="notification-title"><?php echo __('Missing tipps') ?></span>
          <span class="notification-description"><?php echo __("There are %s matches within the next days that you haven't tipped yet. You better do now.", count($matchesNotTipped)) ?></span>
        </a> <!-- / .notification -->
        <?php } ?>
        <?php if (count($questionsNotTipped) > 0) { ?>
        <a href="/enterbonus" class="notification">
          <span class="notification-icon"><i class="fa fa-cloud-upload text-primary"></i></span>
          <span class="notification-title"><?php echo __('Missing bonus tipps') ?></span>
          <span class="notification-description"><?php echo __("There are %s bonus questions that you haven't tipped yet. What are you waiting for?", count($questionsNotTipped)) ?></span>
        </a> <!-- / .notification -->
        <?php } ?>
      </div> <!-- / .notification-list -->
    </div> <!-- / .dropdown-menu -->
  <?php } ?>
</li>