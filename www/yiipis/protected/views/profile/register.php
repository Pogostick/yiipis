<?php
/**
 * register.php
 * Advertiser registration
 * 
 * @version SVN: $Revision: 7 $
 * @modifiedby $LastChangedBy: jablan $
 * @lastmodified  $Date: 2010-02-22 12:30:20 -0500 (Mon, 22 Feb 2010) $
 */

	echo $this->renderPartial( '_profileForm', 
		array(
			'model' => $model,
			'update' => false,
		)
	);
