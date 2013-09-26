<?php $this->beginContent('//layouts/main'); ?>
<div class="span-5 last">
	<div id="sidebar">

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Modles',
		));
		$this->widget('zii.widgets.CMenu', array(
	         'items'=>array(
	            array('label'=>'player', 'url'=>array('cp/player')),
	            array('label'=>'subscribe', 'url'=>array('cp/subscribe')),
	            array('label'=>'trade', 'url'=>array('cp/trade')),
	            array('label'=>'user', 'url'=>array('cp/user')),
	            array('label'=>'message_queue', 'url'=>array('cp/message_queue')),
	            // array('label'=>'', 'url'=>array('')),
	        ),
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>

	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
	</div><!-- sidebar -->
</div>

<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>