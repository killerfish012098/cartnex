
<div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">

        <div class="heading-box heading-product hero-unit"><h2><?php echo Yii::t('product', 'heading_title_compare'); ?></h2></div>

        <div class="col-md-12">
        
            <?php if (count($data['products']) > 0) { ?>
                <table class="table compare_div_main">
                    <thead>
                        <tr>
                            <td valign="top" width="15%;"><strong><?php echo Yii::t('product', 'text_product'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td class="product-name-compare-div"><p><a href="<?php echo $this->createUrl('product/productdetails', array("product_id" => $products['product_id'])); ?>"><?php echo $products['full_name'] ?></a></p>
                            <?php if($products['rating']){ ?> <p class="rating-div"><span style="font-size:10px;"> <img src="<?php echo Yii::app()->params['config']['site_url'] . 'images/' . $products['rating'] . "-star.png"; ?>"/> (<?php echo $products['reviews'] ?><?php echo Yii::t('product', 'text_overall_rating'); ?>) </span>  </p> <?php }?>
                                    <a href="<?php echo $this->createUrl('product/removecompare', array('product_id' => $products['product_id'])); ?>"><p class="close compare-close">x</p></a> </td>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td valign="top"><strong><?php echo Yii::t('product', 'text_images'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><img src="<?php echo $products['image']; ?>" alt="<?php echo $products['name'] ?>"></td>
                            <?php } ?>
                        </tr>

                        <tr>
                            <td valign="top"><strong><?php echo Yii::t('product', 'text_description'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><span class="new-price"><?php echo $products['description'] ?></span></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td valign="top"><strong><?php echo Yii::t('product', 'text_price'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><p class="new-price"><?php echo $products['price']; ?></p></td>
                            <?php } ?>
                        </tr>

                        <tr>
                            <td valign="top"><strong><?php echo Yii::t('product', 'text_model'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><p><?php echo $products['model'] ?><?php echo Yii::t('product', 'text_manufacturer'); ?></p></td>
                            <?php } ?>
                        </tr>

                        <tr>
                            <td valign="top"><strong><?php echo Yii::t('product', 'text_brand'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><p><?php echo $products['manufacturer'] ?></p></td>
                            <?php } ?>
                        </tr>


                        <tr>
                            <td valign="top"><strong><?php echo Yii::t('product', 'text_avaiability'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><p><?php echo $products['quantity'] ?></p></td>
                            <?php } ?>
                        </tr>



                        <tr>
                            <td><strong><?php echo Yii::t('product', 'text_weight'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><p><?php echo round($products['weight'], 2) . " cm" ?></p></td>
                            <?php } ?>
                        </tr>

                        <tr>
                            <td><strong><?php echo Yii::t('product', 'text_dimentions'); ?></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><p><?php echo round($products['length'], 2) . " cm" ?> x <?php echo round($products['width'], 2) . " cm" ?> x <?php echo round($products['height'], 2) . " cm" ?></p></td>
                            <?php } ?>
                        </tr>


                        <?php foreach ($data['attribute_groups'] as $attribute_group) { ?>
                            <tr>
                                <td class="compare-attribute" colspan="<?php echo count($data['products']) + 1; ?>"><strong><?php echo $attribute_group['name']; ?></strong></td>
                            </tr>
                            <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
                                <tr>
                                    <td style="text-align:right;"><strong><?php echo $attribute['name']; ?></td>
                                    <?php foreach ($data['products'] as $product) {
                                        ?>
                                        <?php if (isset($data['products'][$product['product_id']]['attribute'][$key])) { ?></strong>
                                            <td ><?php echo $data['products'][$product['product_id']]['attribute'][$key]; ?></td>
                                        <?php } else { ?>
                                            <td></td>
                                        <?php } ?>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <tr>
                            <td><strong></strong></td>
                            <?php foreach ($data['products'] as $products) { ?>
                                <td><?php $this->widget('bootstrap.widgets.TbButton', array('type' => 'primary', 'size' => 'large', 'label' => Yii::t('common','button_cart'), 'htmlOptions' => array('class' => 'addtocart', 'href' => $this->createAbsoluteUrl('product/productdetails', array('product_id' => $products['product_id']))),)); ?> </td>
                            <?php } ?>
                        </tr>

                    </tbody>

                </table>
            <?php } else {
                echo "No Compare List found.";
            } ?>

        </div>

    </div>
    <div class="clearfix"></div>
</div>


