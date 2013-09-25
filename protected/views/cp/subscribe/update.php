<?php
$this->breadcrumbs=array(
	'Subscribe Ars'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SubscribeAr', 'url'=>array('index')),
	array('label'=>'Create SubscribeAr', 'url'=>array('create')),
	array('label'=>'View SubscribeAr', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SubscribeAr', 'url'=>array('admin')),
);
?>

<h1>Update SubscribeAr <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>