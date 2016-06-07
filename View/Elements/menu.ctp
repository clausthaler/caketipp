<div class="portlet-header">
  <h4 class="portlet-title">
    <?php echo __('Ranking'); ?>
  </h4>
</div> <!-- /.portlet-header -->
<div class="portlet-body">
  <ul class="nav nav-layout-sidebar nav-stacked">
    <?php if (Configure::read('mode') == 1) { ?>
    <li>
      <a href="/">
      <i class="fa fa-clock-o"></i> 
      Testzeit:&nbsp;&nbsp;<?php echo $this->Session->read('currentdatetime'); ?>
      </a>
    </li>
    <?php } ?>
    <li <?php if ($active == 'rules') { echo ' class="active" '; } ?>>
      <a href="/rules">
      <i class="fa fa-bullhorn"></i> 
      &nbsp;&nbsp;<?php echo __('Rules');?>
      </a>
    </li>
    <li <?php if ($active == 'dashboard') { echo ' class="active" '; } ?>>
      <a href="/">
      <i class="fa fa-dashboard"></i> 
      &nbsp;&nbsp;<?php echo __('Dashboard');?>
      </a>
    </li>
    <li <?php if ($active == 'tippoverview') { echo ' class="active" '; } ?>>
      <a href="/tipps/ranking">
      <i class="fa fa-dashboard"></i> 
      &nbsp;&nbsp;<?php echo __('Tipp overview');?>
      </a>
    </li>
    <li <?php if ($active == 'statistics') { echo ' class="active" '; } ?>>
      <a href="/tipps/statistics">
      <i class="fa fa-dashboard"></i> 
      &nbsp;&nbsp;<?php echo __('Tipp statistics');?>
      </a>
    </li>
    <li <?php if ($active == 'blog') { echo ' class="active" '; } ?>>
      <a href="/blog">
      <i class="fa fa-book"></i> 
      &nbsp;&nbsp;<?php echo __('Blog');?>
      </a>
    </li>
    <li <?php if ($active == 'schedule') { echo ' class="active" '; } ?>>
      <a href="/schedule">
      <i class="fa fa-table"></i> 
      &nbsp;&nbsp;<?php echo __('Schedule');?>
      </a>
    </li>
    <li <?php if ($active == 'grouptables') { echo ' class="active" '; } ?>>
      <a href="/grouptables">
      <i class="fa fa-table"></i> 
      &nbsp;&nbsp;<?php echo __('Group tables');?>
      </a>
    </li>
    <li <?php if ($active == 'entertipps') { echo ' class="active" '; } ?>>
      <a href="/entertipps">
      <i class="fa fa-bullseye"></i> 
      &nbsp;&nbsp;<?php echo __('Tippenter');?>
      </a>
    </li>
    <li <?php if ($active == 'enterbonus') { echo ' class="active" '; } ?>>
      <a href="/enterbonus">
      <i class="fa fa-question"></i> 
      &nbsp;&nbsp;<?php echo __('Bonus questions');?>
      </a>
    </li>
  </ul>
</div> <!-- /.portlet-body -->