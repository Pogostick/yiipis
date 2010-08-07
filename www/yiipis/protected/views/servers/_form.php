<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'managed-server-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name_text'); ?>
		<?php echo $form->textField($model,'name_text',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url_text'); ?>
		<?php echo $form->textField($model,'url_text',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'url_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dev_url_text'); ?>
		<?php echo $form->textField($model,'dev_url_text',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'dev_url_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dev_server_id'); ?>
		<?php echo $form->textField($model,'dev_server_id'); ?>
		<?php echo $form->error($model,'dev_server_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_push_date'); ?>
		<?php echo $form->textField($model,'last_push_date'); ?>
		<?php echo $form->error($model,'last_push_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dev_last_push_date'); ?>
		<?php echo $form->textField($model,'dev_last_push_date'); ?>
		<?php echo $form->error($model,'dev_last_push_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->