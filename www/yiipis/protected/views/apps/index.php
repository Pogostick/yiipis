<?php
CPSjqUIWrapper::loadScripts( null, 'pepper-grinder' );
?>

<div id="inner-page-menu" class="overcast">

	<span rel="add" class="inner-page-menu-item ui-widget-content">
		<span id="app-manager-add" rel="yiipis-menu-icon-hover" class="yiipis-menu-icon yiipis-menu-icon-plus hoverable"></span>
		<h1>Add App</h1>
		<p>Aliquam imperdiet sem a dui suscipit ultricies. Nullam sit amet ante nec lacus bibendum tristique ac facilisis tellus. Suspendisse sit amet risus dolor. Nunc luctus imperdiet commodo. Nam blandit scelerisque ligula,</p>
	</span>

	<span rel="show" class="inner-page-menu-item ui-widget-content">
		<span id="app-manager-show" rel="yiipis-menu-icon-hover" class="yiipis-menu-icon yiipis-menu-icon-check hoverable"></span>
		<h1>Administer Apps</h1>
		<p>Aliquam imperdiet sem a dui suscipit ultricies. Nullam sit amet ante nec lacus bibendum tristique ac facilisis tellus. Suspendisse sit amet risus dolor. Nunc luctus imperdiet commodo. Nam blandit scelerisque ligula,</p>
	</span>

	<span rel="import" class="inner-page-menu-item clear ui-widget-content">
		<span id="app-manager-import" rel="yiipis-menu-icon-hover" class="yiipis-menu-icon yiipis-menu-icon-arrow-up hoverable"></span>
		<h1>Import an App</h1>
		<p>Aliquam imperdiet sem a dui suscipit ultricies. Nullam sit amet ante nec lacus bibendum tristique ac facilisis tellus. Suspendisse sit amet risus dolor. Nunc luctus imperdiet commodo. Nam blandit scelerisque ligula,</p>
	</span>

	<span rel="remove" class="inner-page-menu-item ui-widget-content">
		<span id="app-manager-remove" rel="yiipis-menu-icon-hover" class="yiipis-menu-icon yiipis-menu-icon-minus hoverable"></span>
		<h1>Remove an App</h1>
		<p>Aliquam imperdiet sem a dui suscipit ultricies. Nullam sit amet ante nec lacus bibendum tristique ac facilisis tellus. Suspendisse sit amet risus dolor. Nunc luctus imperdiet commodo. Nam blandit scelerisque ligula,</p>
	</span>

</div>

<script type="text/javascript">
	$(function(){
		$('span.inner-page-menu-item')
			.hover(function(){
				$(this).addClass('ui-state-active');
			},function(){
				$(this).removeClass('ui-state-active');
			})
			.click(function(e){
				e.preventDefault();
				window.location.href = $(this).attr('rel');
				return false;
			})
	});
</script>
