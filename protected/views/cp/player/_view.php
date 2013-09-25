<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source')); ?>:</b>
	<?php echo CHtml::encode($data->source); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_uid')); ?>:</b>
	<?php echo CHtml::encode($data->source_uid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('st')); ?>:</b>
	<?php echo CHtml::encode($data->st); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sd')); ?>:</b>
	<?php echo CHtml::encode($data->sd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('intro')); ?>:</b>
	<?php echo CHtml::encode($data->intro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('certificate')); ?>:</b>
	<?php echo CHtml::encode($data->certificate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profit_ratio_d1')); ?>:</b>
	<?php echo CHtml::encode($data->profit_ratio_d1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profit_ratio_d5')); ?>:</b>
	<?php echo CHtml::encode($data->profit_ratio_d5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profit_ratio_d20')); ?>:</b>
	<?php echo CHtml::encode($data->profit_ratio_d20); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profit_ratio_total')); ?>:</b>
	<?php echo CHtml::encode($data->profit_ratio_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_create')); ?>:</b>
	<?php echo CHtml::encode($data->time_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_update')); ?>:</b>
	<?php echo CHtml::encode($data->time_update); ?>
	<br />

	*/ ?>

</div>