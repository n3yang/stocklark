<?php
$this->breadcrumbs=array(
	'Message Queue Ars'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MessageQueueAr', 'url'=>array('index')),
	array('label'=>'Create MessageQueueAr', 'url'=>array('create')),
	array('label'=>'Update MessageQueueAr', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MessageQueueAr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MessageQueueAr', 'url'=>array('admin')),
);
?>

<h1>View MessageQueueAr #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'content',
		'time_create',
		'time_update',
		'status',
	),
)); ?>
