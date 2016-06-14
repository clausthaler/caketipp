      <div class="col-md-4">      
        <div class="portlet portlet-boxed">
          <div class="portlet-header">
            <h4 class="portlet-title"><?php echo __('Last 10 Top Tipps'); ?> </h4>
          </div>
          <div class="portlet-body">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>&nbsp;</th>
                  <th><?php echo __('Name'); ?></th>
                  <th><?php echo __('Game'); ?></th>
                  <th><?php echo __('Result'); ?></th>
                  <th><?php echo __('Tipp'); ?></th>
                </tr>
              </thead>
              <tbody>
              <?php
              $toptipps = $this->requestAction('toptipps' );
              foreach ($toptipps as $tipp) {
                if ($tipp['User']['username'] == $this->Session->read('Auth.User.id')) {
                  echo '<tr style="background-color:lightgreen" class="userinfo-modal" data-user="' . $tipp['User']['username'] . '">';
                } else {
                  echo '<tr class="userinfo-modal" data-user="' . $tipp['User']['username'] . '">';
                }
                echo '<td style="width:30px">';
                if (!empty($tipp['User']['photo'])) {
                  echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $tipp['User']['photo_dir'] .  DS . 'small_' . $tipp['User']['photo'], array('style' => 'max-width:30px; max-height:30px;'));
                } else {
                  echo '&nbsp;';
                }
                echo '</td>';
                echo '<td>' . $tipp['User']['username'] . '</td>';
                echo '<td>' . $tipp['Match']['name'] . '</td>';
                echo '<td>' . $tipp['Match']['points_team1'] . ':'.  $tipp['Match']['points_team2'] . '</td>';
                echo '<td>' . $tipp['Tipp']['points_team1'] . ':'. $tipp['Match']['points_team2'] . '</td>';
//                echo '<td>' . $tipp['Tipp']['points'] . '</td>';
                echo '</tr>';
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
