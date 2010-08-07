<?php
$this->breadcrumbs=array(
	'Servers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Servers', 'url'=>array('index')),
	array('label'=>'Create a Server', 'url'=>array('create')),
	array('label'=>'Update a Server', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete a Server', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this server?')),
	array('label'=>'Manage Servers', 'url'=>array('admin')),
);
?>

<h1>Server: <?php echo $model->name_text; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name_text',
		'url_text',
		'dev_url_text',
		'dev_server_id',
		'last_push_date',
		'dev_last_push_date',
		'create_date',
		'lmod_date',
	),
)); ?>
