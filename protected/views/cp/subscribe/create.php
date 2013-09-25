<?php
$this->breadcrumbs=array(
	'Subscribe Ars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SubscribeAr', 'url'=>array('index')),
	array('label'=>'Manage SubscribeAr', 'url'=>array('admin')),
);
?>

<h1>Create SubscribeAr</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>