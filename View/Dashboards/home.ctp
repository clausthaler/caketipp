<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php 
        if ($this->Session->read('Auth.User.role') == 'admin') { 
          $currentmatches = $this->requestAction('matches/openresults');
          if (!empty($currentmatches)) { ?>
            <div class="portlet portlet-boxed">
              <div class="portlet-body table-responsive">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Date'); ?></th>
                      <th><?php echo __('Match'); ?></th>
                      <th style="text-align: center;"><?php echo __('Result'); ?></th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($currentmatches as $id => $match) { ?>
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
                        echo $match['Team1']['name']; 
                        echo " - ";
                        if (!empty($match['Team2']['iconurl'])) {
                          echo $this->Html->image($match['Team2']['iconurl']);
                        }
                        echo "&nbsp;";
                        echo $match['Team2']['name']; 
                      ?>
                      </td>
                      <td style="text-align: center;">
                      <?php 
                      if (is_numeric($match['Match']['points_team1'])) { 
                        echo $match['Match']['points_team1'] . ':' . $match['Match']['points_team2'];
                      }
                      ?>
                      </td>
                      <td>
                        <?php
                        echo $this->Html->link(__('Enter Result'), array(
                            'controller' => 'matches',
                            'action' => 'result',
                            'admin' => true, 
                            $match['Match']['id']),
                            array('class' => 'btn btn-xs btn-success'));
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php 
          }
        } ?>


        <div class="portlet portlet-boxed">
        <div class="portlet-body">

        <ul id="rankingTab" class="nav nav-pills">
          <?php if ($show <> 'matches') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
            <a href="#ranking" data-toggle="tab"><?php echo __('Ranking'); ?></a>
          </li>

          <?php if ($show == 'matches') {
            echo '<li class="active">';
          } else {
            echo '<li>';
          }
          ?>
            <a href="#today" data-toggle="tab"><?php echo __('Matches today'); ?></a>
          </li>
        </ul>

        <div id="rankingTabContent" class="tab-content">

          <?php print_r($show); ?>

          <?php 
          if ($show <> 'matches') {
            echo '<div class="tab-pane fade " id="today">';
          } else {
            echo '<div class="tab-pane fade in active" id="today">';
          } ?>
            <?php print_r($this->requestAction('tipps/dayranking/1')); ?>
          </div> <!-- /.tab-pane -->

          <?php 
          if ($show <> 'matches') {
            echo '<div class="tab-pane fade in active" id="ranking">';
          } else {
            echo '<div class="tab-pane fade" id="ranking">';
          } ?>
            <div class="table-responsive">

                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Pos'); ?></th>
                      <th>&nbsp;</th>
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
                        echo '<tr style="background-color:lightgreen" class="userinfo-modal" data-user="' . $tipper['username'] . '">';
                        if ($tipper['sum'] == $lastsum) {
                          echo '<td><a data-toggle="modal" href="#userInfoModal">&nbsp;</a></td>';
                        } else {
                          echo '<td><a data-toggle="modal" href="#userInfoModal">' . $count . '</a></td>';
                        }
                        echo '<td style="width:30px">';
                        if (!empty($tipper['photo'])) {
                          echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $tipper['photo_dir'] .  DS . 'small_' . $tipper['photo'], array('style' => 'max-width:30px; max-height:30px;'));
                        } else {
                          echo '&nbsp;';
                        }
                        echo '</td>';
                        echo '<td>' . $tipper['username'] . '</td>';
                        echo '<td>' . $tipper['sum'] . '</td>';
                        echo '</tr>';
                      } else {
                        if ($count < 9 || ($count == 9 || $count == 10) && $found ) {
                          echo '<tr class="userinfo-modal" data-user="' . $tipper['username'] . '">';
                          if ($tipper['sum'] == $lastsum) {
                            echo '<td>&nbsp;</td>';
                          } else {
                            echo '<td>' . $count . '</td>';
                          }
                          echo '<td style="width:30px">';
                          if (!empty($tipper['photo'])) {
                            echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $tipper['photo_dir'] .  DS . 'small_' . $tipper['photo'], array('style' => 'max-width:30px; max-height:30px;'));
                          } else {
                            echo '&nbsp;';
                          }
                          echo '</td>';
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
                <a href="/ranking" class="btn btn-xs btn-info"><?php echo __('Complete Ranking') ?></a>            </div>
          </div> <!-- /.tab-pane -->

        </div> <!-- /.tab-content -->




              </div>
            </div>
            <div class="portlet portlet-boxed">
              <div class="portlet-header">
                <h4 class="portlet-title"><?php echo __('Next matches'); ?> </h4>
              </div>
              <div class="portlet-body table-responsive">
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __('Date'); ?></th>
                      <th><?php echo __('Team 1'); ?></th>
                      <th>&nbsp;</th>
                      <th><?php echo __('Team 2'); ?></th>
                      <th style="text-align: center;">Tipp</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $nextmatches = $this->requestAction('matches/nextmatches/7');
                    $matches = $nextmatches['nextmatches'];
                    $tipps = Hash::combine($nextmatches['tipps'], '{n}.Tipp.match_id', '{n}.Tipp'); 
                  ?>
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
                        echo $match['Team1']['name']; 
                      ?>
                      </td>
                      <td>:</td>
                      <td>
                      <?php 
                        if (!empty($match['Team2']['iconurl'])) {
                          echo $this->Html->image($match['Team2']['iconurl']);
                        }
                        echo "&nbsp;";
                        echo $match['Team2']['name']; 
                      ?>
                      </td>
                      <td class="col-xs-3" style="text-align: center;">
                      <?php 
                      if (isset($tipps[$match['Match']['id']]['points_team1'])) { 
                        echo $tipps[$match['Match']['id']]['points_team1'] . ':' . $tipps[$match['Match']['id']]['points_team2'];
                      } else {
                        echo '<a href="/entertipps" class="btn btn-xs btn-info">' .  __('Tippenter') . '</a>';
                      }
                      ?>
                      </td>

                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
                <a href="/schedule" class="btn btn-xs btn-info"><?php echo __('Show schedule') ?></a>
              </div>
            </div>
      </div>
      <div class="col-md-6">

        <div class="portlet portlet-boxed">
          <div class="portlet-body">
            <div id="showpostbox">
              <a href="javascript:tippspiel_admin.showpostbox()" type="button" class="btn btn-primary btn-xs"><?php echo __('Say something') ?></a>
              <br/>
              <br/>
            </div>
            <div id="postbox" style="display:none">
              <p>
                <a href="javascript:tippspiel_admin.hidepostbox()"  type="button" class="btn btn-default btn-xs"><?php echo __('Cancel') ?></a>
                <a href="javascript:tippspiel_admin.postblogitem()" id="saveblogitem" type="button" class="btn btn-primary btn-xs"><?php echo __('Post!') ?></a>
                <div class="share-widget clearfix">
                  <div id="summernote"></div>
                  <?php 
                    echo $this->Form->create('Feed', array(
                      'parsley' => false,
                      'id' => 'postBoxForm',
                      'action' => 'blogadd',
                      'style' => 'display:none',
                      'id' => 'postboxform'
                    )); 
                    echo $this->Form->textarea('text', array(
                      'label' => false
                    ));
                    echo $this->Form->end();
                  ?>
                </div> <!-- /.share-widget -->

              </p>
            </div>
            <?php 
              $feeds = $this->requestAction('feeds/stream' ); 
              echo $this->element('blogstream', array('feeds' => $feeds));
            ?>

            <br class="visible-xs">
          </div>
        </div>
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->
<div id="userInfoModal" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
    </div> <!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>