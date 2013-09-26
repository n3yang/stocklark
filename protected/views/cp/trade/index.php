<?php
$this->breadcrumbs=array(
	'Trade Ars',
);

$this->menu=array(
	array('label'=>'Create TradeAr', 'url'=>array('create')),
	array('label'=>'Manage TradeAr', 'url'=>array('admin')),
);
?>

<h1>Trade Ars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
