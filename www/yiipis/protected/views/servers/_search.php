<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name_text'); ?>
		<?php echo $form->textField($model,'name_text',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url_text'); ?>
		<?php echo $form->textField($model,'url_text',array('size'=>60,'maxlength'=>1024)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dev_url_text'); ?>
		<?php echo $form->textField($model,'dev_url_text',array('size'=>60,'maxlength'=>1024)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dev_server_id'); ?>
		<?php echo $form->textField($model,'dev_server_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_push_date'); ?>
		<?php echo $form->textField($model,'last_push_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dev_last_push_date'); ?>
		<?php echo $form->textField($model,'dev_last_push_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lmod_date'); ?>
		<?php echo $form->textField($model,'lmod_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->