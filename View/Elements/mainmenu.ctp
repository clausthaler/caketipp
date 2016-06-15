    <div class="container">

      <a class="mainnav-toggle" data-toggle="collapse" data-target=".mainnav-collapse">
        <span class="sr-only">Toggle navigation</span>
        <i class="fa fa-bars"></i>
      </a>

      <nav class="collapse mainnav-collapse" role="navigation">

        <ul class="mainnav-menu">
          <li class="">
            <a href="/home">Home</a>
          </li>

          <li class="dropdown">
            <a href="./index.html" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
              <?php echo __('Enter Tipps');?>
              <i class="mainnav-caret"></i>
            </a>

            <ul class="dropdown-menu" role="menu">
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
              <li <?php if ($active == 'tipptables') { echo ' class="active" '; } ?>>
                <a href="/tipptables">
                <i class="fa fa-table"></i> 
                &nbsp;&nbsp;<?php echo __('Tipp tables');?>
                </a>
              </li>
              <li <?php if ($active == 'schedule') { echo ' class="active" '; } ?>>
                <a href="/schedule">
                <i class="fa fa-table"></i> 
                &nbsp;&nbsp;<?php echo __('Schedule');?>
                </a>
              </li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="./index.html" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
              <?php echo __('Results');?>
              <i class="mainnav-caret"></i>
            </a>

            <ul class="dropdown-menu" role="menu">
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
              <li <?php if ($active == 'grouptables') { echo ' class="active" '; } ?>>
                <a href="/grouptables">
                <i class="fa fa-table"></i> 
                &nbsp;&nbsp;<?php echo __('Group tables');?>
                </a>
              </li>
            </ul>
          </li>

          <?php if ($this->Session->read('Auth.User.role') == 'admin') { ?>

          <li class="dropdown">
            <a href="./index.html" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
              Admin
              <i class="mainnav-caret"></i>
            </a>

            <ul class="dropdown-menu" role="menu">
              <li <?php if ($active == 'matches') { echo ' class="active" '; } ?>>
                <a href="/admin/matches">
                <i class="fa fa-dollar"></i> 
                &nbsp;&nbsp;<?php echo __('Matches');?>
                </a>
              </li>
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
              <li <?php if ($active == 'questions') { echo ' class="active" '; } ?>>
                <a href="/admin/questions">
                <i class="fa fa-question"></i> 
                &nbsp;&nbsp;<?php echo __('Questions');?>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>


        </ul>

      </nav>

    </div>
