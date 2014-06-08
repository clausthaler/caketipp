<div id="entertipps">
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
    <?php echo $this->element('menu', array("active" => "entertipps")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
      <section>
      <?php
        $teams = Hash::combine($teams, '{n}.Team.id', '{n}.Team'); 
        $rounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round'); 
        $groups = Hash::combine($groups, '{n}.Group.id', '{n}.Group'); 
        $tipps = Hash::combine($tipps, '{n}.Tipp.match_id', '{n}.Tipp'); 
      ?>           
        <div class="btn-group">
          <button data-toggle="dropdown" class="btn btn-tertiary dropdown-toggle" type="button">
            <?php echo __('Select Round'); ?> <span class="caret"></span>
          </button>
          <ul role="menu" class="dropdown-menu">
            <?php foreach ($rounds as $key => $round) { ?>
            <li><a href="javascript:void(0)" onclick="tippspiel_admin.loadRoundTipps('<?php echo $key; ?>')" tabindex="-1" data-toggle="tab"><?php echo $round['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
           
        <br><br>
        <!-- start: Content -->
        <?php
          echo $this->Form->create('Tipp', array(
            'action' => 'entertipps/' . $roundId,
            'role' => 'form',
            'class' => 'form-inline'
          )); 
          echo '<h4>' . $rounds[$roundId]['name']  . '</h4>';
          echo '<table class="table table-condensed" cellpadding="0" cellspacing="0">';
          echo '<tr>';
          echo '<th>' . __('Date') . '</th>';
          echo '<th>' . __('Team 1') . '</th>';
          echo '<th>-</th>';
          echo '<th>' . __('Team 2') . '</th>';
          if ($roundId <= 3) {
            echo '<th style="text-align: center;">' . __('Group') . '</th>';
          }
          echo '<th style="text-align: center;">' . __('Result') . '</th>';
          echo '<th style="text-align: center;">' . __('Tipp') . '</th>';
          echo '</tr>';

          foreach ($matches as $key => $match) {
            echo '<tr>';
            echo '<td>';
            echo __(date("D", $match['Match']['kickoff'])) . ', ';
            echo date("d.m", $match['Match']['kickoff']); 
            echo '&nbsp;<small>' . date("H:i", $match['Match']['kickoff']) . ' </small>'; 
            echo '</td>';
            echo '<td>';
            echo $teams[$match['Match']['team1_id']]['name'];
            if (!empty($teams[$match['Match']['team1_id']]['iconurl'])) {
              echo '&nbsp;' . $this->Html->image($teams[$match['Match']['team1_id']]['iconurl']);
            }
            echo '</td>';
            echo '<td>-</td>';
            echo '<td>';
            echo $teams[$match['Match']['team2_id']]['name'];
            if (!empty($teams[$match['Match']['team2_id']]['iconurl'])) {
              echo '&nbsp;' . $this->Html->image($teams[$match['Match']['team2_id']]['iconurl']);
            }
            echo '</td>';
            if ($roundId <= 3) {
              echo '<td style="text-align: center;">';
              echo $groups[$match['Match']['group_id']]['shortname'];
              echo '</td>';
            }
            echo '<td style="text-align: center;">';
            echo  $match['Match']['points_team1'] . ':' . $match['Match']['points_team2'];
            if ($match['Match']['extratime'] != 0) {
              if ($match['Match']['extratime'] == 1) {
                echo '&nbsp;' . __('o t');
              }
              if ($match['Match']['extratime'] == 2) {
                echo '&nbsp;' . __('pen');
              }
            }
            echo '</td>';
            echo '<td class="col-xs-2" style="text-align: center;">';
            if ($match['Match']['due'] > strtotime($this->Session->read('currentdatetime'))) {
              echo '<div class="form-group">';
              echo $this->Form->input('Tipp.' . $match['Match']['id'] . '.points1', array(
                'type'=>'select',
                'label' => false,
                'empty' => true,
                'class' => 'tipp-select',
                'div' => false,
                'options' => Configure::read('MatchResults'),
                'value' => isset($tipps[$match['Match']['id']]['points_team1']) ? $tipps[$match['Match']['id']]['points_team1'] : false));
              echo '</div><div class="form-group">&nbsp;:&nbsp;</div><div class="form-group">';
              echo $this->Form->input('Tipp.' . $match['Match']['id'] . '.points2', array(
                'type'=>'select',
                'label' => false,
                'empty' => true,
                'class' => 'tipp-select',
                'div' => false,
                'options' => Configure::read('MatchResults'),
                'value' => isset($tipps[$match['Match']['id']]['points_team2']) ? $tipps[$match['Match']['id']]['points_team2'] : false));
              echo '</div>';
            } else {
              echo isset($tipps[$match['Match']['id']]['points_team1']) ? $tipps[$match['Match']['id']]['points_team1'] : ' ' ;
              echo ':';
              echo isset($tipps[$match['Match']['id']]['points_team2']) ? $tipps[$match['Match']['id']]['points_team2'] : ' ' ;

            }
            echo '</td>';
            echo '</tr>';

          }
          echo "</table>";
          echo $this->Form->button(__('Save'), array(
            'type' => 'submit',
            'escape' => true,
            'class' => 'btn btn-primary'
            )); 
          echo $this->Form->end(); 
          ?>
      </section> <!-- /.demo-section -->
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->
</div>
