<div class="center-wrapper Categories-inner-pages"> 
    <div class="shopping-cart-main-div">
        <div class="heading-box heading-product hero-unit"><h2><?php echo Yii::t('checkout', 'text_shopping_cart') ?></h2></div>
        <div class="main-shopping-table"><?php if (is_array($data['product'])) { ?>
                <form method="post"  id="myForm">
                    <table class="table main-shopping-div" >
                        <thead><td width="5%;"><strong><?php echo Yii::t('checkout', 'text_remove') ?></strong></td>
                        <td width="12%"></td>
                        <td width="24%;" ><strong><?php echo Yii::t('checkout', 'text_item') ?></strong></td>
                        <td width="11%;" ><strong><?php echo Yii::t('checkout', 'text_model') ?></strong></td>
                        <td width="20%;" ><strong><?php echo Yii::t('checkout', 'text_quantity') ?></strong></td>
                        <td width="15%"> <strong><?php echo Yii::t('checkout', 'text_price') ?></strong></td>
                        <td  width="15%;"> <strong><?php echo Yii::t('checkout', 'text_subtotal') ?></strong></td>
                        </thead>

                        <tbody>
                            <?php foreach ($data['product'] as $product) { ?>

                                <tr id="product-<?php echo $product['id_product']; ?>" class="product-count <?php echo $product['stock']; ?>">
                                    <td>  <a style="cursor:pointer;" class="remove-div-cart" href="<?php echo $this->createUrl('checkout/carts', array('remove' => $product['key'])); ?>"> <i class="glyphicon glyphicon-trash"></i> </a> </td>
                                    <td><a href="<?php echo $this->createUrl('product/productdetails', array('product_id' => $product['id_product']));
                        ?>" ><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name'] ?>" title="<?php echo $product['name'] ?>"/> </a> </td>
                                    <td><strong><?php echo $product['full_name'] ?></strong><br />
                                           <?php
                                           if (count($product['option']) > 0):
                                               foreach ($product['option'] as $option):
                                                   ?>
                                                <span class="col-md-12"> - <?php echo $option[name] . " : " . $option[option_value]; ?></span> 
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                        <!--DELIVERY DETAILS SUBTOTAL--> </td>
                                    <td><?php echo $product['model'] ?></td>
                                    <td>
                                        <p>
                                            <input type="text" name="quantity[<?php echo $product['key']; ?>]" id="quantity" value="<?php echo $product['quantity'] ?>" class="ui-autocomplete-input" style="height:35px;" autocomplete="off"/>
                                            <input type="hidden" name="product_id[]" id="product_id" value="<?php echo $product['key']; ?>" class="ui-autocomplete-input" style="height:35px;" autocomplete="off"/>
                                            <a style="cursor:pointer;" class="btn btn-inverse" onclick="return submitForm()"><i class="glyphicon glyphicon-refresh"></i></a>
                                        </p>
                                    </td>
                                    <td><strong><?php echo $product['price'] ?></strong> </td>
                                    <td><h3><?php echo $product['total']; ?></h3></td>
                                </tr>
    <?php } ?>
                        </tbody>
                    </table>
                </form>

                <div class="table-instal">
                    <div class="col-md-12  bg-color-div ">
                        <div class="col-md-8 ">
                            <?php if($data['coupon_status']){?>
                                <div class="col-md-12 shopping-bg-commer left-cart-div">
                                    <form method="post" action="">
                                    <p><?php echo Yii::t('checkout', 'text_apply_discount')
    ?></p>
                                    <div class="row col-md-12">	
                                        <div class="col-md-8 news-letter-text">
                                            <input type="text" name="Apply_Discount_Code" placeholder="Enter Coupon Code" id="Apply_Discount_Code" class="form-control ui-autocomplete-input" autocomplete="off" value="<?php echo $data['coupon']; ?>"> 
                                            <div id="errorcoupon" class="errorMessage" style="display:none; position:relative; left:0px;"></div>
                                        </div>
                                        <div class="col-md-4"><input type="submit" value="Apply Coupon" class="btn btn-inverse btn-large" onclick="return checkCoupon();" /> </div>  
                                    </div>
                                    </form>
        </div><?php }?>
                            
                        </div>
                        <div class="col-md-4 shopping-bg-commer right-cart-div">
    <?php
    foreach ($data['cart_rules']['cartRule'] as $rule):
        echo "<div>" . $rule['label'] . "<strong>" . $rule['text'] . "</strong></div>";
    endforeach;
    ?>
                        </div>
                    </div>
                </div>
<?php }else { ?>
                <div><?php echo Yii::t('checkout', 'text_no_products_cart'); ?></div>
            <?php } ?>
        </div>
        <div class="shopping-cart-div">
            <div class="col-md-3 pull-left"> <span class="glyphicon glyphicon-circle-arrow-left"></span> <a href="<?php echo $this->createUrl("site/index"); ?>"><?php echo Yii::t('checkout', 'text_continue_shopping')
            ?></a> </div> 
            <?php if($data['product']){?>
            <div class="col-md-2 pull-right order-now-div"><a href="<?php echo $data['checkout']['href']; ?>" class="btn btn-inverse" ><?php echo Yii::t('checkout', 'text_order_now')
            ?> <i class="glyphicon glyphicon-circle-arrow-right"></i></a> </div>
            <?php }?>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
    function checkCoupon() {
        if ($("#Apply_Discount_Code").val() == '') {
            $("#errorcoupon").show().html("<?php echo Yii::t('checkout', 'text_enter_coupon');
            ?>");
            return false;
        }
    }
</script>
