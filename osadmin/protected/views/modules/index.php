<?php $this->beginWidget('CActiveForm', array(
    'id'=>'gridForm',
    'enableAjaxValidation'=>false,
)); ?>
<div class="span12 top_box_fixed">
    <?php    $this->widget('ext.Flashmessage.Flashmessage');    ?> 
   
    <div class="row-fluid grid-menus span12 pull-left ">
        <div class="span12">
            <div class="span2 dropdown_cut_main pull-right">
                <div class="span7 pull-right">
                    <?php
                    /*if (min(Yii::app()->params['config_page_sizes']) < sizeof($dataProvider)):
                        echo 'List ' . CHtml::dropDownList('no-width','page',  
						Yii::app()->params['config_page_sizes'],
                                array('options' => array(Yii::app()->params['config_page_size'] => array(
                                    'selected' => true)), 'class' => 'no-bg-color',
                            'onchange' => "if(this.value!='')"
                            . " {"
                            . " href=window.location.href;    if(href.search('" . $this->uniqueid . "/index')=='-1'){url=href.replace('/page/" . Yii::app()->request->getParam('page',
                                    10) . "','')+'/index/page/'+this.value;}else { url=href.replace('/page/" . Yii::app()->request->getParam('page',
                                    10) . "','')+'/page/'+this.value;} window.location=url;}")
                        );
                    endif;*/
                    ?>
<?php Library::getPageList(array('totalItemCount' => $dataProvider->totalItemCount)); ?>

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
            'template' => "{summary}{pager}<div class='items_main_div span12'>{items}</div>",
            'summaryText' => 'Displaying {start}-{end} of {count} Results.',
            'enablePagination' => true,
            'pager' => array('class' => 'CListPager', 'header' => '&nbsp;Page', 'id' => 'no-widthdesign_left'),
            'ajaxUpdate' => false,
            'id' => 'productinfo-grid',
            'dataProvider' => $dataProvider,
            //'filter' => $model,
            'columns' => array(
                array(
                    'header' => 'S.No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                ),
		//array('name'=>'file','header'=>"Shipping Gateway",'value'=>'$data[file]','type'=>'raw',value=>array($this,'grid')),
                array('name'=>'title','header'=>"Title",'value'=>'$data[title]','type'=>'raw'),
                //array('name'=>'sort_order','header'=>"Sort Order",'value'=>'$data[sort_order]','type'=>'raw'),
                //array('name'=>'status','header'=>"Status",'value'=>'$data[status]','type'=>'raw','value'=>array($this,'grid')),
                array('name'=>'installed','header'=>"Action",'value'=>'$data[installed]','type'=>'raw','value'=>array($this,'grid')),
					
            ),
        ));
        ?>
        <input type="hidden" name="backurl" value="<?php echo base64_encode(urldecode(Yii::app()->request->requestUri)); ?>">

    </div>
</div>
<div class="clearfix"></div>	
<div class="clearfix"></div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
   /*$("#uninstall").click(function(event){
      alert('hell');
          $.post($(this).attr('href'),

          );
      });*/

jQuery(document).on('click','#uninstall',function() {
	if(!confirm('Are you sure you want to uninstall this item?')) return false;
	var th = this,
		afterDelete = function(){};
	jQuery('#productinfo-grid').yiiGridView('update', {
		type: 'POST',
		url: jQuery(this).attr('href'),
		data:{ 'YII_CSRF_TOKEN':$('input[name="YII_CSRF_TOKEN"]').val() },
		success: function(data) {
			jQuery('#productinfo-grid').yiiGridView('update');
			afterDelete(th, true, data);
		},
		error: function(XHR) {
			return afterDelete(th, false, XHR);
		}
	});
	return false;
});
</script>