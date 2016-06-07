<div class="container">
  <div class="row">
    <div class="col-sm-7 col-md-8">
      <div class="row">
        <div class="col-md-6">
          <div class="portlet portlet-boxed">
            <!-- start: Main Menu -->
            <?php echo $this->element('menu', array("active" => "dashboard")); ?>
            <!-- end: Main Menu -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col-md-6 -->
        <div class="col-md-6">
          <div class="portlet portlet-boxed">
            <div class="portlet-header">
              <h4 class="portlet-title">
                <?php echo __('Ranking'); ?>
              </h4>
            </div> <!-- /.portlet-header -->
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
                <a href="/ranking" class="btn btn-xs btn-info"><?php echo __('Complete Ranking') ?></a>
            </div> <!-- /.portlet-body -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col-md-6 -->
      </div> <!-- /.row -->


      <div class="portlet portlet-boxed">
        <div class="portlet-header">
          <h4 class="portlet-title"><?php echo __('Next matches'); ?> </h4>
        </div>
        <div class="portlet-body">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th><?php echo __('Date'); ?></th>
                <th><?php echo __('Team 1'); ?></th>
                <th>&nbsp;</th>
                <th><?php echo __('Team 2'); ?></th>
              </tr>
            </thead>
            <tbody>
            <?php $matches = $this->requestAction('matches/nextmatches/7' ); ?>
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
              </tr>
            <?php } ?>
            </tbody>
          </table>
          <a href="/schedule" class="btn btn-xs btn-info"><?php echo __('Show schedule') ?></a>
        </div>
      </div>



    </div> <!-- /.col-sm-7 col-md-8 -->
    <div class="col-sm-5 col-md-4">
      <div class="portlet portlet-boxed">
      <?php 
        $feeds = $this->requestAction('feeds/stream' ); 
        echo $this->element('feedstream', array('feeds' => $feeds));
      ?>
      </div> <!-- /.portlet -->
    </div> <!-- /.col-sm-5 col-md-4 -->
  </div> <!-- /.row -->
</div> <!-- /.container -->