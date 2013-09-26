<?php
$this->breadcrumbs=array(
	'Trade Ars'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TradeAr', 'url'=>array('index')),
	array('label'=>'Create TradeAr', 'url'=>array('create')),
	array('label'=>'View TradeAr', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TradeAr', 'url'=>array('admin')),
);
?>

<h1>Update TradeAr <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>