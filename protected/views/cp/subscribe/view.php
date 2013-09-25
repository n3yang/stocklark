<?php
$this->breadcrumbs=array(
	'Subscribe Ars'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SubscribeAr', 'url'=>array('index')),
	array('label'=>'Create SubscribeAr', 'url'=>array('create')),
	array('label'=>'Update SubscribeAr', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SubscribeAr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubscribeAr', 'url'=>array('admin')),
);
?>

<h1>View SubscribeAr #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'type',
		'feature',
		'time_create',
		'time_over',
		'status',
	),
)); ?>
