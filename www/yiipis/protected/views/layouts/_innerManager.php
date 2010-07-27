<?php
/**
 * _innerManager page layout
 *
 * @package 	yiipis
 * @subpackage 	views.layouts
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */

//	Our one column layout css file. You can change the inner layout of the page by changing these styles
PS::_rcf( '/css/layouts/_innerManager.css' );
?>

<div id="content-container">

	<div id="content-column">
		<?php echo $content; ?>
	</div>

</div>