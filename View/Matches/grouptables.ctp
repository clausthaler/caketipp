<?php 
$matches = Hash::combine($matches, '{n}.Match.id', '{n}.Match', '{n}.Match.group_id');
$ladders = Hash::combine($ladders, '{n}.Ladder.id', '{n}.Ladder', '{n}.Ladder.group_id');
$teams = Hash::combine($teams, '{n}.Team.id', '{n}.Team');
?>
<div class="mainnav">
  <?php 
    echo $this->Session->flash('flash', array('element' => 'message'));
    echo $this->Session->flash('auth', array('element' => 'message'));
  ?>
</div> <!-- /.mainnav -->
<div class="content">
  <div class="container">
    <div class="layout layout-main-right layout-stack-sm">
    <!-- start: Main Menu -->
    <?php echo $this->element('menu', array("active" => "grouptables")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <?php foreach ($groups as $groupkey => $group) { ?>
        <div class="portlet">
          <h4 class="portlet-title">
            <u><?php echo $group['Group']['name'] ?></u>
          </h4>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-6">
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
                  <?php foreach ($ladders[$group['Group']['id']] as $ladderkey => $ladder) { ?>
                    <tr style="text-align:center">
                      <td><?php echo $ladder['pos'] ?></td>
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
                <table class="table table-condensed">
                  <thead>
                  <tr>
                    <th><?php echo __('Date'); ?></th>
                    <th><?php echo __('Teams'); ?></th>
                    <th style="text-align:center"><?php echo __('Result'); ?></th>
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