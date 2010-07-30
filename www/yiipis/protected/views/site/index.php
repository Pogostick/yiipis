<?php
//	Load some scripts...
//CPSEnhanceJSTree::create( 'files', array( 'target' => '#files' ) );
//CPSjqUIWrapper::create( 'jstree', array( 'target' => '#navigation', 'plugins' => array( 'themes', 'html_data' ) ) );
//CPSjqUIAlerts::loadScripts();

$this->pageTitle = Yii::app()->name;

?>
<div style="text-align:center">

	<h1 id="welcome-header" style="padding-top:150px;font-size:3.5em">Are you ready to get your Yii on?<BR /><BR /><span class="yiipis">YiiPIS</span> is coming soon!</h1>

	<script type="text/javascript">
		$(function(){
			$('h1').effect('pulsate',{times:2},10000);
		});
	</script>
</div>
