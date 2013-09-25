<?php
$this->breadcrumbs=array(
	'Subscribe Ars',
);

$this->menu=array(
	array('label'=>'Create SubscribeAr', 'url'=>array('create')),
	array('label'=>'Manage SubscribeAr', 'url'=>array('admin')),
);
?>

<h1>Subscribe Ars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
