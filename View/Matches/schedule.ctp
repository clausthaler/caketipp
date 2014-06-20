<div class="mainnav">
  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
</div> <!-- /.mainnav -->
<div class="content">
  <div class="container">
    <div class="row">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "schedule")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div id="settings-content" class="tab-content stacked-content">
          <div class="tab-pane fade in active" id="profile-tab">
            <h3 class="content-title"><u><?php echo __('Schedule'); ?></u></h3>

            <?php
             $teams = Hash::combine($teams, '{n}.Team.id', '{n}.Team'); 
             $rounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round'); 
             $groups = Hash::combine($groups, '{n}.Group.id', '{n}.Group'); 
             $matches = Hash::combine($matches, '{n}.Match.id', '{n}.Match', '{n}.Match.round_id');
            ?>           
            <!-- start: Content -->
            <?php 
            foreach ($matches as $key => $round) {
              echo '<h4>' . $rounds[$key]['name'] . '</h4>';
              echo '<table class="table table-condensed" cellpadding="0" cellspacing="0">';
              echo '<tr>';
              echo '<th>' . __('Date') . '</th>';
              echo '<th>' . __('Team 1') . '</th>';
              echo '<th>-</th>';
              echo '<th>' . __('Team 2') . '</th>';
              $curAr = current($round); 
              if (isset($groups[$curAr['group_id']]['shortname'])) {
                echo '<th style="text-align: center;">' . __('Group') . '</th>';
              }
              echo '<th style="text-align: center;">' . __('Result') . '</th>';
              echo '</tr>';
              foreach ($round as $key => $match) {
                  echo '<tr>';
                  echo '<td>';
                  echo __(date("D", $match['kickoff'])) . ', ';
                  echo date("d.m", $match['kickoff']); 
                  echo '&nbsp;<small>' . date("H:i", $match['kickoff']) . ' </small>'; 
                  echo '</td>';
                  echo '<td>';
                  if (!empty($teams[$match['team1_id']]['iconurl'])) {
                    echo $this->Html->image($teams[$match['team1_id']]['iconurl']) . '&nbsp;';
                  }
                  echo $teams[$match['team1_id']]['name'];
                  echo '</td>';
                  echo '<td>-</td>';
                  echo '<td>';
                  if (!empty($teams[$match['team2_id']]['iconurl'])) {
                    echo $this->Html->image($teams[$match['team2_id']]['iconurl']) . '&nbsp;';
                  }
                  echo $teams[$match['team2_id']]['name'];
                  echo '</td>';
                  if (isset($groups[$match['group_id']]['shortname'])) {
                    echo '<td style="text-align: center;">';
                    echo $groups[$match['group_id']]['shortname'];
                    echo '</td>';
                  }
                  echo '<td style="text-align: center;">';
                  echo  $match['points_team1'] . ':' . $match['points_team2'];
                  if ($match['extratime'] != 0) {
                    if ($match['extratime'] == 1) {
                      echo '&nbsp;' . __('o t');
                    }
                    if ($match['extratime'] == 2) {
                      echo '&nbsp;' . __('pen');
                    }
                  }
                  echo '</td>';
                  echo '</tr>';
                  # code...
                }
              echo "</table>";
              # code...
            }
            #print_r(Hash::sort($matches, '{n}.Match.round_id', 'asc'));
#            print_r($matches);

            ?>
             <!-- /.Content -->

          </div> <!-- /.tab-pane -->
        </div> <!-- /.tab-content -->
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->