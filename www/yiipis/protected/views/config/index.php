<?php
//	Load me some scripts...
Yii::app()->getClientScript()->registerCoreScript('jquery');
CPSEnhanceJSTree::create( 'configs', array( 'target' => '#configs' ) );
CPSjqUIAlerts::loadScripts();

$_oFile = new ConfigurationFile( $_SERVER['DOCUMENT_ROOT'].'/library/config/main.xml');

$this->pageTitle = 'Configuration Editor';
?>

<h1>Configuration Editor</h1>

<div class="black">
	<div id="config-chooser">
		<?php echo $_oFile->asUnorderedList( 'configs' ); ?>
	</div>
	<div id="config-editor" style="margin:10px;">
		<div style="padding-top:5px;padding-bottom:5px;text-align:center;width:100%">Notes</div>
	</div>
</div>