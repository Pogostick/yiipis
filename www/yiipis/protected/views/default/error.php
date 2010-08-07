<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div style="text-align:center;margin:25px auto;">
	<img src="/images/404.jpg" />
	<div class="error">
		<?php echo CHtml::encode($message); ?>
	</div>
</div>