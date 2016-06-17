<?php //echo '<pre>';print_r($data);echo '</pre>';?>
<div class="left-block " id="left-<?php echo $_POST['loop_id'] ?>">
    <div class="product-image-container <?php if ($_POST['product_style_type'] != 'list') { ?>col-md-3<?php } ?>" id="three-<?php echo $_POST['loop_id'] ?>">
        <a href="<?php echo $this->createUrl('product/productdetails',array('product_id'=>$data['product']['product_id'])); ?>">
            <img src="<?php echo $data['product']['image']; ?>" alt="<?php echo $data['product']['full_name']; ?>" class="col-md-12 "></a>
        <div class="clearfix"></div>
        <div class="box-white-quck-lable"> 
        <?php $this->widget('bootstrap.widgets.TbButton',
        array('label' => Yii::t('common', 'button_quickview'), 'type' => '', 'htmlOptions' => array(
        'data-toggle' => 'modal', 'data-target' => '#myModal', 'onclick' => 'quickView(' . $data['product']['product_id'] . ')'),)); ?>
        </div>	
    </div>
</div>
<div class="right-block <?php if ($_POST['product_style_type'] == 'grid') { ?>col-md-6<?php } ?>" id="six-<?php echo $_POST['loop_id'] ?>">
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array('heading' => $data['product']['name'], 'htmlOptions' => array('class' => 'product-del-box'),)); ?>
    <div class="show-div delct-div-mian"><p><?php echo $data['products']['discription'] ?></p>  </div>
            <?php if (Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS') == 1) { ?>
        <p class="rating-div"><img src="<?php echo Yii::app()->params['config']['site_url'] . 'images/' . $data['products']['rating'] . "-star.png"; ?>"/></p>
        <?php } ?>
    <?php  if ($data['product']['quantity'] <= 0) {?>
       <div class="stock-main-div">
           <span class="stock-div">
               <span class="label label-danger"><?php echo $data['product']['stock_status']; ?></span>
           </span> 
       </div>
   <?php } ?>

<?php $this->endWidget(); ?>
</div>
<?php if ($data['product']['price']) { ?>
<div class="right-main-div <?php if ($_POST['product_style_type'] == 'grid') { ?>col-md-3<?php } ?>" id="threea-<?php echo $_POST['loop_id'] ?>">
    <p class="price-div">
<?php 
                                                if($data['product']['special']){?>
                                            <span class="price-new"><i class="icon icon-inr"></i> <?php echo $data['product']['special']; ?></span> 
                                            <span class="price-old"><i class="icon icon-inr"></i> <?php echo $data['product']['price']; ?></span> 
                                                <?php }else{ ?>
                                            <span class="price-new"><i class="icon icon-inr"></i> <?php echo $data['product']['price']; ?></span> 
                                            <?php } ?>
                                            <?php foreach($data['product']['special_prices'] as $special){?>
                                            <span class="price-offer"><?php echo $special['label'];?></span><?php }?>
                                            
    </p>
    <div class="addtocart-div"><?php $this->widget('bootstrap.widgets.TbButton',
        array('type' => 'inverse', 'size' => 'large', 'label' => Yii::t('common','button_cart'), 'htmlOptions' => 
            array('class' => 'addtocart', 'onclick' => 'addToCart(\'' . $data['product']['product_id'] . '\')'),)); ?></div> 
    <div class="main-review-div"> 
        <span class="write-a-review"> <span class="glyphicon glyphicon-pencil"></span> 
            <a style="cursor:pointer;" onclick="return addToCompare('<?php echo $data['product']['product_id']; ?>')";>
                <?php echo Yii::t('common','button_compare') ?></a>
        </span> 
        <span class="add-to-my-wishlist"> <span class="glyphicon glyphicon-heart"></span> 
            <a style="cursor:pointer;" onclick="return addToWishList('<?php echo $data['product']['product_id']; ?>')";>
                <?php echo Yii::t('common','button_wishlist') ?></a>
        </span>
    </div>
</div><?php }?>
<div class="clearfix"></div>