<?php
$this->breadcrumbs=array(
	'Servers',
);

$this->menu=array(
	array('label'=>'Create a Server', 'url'=>array('create')),
	array('label'=>'Manage Servers', 'url'=>array('admin')),
);
?>

<h1>Your Servers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
