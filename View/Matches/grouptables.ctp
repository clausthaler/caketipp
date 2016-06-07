<?php 
$matches = Hash::combine($matches, '{n}.Match.id', '{n}.Match', '{n}.Match.group_id');
$tipps = Hash::combine($tipps, '{n}.Tipp.match_id', '{n}.Tipp');
$ladders = Hash::combine($ladders, '{n}.Ladder.id', '{n}.Ladder', '{n}.Ladder.group_id');
$teams = Hash::combine($teams, '{n}.Team.id', '{n}.Team');
$tippladders = Hash::combine($tippladders, '{n}.Ladder.id', '{n}.Ladder', '{n}.Ladder.group_id');
?>
<div id="tippersgrouptables">
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
    <?php echo $this->element('menu', array("active" => "grouptables")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8">
        <div class="row form-group">
          <?php echo $this->Form->label('TipperSelect', __('Show group bonus for'), 'col-md-3'); ?>
          <div class="col-md-4">
              <?php echo $this->Form->select('TipperSelect', $users, 
                array(
                  'label' => false,
                  'div' => false,
                  'class' => 'form-control',
                  'empty' => false,
                  'onchange' => 'tippspiel_admin.refreshGroupTables()',
                  'value' => $user['User']['username'])); 
              ?>
          </div>
        </div>

        <?php $sum = 0; ?>
        <?php foreach ($groups as $groupkey => $group) { ?>
        <?php 
          $groupid = $group['Group']['id']; 
          $ladders[$groupid] = Hash::combine($ladders[$groupid], '{n}.team_id', '{n}'); 
          $tippladders[$groupid] = Hash::combine($tippladders[$groupid], '{n}.team_id', '{n}'); 
        ?>

        <div class="portlet">
          <h4 class="portlet-title">
            <u><?php echo $group['Group']['name'] ?></u>
          </h4>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-8">
                <table class="table table-condensed">
                  <thead>
                  <tr>
                    <th><?php echo __('Date'); ?></th>
                    <th><?php echo __('Teams'); ?></th>
                    <th style="text-align:center"><?php echo __('Result'); ?></th>
                    <th style="text-align:center"><?php echo __('Tipp'); ?></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($matches[$groupid] as $matchkey => $match) { ?>
                  <tr>
                    <td><?php echo date("d.m", $match['kickoff']) . '&nbsp;<small>' . date("H:i", $match['kickoff']) . ' </small>'; ?></td>
                    <td><?php echo $teams[$match['team1_id']]['name'] . ' - ' . $teams[$match['team2_id']]['name']; ?> </td>
                    <td style="text-align:center">
                    <?php echo $match['points_team1'] . ':' . $match['points_team2']; 
                    if ($match['extratime'] != 0) {
                      if ($match['extratime'] == 1) {
                        echo '&nbsp;' . __('o t');
                      }
                      if ($match['extratime'] == 2) {
                        echo '&nbsp;' . __('pen');
                      }
                    }
                    ?>
                    </td>
                    <?php 
                      if (isset($tipps[$matchkey])) {
                        if ($tipps[$matchkey]['points'] > 0) {
                          echo '<td style="text-align:center; color:green;font-weight:bold;">';
                        } else {
                          echo '<td style="text-align:center;">';
                        }
                        echo $tipps[$matchkey]['points_team1'] . ':' . $tipps[$matchkey]['points_team2']; 
                      } else {
                        echo '<td style="text-align:center;">';
                        echo '-'; 
                      }
                    ?>
                    </td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>

              </div> <!-- /.col -->
            </div> <!-- /.row -->
            <div class="row">
              <div class="col-md-6">
                <h5><u><?php echo __('Result'); ?></u></h5>
                <table class="table table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Pos'); ?></th>
                      <th><?php echo __('Team'); ?></th>
                      <th><?php echo __('Matches'); ?></th>
                      <th><?php echo __('Points'); ?></th>
                      <th><?php echo __('Goals'); ?></th>
                      <th><?php echo __('Diff'); ?></th>
                      <th><?php echo __('w'); ?></th>
                      <th><?php echo __('d'); ?></th>
                      <th><?php echo __('l'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $pos = 1; ?>
                  <?php foreach ($ladders[$groupid] as $ladderkey => $ladder) { ?>
                    <tr style="text-align:center">
                      <?php 
                        $ladders[$groupid][$ladderkey]['pos'] = $pos++;
                      ?>
                      <td><?php echo $ladders[$groupid][$ladderkey]['pos']; ?></td>
                      <td style="text-align:left">
                      <?php 
                        echo $this->Html->image($teams[$ladder['team_id']]['iconurl']) . '&nbsp;';
                        echo $teams[$ladder['team_id']]['name'];
                      ?>
                      </td>
                      <td><?php echo $ladder['matches'] ?></td>
                      <td><?php echo $ladder['points'] ?></td>
                      <td><?php echo $ladder['goodgoals'] ?></td>
                      <td><?php echo ($ladder['goodgoals'] - $ladder['badgoals']) ?></td>
                      <td><?php echo $ladder['won'] ?></td>
                      <td><?php echo $ladder['draw'] ?></td>
                      <td><?php echo $ladder['lost'] ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div> <!-- /.col -->
              <div class="col-md-6">
                <h5><u><?php echo __('Tipp table'); ?></u></h5>
                <table class="table table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Pos'); ?></th>
                      <th><?php echo __('Team'); ?></th>
                      <th><?php echo __('Matches'); ?></th>
                      <th><?php echo __('Points'); ?></th>
                      <th><?php echo __('Goals'); ?></th>
                      <th><?php echo __('Diff'); ?></th>
                      <th><?php echo __('w'); ?></th>
                      <th><?php echo __('d'); ?></th>
                      <th><?php echo __('l'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $pos = 1; 
                  $points = array(
                    'pos' => 0,
                    'points' => 0,
                    'diff' => 0
                    );
                  ?>
                  <?php foreach ($tippladders[$groupid] as $tippladderkey => $tippladder) { ?>
                    <tr style="text-align:center">
                      <?php 
                        $tippladders[$groupid][$tippladderkey]['pos'] = $pos++;
                        echo '<td>' . $tippladders[$groupid][$tippladderkey]['pos'];
                        if ($tippladders[$groupid][$tippladderkey]['pos'] == $ladders[$groupid][$tippladderkey]['pos']) {
                          echo '<sub style="color:red;font-weight:bold">4</sub>';
                          $points['pos'] = $points['pos'] + 4;
                        }
                        echo  '</td>';                        
                      ?>
                      <td style="text-align:left">
                      <?php 
                        echo $this->Html->image($teams[$tippladder['team_id']]['iconurl']) . '&nbsp;';
                        echo $teams[$tippladder['team_id']]['name'];
                      ?>
                      </td>
                      <td><?php echo $tippladder['matches'] ?></td>
                      <?php 
                        echo '<td>' . $tippladders[$groupid][$tippladderkey]['points'];
                        if ($tippladders[$groupid][$tippladderkey]['points'] == $ladders[$groupid][$tippladderkey]['points']) {
                          echo '<sub style="color:red;font-weight:bold">2</sub>';
                          $points['points'] = $points['points'] + 2;
                        }
                        echo  '</td>';                        
                      ?>
                      <td><?php echo $tippladder['goodgoals'] ?></td>
                      <?php 
                        echo '<td>' . ($tippladders[$groupid][$tippladderkey]['goodgoals'] - $tippladders[$groupid][$tippladderkey]['badgoals']);
                        if (($tippladders[$groupid][$tippladderkey]['goodgoals'] - $tippladders[$groupid][$tippladderkey]['badgoals']) == ($ladders[$groupid][$tippladderkey]['goodgoals'] - $ladders[$groupid][$tippladderkey]['badgoals'])) {
                          echo '<sub style="color:red;font-weight:bold">1</sub>';
                          $points['diff'] = $points['diff'] + 1;
                        }
                        echo  '</td>';                        
                      ?>
                      <td><?php echo $tippladder['won'] ?></td>
                      <td><?php echo $tippladder['draw'] ?></td>
                      <td><?php echo $tippladder['lost'] ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td style="text-align:center;color:red;"><?php echo $points['pos']; ?></td>
                    <td colspan="2">&nbsp;</td>
                    <td style="text-align:center;color:red;"><?php echo $points['points']; ?></td>
                    <td>&nbsp;</td>
                    <td style="text-align:center;color:red;"><?php echo $points['diff']; ?></td>
                    <td colspan="3" style="text-align:right;color:red;font-weight:bold;"><?php echo $points['pos'] + $points['points'] + $points['diff'] ?></td>
                  </tr>
                  <?php $sum = $sum + $points['pos'] + $points['points'] + $points['diff']; ?>
                  </tbody>
                </table>              
              </div> <!-- /.col -->
            </div> <!-- /.row -->
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
        <?php } ?>
        <p style="font-weight:bold"><?php echo __('Bonus points for group tables '); ?> <span style="color:red;font-weight:bold"><?php  echo $sum ?></p>
      </div> <!-- /.col -->
    </div>
  </div>
</div>  
</div>  