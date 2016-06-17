<div class="span12 top_box_fixed">
    <?php    $this->widget('ext.Flashmessage.Flashmessage');?>
    <div class="row-fluid nav_main">
	
     <?php if(!empty($model->product_name)){?><div class="span2 fluid_span"><?php echo Yii::t('productreports','column_totalorders')?><span>	<?php echo $data['productOrdersTotal'];?> </span></div>
      <div class="span2 fluid_span"><?php echo Yii::t('productreports','column_itemssold')?><span> <?php echo $data['productQuantitySold'];?></span></div>
     <div class="span2 fluid_span"><?php echo Yii::t('productreports','column_currentstock')?><span> <?php echo $data['stockOfProduct'];?> </span>	</div>
    <div class="span2 fluid_span"><?php echo Yii::t('productreports','column_totalcustomers')?><span> <?php echo $data['productOrderedCustomers'] ;?>  </span>	</div>
        <div class="span2 fluid_span"><?php echo Yii::t('productreports','column_totalamount')?><span> <?php echo $data['productRevenue'];?></span></div><?php }?>
        
    </div> 

    <?php
    $form = $this->beginWidget('CActiveForm', array('method'=>'get',
        'id' => 'gridForm',
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php $this->renderPartial('_search',array('model'=>$model,'form'=>$form)); ?>	
    <div class="row-fluid grid-menus span12 pull-left ">
        <div class="span12">
            <div class="span10 buttons_top">
            </div>
            <div class="span2 dropdown_cut_main pull-right">
                <div class="span7 pull-right">
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12 top_box_margin">
        <?php
        $this->widget('bootstrap.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered condensed',
            'template' => "{summary}{pager}{items}",
            'summaryText' => 'Displaying {start}-{end} of {count} Results.',
            'enablePagination' => true,
            'pager' => array('class' => 'CListPager', 'header' => '&nbsp;Page', 'id' => 'no-widthdesign_left'),
            'ajaxUpdate' => false,
            'id' => 'productinfo-grid',
            'dataProvider' => $model->productReport(),
            //'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'S.No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
				

	
                array('name' => 'customer', 'header' => Yii::t('productreports','column_customer'), 'value' => '$data[customer]'),
                array('name' => 'email_address', 'header' => Yii::t('productreports','column_email'), 'value' => '$data[email_address]'),
                array('name' => 'quantity', 'header' => Yii::t('productreports','column_sold'), 'value' => '$data[quantity]'),
				array('name' => 'total', 'header' => Yii::t('productreports','column_amount'), 'value' => array($this,'grid')),
                array('name' => 'orders', 'header' => Yii::t('productreports','column_orders'), 'value' => '$data[orders]'),
             ),
        ));
        ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="clearfix"></div>	