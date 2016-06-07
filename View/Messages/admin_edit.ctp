<?php
$this->Html->script('libs/tinymce/tinymce.min', array('inline' => false));
?>
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
    <?php echo $this->element('menu', array("active" => "profile")); ?>
    <!-- end: Main Menu -->
      <div class="col-md-9 col-sm-8 layout-main">
        <h3 class="content-title"><u><?php echo __('New Message'); ?></u></h3>
				<?php 
					echo $this->Form->create('Message', array(
            'action' => 'edit',
            'id' => 'EditForm',
            'role' => 'form',
            'parsley' => false
					)); 
					echo $this->Form->input('id');
	        echo $this->Form->input('title', array(
  	        'label' => __('Title'),
    	      'class' => 'form-control',
      	    'div' => 'form-group',
        	  'type' => 'text',
          	'placeholder' => __('Name'),
            'onchange' => 'tippspiel_admin.messagerefresh()',
	        ));
					echo $this->Form->input('text', array(
  	        'label' => false,
    	      'class' => 'form-control',
      	    'div' => 'form-group',
      	    'required' => false
	        ));
  	    ?>
          <div class="form-group">
            <?php
              echo $this->Form->button(__('Save'), array(
                'type' => 'submit',
                'escape' => true,
                'class' => 'btn btn-primary'
                )); 
              echo '&nbsp;';
            ?>
            <a href="/admin/messages" class="btn btn-default"><?php echo __d('users', 'Cancel'); ?></a>
            &nbsp;
            <?php
              echo $this->Form->postLink(__('Publish & send'), array('action' => 'publish', $this->request->data['Message']['id']), array('id' => 'PublishMessage', 'type' => 'button', 'class' => 'btn btn-info'), __('Are you sure you want to publish and email this message?'));
            ?>
          </div>
          <?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "visualblocks code fullscreen",
        "insertdatetime table contextmenu paste"
    ],
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent fullscreen"
});
</script>
