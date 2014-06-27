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


        <?php foreach ($groups as $groupkey => $group) { ?>
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
                  <?php foreach ($matches[$group['Group']['id']] as $matchkey => $match) { ?>
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
                  <?php foreach ($ladders[$group['Group']['id']] as $ladderkey => $ladder) { ?>
                    <tr style="text-align:center">
                      <td><?php echo $pos++; ?></td>
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
                  <?php $pos = 1; ?>
                  <?php foreach ($tippladders[$group['Group']['id']] as $tippladderkey => $tippladder) { ?>
                    <tr style="text-align:center">
                      <td><?php echo $pos++; ?></td>
                      <td style="text-align:left">
                      <?php 
                        echo $this->Html->image($teams[$tippladder['team_id']]['iconurl']) . '&nbsp;';
                        echo $teams[$tippladder['team_id']]['name'];
                      ?>
                      </td>
                      <td><?php echo $tippladder['matches'] ?></td>
                      <td><?php echo $tippladder['points'] ?></td>
                      <td><?php echo $tippladder['goodgoals'] ?></td>
                      <td><?php echo ($tippladder['goodgoals'] - $tippladder['badgoals']) ?></td>
                      <td><?php echo $tippladder['won'] ?></td>
                      <td><?php echo $tippladder['draw'] ?></td>
                      <td><?php echo $tippladder['lost'] ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>              
              </div> <!-- /.col -->
            </div> <!-- /.row -->
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
        <?php } ?>

      </div> <!-- /.col -->
    </div>
  </div>
</div>  
</div>  