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
    <?php echo $this->element('menu', array("active" => "dashboard")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <div class="row">
          <div class="col-md-6">
            <div class="portlet">
              <div class="portlet-title">
                <h4><?php echo __('Ranking'); ?> </h4>
              </div>
              <div class="portlet-body">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Pos'); ?></th>
                      <th><?php echo __('Name'); ?></th>
                      <th><?php echo __('Points'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $tippers = $this->requestAction('ranking' );
                    $tippers = Hash::combine($tippers, '{n}.c.id', '{n}.c'); 
                    
                    $found = false;
                    $count = 1;
                    $lastsum = 0;
                    foreach ($tippers as $id => $tipper) {
                      if ($id == $this->Session->read('Auth.User.id')) {
                        $found = true;
                        echo '<tr style="background-color:lightgreen">';
                        if ($tipper['sum'] == $lastsum) {
                          echo '<td>&nbsp;</td>';
                        } else {
                          echo '<td>' . $count . '</td>';
                        }
                        echo '<td>' . $tipper['username'] . '</td>';
                        echo '<td>' . $tipper['sum'] . '</td>';
                        echo '</tr>';
                      } else {
                        if ($count < 9 || ($count == 9 || $count == 10) && $found ) {
                          echo '<tr>';
                          if ($tipper['sum'] == $lastsum) {
                            echo '<td>&nbsp;</td>';
                          } else {
                            echo '<td>' . $count . '</td>';
                          }
                          echo '<td>' . $tipper['username'] . '</td>';
                          echo '<td>' . $tipper['sum'] . '</td>';
                          echo '</tr>';
                        } elseif ($count == 9 && !$found) {
                          echo '<tr>';
                          echo '<td colspan="3">&nbsp;...&nbsp;</td>';
                          echo '</tr>';
                          # code...
                        }
                      }
                      $lastsum = $tipper['sum'];
                      if ($found && $count > 10) {
                        break;
                      }
                      $count++;
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="portlet">
              <div class="portlet-title">
                <h4><?php echo __('Next matches'); ?> </h4>
              </div>
              <div class="portlet-body">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Date'); ?></th>
                      <th><?php echo __('Team 1'); ?></th>
                      <th>&nbsp;</th>
                      <th><?php echo __('Team 2'); ?></th>
                      <th><?php echo __('Groupe'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $matches = $this->requestAction('matches/nextmatches' ); ?>
                  <?php foreach ($matches as $id => $match) { ?>
                    <tr>
                      <td>
                      <?php 
                        echo __(date("D", $match['Match']['kickoff'])) . ', ';
                        echo date("d.m", $match['Match']['kickoff']); 
                        echo '&nbsp;<small>' . date("H:i", $match['Match']['kickoff']) . ' </small>'; 
                      ?>
                      </td>
                      <td>
                      <?php 
                        if (!empty($match['Team1']['iconurl'])) {
                          echo $this->Html->image($match['Team1']['iconurl']);
                        }
                        echo "&nbsp;";
                        echo $this->Html->link($match['Team1']['name'], array('controller' => 'teams', 'action' => 'view',  $match['Team1']['id'])); 
                      ?>
                      </td>
                      <td>:</td>
                      <td>
                      <?php 
                        if (!empty($match['Team2']['iconurl'])) {
                          echo $this->Html->image($match['Team2']['iconurl']);
                        }
                        echo "&nbsp;";
                        echo $this->Html->link($match['Team2']['name'], array('controller' => 'teams', 'action' => 'view',  $match['Team2']['id'])); 
                      ?>
                      </td>
                      <td>
                      <?php echo $this->Html->link($match['Group']['shortname'], array('controller' => 'groups', ' action' => 'view  ', $match['Group']['id'])); ?>
                      </td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">

          <h4 class="content-title"><u>Activity Feed</u></h4>

            <div class="share-widget clearfix">

              <textarea class="form-control share-widget-textarea" rows="3" placeholder="Share what you've been up to..." tabindex="1"></textarea>

              <div class="share-widget-actions">

              <div class="pull-right">
                <a class="btn btn-primary btn-sm" tabindex="2">Post</a>
              </div>

              </div> <!-- /.share-widget-actions -->

            </div> <!-- /.share-widget -->

            <br><br>

            <div class="feed-item feed-item-idea">

              <div class="feed-icon">
                <i class="fa fa-lightbulb-o"></i>
              </div> <!-- /.feed-icon -->

              <div class="feed-subject">
                <p><a href="javascript:;">Nikita Williams</a> shared an idea: <a href="javascript:;">Create an Awesome Idea</a></p>
              </div> <!-- /.feed-subject -->

              <div class="feed-content">
                <ul class="icons-list">
                  <li>
                    <i class="icon-li fa fa-quote-left"></i>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes.
                  </li>
                </ul>
              </div> <!-- /.feed-content -->

              <div class="feed-actions">
                <a href="javascript:;" class="pull-left"><i class="fa fa-thumbs-up"></i> 123</a> 
                <a href="javascript:;" class="pull-left"><i class="fa fa-comment-o"></i> 29</a>

                <a href="javascript:;" class="pull-right"><i class="fa fa-clock-o"></i> 2 days ago</a>
              </div> <!-- /.feed-actions -->

            </div> <!-- /.feed-item -->



            <div class="feed-item feed-item-image">

              <div class="feed-icon">
                <i class="fa fa-picture-o"></i>
              </div> <!-- /.feed-icon -->

              <div class="feed-subject">
                <p><a href="javascript:;">Nikita Williams</a> posted the <strong>4 files</strong>: <a href="javascript:;">Annual Reports</a></p>
              </div> <!-- /.feed-subject -->

              <div class="feed-content">
                <div class="thumbnail" style="width: 375px">
                  <img src="./img/mockup.png" style="width: 100%;" alt="Gallery Image">
                </div> <!-- /.thumbnail -->
              </div> <!-- /.feed-content -->

              <div class="feed-actions">
                <a href="javascript:;" class="pull-left"><i class="fa fa-thumbs-up"></i> 123</a> 
                <a href="javascript:;" class="pull-left"><i class="fa fa-comment-o"></i> 29</a>

                <a href="javascript:;" class="pull-right"><i class="fa fa-clock-o"></i> 2 days ago</a>
              </div> <!-- /.feed-actions -->

            </div> <!-- /.feed-item -->



            <div class="feed-item feed-item-file">

              <div class="feed-icon">
                <i class="fa fa-cloud-upload"></i>
              </div> <!-- /.feed-icon -->

              <div class="feed-subject">
                <p><a href="javascript:;">Nikita Williams</a> posted the <strong>4 files</strong>: <a href="javascript:;">Annual Reports</a></p>
              </div> <!-- /.feed-subject -->

              <div class="feed-content">
                <ul class="icons-list">
                  <li>
                    <i class="icon-li fa fa-file-text-o"></i>
                    <a href="javascript:;">Annual Report 2007</a> - annual_report_2007.pdf
                  </li>

                  <li>
                    <i class="icon-li fa fa-file-text-o"></i>
                    <a href="javascript:;">Annual Report 2008</a> - annual_report_2007.pdf
                  </li>

                  <li>
                    <i class="icon-li fa fa-file-text-o"></i>
                    <a href="javascript:;">Annual Report 2009</a> - annual_report_2007.pdf
                  </li>

                  <li>
                    <i class="icon-li fa fa-file-text-o"></i>
                    <a href="javascript:;">Annual Report 2010</a> - annual_report_2007.pdf
                  </li>
                </ul>
              </div> <!-- /.feed-content -->

              <div class="feed-actions">
                <a href="javascript:;" class="pull-left"><i class="fa fa-thumbs-up"></i> 123</a> 
                <a href="javascript:;" class="pull-left"><i class="fa fa-comment-o"></i> 29</a>

                <a href="javascript:;" class="pull-right"><i class="fa fa-clock-o"></i> 2 days ago</a>
              </div> <!-- /.feed-actions -->

            </div> <!-- /.feed-item -->



            <div class="feed-item feed-item-bookmark">

              <div class="feed-icon">
                <i class="fa fa-bookmark"></i>
              </div> <!-- /.feed-icon -->

              <div class="feed-subject">
                <p><a href="javascript:;">Nikita Williams</a> bookmarked a page on Delicious: <a href="javascript:;">Jumpstart Themes</a></p>
              </div> <!-- /.feed-subject -->

              <div class="feed-content">
              </div> <!-- /.feed-content -->

              <div class="feed-actions">
                <a href="javascript:;" class="pull-left"><i class="fa fa-thumbs-up"></i> 123</a> 
                <a href="javascript:;" class="pull-left"><i class="fa fa-comment-o"></i> 29</a>

                <a href="javascript:;" class="pull-right"><i class="fa fa-clock-o"></i> 2 days ago</a>
              </div> <!-- /.feed-actions -->

            </div> <!-- /.feed-item -->



            <div class="feed-item feed-item-question">

              <div class="feed-icon">
                <i class="fa fa-question"></i>
              </div> <!-- /.feed-icon -->

              <div class="feed-subject">
                <p><a href="javascript:;">Nikita Williams</a> posted the question: <a href="javascript:;">Who can I call to get a new parking pass for the Rowan Building?</a></p>
              </div> <!-- /.feed-subject -->

              <div class="feed-content">
                <ul class="icons-list">
                  <li>
                    <i class="icon-li fa fa-quote-left"></i>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes.
                  </li>
                </ul>
              </div> <!-- /.feed-content -->

              <div class="feed-actions">
                <a href="javascript:;" class="pull-left"><i class="fa fa-thumbs-up"></i> 123</a> 
                <a href="javascript:;" class="pull-left"><i class="fa fa-comment-o"></i> 29</a>

                <a href="javascript:;" class="pull-right"><i class="fa fa-clock-o"></i> 2 days ago</a>
              </div> <!-- /.feed-actions -->

            </div> <!-- /.feed-item -->

            <br class="visible-xs">            
            <br class="visible-xs">
            
          </div>
        </div>
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->