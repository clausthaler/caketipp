<div id="tippsoverview">
        <?php
          //calculate match table headers first
          $mth1 = '';
          $mth2 = '';
          $mth3 = '';
          $extratime = array('', __('et'), __('pen'));
          foreach ($matches as $key => $match) {
            if ($match['Match']['kickoff'] < strtotime($this->Session->read('currentdatetime')) && $match['Match']['isfinished'] != 1) {
              $style = ';color:red';
            } else {
              $style = '';
            }
            $mth1 = $mth1 . '<th style="text-align:center">' . $teams[$match['Match']['team1_id']]['iso'] . '</th>';
            $mth2 = $mth2 . '<th style="text-align:center' . $style  . '">' . $match['Match']['points_team1'] . ':' . $match['Match']['points_team2'] . ' ' . $extratime[$match['Match']['extratime']] . '</th>';
            $mth3 = $mth3 . '<th style="text-align:center">' . $teams[$match['Match']['team2_id']]['iso'] . '</th>';
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
            $lasttotal = 0;
            foreach ($users as $userkey => $user) {
              if ($pos > 14) {
                $addclass = ' rankingextrarow' ;
              } else {
                $addclass = '';
              }
              if ($user['username'] == $this->Session->read('Auth.User.username')) {
                echo '<tr style="background-color:lightgreen" class="' . $addclass . '">';
              } else {
                echo '<tr class="' . $addclass . '">';
              }
  
              if ($user['roundtotal'] != $lasttotal) {
                echo '<td>' . $pos . '</td>';
              } else {
                echo '<td>&nbsp;</td>';
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
              $lasttotal = $user['roundtotal'];
              $pos++;
            }
          echo '</table>';
          ?>
</div>
          <a href="javascript:tippspiel_admin.toggleextrarows(this)" class="btn btn-xs btn-info rankingextrarow" style="display:initial"><?php echo __('Show all') ?></a>
          <a href="javascript:tippspiel_admin.toggleextrarows(this)" class="btn btn-xs btn-info rankingextrarow" style="display:none"><?php echo __('Show less') ?></a>
