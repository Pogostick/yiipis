<?php
/**
 * _oneColumn page layout
 * This is a content layout file
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

//	Our one column css file
PS::_rcf( '/css/layouts/_oneColumn.css' );
?>

<div id="content-container">

	<div id="content-column">

		<?php echo $content; ?>
		
	</div>

</div>