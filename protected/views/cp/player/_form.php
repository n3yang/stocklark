<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'player-ar-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'source'); ?>
		<?php echo $form->textField($model,'source',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source_uid'); ?>
		<?php echo $form->textField($model,'source_uid',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'source_uid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'st'); ?>
		<?php echo $form->textField($model,'st',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'st'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sd'); ?>
		<?php echo $form->textField($model,'sd',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'intro'); ?>
		<?php echo $form->textField($model,'intro',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'intro'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'certificate'); ?>
		<?php echo $form->textField($model,'certificate',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'certificate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profit_ratio_d1'); ?>
		<?php echo $form->textField($model,'profit_ratio_d1',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'profit_ratio_d1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profit_ratio_d5'); ?>
		<?php echo $form->textField($model,'profit_ratio_d5',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'profit_ratio_d5'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profit_ratio_d20'); ?>
		<?php echo $form->textField($model,'profit_ratio_d20',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'profit_ratio_d20'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profit_ratio_total'); ?>
		<?php echo $form->textField($model,'profit_ratio_total',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'profit_ratio_total'); ?>
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