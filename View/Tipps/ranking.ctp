<div id="tippsoverview">
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
      <?php echo $this->element('menu', array("active" => "tippoverview")); ?>
      <!-- end: Main Menu -->
        <div class="col-md-9 col-sm-8 layout-main">
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
          <h4><?php echo __('Ranking'); ?> </h4>
          <table class="table table-condensed">
            <thead>
              <tr>
                <th><?php echo __('Pos'); ?></th>
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
                echo '<td>' . $users[$key] . '</td>';
                foreach ($tipp as $round => $points) {
                  echo '<td>' . $points . '</td>';
                }
                echo '</tr>';
                $lastsum = $tipp['total'];
                $position++;
              } 
            ?>
            </tbody>
          </table>
        </div> <!-- /.col -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </div> <!-- .content -->
</div> <!-- #tippoverview -->