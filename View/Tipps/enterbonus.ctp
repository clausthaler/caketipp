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
    <?php echo $this->element('menu', array("active" => "enterbonus")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <section>
        <?php
          $tipps = Hash::combine($tipps, '{n}.Tipp.question_id', '{n}.Tipp'); 
          echo $this->Form->create('Tipp', array(
            'action' => 'enterbonus',
            'role' => 'form'
          )); 
          echo '<h4>' . __('Bonus questions')  . '</h4>';
          echo '<table class="table table-condensed" cellpadding="0" cellspacing="0">';
          echo '<tr>';
          echo '<th>' . __('Date') . '</th>';
          echo '<th>' . __('Question') . '</th>';
          echo '<th>' . __('Points') . '</th>';
          echo '<th class="col-xs-2" style="text-align: center;">' . __('Tipp') . '</th>';
          echo '</tr>';
          foreach ($questions as $key => $question) {
            echo '<tr>';
            echo '<td>';
            echo __(date("D", $question['Question']['due'])) . ', ';
            echo date("d.m.Y", $question['Question']['due']); 
            echo '&nbsp;<small>' . date("H:i", $question['Question']['due']) . ' </small>'; 
            echo '</td>';
            echo '<td>';
            echo $question['Question']['text'];
            echo '</td>';
            echo '<td>';
            echo $question['Question']['points'];
            echo '</td>';
            echo '<td class="col-xs-2" style="text-align: center;">';
            if ($question['Question']['due'] > time()) {
              echo $this->Form->input('Question.' . $question['Question']['id'] , array(
                'type'=>'select',
                'label' => false,
                'empty' => true,
                'div' => false,
                'options' => $teams,
                'value' => isset($tipps[$question['Question']['id']]['team_id']) ? $tipps[$question['Question']['id']]['team_id'] : false));
            } else {
              echo isset($tipps[$question['Question']['id']]['team_id']) ? $teams[$tipps[$question['Question']['id']]['team_id']] : ' ' ;
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
