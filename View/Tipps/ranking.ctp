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
    <?php echo $this->element('menu', array("active" => "ranking")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <h4><?php echo __('Ranking'); ?> </h4>
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
            $position = 1;
          ?>
          <?php foreach ($users as $key => $user) { ?>
            <tr>
              <td><?php echo $position++; ?></td>
              <td><?php echo $user['a']['username'] ?></td>
              <td><?php echo $user[0]['sum'] ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div> <!-- /.col -->
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</div> <!-- .content -->