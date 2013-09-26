<?php
$this->breadcrumbs=array(
	'User Ars',
);

$this->menu=array(
	array('label'=>'Create UserAr', 'url'=>array('create')),
	array('label'=>'Manage UserAr', 'url'=>array('admin')),
);
?>

<h1>User Ars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
