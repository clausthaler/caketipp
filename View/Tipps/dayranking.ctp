<div id="tippsoverview">
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="portlet portlet-boxed">
          <div class="portlet-body class="table-responsive"">
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
              </div>
              <br><br>
            </section> <!-- /.demo-section -->
    
            <section style="overflow:scroll;">
        <?php
          //calculate match table headers first
          $mth1 = '';
          $mth2 = '';
          $mth3 = '';
          $extratime = array('', __('et'), __('pen'));
          foreach ($matches as $key => $match) {
            if ($match['Match']['kickoff'] < strtotime($this->Session->read('currentdatetime')) && $match['Match']['isfinished'] != 1) {
              $style = ';background-color:lightyellow;color:red';
            } else {
              $style = '';
            }
            $mth1 = $mth1 . '<th style="text-align:center' . $style  . '">' . $teams[$match['Match']['team1_id']]['iso'] . '</th>';
            $mth2 = $mth2 . '<th style="text-align:center' . $style  . '">' . $match['Match']['points_team1'] . ':' . $match['Match']['points_team2'] . ' ' . $extratime[$match['Match']['extratime']] . '</th>';
            $mth3 = $mth3 . '<th style="text-align:center' . $style  . '">' . $teams[$match['Match']['team2_id']]['iso'] . '</th>';
            # code...
          }
          echo '<table class="table table-condensed" cellpadding="0" cellspacing="0">';
            echo '<tr>';
              echo '<th rowspan="3" style="vertical-align:bottom">' . __('Pos') . '</th>';
              echo '<th rowspan="3">&nbsp;</th>';
              echo '<th rowspan="3" style="vertical-align:bottom">' . __('Name') . '</th>';
              echo $mth1;
              echo '<th rowspan="3" style="vertical-align:bottom;text-align: center;">' . __('Points') . '</th>';
            echo '</tr>';
            echo '<tr>' . $mth2 . '</tr>';
            echo '<tr>' . $mth3 . '</tr>';

            $pos = 1;
            $lastsum = 0;
            foreach ($userlist as $c => $listuser) {
              $user = $users[$listuser['c']['id']];
              if ($user['username'] == $this->Session->read('Auth.User.username')) {
                echo '<tr style="background-color:lightgreen" >';
              } else {
                echo '<tr>';
              }
              if ($listuser['c']['sum'] == $lastsum) {
                echo '<td>&nbsp;</td>';
              } else {
                echo '<td>' . $position . '</td>';
              }
              echo '<td>'; 
              if (!empty($user['photo'])) {
                echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $user['photo_dir'] .  DS . 'small_' . $user['photo'], array('style' => 'max-width:30px; max-height:30px;'));
              }
              echo '</td>'; 
              echo '<td>' . $user['username'] . '</td>';
              foreach ($matches as $matchkey => $match) {
                // only show tipps when tipp due is over or current user
                if ($match['Match']['due'] < strtotime($this->Session->read('currentdatetime')) || $user['username'] == $this->Session->read('Auth.User.username')) {
                  // show if exists tipp
                  if ($match['Match']['kickoff'] < strtotime($this->Session->read('currentdatetime')) && $match['Match']['isfinished'] != 1) {
                    $style = ';background-color:lightyellow;color:red';
                  } else {
                    $style = '';
                  }
                  if (isset($user['Tipps'][$match['Match']['id']])) {
                    echo '<td style="text-align: center;' . $style . '">';
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
                    echo '<td style="text-align:center' . $style . '">&nbsp;</td>'; 
                  }
                  # code...
                } else {
                  echo '<td style="text-align:center"> - </td>'; 
                }
              }              
  
              echo '<td style="text-align: center;">' . $listuser['c']['sum'] . '</td>';
              echo '</tr>';
              $lastsum = $listuser['c']['sum'];
              $pos++;
            }
          echo '</table>';
          ?>
            </section> <!-- /.demo-section -->
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </div> <!-- .content -->
</div>
