<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_text')); ?>:</b>
	<?php echo CHtml::encode($data->name_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_text')); ?>:</b>
	<?php echo CHtml::encode($data->url_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dev_url_text')); ?>:</b>
	<?php echo CHtml::encode($data->dev_url_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dev_server_id')); ?>:</b>
	<?php echo CHtml::encode($data->dev_server_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_push_date')); ?>:</b>
	<?php echo CHtml::encode($data->last_push_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dev_last_push_date')); ?>:</b>
	<?php echo CHtml::encode($data->dev_last_push_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lmod_date')); ?>:</b>
	<?php echo CHtml::encode($data->lmod_date); ?>
	<br />

	*/ ?>

</div>