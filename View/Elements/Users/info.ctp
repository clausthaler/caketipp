<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  		<h3 class="modal-title"><?php echo $user['User']['username'] . '  -  ' . $user['User']['name'] ?></h3>
		</div> <!-- /.modal-header -->

		<div class="modal-body">
          <?php 
          if (!empty($user['User']['photo'])) {
          	echo $this->Html->image(DS . 'files' . DS . 'user' . DS . 'photo'  . DS . $user['User']['photo_dir'] .  DS . $user['User']['photo'], array('style' => 'width:100%'));
          } else {
          	echo 'no image';
          }
          ?>
		</div> <!-- /.modal-body -->
		<div class="modal-footer">
    </div>

	</div> <!-- /.modal-content -->
</div> <!-- /.modal-dialog -->