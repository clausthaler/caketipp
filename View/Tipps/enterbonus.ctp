<div class="content">
  <div class="container">
    <div class="row">
      <div class="portlet portlet-boxed">
        <div class="portlet-header">
          <h5 class="portlet-title"><?php echo __('Schedule'); ?></h5>
        </div>
        <div class="portlet-body">
        <?php
          $saveable = false;
          $tipps = Hash::combine($tipps, '{n}.Tipp.question_id', '{n}'); 
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
          echo '<th class="col-xs-2">' . __('Tipp') . '</th>';
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
            echo '<td class="col-xs-2">';
            if ($question['Question']['due'] > strtotime($this->Session->read('currentdatetime'))) {
              $saveable = true;
              echo $this->Form->input('Question.' . $question['Question']['id'] , array(
                'type'=>'select',
                'label' => false,
                'empty' => true,
                'div' => false,
                'options' => $teams,
                'value' => isset($tipps[$question['Question']['id']]['Tipp']['team_id']) ? $tipps[$question['Question']['id']]['Tipp']['team_id'] : false));
            } else {
              if (isset($tipps[$question['Question']['id']]['Tipp']['team_id'])) {
                echo $this->Html->image($tipps[$question['Question']['id']]['Team']['iconurl']) . '&nbsp;';
                echo  $tipps[$question['Question']['id']]['Team']['name'];
              } else {
                echo ' ';
              }
            }
            echo '</td>';
            echo '</tr>';

          }
          echo "</table>";
          if ($saveable) {
            echo $this->Form->button(__('Save'), array(
              'type' => 'submit',
              'escape' => true,
              'class' => 'btn btn-primary'
              )); 
          }
          echo $this->Form->end(); 
          ?>
        </div><!-- /.portlet-body -->
      </div> <!-- /.portlet -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->
