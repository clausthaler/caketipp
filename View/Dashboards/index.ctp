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
    <div class="layout layout-main-right layout-stack-sm">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "dashboard")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div class="row">
          <div class="col-md-6">
            <div class="portlet">
              <div class="portlet-title">
                <h4><?php echo __('Ranking'); ?> </h4>
              </div>
              <div class="portlet-body">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Pos'); ?></th>
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
                        echo '<tr style="background-color:lightgreen">';
                        if ($tipper['sum'] == $lastsum) {
                          echo '<td>&nbsp;</td>';
                        } else {
                          echo '<td>' . $count . '</td>';
                        }
                        echo '<td>' . $tipper['username'] . '</td>';
                        echo '<td>' . $tipper['sum'] . '</td>';
                        echo '</tr>';
                      } else {
                        if ($count < 9 || ($count == 9 || $count == 10) && $found ) {
                          echo '<tr>';
                          if ($tipper['sum'] == $lastsum) {
                            echo '<td>&nbsp;</td>';
                          } else {
                            echo '<td>' . $count . '</td>';
                          }
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
              </div>
            </div>
          </div>
          <div class="col-md-6">
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
                      <th><?php echo __('Groupe'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $matches = $this->requestAction('matches/nextmatches' ); ?>
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
                          echo $this->Html->image($match['Team1']['iconurl']);
                        }
                        echo "&nbsp;";
                        echo $match['Team1']['name']; 
                      ?>
                      </td>
                      <td>:</td>
                      <td>
                      <?php 
                        if (!empty($match['Team2']['iconurl'])) {
                          echo $this->Html->image($match['Team2']['iconurl']);
                        }
                        echo "&nbsp;";
                        echo $match['Team2']['name']; 
                      ?>
                      </td>
                      <td>
                      <?php echo $match['Group']['shortname']; ?>
                      </td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->