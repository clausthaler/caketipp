<div id="tippsoverview">
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="portlet portlet-boxed">
          <div class="portlet-body table-responsive">

            <div class="row">
            <div class="col-xs-5">
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
            <h4><?php echo __('Ranking'); ?> </h4>
            <table class="table table-condensed">
            <thead>
              <tr>
                <th><?php echo __('Pos'); ?></th>
                <th>&nbsp;</th>
                <th><?php echo __('Name'); ?></th>
                <?php 
                foreach ($rounds as $key => $round) {
                  echo '<th>' . __($round) . '</th>';
                }
                ?>
                <th><?php echo __('Points'); ?></th>
              </tr>
            </thead>
            <tbody>
            <?php
              $position = 1;
              $lastsum = 0;
              foreach ($tipps as $key => $tipp) {
                if ($key == $this->Session->read('Auth.User.id')) {
                  echo '<tr style="background-color:lightgreen">';
                } else {
                  echo '<tr>';
                }
                if ($tipp['total'] == $lastsum) {
                  echo '<td>&nbsp;</td>';
                } else {
                  echo '<td>' . $position . '</td>';
                }
                echo '<td>'; 
                  if (!empty($users[$key]['photo'])) {
                    echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $users[$key]['photo_dir'] .  DS . 'small_' . $users[$key]['photo'], array('style' => 'max-width:30px; max-height:30px;'));
                  }
                echo '</td>'; 

                echo '<td>' . $users[$key]['username'] . '</td>';
                foreach ($tipp as $round => $points) {
                  echo '<td>';
                  if (!$points) {
                    echo '0';
                  } else {
                    echo $points;
                  }
                  echo '</td>';
                }
                echo '</tr>';
                $lastsum = $tipp['total'];
                $position++;
              } 
            ?>
            </tbody>
            </table>
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
      </div> <!-- /.row -->
    </div> <!-- .container -->
  </div> <!-- .content -->
</div> <!-- #tippoverview -->