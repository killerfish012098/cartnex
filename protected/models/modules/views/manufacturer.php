<div class="module-main-div">
<div class="manufavturer-module-wapper">
       
<div class="heading-box"><h2><?php echo Yii::t('modules','heading_title_manufacturer')?></h2></div>

<div class="module-content">
	<?php 
	foreach($data[manufacturers] as $manufacturer)
	{
	?>
   <div class="manufavturer-banner col-md-2 ">
   <div class="sp-image">
   <a href="" target="_blank" title="<?php echo  $manufacturer['name'];?>" > <img src="<?php echo Yii::app()->image->resize($manufacturer['image'],Yii::app()->imageSize->productThumb[w],Yii::app()->imageSize->productThumb[h]);?>"  id="image"   alt="<?php echo $manufacturer['name']?>" /></a>
    </div>
   </div>
   <? }?>
   </div>       </div>
</div> <div class="clearfix"></div>