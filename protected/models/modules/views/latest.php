<?php if(sizeof($data['products'])){?>

 <script>
 $(document).ready(function(){
 $('#demo5').scrollbox({direction: 'h',distance: 134});
$('#demo5-backward').click(function () {$('#demo5').trigger('backward');});
$('#demo5-forward').click(function () { $('#demo5').trigger('forward'); });
});</script>

 
 <?php //echo '<pre>';print_r($data['products']);echo '</pre>';?>
	<div class="row col-md-12 sp-os">
        <div class="module-main-div">
            <div class="product-module-wapper">
            <div class="heading-box"><h2><?php echo Yii::t('modules','heading_title_latest')?></h2></div>
           	<div class="module-content">
                <div class="product-latest-module">
               	  <div id="demo5" class="scroll-img">
                    <ul id="block-new-div" class="products-main-container" style="width:<?php echo (count($data['products'])*25)."%;"?>">
                    	 <?php $i=0;foreach($data['products'] as $product){ ?>
                    	<li class="col-md-<?php echo $data['info']['box_size'];?> product-main-container" id="cn-width-<?php echo $i?>"> <!--product-main-container start-->
                            <div class="product-container">
                                <div class="left-block">
                                  <div class="product-image-container">
                                <a href="<?php echo $this->createUrl("product/productdetails",array("product_id"=>$product['id_product']))?>" title="<?php echo  $product['full_name'];?>" ><img src="<?php echo $product['image'];?>"  alt="<?php echo  $product['full_name'];?>" /></a>
                                   <?php /*?><div class="new-product-lable"> <!--new-product-lable start--> <span class="new-div-wapper label label-inverse"><?php echo Yii::t('module_featured','text_new')?></span><!--new-product-lable end--> </div><?php */?>
                                   <?php if($product[special]>=1){?>
								   <div class="offer-product-lable">  <!--offer-product-lable start--> <span class="offer-div-wapper label label-inverse"><?php echo Yii::t('common','text_flat',array('{flat}'=>$product['flat']))?> </span> <!--offer-product-lable end--></div>
								   <?php } ?>
                                   <div class="box-white-quck-lable"> <!--box-white-quck-lable start-->
                                <!--<span><a href="">Quick View</a></span>-->
                                <?php $this->widget('bootstrap.widgets.TbButton', array('label' =>Yii::t('common','button_quickview'),'type' => '','htmlOptions' => array('data-toggle' => 'modal', 'data-target' => '#myModal','onclick'=>'quickView('.$product['id_product'].')' ),));?>
                                 <!--box-white-quck-lable start-->   </div>
                                   
                                  </div>
                                    </div>
                               
                               <div class="right-block">
                               
                               <a href="<?php echo $this->createUrl("product/productdetails",array("product_id"=>$product['id_product']))?>"><?php $this->beginWidget( 'bootstrap.widgets.TbHeroUnit', array('heading' => $product['name'], 'htmlOptions'=>array('class'=>'product-del-box'), )); ?></a>
								
								 <!--<p class="price-div">
								 <?php if($product[special]>=1){?>
								 <span class="price-new"><i class="icon icon-inr"></i> <?php echo Yii::app()->currency->format($product['special']);?></span> <span class="price-old"><i class="icon icon-inr"></i> <?php echo $product['price'];?></span> 
								 <?php }else{?>
								 <span class="price-new"><i class="icon icon-inr"></i> <?php echo Yii::app()->currency->format($product['price']);?></span> 
								 <?php } ?>
								 </p>-->
								 <?php if ($product['price']) {?>
								  <p class="price-div">
                                            <?php  
                                                if($product['special']){?>
                                            <span class="price-new"><i class="icon icon-inr"></i> <?php echo $product['special']; ?></span> 
                                            <span class="price-old"><i class="icon icon-inr"></i> <?php echo $product['price']; ?></span> 
                                                <?php }else{ ?>
                                            <span class="price-new"><i class="icon icon-inr"></i> <?php echo $product['price']; ?></span> 
                                            <?php } ?>
                                            
                                        </p>
								  <?php foreach($product['special_prices'] as $special){?>
                                            <br /><span class="price-offer"><?php echo $special['label'];?></span><?php }?>
								
								<?php  if ($product['quantity'] <= 0 && !Yii::app()->config->getData('CONFIG_STORE_ALLOW_CHECKOUT')) {?>
                                            <div class="stock-main-div">
                                                <span class="stock-div">
                                                    <span class="label label-danger"><?php echo $product['stock_status']; ?></span>
                                                </span> 
                                            </div>
                                        <?php } ?>								
                                <div class="addtocart-div"><?php $this->widget('bootstrap.widgets.TbButton', array(
								'visible'=>(($product['quantity']<=0) && !(Yii::app()->config->getData('CONFIG_STORE_ALLOW_CHECKOUT')))?false:true,
								'type' => 'inverse','size' => 'large', 'label' =>Yii::t('common','button_cart'), 'htmlOptions'=>array('class'=>'addtocart','onclick'=>'addToCart(\''.$product['id_product'].'\')'), )); ?></div> 
                            
							<?php if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1){?>
								<p class="rating-div"><img src="<?php echo Yii::app()->params['config']['site_url'].'images/'.$product['rating']."-star.png";?>"/></p>
							<?php } ?><?php } ?><?php $this->endWidget(); ?>
                            
                               </div>
                               <div class="clearfix"></div>
                               </div>
                        
                        <!--product-main-container end--></li>
                    
                    <? $i++;}?>
                    
                    </ul>
                     <div class="clearfix"></div>
                </div>
                </div><div class="clearfix"></div></div>
          
                <div id="demo5-btn" class="text-center">
      <button class="btn btn-inverse" id="demo5-backward"><i class="glyphicon glyphicon-chevron-left"></i></button>
      <button class="btn btn-inverse" id="demo5-forward"><i class="glyphicon glyphicon-chevron-right"></i></button>
    </div>
            </div>
        <div class="clearfix"></div>
        </div>
	<div class="clearfix"></div>
	</div>
     <div class="clearfix"></div>
	 <?php }?>