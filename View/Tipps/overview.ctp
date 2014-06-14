<div id="tippsoverview">
  <div class="mainnav">
    <?php 
      echo $this->Session->flash('flash', array('element' => 'message'));
      echo $this->Session->flash('auth', array('element' => 'message'));
    ?>
  </div> <!-- /.mainnav -->
  <div class="content">
    <div class="container">
      <div class="layout layout-main-right layout-stack-sm">
      <!-- start: Main Menu -->
      <?php echo $this->element('menu', array("active" => "tippoverview")); ?>
      <!-- end: Main Menu -->
        <div class="col-md-9 col-sm-8 layout-main">
        <section>
          <div class="row">
            <div class="col-xs-3">
              <label><?php echo __('View'); ?></label>
              <?php echo $this->Form->select('RoundSelect', $roundsselarr, 
                array(
                  'class' => 'form-control',
                  'empty' => false,
                  'onchange' => 'tippspiel_admin.refreshTippsOverview("round")',
                  'value' => $roundselected)); 
              ?>
            </div>
            <div class="col-xs-3">
            <label><?php echo __('Match from'); ?></label>
            <?php echo $this->Form->select('MatchFrom', $fromtomatches, 
              array(
                'class' => 'form-control',
                'onchange' => 'tippspiel_admin.refreshTippsOverview("from")',
                'value' => $frommatch)); 
            ?>
            </div>
            <div class="col-xs-3">
            <label><?php echo __('to'); ?></label>
            <?php echo $this->Form->select('MatchTo', $fromtomatches, 
              array(
                'class' => 'form-control',
                'onchange' => 'tippspiel_admin.refreshTippsOverview("to")',
                'value' => $tomatch)); 
            ?>
            </div>
          </div>
          <br><br>
          <!-- start: Content -->
          <?php
            echo '<h4>' . $rounds[$tipproundid]['name']  . '</h4>';
            echo '<table class="table table-condensed" cellpadding="0" cellspacing="0">';
            echo '<tr>';
            echo '<th>' . __('Date') . '</th>';
            echo '<th>' . __('Team 1') . '</th>';
            echo '<th>-</th>';
            echo '<th>' . __('Team 2') . '</th>';
            if ($rounds[$tipproundid]['name'] == 'Vorrunde') {
              echo '<th style="text-align: center;">' . __('Group') . '</th>';
            }
            echo '<th style="text-align: center;">' . __('Result') . '</th>';
            echo '</tr>';
            // list all matches for this round with result
            foreach ($matches as $key => $match) {
              echo '<tr>';
              echo '<td>';
              echo __(date("D", $match['Match']['kickoff'])) . ', ';
              echo date("d.m", $match['Match']['kickoff']); 
              echo '&nbsp;<small>' . date("H:i", $match['Match']['kickoff']) . ' </small>'; 
              echo '</td>';
              echo '<td>';
              if (!empty($teams[$match['Match']['team1_id']]['iconurl'])) {
                echo $this->Html->image($teams[$match['Match']['team1_id']]['iconurl']) . '&nbsp;';
              }
              echo $teams[$match['Match']['team1_id']]['name'];
              echo '</td>';
              echo '<td>-</td>';
              echo '<td>';
              if (!empty($teams[$match['Match']['team2_id']]['iconurl'])) {
                echo $this->Html->image($teams[$match['Match']['team2_id']]['iconurl']) . '&nbsp;';
              }
              echo $teams[$match['Match']['team2_id']]['name'];
              echo '</td>';
              if (isset($groups[$match['Match']['group_id']]['shortname'])) {
                echo '<td style="text-align: center;">';
                echo $groups[$match['Match']['group_id']]['shortname'];
                echo '</td>';
              }
              if ($match['Match']['kickoff'] < time() && $match['Match']['isfinished'] != 1) {
                echo '<td style="text-align:center;color:red;">';
              } else {
                echo '<td style="text-align: center;">';
              }
              echo  $match['Match']['points_team1'] . ':' . $match['Match']['points_team2'];
              if ($match['Match']['extratime'] != 0) {
                if ($match['Match']['extratime'] == 1) {
                  echo '&nbsp;' . __('o t');
                }
                if ($match['Match']['extratime'] == 2) {
                  echo '&nbsp;' . __('pen');
                }
              }
              echo '</td>';
              echo '</tr>';
  
            }
            echo "</table>";
            ?>
        </section> <!-- /.demo-section -->
        <section>
        <?php
          //calculate match table headers first
          $mth1 = '';
          $mth2 = '';
          $mth3 = '';
          $extratime = array('', __('et'), __('pen'));
          foreach ($matches as $key => $match) {
            if ($match['Match']['kickoff'] < time() && $match['Match']['isfinished'] != 1) {
              $style = ';color:red';
            } else {
              $style = '';
            }
            $mth1 = $mth1 . '<th style="text-align:center">' . $teams[$match['Match']['team1_id']]['iso'] . '</th>';
            $mth2 = $mth2 . '<th style="text-align:center' . $style  . '">' . $match['Match']['points_team1'] . ':' . $match['Match']['points_team2'] . ' ' . $extratime[$match['Match']['extratime']] . '</th>';
            $mth3 = $mth3 . '<th style="text-align:center">' . $teams[$match['Match']['team2_id']]['iso'] . '</th>';
            # code...
          }
          echo '<h4>' . __('Tipps')  . '</h4>';
          echo '<table class="table table-condensed" cellpadding="0" cellspacing="0">';
            echo '<tr>';
              echo '<th rowspan="3" style="vertical-align:bottom">' . __('Pos') . '</th>';
              echo '<th rowspan="3" style="vertical-align:bottom">' . __('Name') . '</th>';
              echo $mth1;
              echo '<th rowspan="3" style="vertical-align:bottom;text-align: center;">' . __('Points') . '</th>';
              echo '<th rowspan="3" style="vertical-align:bottom;text-align: center;"><i class="fa fa-ban"></i></th>';
            echo '</tr>';
            echo '<tr>' . $mth2 . '</tr>';
            echo '<tr>' . $mth3 . '</tr>';
            $pos = 1;
            $lasttotal = 0;
            foreach ($users as $userkey => $user) {
              if ($user['username'] == $this->Session->read('Auth.User.username')) {
                echo '<tr style="background-color:lightgreen">';
              } else {
                echo '<tr>';
              }
  
              if ($user['roundtotal'] != $lasttotal) {
                echo '<td>' . $pos . '</td>';
              } else {
                echo '<td>&nbsp;</td>';
              }
              echo '<td>' . $user['username'] . '</td>';
              foreach ($matches as $matchkey => $match) {
                // only show tipps when tipp due is over
                if ($match['Match']['due'] < time()) {
                  // show if exists tipp
                  if (isset($user['Tipps'][$match['Match']['id']])) {
                    echo '<td style="text-align: center;">';
                    echo $user['Tipps'][$match['Match']['id']]['points_team1'] 
                    . ':' 
                    . $user['Tipps'][$match['Match']['id']]['points_team2'];
                    if ($user['Tipps'][$match['Match']['id']]['points'] > 0) {
                      echo '<sub style="color:red;font-weight:bold">'
                      . $user['Tipps'][$match['Match']['id']]['points']
                      . '</sub>';
                    echo '</td>';
                    }
                  } else {
                    echo '<td style="text-align:center">&nbsp;</td>'; 
                  }
                  # code...
                } else {
                  echo '<td style="text-align:center"> - </td>'; 
                }
              }              
  
              echo '<td style="text-align: center;">' . $user['roundtotal'] . '</td>';
              echo '<td style="text-align: center;">' . round($user['roundtotal'] / count($matches), 2) . '</td>';
              $lasttotal = $user['roundtotal'];
              $pos++;
            }
          echo '</table>';
          ?>
  
        </section> <!-- /.demo-section -->
  
        </div> <!-- /.col -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </div> <!-- .content -->
</div>
