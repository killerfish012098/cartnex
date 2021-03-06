<div class="span12 top_box_fixed">
    <?php    $this->widget('ext.Flashmessage.Flashmessage');    ?> 
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
            <?php Library::addButton(array('label'=>Yii::t('common','button_insert'),'url'=> $this->createUrl('create')));  ?>
            <?php Library::buttonBulk(array('label'=>Yii::t('common','button_delete'),'permission'=>$this->deletePerm,'url'=> $this->createUrl($this->uniqueid . "/delete")));?>
            <?php Library::buttonBulk(array('label'=>'Approve Customers','permission'=>$this->editPerm,'type'=>'info','url'=> $this->createUrl($this->uniqueid . "/approve")));?>
            </div>
            <div class="span2 dropdown_cut_main pull-right">
                <div class="span7 pull-right">
                    <?php Library::getPageList(array('totalItemCount' => $model->search()->totalItemCount)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
<div class="span12 top_box_margin">

   
    
<?php

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	 'type'=>'striped bordered condensed',
	 'template'=>"{summary}{pager}<div>{items}</div>",
	 'summaryText'=>'Displaying {start}-{end} of {count} Results.',
	 'enablePagination' => true,
        'pager'=>array('class'=>'CListPager', 'header' => '&nbsp;Page',  'id' => 'no-widthdesign_left' ),
	'ajaxUpdate'=>false,
	'id'=>'productinfo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'bulkActions' => array(
                'actionButtons' => array(
                    
                        ),
					'checkBoxColumnConfig' => array(
                    'name' => 'id',
                    'id'=>'id',
                    'value'=>'$data->primaryKey',
                        ),
        ),
	'columns'=>array(
     array(
        'header'=>'S.No',
        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
      ),
                array('name'=>'firstname','header'=>Yii::t('customers','column_firstname'),'value'=>'$data->firstname'),
                array('name'=>'lastname','header'=>Yii::t('customers','column_lastname'),'value'=>'$data->lastname'),
                array('name'=>'email','header'=>Yii::t('customers','column_email'),'value'=>'$data->email'),
                array('name'=>'date_created','header'=>Yii::t('customers','column_date_created'),'value'=>'$data->date_created'),
				
				array('name'=>'status','header'=>Yii::t('customers','column_status'),
				'filter'=>CHtml::dropDownList('Customer[status]', $_GET['Customer']['status'],  
				array(''=>'All','1'=>'Enable','0'=>'Disable',)
				), 'value'=>'$data->status==1?"Enabled":"Disabled"'),
				
			
				
				array('name'=>'approved','header'=>Yii::t('customers','column_approved'),
				'filter'=>CHtml::dropDownList('Customer[approved]', $_GET['Customer']['approved'],  
				array(''=>'All','1'=>'Approved','0'=>'Un-Approved',)
				), 'value'=>'$data->approved==1?"Approved":"Un-Approved"'),

		array('class'=>'bootstrap.widgets.TbButtonColumn',
                    'htmlOptions'=>array('style'=>'min-width:50px;'),
                    'template'=>$this->gridPerm['template'],
                    'buttons'=>array('update'=>array('label'=>$this->gridPerm[buttons][update][label], 'url'=>'Yii::app()->createUrl(Yii::app()->controller->id."/update/",array("backurl"=>base64_encode(urldecode(Yii::app()->request->requestUri)),"id"=>$data->primaryKey))'),'delete'=>array('url'=>' Yii::app()->createUrl(Yii::app()->controller->id."/delete/",array("backurl"=>base64_encode(urldecode(Yii::app()->request->requestUri)),"id"=>$data->primaryKey))')),
        ),
	),
)); 
?>
    <input type="hidden" name="backurl" value="<?php echo base64_encode(urldecode(Yii::app()->request->requestUri));?>">
<?php $this->endWidget(); ?>
</div>
</div>

<div class="clearfix"></div>	
</div>
<div class="clearfix"></div>	
</div>