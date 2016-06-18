<div id="tippsoverview">
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="portlet portlet-boxed">
          <div class="portlet-body">
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
            <br>
            <br>
            <section>
            <table class="table table-condensed" cellpadding="0" cellspacing="0">
              <tr>
                <th><?php echo __('Question'); ?></th>
                <th><?php echo __('Points'); ?></th>
                <th><?php echo __('Answer'); ?></th>
              </tr>
              <?php foreach ($questions as $key => $question) : ?>
                <tr>
                  <td><?php echo $question['text'] ; ?></td>
                  <td><?php echo $question['points'] ; ?></td>
                  <td>
                    <?php 
                    if ($question['team_id'] <> 0) {
                      echo $this->Html->image($teams[$question['team_id']]['iconurl']) . '&nbsp;';
                      echo $teams[$question['team_id']]['name'] ;
                    } else {
                      echo('-');
                    } 
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </table>  
            </section> <!-- /.demo-section -->
            <br>
            <h4><?php echo __('Tipps'); ?> </h4>
            <table class="table table-condensed">
            <thead>
              <tr>
                <th><?php echo __('Name'); ?></th>
                <?php foreach ($questions as $key => $question) : ?>
                  <th><?php echo $question['name'] ; ?></th>
                <?php endforeach; ?>
                <th><?php echo __('Points'); ?></th>
              </tr>
            </thead>
            <tbody>
            <?php
              foreach ($users as $id => $user) {
                if ($user['username'] == $this->Session->read('Auth.User.username')) {
                  echo '<tr style="background-color:lightgreen">';
                } else {
                  echo '<tr>';
                }
                echo '<td>' . $user['username'] . '</td>';

                if (isset($tipps[$user['username']])) {
                  $userhastipps = true;
                  $usertipps = $tipps[$user['username']];
                } else {
                  $userhastipps = false;
                }
                $points = 0;
                foreach ($questions as $key => $question) {
                  $style = '';
                  if ($userhastipps && isset($usertipps[$question['id']])) {
                    if (gettype(array_search($usertipps[$question['id']]['team_id'], $possibleanswers[$question['id']])) != 'integer') {
                      $style = 'opacity:0.3;';
                    }
                  }
                  echo '<td style="' . $style . '">';
                  if ($userhastipps && isset($usertipps[$question['id']])) {
                    if (!empty($teams[$usertipps[$question['id']]['team_id']]['iconurl'])) {
                      echo $this->Html->image($teams[$usertipps[$question['id']]['team_id']]['iconurl']) . '&nbsp;';
                    }
                    echo $teams[$usertipps[$question['id']]['team_id']]['name'];
                    $points = $points + $usertipps[$question['id']]['points'];
                  } else {
                    echo '-';
                  }
                  echo '</td>';
                }
                echo '<td>' . $points . '</td>';
                echo '</tr>';
              } 
            ?>
            </tbody>
            </table>
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </div> <!-- .content -->
</div> <!-- #tippoverview -->