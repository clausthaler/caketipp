<div class="col-md-3 col-sm-4 layout-sidebar">
  <div class="nav-layout-sidebar-skip">
    <strong>Tab Navigation</strong> / <a href="#settings-content">Skip to Content</a>   
  </div>

  <ul class="nav nav-layout-sidebar nav-stacked">
    <?php if (Configure::read('mode') == 1) { ?>
    <li>
      <a href="/">
      <i class="fa fa-clock-o"></i> 
      Testzeit:&nbsp;&nbsp;<?php echo $this->Session->read('currentdatetime'); ?>
      </a>
    </li>
    <?php } ?>
    <li <?php if ($active == 'dashboard') { echo ' class="active" '; } ?>>
      <a href="/">
      <i class="fa fa-dashboard"></i> 
      &nbsp;&nbsp;<?php echo __('Dashboard');?>
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
    <li <?php if ($active == 'tippoverview') { echo ' class="active" '; } ?>>
      <a href="/tipps/overview">
      <i class="fa fa-dashboard"></i> 
      &nbsp;&nbsp;<?php echo __('Tipp overview');?>
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
    <li <?php if ($active == 'profile') { echo ' class="active" '; } ?>>
      <a href="/profile">
      <i class="fa fa-user"></i> 
      &nbsp;&nbsp;<?php echo __('Profile');?>
      </a>
    </li>
  </ul>
  <?php if ($this->Session->read('Auth.User.role') == 'admin') { ?>
  <ul class="nav nav-layout-sidebar nav-stacked">
    <li <?php if ($active == 'users') { echo ' class="active" '; } ?>>
      <a href="/admin/users">
      <i class="fa fa-user"></i> 
      &nbsp;&nbsp;<?php echo __('Users');?>
      </a>
    </li>
    <li <?php if ($active == 'groups') { echo ' class="active" '; } ?>>
      <a href="/admin/groups">
      <i class="fa fa-lock"></i> 
      &nbsp;&nbsp;<?php echo __('Groups');?>
      </a>
    </li>
    <li <?php if ($active == 'rounds') { echo ' class="active" '; } ?>>
      <a href="/admin/rounds">
      <i class="fa fa-bullhorn"></i> 
      &nbsp;&nbsp;<?php echo __('Rounds');?>
      </a>
    </li>
    <li <?php if ($active == 'matches') { echo ' class="active" '; } ?>>
      <a href="/admin/matches">
      <i class="fa fa-dollar"></i> 
      &nbsp;&nbsp;<?php echo __('Matches');?>
      </a>
    </li>
    <li <?php if ($active == 'questions') { echo ' class="active" '; } ?>>
      <a href="/admin/questions">
      <i class="fa fa-question"></i> 
      &nbsp;&nbsp;<?php echo __('Questions');?>
      </a>
    </li>
  </ul>
  <?php } ?>
</div> <!-- /.col -->