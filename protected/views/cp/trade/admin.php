<?php
$this->breadcrumbs=array(
	'Trade Ars'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TradeAr', 'url'=>array('index')),
	array('label'=>'Create TradeAr', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trade-ar-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Trade Ars</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trade-ar-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'source',
		'source_uid',
		'price',
		'amount',
		'stock_code',
		/*
		'stock_name',
		'sell_buy',
		'time_deal',
		'remark',
		'note_content',
		'name',
		'st',
		'sd',
		'time_create',
		'time_update',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
