<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="content">
  <div class="container">
    <div class="error-container">
      <div class="error-code">
      500
      </div> <!-- /.error-code -->
      <div class="error-details">
        <h4>There was a problem serving the requested page.</h4>
        <h3><?php echo $name; ?></h3>
        <br>
        <p><strong>What should I do:</strong></p>
        <ul class="icons-list">
          <li>
            <i class="icon-li fa fa-check-square-o"></i>
            you can try refreshing the page, the problem may be temporary
          </li>
          <li>
            <i class="icon-li fa fa-check-square-o"></i>
            if you entered the url by hand, double check that it is correct
          </li>
          <li>
            <i class="icon-li fa fa-check-square-o"></i>
            Nothing! we've been notified of the problem and will do our best to make sure it doesn't happen again!
          </li>
        </ul>
      </div> <!-- /.error-details -->
    </div> <!-- /.error -->
  </div> <!-- /.container -->
</div> <!-- .content -->
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
