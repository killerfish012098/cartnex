<?php
/*echo '<pre>';
print_r($model->customerOrderTotalReport()->getData());
echo '</pre>';*/?>
<div class="span12 top_box_fixed">
    <?php
    $this->widget('ext.Flashmessage.Flashmessage');
    ?> 
    <?php
    $form = $this->beginWidget('CActiveForm',
            array(
        'method'=>'get',        
        'id' => 'gridForm',
        'enableAjaxValidation' => false,
    ));
    ?>
	<?php $this->renderPartial('_search',array('model'=>$model,'form'=>$form)); ?>	
    <div class="row-fluid grid-menus span12 pull-left ">
        <div class="span12">
            <div class="span10 buttons_top">
            <div class="btn-group pull-left">
  <button class="btn"> Customers orders Chart </button>
  <button class="btn dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
  </button>
  <div class="dropdown-menu chart-chart">

            
           
           <div class="product-grahs-div">  
           <?php
$chartData=array();
foreach($model->customerOrderTotalReport()->getData() as $info)
{
    $chartData[]=array($info['customer'],(int)$info['orders']);
}

//echo '<pre>';print_r($model->customerOrderTotalReport()->getData());print_r($chartData);echo '</pre>';
$this->widget('bootstrap.widgets.TbHighCharts',array(
'options' => array(
 'title' => array(
'text' => Yii::t('customerordertotal','entry_lable_chart'),
),
	'series' => array(array(
    'type'=>'pie',
    'data'=>$chartData,
))
        )
));?>

</div>
</div>
</div>
            
            </div>

            <div class="span2 dropdown_cut_main pull-right">
                <div class="span7 pull-right">
                   <?php Library::getPageList(array('totalItemCount' => $model->customerOrderTotalReport()->totalItemCount)); ?>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12 top_box_margin">
        <?php
        $this->widget('bootstrap.widgets.TbExtendedGridView',
                array(
            'type' => 'striped bordered condensed',
            'template' => "{summary}{pager}{items}",
            'summaryText' => 'Displaying {start}-{end} of {count} Results.',
            'enablePagination' => true,
            'pager' => array('class' => 'CListPager', 'header' => '&nbsp;Page', 'id' => 'no-widthdesign_left'),
            'ajaxUpdate' => false,
            'id' => 'productinfo-grid',
            'dataProvider' => $model->customerOrderTotalReport(),
            //'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'S.No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),

                array('name' => 'customer', 'header'=>Yii::t('customerordertotal','column_customer'), 'value' => '$data[customer]'),
                array('name' => 'customer_group', 'header'=>Yii::t('customerordertotal','column_customer_group'),'value' => '$data[customer_group]'),
                array('name' => 'email', 'header'=>Yii::t('customerordertotal','column_email'), 'value' => '$data[email]'),
                // array('name'=>'status','header'=>Yii::t('customerordertotal','column_status'),'value'=>'$data[status]'),
                array('name' => 'orders','header'=>Yii::t('customerordertotal','column_orders'), 'value' => '$data[orders]'),
                array('name' => 'products', 'header'=>Yii::t('customerordertotal','column_products'), 'value' => '$data[products]'),
                array('name' => 'total', 'header'=>Yii::t('customerordertotal','column_total'), 'value' =>array($this,'grid')),//'$data[total]'),
            ),
        ));
        ?>
<?php $this->endWidget(); ?>
    </div>
</div>

<div class="clearfix"></div>	
