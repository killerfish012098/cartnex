<div class="wide form row-fluid fileter_div_main">
<?php
//echo '<input type="text" id="Order_product_name" name="Order[product_name]" class="span2" placeholder="Product Name" value="'.$model->product_name.'">';
		foreach(Product::getProducts() as $pro):
             $data['product'][$pro->id_product]=$pro->name;
        endforeach;
		
		$this->widget(
				'bootstrap.widgets.TbSelect2',
				array(
					'name' => 'Order[product_name]',
					'data'=>$data['product'],
					'options' => array(
							'placeholder'=>'Search Product..'
							
							
                            ),
                    'htmlOptions' => array(
					'class'=>'span4',
					'width'=>'auto',
                            'options' => array(
									$model->product_name => array('selected' => 'selected'),
                                ),
							'id' => 'issue-574-checker-select'   
							),           
				)
			);


$this->widget('bootstrap.widgets.TbDatePicker',array(
    'name'=>'Order[date_from]',
	'htmlOptions'=>array(
		'placeholder'=>'Date From',
		'class'=>'span3'
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
		'placeholder'=>'Date To',
		'class'=>'span4'
	),
    'value'=>$model->date_to,
    'options' => array(
        'format' => 'yyyy-mm-dd',
        'viewformat' => 'yyyy-mm-dd',
		
	)
));

//echo '<input type="text" id="Order_date_from" name="Order[date_from]" class="span2" placeholder="Date From" value="'.$model->date_from.'">';
//echo '<input type="text" id="Order_date_to" name="Order[date_to]" class="span2" placeholder="Date To" value="'.$model->date_to.'">';
?>
<?php echo CHtml::submitButton('Search',array('class'=>'span2 btn btn-info')); ?>
</div>