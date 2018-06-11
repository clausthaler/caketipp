<div class="mainnav">
  <!-- temporary maintnance warning 
  <div class="alert alert-warning">
    <strong>Im den nächsten Minuten kann es aufgrund von Wartungsarbeiten zu eingeschränkter Verfügbarkeit oder Fehlermeldungen auf der Seite kommen.</strong>
  </div>
   temporary maintnance warning -->
  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
</div> <!-- /.mainnav -->
<div class="content">
  <div class="container">
    <div class="row">
      <!-- start: Main Menu -->
      <?php echo $this->element('menu', array("active" => "dashboard")); ?>
      <!-- end: Main Menu -->
      <div class="col-md-6 col-sm-8 layout-main">
            <div class="portlet">
              <div class="portlet-title">
                <h4><?php echo __('Ranking'); ?> </h4>
              </div>
              <div class="portlet-body">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Pos'); ?></th>
                      <th>&nbsp;</th>
                      <th><?php echo __('Name'); ?></th>
                      <th><?php echo __('Points'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $tippers = $this->requestAction('ranking' );
                    $tippers = Hash::combine($tippers, '{n}.c.id', '{n}.c'); 
                    
                    $found = false;
                    $count = 1;
                    $lastsum = 0;
                    foreach ($tippers as $id => $tipper) {
                      if ($id == $this->Session->read('Auth.User.id')) {
                        $found = true;
                        echo '<tr style="background-color:lightgreen" class="userinfo-modal" data-user="' . $tipper['username'] . '">';
                        if ($tipper['sum'] == $lastsum) {
                          echo '<td><a data-toggle="modal" href="#userInfoModal">&nbsp;</a></td>';
                        } else {
                          echo '<td><a data-toggle="modal" href="#userInfoModal">' . $count . '</a></td>';
                        }
                        echo '<td style="width:30px">';
                        if (!empty($tipper['photo'])) {
                          echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $tipper['photo_dir'] .  DS . 'small_' . $tipper['photo'], array('style' => 'max-width:30px; max-height:30px;'));
                        } else {
                          echo '&nbsp;';
                        }
                        echo '</td>';
                        echo '<td>' . $tipper['username'] . '</td>';
                        echo '<td>' . $tipper['sum'] . '</td>';
                        echo '</tr>';
                      } else {
                        if ($count < 9 || ($count == 9 || $count == 10) && $found ) {
                          echo '<tr class="userinfo-modal" data-user="' . $tipper['username'] . '">';
                          if ($tipper['sum'] == $lastsum) {
                            echo '<td>&nbsp;</td>';
                          } else {
                            echo '<td>' . $count . '</td>';
                          }
                          echo '<td style="width:30px">';
                          if (!empty($tipper['photo'])) {
                            echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $tipper['photo_dir'] .  DS . 'small_' . $tipper['photo'], array('style' => 'max-width:30px; max-height:30px;'));
                          } else {
                            echo '&nbsp;';
                          }
                          echo '</td>';
                          echo '<td>' . $tipper['username'] . '</td>';
                          echo '<td>' . $tipper['sum'] . '</td>';
                          echo '</tr>';
                        } elseif ($count == 9 && !$found) {
                          echo '<tr>';
                          echo '<td colspan="3">&nbsp;...&nbsp;</td>';
                          echo '</tr>';
                          # code...
                        }
                      }
                      $lastsum = $tipper['sum'];
                      if ($found && $count > 10) {
                        break;
                      }
                      $count++;
                    } ?>
                  </tbody>
                </table>
                <a href="/ranking" class="btn btn-xs btn-info"><?php echo __('Complete Ranking') ?></a>
              </div>
            </div>
            <div class="portlet">
              <div class="portlet-title">
                <h4><?php echo __('Next matches'); ?> </h4>
              </div>
              <div class="portlet-body">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Date'); ?></th>
                      <th><?php echo __('Team 1'); ?></th>
                      <th>&nbsp;</th>
                      <th><?php echo __('Team 2'); ?></th>
                      <th style="text-align: center;">Tipp</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $nextmatches = $this->requestAction('matches/nextmatches/7');
                    $matches = $nextmatches['nextmatches'];
                    $tipps = Hash::combine($nextmatches['tipps'], '{n}.Tipp.match_id', '{n}.Tipp'); 
                  ?>
                  <?php foreach ($matches as $id => $match) { ?>
                    <tr>
                      <td>
                      <?php 
                        echo __(date("D", $match['Match']['kickoff'])) . ', ';
                        echo date("d.m", $match['Match']['kickoff']); 
                        echo '&nbsp;<small>' . date("H:i", $match['Match']['kickoff']) . ' </small>'; 
                      ?>
                      </td>
                      <td>
                      <?php 
                        if (!empty($match['Team1']['iconurl'])) {
                          echo $this->Html->image('flags/' . $match['Team1']['iconurl']);
                        }
                        echo "&nbsp;";
                        echo $match['Team1']['name']; 
                      ?>
                      </td>
                      <td>:</td>
                      <td>
                      <?php 
                        if (!empty($match['Team2']['iconurl'])) {
                          echo $this->Html->image('flags/' . $match['Team2']['iconurl']);
                        }
                        echo "&nbsp;";
                        echo $match['Team2']['name']; 
                      ?>
                      </td>
                      <td class="col-xs-3" style="text-align: center;">
                      <?php 
                      if (isset($tipps[$match['Match']['id']]['points_team1'])) { 
                        echo $tipps[$match['Match']['id']]['points_team1'] . ':' . $tipps[$match['Match']['id']]['points_team2'];
                      } else {
                        echo '<a href="/entertipps" class="btn btn-xs btn-info">' .  __('Tippenter') . '</a>';
                      }
                      ?>
                      </td>

                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
                <a href="/schedule" class="btn btn-xs btn-info"><?php echo __('Show schedule') ?></a>
              </div>
            </div>
      </div>
      <div class="col-md-3">
        <?php 
          $feeds = $this->requestAction('feeds/stream' ); 
          echo $this->element('feedstream', array('feeds' => $feeds));
        ?>
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->
<div id="userInfoModal" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
    </div> <!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>