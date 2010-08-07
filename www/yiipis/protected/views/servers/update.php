<?php
$this->breadcrumbs=array(
	'Servers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Servers', 'url'=>array('index')),
	array('label'=>'Create Server', 'url'=>array('create')),
	array('label'=>'View Server', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Servers', 'url'=>array('admin')),
);
?>

<h1>Update Server: <?php echo $model->name_text; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>