<?php
$this->breadcrumbs=array(
	'User Ars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserAr', 'url'=>array('index')),
	array('label'=>'Manage UserAr', 'url'=>array('admin')),
);
?>

<h1>Create UserAr</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>