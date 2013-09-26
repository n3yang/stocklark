<?php
$this->breadcrumbs=array(
	'User Ars'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserAr', 'url'=>array('index')),
	array('label'=>'Create UserAr', 'url'=>array('create')),
	array('label'=>'View UserAr', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserAr', 'url'=>array('admin')),
);
?>

<h1>Update UserAr <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>