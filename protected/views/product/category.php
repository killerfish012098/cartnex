<?php //echo '<pre>';print_r($data['products']);echo '</pre>'; ?>
<div class=" Categories-inner-pages"> 
    <div class="categorie-detiles">
        <div class="heading-box "><h2><?php echo $data[catagorydetails][name] ?></h2></div>
        <div class="col-md-2">
            <img src="<?php echo $data[catagorydetails][image]; ?>"  alt="<?php echo $data[catagorydetails][name] ?>" title="<?php echo $data[catagorydetails][name] ?>" />
        </div>
        <div class="col-md-9"><p><?php echo $data[catagorydetails][description] ?></p></div>
        <div class="clearfix"></div>
    </div>

    <div class="sub-categorie-detiles">
        <ul class="">
<?php foreach ($data['sub_categories'] as $category): ?>
    <li class="col-md-3 sub-catgor-list">
        <a href="<?php echo $category['href']; ?>" title="<?php echo $category['name']; ?>" > 
            <img src="<?php echo $category['image']; ?>"  alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" /> 
        </a>
        <div class="heading-sub-cate-name"><a href="<?php echo $category['href']; ?>" > <?php echo $category['name']; ?> </a></div>
    </li>
<?php endforeach; ?>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="heading-main">
        <div class="heading-box"><h2><?php echo $data[catagorydetails][name] ?></h2></div>
        <div class="pull-right design-main"><span class="pag-vag"><?php echo $data['pagination_desc']; ?></span>
            <div class="display">
                <p class="icon-main" style="cursor:pointer;"><span class="glyphicon glyphicon-th-large"></span></p> 
                <p class="icon-main" style="cursor:pointer;"><span class="glyphicon glyphicon-align-justify"></span></p> 
            </div>
        </div>
    </div>

    <div class="fliter-bar-div row">
        <div class="col-md-6 navgasan-bar pull-left clinkPagerCss">
            <?php
            $this->widget('CLinkPager',
                    array(
                'pages' => $pages,
                'header' => '',
                'firstPageLabel' => '&lt;&lt;',
                'lastPageLabel' => '&gt;&gt;',
                'nextPageLabel' => '&gt;',
                'prevPageLabel' => '&lt;',
                'maxButtonCount' => '5',
                'selectedPageCssClass' => 'active',
                'htmlOptions' => array(
                    'class' => '',
                )
            ))
            ?>
        </div>

        <div class="col-md-6">
            <span class="pull-right col-md-6 sorts-by-div">
                <select class="pull-right form-control populatity-div" onchange="location = this.value;">
                    <?php foreach ($data['sorts'] as $sorts) { ?>
                        <option value="<?php echo $sorts[href]; ?>" <?php if ($sorts[value] == $data['sort'] . "-" . $data['order']) { ?> selected="selected"<?php } ?>)>
                            <?php echo $sorts[text]; ?>
                        </option>
                <?php } ?>
                </select>
            </span>
            <span class="pull-right col-md-3 text-right sort-by-div"><?php echo Yii::t('product', 'text_sortby'); ?></span>
        </div>
    </div>

    <div class="categorie-products"> 
        <div class="products-gridview">
            <ul id="block-new-div" class="products-main-container">
                <?php
                if (is_array($data['products'])) {
                    $i = 0;
                    foreach ($data['products'] as $product) { //echo '<pre>';print_r($product);echo '</pre>';?>
                        <li class="col-md-12 product-main-container" id="li-<?php echo $i ?>"> <!--product-main-container start-->
                            <div class="categort-position">
                                    <?php if (count($product['group']) > 0) { ?>
                                    <div class="product-list-lable" style="height:<?php echo Yii::app()->imageSize->productThumb[h] ?>px;"  id="product-list-<?php echo $i ?>">
                                            <?php foreach ($product['group'] as  $groupimage) {?>
                                            <a href="<?php  echo $this->createUrl("product/productdetails", array("product_id" => $groupimage['product_id'])) ?>"
                                               onmouseenter="return getProductList('<?php echo $groupimage['product_id'] ?>','<?php echo $product['product_id'] ?>','<?php echo $i ?>')">
                                                <img src="<?php echo $groupimage['image']?>"  class="col-md-12 "></a>
                                    <?php } ?>
                                    </div>
                                    <?php } ?>
                                    <?php if (count($product['group']) > 0) { ?>
                                    <div class="product-container" style="position:relative" id="product-list-<?php echo $product['product_id'] ?>">
                                    <?php } ?>
                                    <div class="left-block" >
                                        <div class="product-image-container col-md-3" id="three-<?php echo $i ?>">
                                            <a href="<?php echo $this->createUrl("product/productdetails",array("product_id" => $product['product_id']))?>">
                                                <img src="<?php echo $product['image'];?>" alt="<?php echo $product['full_name'];?>" class="col-md-12 ">
                                            </a>
                                            <div class="clearfix"></div>
                                            <div class="box-white-quck-lable">
                                                <?php
                                                $this->widget('bootstrap.widgets.TbButton',
                                                        array('label' => Yii::t('common',
                                                            'button_quickview'),
                                                    'type' => '',
                                                    'htmlOptions' => array('data-toggle' => 'modal',
                                                        'data-target' => '#myModal',
                                                        'onclick' => 'quickView(' . $product['product_id'] . ')'),));
                                                ?>
                                            </div>	
                                        </div>
                                    </div>
                                    <div class="right-block col-md-6" id="six-<?php echo $i ?>">
                                        <a href="<?php echo $this->createUrl("product/productdetails",array("product_id" => $product['product_id']))?>"><?php
                                               $this->beginWidget('bootstrap.widgets.TbHeroUnit',
                                                       array('heading' => $product['name'],
                                                   'htmlOptions' => array(
                                                       'class' => 'product-del-box'),));
                                               ?></a>
        <?php 
        if (Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS') == 1) { ?>
                                            <p class="rating-div"><img src="<?php echo Yii::app()->params['config']['site_url'] . 'images/' . $product['rating'] . "-star.png"; ?>"/></p>
                                        <?php } ?>
                                        <?php  if ($product['quantity'] <= 0 && !Yii::app()->config->getData('CONFIG_STORE_ALLOW_CHECKOUT')) {?>
                                            <div class="stock-main-div">
                                                <span class="stock-div">
                                                    <span class="label label-danger"><?php echo $product['stock_status']; ?></span>
                                                </span> 
                                            </div>
                                        <?php } ?>
                                    <?php $this->endWidget(); ?>
                                    </div>
									<?php if ($product['price']) {?>
                                    <div class="right-main-div col-md-3" id="threea-<?php echo $i ?>">
                                        <p class="price-div">
                                            <?php  
                                                if($product['special']){?>
                                            <span class="price-new"><i class="icon icon-inr"></i> <?php echo $product['special']; ?></span> 
                                            <span class="price-old"><i class="icon icon-inr"></i> <?php echo $product['price']; ?></span> 
                                                <?php }else{ ?>
                                            <span class="price-new"><i class="icon icon-inr"></i> <?php echo $product['price']; ?></span> 
                                            <?php } ?>
                                            
                                        </p>
                                       
                                        <div class="addtocart-div pull-right"><?php
                                            $this->widget('bootstrap.widgets.TbButton',
                                                    array(
											'visible'=>(($product['quantity']<=0) && !(Yii::app()->config->getData('CONFIG_STORE_ALLOW_CHECKOUT')))?false:true,
											'type' => 'inverse', 'size' => 'large',
                                                'label' => Yii::t('common',
                                                        'button_cart'), 'htmlOptions' => array(
                                                    'class' => 'addtocart',
                                                    'onclick' => 'addToCart(\'' . $product['product_id'] . '\')'),));
                                            ?></div> 
                                             <?php foreach($product['special_prices'] as $special){?>
                                            <br /><span class="price-offer"><?php echo $special['label'];?></span><?php }?>
                                            
                                        <div class="main-review-div"> 
                                            <span class="write-a-review col-md-6"> <span class="glyphicon glyphicon-pencil"></span> 
                                            <a style="cursor:pointer;" onclick="return addToCompare('<?php echo $product['product_id']; ?>')";>
                                                <?php echo Yii::t('common','button_compare') ?></a>
                                            </span> 
                                            <span class="add-to-my-wishlist col-md-6"> <span class="glyphicon glyphicon-heart"></span> <a style="cursor:pointer;"
                                             onclick="return addToWishList('<?php echo $product['product_id']; ?>')";><?php echo Yii::t('common','button_wishlist');?></a></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div><?php }?>
                                </div>

                                <div class="clearfix"></div>    
                                <!--product-main-container end--></li>

                            <?php
                        $i++;
                    }
                } else {?>
                    <li class="col-md-4 product-main-container"><?php echo Yii::t('common', 'text_no_products');?></li>
            <?php } ?>
                <input type="hidden"  id="loop-id" value="<?php echo $i ?>" />
                <input type="hidden" id="product-style-type" value="<?php echo Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_PRODUCT_LIST_VIEW') ?>"/>
                   <div class="clearfix"></div>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="fliter-bar-div row bottom-div-fliter">
        <div class="col-md-6 navgasan-bar pull-left clinkPagerCss">
            <?php
            $this->widget('CLinkPager',
                    array(
                'pages' => $pages,
                'header' => '',
                'firstPageLabel' => '&lt;&lt;',
                'lastPageLabel' => '&gt;&gt;',
                'nextPageLabel' => '&gt;',
                'prevPageLabel' => '&lt;',
                'maxButtonCount' => '5',
                'selectedPageCssClass' => 'active',
                'htmlOptions' => array('class' => '',)
            ))
            ?>
        </div>
        <div class="col-md-6">
            <span class="pull-right col-md-6 sorts-by-div">
                <select class="pull-right form-control populatity-div" onchange="location = this.value;">
                    <?php foreach ($data['sorts'] as $sorts) { ?>
                     <option value="<?php echo $sorts[href]; ?>" <?php if ($sorts[value] == $data['sort'] . "-" . $data['order']) { ?> selected="selected"<?php } ?>)>
                         <?php echo $sorts[text]; ?>
                     </option>
                    <?php } ?>
                </select></span>
            <span class="pull-right col-md-3 text-right sort-by-div"><?php echo Yii::t('product', 'text_sortby')?></span>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
 <script type="text/javascript">
 	if($.totalStorage('display')!=null)
	{
		display($.totalStorage('display'));
	}else
	{
		display($("#product-style-type").val());
	}
</script>
    