
  <div class="center-wrapper Categories-inner-pages"> 
<div class="categorie-detiles">
<div class="heading-box "><h2><?php echo $data[catagorydetails][name]?></h2></div>

  <div class="col-md-3"><img src="<?php echo Yii::app()->image->resize($data[catagorydetails][image],Yii::app()->imageSize->categoryThumb[w],Yii::app()->imageSize->categoryThumb[h]);?>"  alt="<?php echo $data[catagorydetails][name]?>" title="<?php echo $data[catagorydetails][name]?>" /></div>
  
  <div class="col-md-9"><p><?php echo $data[catagorydetails][description]?></p></div>
   <div class="clearfix"></div>
  </div>
  

<div class="heading-main">
<div class="heading-box"><h2><?php echo $data['brand_name']?></h2></div>
<div class="pull-right design-main"><span class="pag-vag"><?php echo $data['dispaly_pagination'];?></span>
  <div class="display">
    <p class="icon-main" style="cursor:pointer;"><span class="glyphicon glyphicon-th-large"></span></p>  <p class="icon-main" style="cursor:pointer;"><span class="glyphicon glyphicon-align-justify"></span></p> </div></div>
    
</div>

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



</div>

<div class="categorie-products"> 

<div class="products-gridview">
<style type="text/css">
li:hover .product-list-lable{display:block;}
</style>
<ul id="block-new-div" class="products-main-container">
<?php 
if(count($data['products'])>0){
	$i=0;
foreach ($data['products'] as $product){?>
<li class="col-md-12 product-main-container" id="li-<?php echo $i?>"> <!--product-main-container start-->
<div class="categort-position">
<?php if(count($product['group_products'])>0){?>
<div class="product-list-lable" style="height:<?php echo Yii::app()->imageSize->productThumb[h]?>px;" id="product-list-<?php echo $i?>">
<a href="<?php echo $this->createUrl('product/productdetails',array('product_id'=>$product['product_id']));?>" onmouseenter="return getProductList('<?php echo $product['product_id']?>','<?php echo $product['product_id']?>','<?php echo $i?>')"><img src="<?php echo Yii::app()->image->resize($product['image'],Yii::app()->imageSize->productAdditional[w],Yii::app()->imageSize->productAdditional[h]);?>" alt="" class="col-md-12 "></a>
<?php foreach($product['group_products'] as $groupimage){?>
<a href="<?php echo $this->createUrl('product/productdetails',array('product_id'=>$groupimage['product_id']));?>" onmouseenter="return getProductList('<?php echo $groupimage['product_id']?>','<?php echo $product['product_id']?>','<?php echo $i?>')"><img src="<?php echo Yii::app()->image->resize($groupimage['image'],Yii::app()->imageSize->productAdditional[w],Yii::app()->imageSize->productAdditional[h]);?>" alt="" class="col-md-12 "></a>
<?php } ?>
</div>
<?php } ?>
<?php if(count($product['group_products'])>0){ ?>
<div class="product-container" style="position:relative" id="product-list-<?php echo $product['product_id']?>">

<?php } ?>


	<div class="left-block" id="left-<?php echo $i?>">
    <div class="product-image-container col-md-3" id="three-<?php echo $i?>">



   <a href="<?php echo $this->createUrl('product/productdetails',array('product_id'=>$product['product_id']));?>"><img src="<?php echo Yii::app()->image->resize($product['image'],Yii::app()->imageSize->productThumb[w],Yii::app()->imageSize->productThumb[h]);?>" alt="" class="col-md-12 "></a>
   
<div class="clearfix"></div>

    
     <div class="box-white-quck-lable"> <!--box-white-quck-lable start-->
<?php $this->widget('bootstrap.widgets.TbButton', array('label' => Yii::t()'Quick View','type' => '','htmlOptions' => array('data-toggle' => 'modal', 'data-target' => '#myModal','onclick'=>'quickView('.$product['product_id'].')' ),));?>
  <!--box-white-quck-lable start-->   </div>	
    </div>
  	 </div>
    
    <div class="right-block col-md-6" id="six-<?php echo $i?>">
 	<a href="<?php echo $this->createUrl('product/productdetails',array('product_id'=>$product['product_id']));?>"><?php $this->beginWidget( 'bootstrap.widgets.TbHeroUnit', array('heading' => $product['name'], 'htmlOptions'=>array('class'=>'product-del-box'), )); ?></a>
      
   <div class="show-div delct-div-mian"><p><?php echo $product['discription']?></p>  </div>
   <?php if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1){?>
  <p class="rating-div"><img src="<?php echo Yii::app()->params['config']['site_url'].'images/'.$product['rating']."-star.png";?>"/>   </p>
  <?php } ?>
   
    
   
    <div class="stock-main-div"><span class="stock-div">
        <?php if($product['quantity']>0){?>
        <span class="label label-success"><?php echo  Yii::t('product','text_instock')?></span> </span>  
        <?php }else{?>
        <span class="label label-success"><?php echo  Yii::t('product','text_outofstock')?></span> </span><?php echo  Yii::t('product','text_nill')?> 
        <?php } ?>
        </div>
        

 
 
<?php $this->endWidget(); ?>
    </div>
    <div class="right-main-div col-md-3" id="threea-<?php echo $i?>">
      <p class="price-div">
     <?php if($product[special_quantity]>=1){?>
     <span class="price-new"><i class="icon icon-inr"></i> <?php echo Yii::app()->currency->format($product['special']);?></span> <span class="price-old"><i class="icon icon-inr"></i> <?php echo $product['price'];?></span> <!--<span class="price-offer">30% off</span>-->
     <?php }else{?>
     <span class="price-new"><i class="icon icon-inr"></i> <?php echo Yii::app()->currency->format($product['price']);?></span> 
     <?php } ?>
     </p>
     <div class="addtocart-div"><?php $this->widget('bootstrap.widgets.TbButton', array('type' => 'inverse','size' => 'large', 'label' => Yii::t('common','button_cart'), 'htmlOptions'=>array('class'=>'addtocart','onclick'=>'addToCart(\''.$product['product_id'].'\')'), )); ?></div> 
     
    <div class="main-review-div"> 
    

	<span class="write-a-review"> <span class="glyphicon glyphicon-pencil"></span> <a style="cursor:pointer;" onclick="return addToCompare('<?php echo $product['product_id'];?>;?>')";><?php echo Yii::t('common','button_compare')?></a></span> <span class="add-to-my-wishlist"> <span class="glyphicon glyphicon-heart"></span> <a style="cursor:pointer;" onclick="return addToWishList('<?php echo $product['product_id'];?>')";><?php echo Yii::t('common','button_wishlist')?></a></span>
    </div>
    </div>
   </div>
    

<!--product-main-container end--></li>

<?php $i++;}}else{ ?>
<li class="col-md-4 product-main-container"><?php echo Yii::t('common','text_no_products')?></li>
<?php } ?>
<input type="hidden"  id="loop-id" value="<?php echo $i?>" />
<input type="hidden" id="product-style-type" value="<?php echo Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_PRODUCT_LIST_VIEW')?>"/>




 <div class="clearfix"></div>
</ul>
   
    <div class="clearfix"></div>
    </div>
</div><div class="clearfix"></div>
</div>
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



</div>
<div class="clearfix"></div>
  
  </div>


<script type="text/javascript">

function filters(filter,id){
	key = encodeURI(filter); value = encodeURI(id);

    var kvp = document.location.search.substr(1).split('&');

    var i=kvp.length; var x; while(i--) 
    {
        x = kvp[i].split('=');

        if (x[0]==key)
		{
			if(key=='priceranga'){
				x[1]=value;
			}else{
			x[1]=x[1].split(',');
		    index=x[1].indexOf(value);
			if(index>=0){
			x[1].splice(index, 1)
			}else{
				if(x[1]==''){
					x[1]=value;
				}else{
			      x[1] = x[1]+","+value;
				}
			}}
            kvp[i] = x.join('=');
            break;
        }
    }

    if(i<0) {kvp[kvp.length] = [key,value].join('=');}

    //this will reload the page, it's likely better to store this until finished
    document.location.search = kvp.join('&'); 
}
function priceRange(){
   filters("priceranga",$("#from").val()+","+$("#to").val());

}
</script>