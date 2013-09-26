<?php
$this->breadcrumbs=array(
	'User Ars'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UserAr', 'url'=>array('index')),
	array('label'=>'Create UserAr', 'url'=>array('create')),
	array('label'=>'Update UserAr', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserAr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserAr', 'url'=>array('admin')),
);
?>

<h1>View UserAr #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'wechat_open_id',
		'wechat_fake_id',
		'wechat_followed',
		'gender',
		'status',
		'time_create',
		'time_update',
	),
)); ?>
