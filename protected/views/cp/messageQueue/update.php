<?php
$this->breadcrumbs=array(
	'Message Queue Ars'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MessageQueueAr', 'url'=>array('index')),
	array('label'=>'Create MessageQueueAr', 'url'=>array('create')),
	array('label'=>'View MessageQueueAr', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MessageQueueAr', 'url'=>array('admin')),
);
?>

<h1>Update MessageQueueAr <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>