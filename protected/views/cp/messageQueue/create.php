<?php
$this->breadcrumbs=array(
	'Message Queue Ars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MessageQueueAr', 'url'=>array('index')),
	array('label'=>'Manage MessageQueueAr', 'url'=>array('admin')),
);
?>

<h1>Create MessageQueueAr</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>