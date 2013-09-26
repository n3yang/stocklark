<?php
$this->breadcrumbs=array(
	'Trade Ars'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TradeAr', 'url'=>array('index')),
	array('label'=>'Create TradeAr', 'url'=>array('create')),
	array('label'=>'Update TradeAr', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TradeAr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TradeAr', 'url'=>array('admin')),
);
?>

<h1>View TradeAr #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'source',
		'source_uid',
		'price',
		'amount',
		'stock_code',
		'stock_name',
		'sell_buy',
		'time_deal',
		'remark',
		'note_content',
		'name',
		'st',
		'sd',
		'time_create',
		'time_update',
		'status',
	),
)); ?>
