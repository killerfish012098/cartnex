
  <div class="center-wrapper Categories-inner-pages"> 

<div class="heading-main">
<div class="heading-box"><h2><?php echo Yii::t('product','heading_title_brand');?></h2></div>
<div class="pull-right design-main"><span class="pag-vag"><?php echo Yii::t('product','text_total_brands',array('{count}'=>$data['total_brands']));?></span>
</div>   
</div>


<div class="brands-name"> 

<div class="names-on-brands" >
<?php foreach ($data['categories'] as $key=>$value):?>
<span class="names-itam"> <a href="#<?php echo $key?>"><?php echo $key?></a></span>
<?php endforeach;?>
</div>
<?php foreach ($data['categories'] as $key=>$value):?>
<div class="names-on-numbers">
<div class="col-md-1 brends-tital-divs" id="<?php echo $key?>"><?php echo $key?></div>
<div class="col-md-11">
<ul class="brands-div-main">
<?php foreach ($value['manufacturer'] as $brand):?>
<li class="col-md-3"><a href="<?php echo $brand['href']?>" target="_blank"><?php echo $brand['name']?></a></li>
<?php endforeach;?>
<div class="clearfix"></div>
</ul>
</div>
<div class="clearfix"></div>
</div>
<?php endforeach;?>



</div>



<input type="hidden"  id="loop-id" value="<?php echo $i?>" />
<input type="hidden" id="product-style-type" value="<?php echo Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_PRODUCT_LIST_VIEW')?>"/>
<div class="clearfix"></div>
</div><div class="clearfix"></div>

<div class="fliter-bar-div row">

<div class="col-md-6 navgasan-bar pull-left clinkPagerCss">
<?php
    $this->widget('CLinkPager', array(
         'pages' => $pages,   
		 'header' =>'',       
		 'firstPageLabel' => '&lt;&lt;',
		 'lastPageLabel' => '&gt;&gt;',         
		 'nextPageLabel' => '&gt;',         
		 'prevPageLabel' => '&lt;',    
		 'maxButtonCount'=> '5' ,   
		 'selectedPageCssClass' => 'active',               
		 'htmlOptions' => array(             
		 						'class' => '',         
							)
    ))
    ?>
</div>

