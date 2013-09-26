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

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stock_code')); ?>:</b>
	<?php echo CHtml::encode($data->stock_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stock_name')); ?>:</b>
	<?php echo CHtml::encode($data->stock_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sell_buy')); ?>:</b>
	<?php echo CHtml::encode($data->sell_buy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_deal')); ?>:</b>
	<?php echo CHtml::encode($data->time_deal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remark')); ?>:</b>
	<?php echo CHtml::encode($data->remark); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note_content')); ?>:</b>
	<?php echo CHtml::encode($data->note_content); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_create')); ?>:</b>
	<?php echo CHtml::encode($data->time_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_update')); ?>:</b>
	<?php echo CHtml::encode($data->time_update); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>