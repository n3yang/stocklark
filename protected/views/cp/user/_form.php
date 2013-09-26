<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-ar-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wechat_open_id'); ?>
		<?php echo $form->textField($model,'wechat_open_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'wechat_open_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wechat_fake_id'); ?>
		<?php echo $form->textField($model,'wechat_fake_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'wechat_fake_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wechat_followed'); ?>
		<?php echo $form->textField($model,'wechat_followed'); ?>
		<?php echo $form->error($model,'wechat_followed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->textField($model,'gender'); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_create'); ?>
		<?php echo $form->textField($model,'time_create'); ?>
		<?php echo $form->error($model,'time_create'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_update'); ?>
		<?php echo $form->textField($model,'time_update'); ?>
		<?php echo $form->error($model,'time_update'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->