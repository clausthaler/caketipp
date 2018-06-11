<div class="content">
  <div class="container">
    <?php foreach ($groups as $key => $group) { ?>
    <div class="row">
      <div class="portlet portlet-boxed">
        <div class="portlet-header">
          <h5 class="portlet-title"><?php echo $group['Group']['name']; ?> </h5>
        </div>
        <div class="portlet-body table-responsive">
          <div class="col-md-6">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th><?php echo __('Date'); ?></th>
                  <th><?php echo __('Game'); ?></th>
                  <th style="text-align:center"><?php echo __('Tipp'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $matches = Set::sort($group['Match'], '{n}.kickoff', 'asc');
                foreach ($matches as $matchkey => $match) { ?>
                <tr>
                  <td><?php echo date("d.m", $match['kickoff']) . '&nbsp;<small>' . date('H:i', $match['kickoff']) .   '</small>'; ?>
                  </td>
                  <td>
                  <?php 
                   echo $this->Html->image('flags/' . $teams[$match['team1_id']]['iconurl']) 
                    . '&nbsp;' 
                    . $teams[$match['team1_id']]['name']
                    . ' - '
                    . $teams[$match['team2_id']]['name']
                    . '&nbsp;' 
                    . $this->Html->image('flags/' . $teams[$match['team2_id']]['iconurl']);
                  ?>
                  <td style="text-align:center">
                  <?php 
                    if (array_key_exists($match['id'], $group['Tipp'])) {
                      echo $group['Tipp'][$match['id']]['points_team1'] . ':' . $group['Tipp'][$match['id']]['points_team2'];
                      } else {
                        echo "&nbsp;";
                      }
                  ?>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div><!-- /.col -->
          <div class="col-md-6">
            <h6><?php echo __('Tipp table'); ?></h6>
            <table class="table table-bordered table-condensed">
              <thead>
                <tr>
                  <th>Pos</th>
                  <th>Team</th>
                  <th>Spiele</th>
                  <th>Punkte</th>
                  <th>Tore</th>
                  <th>Diff</th>
                  <th>g</th>
                  <th>u</th>
                  <th>v</th>
                </tr>
              </thead>
              <tbody>
              <?php $pos = 1; ?>
              <?php foreach ($group['Ladder'] as $ladderkey => $ladder) { ?>
                <tr style="text-align:center">
                  <?php 
                    $group['Ladder'][$ladderkey]['pos'] = $pos++;
                  ?>
                  <td><?php echo $group['Ladder'][$ladderkey]['pos']; ?></td>
                  <td style="text-align:left">
                  <?php 
                   echo $this->Html->image('flags/' . $teams[$ladder['team_id']]['iconurl']) . '&nbsp;';
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
          </div><!-- /.col -->
        </div> <!-- /.portlet-body -->
      </div> <!-- /.portlet -->
    </div> <!-- /.row -->
  <?php }  ?>
  </div> <!-- /.container -->
</div> <!-- .content -->