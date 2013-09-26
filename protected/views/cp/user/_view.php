<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wechat_open_id')); ?>:</b>
	<?php echo CHtml::encode($data->wechat_open_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wechat_fake_id')); ?>:</b>
	<?php echo CHtml::encode($data->wechat_fake_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wechat_followed')); ?>:</b>
	<?php echo CHtml::encode($data->wechat_followed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('time_create')); ?>:</b>
	<?php echo CHtml::encode($data->time_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_update')); ?>:</b>
	<?php echo CHtml::encode($data->time_update); ?>
	<br />

	*/ ?>

</div>