<?php
if ($data['total_qty']) {
    foreach ($data['products'] as $product) {?>
        <div class="product-dispaying">
            <div class="img-product">
                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"  title="<?php echo $product['name']; ?>" class="img-side-contet"/></a>
                <div class="col-md-8"><h5> <?php echo $product['name'] ?> <div>
        <?php foreach ($product['option'] as $option) { ?>
        - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
        <?php } ?>
      </div> X <?php echo $product['quantity'] ?></h5>
                    <div class="price-div"><?php echo $product['price']; ?> </div>
                </div>
            </div>
            <div class="close-div-main close" onclick="return removeFromCart('<?php echo $product['key'] ?>')"><i class="glyphicon glyphicon-remove-circle"></i></div>
        </div>
    <?php } ?>
    <div class="cart-prices">
        <?php foreach ($data['cart_rules']['cartRule'] as $rule): ?>
            <div class="cart-prices-line first-line">
                <span class="price cart_block_shipping_cost ajax_cart_shipping_cost pull-right">
                    <?php echo $rule['text']; ?>
                </span>
                <span>
                    <?php echo $rule['label']; ?>
                </span>
            </div>
        <?php endforeach; ?>

    </div>

    <p class="cart-buttons">
        <?php $this->widget('bootstrap.widgets.TbButton', array("url"=>$this->createUrl('checkout/checkout'),'type' => 'inverse', 'size' => 'large', 'label' => 'Checkout', 'htmlOptions' => array('class' => 'success full-width'),)); ?>
    </p>
    <?php
}else {
    echo "<div class='padding-msg'> Your shopping cart is empty!</div>";
}?>