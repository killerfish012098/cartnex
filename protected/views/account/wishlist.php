<div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">
        <div class="heading-box heading-product hero-unit"><h2><?php echo Yii::t('account', 'heading_title_wishlist') ?></h2></div>
        <div class="col-md-12">
            <div class="product-latest-module product-wishlist-box">
                <ul id="block-new-div" class="products-main-container">
                    <?php if (is_array($data['products'])) {
                        foreach ($data['products'] as $product) {?>
                            <li class="col-md-4 product-main-container" id="wishlist-list-<?php echo $product['product_id'] ?>">                                                          <div class="product-container">
                                    <div class="left-block">
                                        <div class="product-image-container">
                                            <a href="<?php echo $product['productDetailsLink']; ?>" target="_blank" title="<?php echo $product['name']; ?>"><img src="<?php echo $product['image']; ?>"/></a>
                                            <div class="close-div-main close" onclick="location='<?php echo $product[deleteLink];?>'"><i class="glyphicon glyphicon-remove"></i></div>
                                        </div>
                                    </div>
                                    <div class="right-block">
                                        <p class="price-div"><?php echo $product['name']; ?></p>
                                            <p class="price-div">
                                                <?php if($product['special']){?>
                                                    <span class="price-new"><?php echo $product['special']; ?></span><span class="price-old"><?php echo $product['price']; ?></span>
                                                <?php }else{?>
                                               <span class="price-new"><?php echo $product['price']; ?></span>
                                                <?php }?>
                                            </p>
                                        <div class="addtocart-div"><?php $this->widget('bootstrap.widgets.TbButton', array('type' => 'inverse', 'size' => 'large', 'label' => Yii::t('common', 'button_cart'), 'htmlOptions' => array('class' => 'addtocart', 'onclick' => 'addToCart(\'' . $product['product_id'] . '\')'),)); ?></div> 
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <!--product-main-container end--></li>
                        <?php }
                    } else { ?>
                        <li class="col-md-4 product-main-container"><?php echo Yii::t('common', 'text_no_products') ?></li>
<?php } ?>
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>
    </div>
</div>