<?php
$this->breadcrumbs=array(
	'Player Ars'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PlayerAr', 'url'=>array('index')),
	array('label'=>'Create PlayerAr', 'url'=>array('create')),
	array('label'=>'Update PlayerAr', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PlayerAr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PlayerAr', 'url'=>array('admin')),
);
?>

<h1>View PlayerAr #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'source',
		'source_uid',
		'name',
		'st',
		'sd',
		'title',
		'intro',
		'certificate',
		'profit_ratio_d1',
		'profit_ratio_d5',
		'profit_ratio_d20',
		'profit_ratio_total',
		'time_create',
		'time_update',
	),
)); ?>
