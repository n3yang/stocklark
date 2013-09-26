<?php
$this->breadcrumbs=array(
	'Message Queue Ars',
);

$this->menu=array(
	array('label'=>'Create MessageQueueAr', 'url'=>array('create')),
	array('label'=>'Manage MessageQueueAr', 'url'=>array('admin')),
);
?>

<h1>Message Queue Ars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
