<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trade-ar-form',
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
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock_code'); ?>
		<?php echo $form->textField($model,'stock_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'stock_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock_name'); ?>
		<?php echo $form->textField($model,'stock_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'stock_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sell_buy'); ?>
		<?php echo $form->textField($model,'sell_buy'); ?>
		<?php echo $form->error($model,'sell_buy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_deal'); ?>
		<?php echo $form->textField($model,'time_deal'); ?>
		<?php echo $form->error($model,'time_deal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'remark'); ?>
		<?php echo $form->textField($model,'remark',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'remark'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note_content'); ?>
		<?php echo $form->textField($model,'note_content',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'note_content'); ?>
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
		<?php echo $form->labelEx($model,'time_create'); ?>
		<?php echo $form->textField($model,'time_create'); ?>
		<?php echo $form->error($model,'time_create'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_update'); ?>
		<?php echo $form->textField($model,'time_update'); ?>
		<?php echo $form->error($model,'time_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->