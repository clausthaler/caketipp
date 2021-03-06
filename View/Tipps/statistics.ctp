<?php 
#print_r($maxdiff);
#print_r($usertimelines);
#die();
  $this->Html->script('plugins/flot/jquery.flot', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.tooltip.min', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.pie', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.resize', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.orderBars', array('block' => 'scriptBottom'));
  $this->Html->script('plugins/flot/jquery.flot.stack', array('block' => 'scriptBottom'));
?>
<div id="tippstatistics">
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="portlet portlet-boxed">
          <div class="portlet-body table-responsive">
            <div class="col-md-9">
        <div class="row form-group">
          <?php echo $this->Form->label('TipperSelect', __('Show statistics for'), 'col-md-3'); ?>
          <div class="col-md-4">
              <?php echo $this->Form->select('TipperSelect', $users, 
                array(
                  'label' => false,
                  'div' => false,
                  'class' => 'form-control',
                  'empty' => false,
                  'onchange' => 'tippspiel_admin.refreshTippsStatistics()',
                  'value' => $user['User']['username'])); 
              ?>
          </div>
        </div>
        <div class="portlet">
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-4">
                <h4>
                  <u><?php echo __('Tipps total') ?></u>
                </h4>
                <p></p>
                <div id="tipps" class="chart-holder"></div>
              </div> <!-- /.col -->
              <div class="col-md-4">
                <h4>
                  <u><?php echo __('Tipp hits') ?></u>
                </h4>
                <div id="tipphits" class="chart-holder"></div>
              </div> <!-- /.col -->
              <div class="col-md-4">
                <h4>
                  <u><?php echo __('Played matches tipps') ?></u>
                </h4>
                <table class="table table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th colspan="4" class="text-center"><?php echo __('For played games') ?></th>
                    </tr>
                    <tr>
                      <th class="text-center"><?php echo __('Tipp') ?></th>
                      <th class="text-center"><?php echo __('Count') ?></th>
                      <th class="text-center"><?php echo __('Points') ?></th>
                      <th class="text-center"><i class="fa fa-ban"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($resultsTipps as $resultsTipp) : ?>
                    <tr>
                      <td class="text-center"><?php echo $resultsTipp['a']['result']; ?></td>
                      <td class="text-center"><?php echo $resultsTipp['0']['count']; ?></td>
                      <td class="text-center"><?php echo $resultsTipp['0']['points']; ?></td>
                      <td class="text-center"><?php echo round($resultsTipp['0']['average'], 1) ?></td>
                    </tr>
                    <?php endforeach;?>
                  </tbody>
                </table>
              </div> <!-- /.col -->
            </div> <!-- /.row -->
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
        <div class="portlet">
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-6">
                <h4>
                  <u><?php echo __('Points per country - Top 10') ?></u>
                </h4>
                <div id="pointspercountry" class="chart-holder"></div>
              </div> <!-- /.col -->
            </div> <!-- /.row -->
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
        <div class="portlet">
          <div class="portlet-body">
            <h4>
              <u><?php echo __('Personal ranking') ?></u>
            </h4>
            <div id="persranking" class="chart-holder"></div>
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->      
        <div class="portlet">
          <div class="portlet-body">
            <h4>
              <u><?php echo __('Difference to top') ?></u>
            </h4>
            <div id="difftotop" class="chart-holder"></div>
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->      
        <div class="portlet">
          <div class="portlet-body">
            <h4>
              <u><?php echo __('Points timeline') ?></u>
            </h4>
            <div id="pointstimeline" class="chart-holder"></div>
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->      
            </div> <!-- /.col -->
          </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </div> <!-- .content -->
</div>
<script type="text/javascript">
$(function () {

  function labelFormatter(label, series) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
  }
  var data, chartOptions

  data = [
    <?php foreach ($tipps as $tipp) : ?>
    { label: "<?php echo $tipp['a']['result']; ?>", data:<?php echo $tipp['0']['count']; ?>},
    <?php endforeach;?>
  ]

  chartOptions = {    
    series: {
      pie: { 
        show: true,
        radius: 1,
        label: {
          show: true,
          radius: 3/4,
          formatter: labelFormatter,
          background: { 
              opacity: 0.5,
              color: '#000'
          }
        }
      }
    },
    legend: {
        show: false
    },
    colors: mvpready_core.layoutColors
  }

  var holder = $('#tipps')

  if (holder.length) {
    $.plot(holder, data, chartOptions )
  }
})

$(function () {

  var ds=[], data, chartOptions
  ds.push ([
  <?php foreach ($countries as $key => $country) : ?>
    [<?php echo $country['x']['pointstotal'] . ', ' . ($key + .1); ?>],
  <?php endforeach;?>
  ]);


  ds.push ([
  <?php foreach ($countries as $key => $country) : ?>
    [<?php echo $country['x']['pointspergame'] . ', ' . ($key - .1); ?>],
  <?php endforeach;?>
  ]);

  var ticks = [
    <?php foreach ($countries as $key => $country) : ?>
    [<?php echo $key . ', "' . $country['x']['country'] . '"'; ?>],
    <?php endforeach;?>
  ];

  data = [{
    label: "<?php echo __('total'); ?>",
    data: ds[0]
  }, {
    label: "<?php echo __('per match'); ?>",
    data: ds[1]
  }]


  chartOptions = {
    xaxis: {

    },
    grid: {
      hoverable: true,
      clickable: false,
      borderWidth: 0
    },
    bars: {
      align: "center",
      horizontal: true,
      show: true,
      barWidth: .25,
      fill: true,
      lineWidth: 0,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    },
    legend: {
      position: "se"
    },
    colors: mvpready_core.layoutColors,
    yaxis: {
        ticks: ticks
    }
  }

  var holder = $('#pointspercountry')

  if (holder.length) {
    $.plot(holder, data, chartOptions )
  }
})

$(function () {
    
  var d1, data, chartOptions


    <?php 
    $difftotopmax = 0;
    foreach ($usertimelines as $key => $timeline) {
      if ($timeline['Usertimeline']['difftotop'] > $difftotopmax) {
        $difftotopmax = $timeline['Usertimeline']['difftotop'];
      }
    } ?>


  d2 = [
    <?php foreach ($usertimelines as $key => $timeline) : ?>
      [<?php echo $key . ', ' . ($difftotopmax - $timeline['Usertimeline']['difftotop']); ?>],
    <?php endforeach;?>
  ]

  function positionFormatter(v, axis) {
    return (<?php echo $difftotopmax; ?> - v - 1);
  }


  data = [{
    label: "Punkte zur Spitze",
    data: d2
  }]
 
  chartOptions = {
    xaxis: { show: false},
    yaxis: { min:0, max:<?php echo $difftotopmax; ?>, tickFormatter: positionFormatter},
    series: {
      lines: {
        show: true, 
        lineWidth: 3
      },
      points: {
        show: true,
        radius: 3,
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
    legend: {
      show: true
    },
    tooltip: true,
    tooltipOpts: {
      content: function(label, xval, yval, flotItem){
               return label + ' ' + (<?php echo $difftotopmax; ?> - yval)
           }
    },
    colors: mvpready_core.layoutColors
  }

  var holder = $('#difftotop')

  if (holder.length) {
    $.plot(holder, data, chartOptions)
  }

})

$(function () {
    
  var d1, data, chartOptions

  function positionFormatter(v, axis) {
    return (50 - v) == 0 ? 1 : (50 - v);
  }
  
  d2 = [
    <?php foreach ($usertimelines as $key => $timeline) : ?>
      [<?php echo $key . ', ' . ($usercount - $timeline['Usertimeline']['position'] +1); ?>],
    <?php endforeach;?>
  ]

  data = [{
    label: "Ranking",
    data: d2
  }]
 
  chartOptions = {
    xaxis: { show: false},
    yaxis: { min:0, max:55, tickFormatter: positionFormatter},
    series: {
      lines: {
        show: true, 
        lineWidth: 3
      },
      points: {
        show: true,
        radius: 3,
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
    legend: {
      show: false
    },
    tooltip: true,
    tooltipOpts: {
      content: function(label, xval, yval, flotItem){
               return "Platz <b>" + (<?php echo $usercount; ?> -  yval + 1) + "</b>"
           },
    },
    colors: mvpready_core.layoutColors
  }

  var holder = $('#persranking')

  if (holder.length) {
    $.plot(holder, data, chartOptions)
  }

})

$(function () {
    
  var d1, data, chartOptions

  function positionFormatter(v, axis) {
    return (50 - v) == 0 ? 1 : (50 - v);
  }
  
  d2 = [
    <?php foreach ($usertimelines as $key => $timeline) : ?>
      [<?php echo $key . ', ' . $timeline['Usertimeline']['points_total']; ?>],
    <?php endforeach;?>
  ]

  data = [{
    label: "Points timeline",
    data: d2
  }]
 
  chartOptions = {
    xaxis: { show: false},
    series: {
      lines: {
        show: true, 
        lineWidth: 3
      },
      points: {
        show: true,
        radius: 3,
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
    legend: {
      show: false
    },
    tooltip: true,
    tooltipOpts: {
      content: "Punkte: %y"
    },
    colors: mvpready_core.layoutColors
  }

  var holder = $('#pointstimeline')

  if (holder.length) {
    $.plot(holder, data, chartOptions)
  }

})

$(function () {

  function labelFormatter(label, series) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
  }

  var data, chartOptions

  data = [
    <?php foreach ($tipphits as $tipphit) : ?>
    { label: "<?php echo $tipphit['x']['type']; ?>", data: <?php echo $tipphit['0']['count']; ?> }, 
    <?php endforeach;?>
  ]

  chartOptions = {    
    series: {
      pie: {
        show: true,  
        innerRadius: 0, 
        label: {
          show: true,
          radius: 3/4,
          formatter: labelFormatter,
          background: { 
              opacity: 0.5,
              color: '#000'
          }
        }
      }
    }, 
    legend: {
        show: false
    },
    colors: mvpready_core.layoutColors
  }

  var holder = $('#tipphits')

  if (holder.length) {
    $.plot(holder, data, chartOptions )
  }


})
</script>