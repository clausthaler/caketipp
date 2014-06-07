<?php 
if (!isset($active)) {
    $active = false;
} ?>
<div id="sidebar-left" class="col-sm-1">
    <div class="nav-collapse sidebar-nav collapse navbar-collapse bs-navbar-collapse">
        <ul class="nav nav-tabs nav-stacked main-menu">
            <li <?php if ($active == 'dashbords') { echo ' class="active" '; } ?> ><a href="/dashboard"><i class="fa fa-bar-chart-o"></i><span class="hidden-sm"> Dashboard</span></a>
            </li>
            <?php if ($this->Session->read('Auth.User.role') == 'admin') { ?>
            <li <?php if ($active == 'users') { echo ' class="active" '; } ?> ><a href="/admin/users"><span class="hidden-sm"> <?php echo __('Users');?></span></a>
            </li>
            <li <?php if ($active == 'groups') { echo ' class="active" '; } ?> ><a href="/admin/groups"><span class="hidden-sm"> <?php echo __('Groups');?></span></a>
            </li>
            <li <?php if ($active == 'rounds') { echo ' class="active" '; } ?> ><a href="/admin/rounds"><span class="hidden-sm"> <?php echo __('Rounds');?></span></a>
            </li>
            <li <?php if ($active == 'matches') { echo ' class="active" '; } ?> ><a href="/admin/matches"><span class="hidden-sm"> <?php echo __('Matches');?></span></a>
            </li>

            <li><a href="/logout"><i class="fa fa-lock"></i><span class="hidden-sm"> <?php echo __('Logout');?></span></a>
            </li>
                
            <?php } ?>
        </ul>
    </div>
</div>
<a id="main-menu-toggle" class="hidden-xs open"><i class="fa fa-bars"></i></a>
