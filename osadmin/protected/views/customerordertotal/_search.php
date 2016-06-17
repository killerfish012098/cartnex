<div class="wide form row-fluid fileter_div_main">
<?php
$this->widget('bootstrap.widgets.TbDatePicker',array(
    'name'=>'Order[date_from]',
	'htmlOptions'=>array(
		'placeholder'=>Yii::t('customerordertotal','entry_date_from'),
		'class'=>'span5'
	),
    'value'=>$model->date_from,
    'options' => array(
        'format' => 'yyyy-mm-dd',
        'viewformat' => 'yyyy-mm-dd',
		
	)
));

$this->widget('bootstrap.widgets.TbDatePicker',array(
    'name'=>'Order[date_to]',
		'htmlOptions'=>array(
		'placeholder'=>Yii::t('customerordertotal','entry_date_to'),
		'class'=>'span5'),
    'value'=>$model->date_to,
    'options' => array(
        'format' => 'yyyy-mm-dd',
        'viewformat' => 'yyyy-mm-dd',
    )
));
?>
<?php echo CHtml::submitButton('Search',array('class'=>'span2 btn btn-info')); ?>
</div>