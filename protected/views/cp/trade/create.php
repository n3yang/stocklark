<?php
$this->breadcrumbs=array(
	'Trade Ars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TradeAr', 'url'=>array('index')),
	array('label'=>'Manage TradeAr', 'url'=>array('admin')),
);
?>

<h1>Create TradeAr</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>