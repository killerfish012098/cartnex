<div class="span12 top_box_fixed">
    <?php
    $this->widget('ext.Flashmessage.Flashmessage');
    ?> 
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
  <button class="btn">Search Keywords Chart </button>
  <button class="btn dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
  </button>
  <div class="dropdown-menu chart-chart">

            
           
           <div class="product-grahs-div">  
           <?php
$chartData=array();
foreach($model->report()->getData() as $info)
{
    $chartData[]=array($info->keyword,(int)$info->hits);
}

$this->widget('bootstrap.widgets.TbHighCharts',array(
'options' => array(
 'title' => array(
'text' => Yii::t('searchterms','lable_chart'),
),
	'series' => array(array(
    'type'=>'pie',
    'data'=>$chartData,
))
        )
));
?>
             
		</div>
	</div>
</div>
             
           
                <?php
                $this->widget(
                        'bootstrap.widgets.TbButton',
                        array(
                    'label' => 'Add Item',
                    'visible' => $this->addPerm,
                    'type' => 'info',
                    'icon' => 'icon-plus icon-white',
                    'url' => $this->createAbsoluteUrl('create')
                        )
                );
                ?>
                
                <?php
                $this->widget(
                        'bootstrap.widgets.TbButton',
                        array(
                    'label' => 'Print Invoice',
                    'visible' => $this->editPerm,
                    'type' => 'info',
                    'icon' => 'icon-plus icon-white',
                    'url' => $this->createAbsoluteUrl('create')
                        )
                );
                ?>

                <?php
                $this->widget(
                        'bootstrap.widgets.TbButton',
                        array(
                    'buttonType' => 'Submit',
                    'label' => 'Delete Item',
                    'visible' => $this->deletePerm,
                    'type' => 'danger',
                    //'color' => 'btn btn-infop',
                    'icon' => 'icon-remove icon-white',
                    'htmlOptions' => array('onclick' => 'var flag=validateGridCheckbox("id[]");
        if(flag)
        {
                document.getElementById("gridForm").method="post";
                document.getElementById("gridForm").action="' . $this->createUrl("delete") . '";
                document.getElementById("gridForm").submit();
        }'),
                        )
                );
                ?>

                
            </div>

            <div class="span2 dropdown_cut_main pull-right">
                <div class="span7 pull-right">
                <?php Library::getPageList(array('totalItemCount' => $model->report()->totalItemCount)); ?>
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
            //'type'=>'striped',
            'template' => "{summary}{pager}{items}",
            'summaryText' => 'Displaying {start}-{end} of {count} Results.',
            'enablePagination' => true,
            'pager' => array('class' => 'CListPager', 'header' => '&nbsp;Page', 'id' => 'no-widthdesign_left'),
            'ajaxUpdate' => false,
            'id' => 'productinfo-grid',
            'dataProvider' => $model->report(),
            'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'S.No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
				array('name'=>'keyword','header'=>Yii::t('searchterms','column_keyword'),'value'=>'$data->keyword'),
				array('name'=>'hits','header'=>Yii::t('searchterms','column_hits'),'value'=>'$data->hits'),
				array('name'=>'percent','header'=>Yii::t('searchterms','column_percent'),'value'=>array($this,'grid'),'filter'=>false),
            ),
        ));
        ?>
        <input type="hidden" name="backurl" value="<?php echo base64_encode(urldecode(Yii::app()->request->requestUri)); ?>">
<?php $this->endWidget(); ?>
    </div>
</div>


	
