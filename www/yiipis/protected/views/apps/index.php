<?php
CPSjqUIWrapper::loadScripts( null, 'pepper-grinder' );
?>

<div id="inner-page-menu" class="overcast">

	<span rel="add" class="inner-page-menu-item ui-widget-content">
		<span id="apps-manager-add-icon" class="inner-page-menu-item-icon">Cool Icon</span>
		<h1>Add an Application</h1>
		<p>Aliquam imperdiet sem a dui suscipit ultricies. Nullam sit amet ante nec lacus bibendum tristique ac facilisis tellus. Suspendisse sit amet risus dolor. Nunc luctus imperdiet commodo. Nam blandit scelerisque ligula,</p>
	</span>

	<span rel="show" class="inner-page-menu-item ui-widget-content">
		<span id="apps-manager-show-icon" class="inner-page-menu-item-icon">Cool Icon</span>
		<h1>List Applications</h1>
		<p>Aliquam imperdiet sem a dui suscipit ultricies. Nullam sit amet ante nec lacus bibendum tristique ac facilisis tellus. Suspendisse sit amet risus dolor. Nunc luctus imperdiet commodo. Nam blandit scelerisque ligula,</p>
	</span>

	<span rel="update" class="inner-page-menu-item ui-widget-content">
		<span id="apps-manager-update-icon" class="inner-page-menu-item-icon">Cool Icon</span>
		<h1>Update an Application</h1>
		<p>Aliquam imperdiet sem a dui suscipit ultricies. Nullam sit amet ante nec lacus bibendum tristique ac facilisis tellus. Suspendisse sit amet risus dolor. Nunc luctus imperdiet commodo. Nam blandit scelerisque ligula,</p>
	</span>

	<span rel="remove" class="inner-page-menu-item ui-widget-content">
		<span id="apps-manager-remove-icon" class="inner-page-menu-item-icon">Cool Icon</span>
		<h1>Remove an Application</h1>
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
