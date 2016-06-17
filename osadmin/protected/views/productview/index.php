

<div class="span12 top_box_fixed">
    <?php
    $this->widget('ext.Flashmessage.Flashmessage');    ?> 
    <?php
    $form = $this->beginWidget('CActiveForm',
            array(
        'id' => 'gridForm',
        'enableAjaxValidation' => false,
    ));
    ?>
  <div class="row-fluid grid-menus span12 pull-left ">
        <div class="span12">
            <div class="span10 buttons_top">
            <div class="btn-group pull-left">
  <button class="btn">Product Views Chart </button>
  <button class="btn dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
  </button>
  <div class="dropdown-menu chart-chart">

            
           
           <div class="product-grahs-div">  
             <?php
$chartData=array();
foreach($model->productViewsReport()->getData() as $info)
{
    $chartData[]=array($info->name,(int)$info->viewed);
}

$this->widget('bootstrap.widgets.TbHighCharts',array(
'options' => array(
 'title' => array(
'text' => Yii::t('productviews','lable_chart'),
),
	'series' => array(array(
    'type'=>'pie',
    'data'=>$chartData,
))
        )
)); ?>
</div>
</div>
</div>
             
            </div>

            <div class="span2 dropdown_cut_main pull-right">
                <div class="span7 pull-right">
					<?php Library::getPageList(array('totalItemCount' => $model->productViewsReport()->totalItemCount)); ?>
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
            'dataProvider' => $model->productViewsReport(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'S.No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
                array('name' => 'name', 'header'=>Yii::t('productviews','column_name'), 'value' => '$data->name'),
                array('name' => 'viewed', 'header'=>Yii::t('productviews','column_viewed'), 'value' => '$data->viewed','filter'=>false),
                array('name' => 'quantity', 'header'=>Yii::t('productviews','column_quantity'), 'value' => '$data->quantity','filter'=>false),
                array('name' => 'sold', 'header'=>Yii::t('productviews','column_sold'), 'value' => '$data->sold','filter'=>false),
                array('name' => 'percent', 'header'=>Yii::t('productviews','column_percent'), 'value' => array($this,'grid'),'filter'=>false)    
            ),
        ));
        ?>
<?php $this->endWidget(); ?>
    </div>
</div>
<div class="clearfix"></div>	
