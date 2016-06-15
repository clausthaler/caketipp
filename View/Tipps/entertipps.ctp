<div id="entertipps">
<div class="content">
  <div class="container">
    <div class="row">
      <div class="portlet portlet-boxed">
        <div class="portlet-body">
      <section>
      <?php
        $teams = Hash::combine($teams, '{n}.Team.id', '{n}.Team'); 
        $rounds = Hash::combine($rounds, '{n}.Round.id', '{n}.Round'); 
        $groups = Hash::combine($groups, '{n}.Group.id', '{n}.Group'); 
        $tipps = Hash::combine($tipps, '{n}.Tipp.match_id', '{n}.Tipp'); 
      ?>           
        <!-- start: Content -->
        <?php
          echo $this->Form->create('Tipp', array(
            'action' => 'entertipps/' . $roundId,
            'role' => 'form',
            'class' => 'form-inline'
          )); 
          echo '<div class="form-group pull-right">';
            echo $this->Form->button(__('Save'), array(
              'id' => 'tippentersave',
              'type' => 'submit',
              'escape' => true,
//              'disabled' => true,
              'class' => 'btn btn-primary'
            )); 
          echo '</div>';
          foreach ($matches2tipp as $round => $matches) {
            echo '<h4>' . $rounds[$round]['name']  . '</h4>';

            echo '<table class="table table-condensed" cellpadding="0" cellspacing="0">';
            echo '<tr>';
            echo '<th>' . __('Date') . '</th>';
            echo '<th>' . __('Team 1') . '</th>';
            echo '<th>-</th>';
            echo '<th>' . __('Team 2') . '</th>';
            if ($round <= 3) {
              echo '<th style="text-align: center;">' . __('Group') . '</th>';
            }
            echo '<th style="text-align: center;">' . __('Tipp') . '</th>';
            echo '</tr>';
            foreach ($matches as $key => $match) {
              if ($match['Match']['kickoff'] > strtotime($this->Session->read('currentdatetime'))) {
              echo '<tr>';
              echo '<td>';
              echo __(date("D", $match['Match']['kickoff'])) . ', ';
              echo date("d.m", $match['Match']['kickoff']); 
              echo '&nbsp;<small>' . date("H:i", $match['Match']['kickoff']) . ' </small>'; 
              echo '</td>';
              echo '<td>';
              if (!empty($teams[$match['Match']['team1_id']]['iconurl'])) {
                echo '&nbsp;' . $this->Html->image($teams[$match['Match']['team1_id']]['iconurl']);
              }
              echo '&nbsp;' . $teams[$match['Match']['team1_id']]['name'];
              echo '</td>';
              echo '<td>-</td>';
              echo '<td>';
              if (!empty($teams[$match['Match']['team2_id']]['iconurl'])) {
                echo '&nbsp;' . $this->Html->image($teams[$match['Match']['team2_id']]['iconurl']);
              }
              echo '&nbsp;' . $teams[$match['Match']['team2_id']]['name'];
              echo '</td>';
              if ($round <= 3) {
                echo '<td style="text-align: center;">';
                echo $groups[$match['Match']['group_id']]['shortname'];
                echo '</td>';
              }
              echo '<td class="col-xs-2" style="text-align: center;">';
              if ($match['Match']['due'] > strtotime($this->Session->read('currentdatetime')) && $match['Match']['isfixed'] == 1) {
                echo '<div class="form-group">';
                echo $this->Form->input('Tipp.' . $match['Match']['id'] . '.points1', array(
                  'type'=>'select',
                  'label' => false,
                  'empty' => true,
//                  'onchange' => 'javascript:alert("hi")',
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
  
            }
            echo "</table>";
          }
          echo $this->Form->end(); 
          ?>
      </section> <!-- /.demo-section -->
        </div> <!-- /.portlet body -->
      </div> <!-- /.portlet -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->
</div>
