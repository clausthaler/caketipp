<?php 
  $usercount = count($users);
  $this->Html->script('libs/jquery-ui.min', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.tooltip.min', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.pie', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.resize', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.orderBars', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.stack', array('block' => 'scriptBottom'));
?>
<div id="tippsoverview">
  <div class="mainnav">
    <?php 
      echo $this->Session->flash('flash', array('element' => 'message'));
      echo $this->Session->flash('auth', array('element' => 'message'));
    ?>
  </div> <!-- /.mainnav -->
  <div class="content">
    <div class="container">
      <div class="portlet">
        <div class="portlet-title" style="border-bottom:none;">
          <?php echo '<< ' . $this->Html->link(__('Back to overview'),
            array('controller' => 'tipps', 'action' => 'ranking')
            #array('class' => 'btn btn-sm btn-success')
            ); 
          ?>
        </div>
        <div class="portlet-body">
          <div id="userbox"  class="clearfix"></div>
          <br>
          <p><?php echo __('Choose tippers to fille the chart'); ?> </p>
          <div class="demo-container">
            <div id="placeholder" class="demo-placeholder" style="float:left; width:1100px; height:600px;"></div>
          </div>
          <div id="timeline" class="chart-holder"></div>
        </div> <!-- /.portlet-body -->
      </div> <!-- /.portlet -->      
    </div> <!-- /.container -->
  </div> <!-- .content -->
</div> <!-- #tippoverview -->
<script type="text/javascript">
$(function() {

  function positionFormatter(v, axis) {
    return (50 - v) == 0 ? 1 : (50 - v) < 0 ? '' : (50 - v);
  }

    var datasets = {
    <?php foreach ($usertimelines as $userid => $usertimeline) : ?>
      <?php echo '"' . $users[$userid] . '"'; ?>: {
        label: <?php echo '"' . $users[$userid] . '"'; ?>,
        data: [
          <?php 
            foreach ($usertimeline as $timelineid => $timeline) {
              echo '[' . $timelineid . ', ' . ($usercount - $timeline['position'] +1) . '],';
            } 
          ?>
          ]}, 
    <?php endforeach;?>
    };

    // hard-code color indices to prevent them from shifting as
    // countries are turned on/off

    var i = 0;
    $.each(datasets, function(key, val) {
      val.color = i;
      ++i;
    });

    var user = '<?php echo $this->Session->read('Auth.User.username') ?>';

    // insert checkboxes 
    var choiceContainer = $("#userbox");
    $.each(datasets, function(key, val) {
      if (user == key) {
        choiceContainer.append("<div class='chartuser'><input type='checkbox' name='" + key +
          "' checked='checked' id='id" + key + "'></input>" +
          "<label for='id" + key + "'>"
          + val.label + "</label></div>");
      } else{
        choiceContainer.append("<div class='chartuser'><input type='checkbox' name='" + key +
          "' id='id" + key + "'></input>" +
          "<label for='id" + key + "'>"
          + val.label + "</label></div>");
      };
    });

    choiceContainer.find("input").click(plotAccordingToChoices);

    function plotAccordingToChoices() {

      var data = [];

      choiceContainer.find("input:checked").each(function () {
        var key = $(this).attr("name");
        if (key && datasets[key]) {
          data.push(datasets[key]);
        }
      });

      if (data.length > 0) {
        $.plot("#placeholder", data, {
          yaxis: {
            min: 0,
            max:55, 
            tickFormatter: positionFormatter
          },
          xaxis: {
            tickDecimals: 0
          },
          legend: {
            show: true,
            position: "nw"
          },
          series: {
            lines: {
              show: true, 
              lineWidth: 3
            },
            points: {
              show: true,
              radius: 2,
              fill: true,
              fillColor: "#ffffff",
              lineWidth: 2
            }
          },
          grid: { 
            hoverable: true, 
            clickable: false, 
            borderWidth: 0 
          },
          tooltip: true,
          tooltipOpts: {
            content: function(label, xval, yval, flotItem){
              return "Platz <b>" + (<?php echo $usercount; ?> -  yval + 1) + "</b>"
            },
          },
        });
      }
    }

    plotAccordingToChoices();

    $( "#placeholder" ).resizable();

    // Add the Flot version string to the footer

    $("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
  });
</script>