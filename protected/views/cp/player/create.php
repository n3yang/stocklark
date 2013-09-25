<?php
$this->breadcrumbs=array(
	'Player Ars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PlayerAr', 'url'=>array('index')),
	array('label'=>'Manage PlayerAr', 'url'=>array('admin')),
);
?>

<h1>Create PlayerAr</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>