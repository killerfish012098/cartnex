<!-- <?php //echo $baseUrl = Yii::app()->baseUrl.'/protected/extensions/bootstrap/assets/bootstrap/css/bootstrap.min.css';  ?> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl = Yii::app()->baseUrl.'/css/bootstrap.min.css';  ?>" /> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl = Yii::app()->baseUrl.'/protected/extensions/bootstrap/assets/bootstrap/css/bootstrap.min.css';  ?>" /> -->
<section class="top-header">
    <div class="container">
        <div class="row header_top">
            <div class="col-md-4 navbar-div">
<?php

$this->widget('zii.widgets.CMenu',
		array('htmlOptions' => array('class' => 'nav navbar-nav left-div-main'),
	'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
	'itemCssClass' => 'item-test', 'encodeLabel' => false, 'items' => array(
		array('label' => $this->global['text_welcome'], 'url' => $this->global['url_welcome'],
			'visible' => true, 'linkOptions' => array(
				"data-description" => "member area")),
	),
));
?>         <div class="clearfix" ></div>
            </div>
            <div class="col-md-5">
                <div class="row col-md-12 sp-os">
                    <div class="module-main-div">
                        <div class="module-content">
                            <div class="order-main-div">
                                <span class="glyphicon glyphicon-shopping-cart"></span><?php echo Yii::t('common','text_order')?><span class="glyphicon glyphicon-arrow-right"></span><span class="glyphicon spo-icon glyphicon-shopping-paym"></span><?php echo Yii::t('common','text_payment')?><span class="glyphicon glyphicon-arrow-right"></span> <span class="glyphicon spo-icon glyphicon-shopping-deliy"></span><?php echo Yii::t('common','text_delivery')?> 
                                <span class="glyphicon glyphicon-arrow-right"></span> <span class="glyphicon spo-icon glyphicon-shopping-closedel"></span><?php echo Yii::t('common','text_close_the_deal')?> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix" ></div>
            </div>
            <div class="col-md-3 pull-right top-nav">
                <!--/.social-icons -->
                <div class="social-icons clearfix">
                    <a href="#" class="glyphicon glyphicon-facebook" ></a>
                    <a href="#" class="glyphicon glyphicon-twiter" ></a>
                    <a href="#" class="glyphicon glyphicon-in" ></a>
                    <a href="#" class="glyphicon glyphicon-vimeo" ></a>
                    <!--/.social-icons -->
                </div>
                <div class="clearfix" ></div>
            </div>
        </div>
    </div>
</section>
<section class="top-1-main">
    <div class="container">
        <div class="row header-main">
            <div class="col-md-4 pull-left  top-nav">        
             <?php
             $this->widget('zii.widgets.CMenu',
	array('htmlOptions' => array('class' => 'nav navbar-nav login-cms-links'),
		'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
		'itemCssClass' => 'item-test', 'encodeLabel' => false, 'items' => array(
	array('label' => Yii::t('common', 'text_home'), 'url' => array('site/index')),
	array('label' => $this->global['text_login_logout'], 'url' =>$this->global['url_login_logout'], 'visible' => true,
		'linkOptions' => array("data-description" => "member area")),
	array('label' => Yii::t('common', 'text_register'), 'url' => array('account/register'),'visible' => Yii::app()->user->isGuest),
	array('label' => Yii::t('common', 'text_contact'), 'url' => array('page/contactus')),
),
));
                ?>
            </div>
            <div class="col-md-1 pull-right top-nav language-div">
                <div class="menu-top">
                    <?php $this->widget('ext.language.languages'); ?>
                </div>
            </div>
            <div class="col-md-1 pull-right top-nav currency-div">
                <?php
                $this->widget('ext.currencies.currencies');   ?>
            </div>
            <div class="col-md-3 pull-right top-nav">
                <?php
                $this->widget('zii.widgets.CMenu',
                        array('htmlOptions' => array('class' => 'nav navbar-nav accoutnt-div'),
                    'submenuHtmlOptions' => array(
                        'class' => 'dropdown-menu'),
                    'itemCssClass' => 'item-test', 'encodeLabel' => false, 'items' => array(
                        array('label' => Yii::t('common', 'text_whishlist'), 'url' => array('account/wishlist')),
                        array('label' => Yii::t('common', 'text_account'), 'url' => array('account/index')),
                        array('label' => Yii::t('common', 'text_checkout'), 'url' => array('checkout/checkout')),
                        array('label' => Yii::t('common', 'text_cart'), 'url' => array('checkout/carts')),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</section>
<section class="header-main">
    <div class="container">
        <div class="row top_header_main">
            <div class="col-md-3 logo-div-main">
                <a href="<?php echo $this->createUrl('site'); ?>" title="<?php echo Yii::app()->config->getData('CONFIG_STORE_NAME'); ?>" >
                    <img src="<?php echo Library::getMiscUploadLink() . Yii::app()->config->getData('CONFIG_STORE_LOGO_IMAGE'); ?>" 
                         width="201" height="50" alt="<?php echo Yii::app()->config->getData('CONFIG_STORE_NAME'); ?>" /></a>
            </div><!--/.col-md-3 -->
            <div class="col-md-3 pull-right cart-maindiv">
                <div class="check-out-box-top text-right-align"><!--/.check-out header -->
                    <div class="btn-toolbar">
                        <div class="cart-info-mix-content">
    <ul id="cart_drop" >
        <li>
            <div id="view-cart">
                <div class="cart-main-show-cart" >
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                    <div class="cart-main-div" id="total_qty"><?php echo $this->global['text_cart_size']; ?></div>
                </div>
                <div class="price-div-cart"><div id="total_price" style="float:left;">
                    <?php echo $this->global['text_cart_total']; ?></div> 
                    <i class="glyphicon glyphicon-chevron-down"></i> </div>
            </div>
            <ul class="drop-don-div-main"><li>
                    <div id="inner-cart-list" class="inner-cart-lists" style="border:0px;"></div>
                </li>
            </ul>
        </li>
    </ul>
</div>
                    </div>
                    <!--/.check-out header --></div>
            </div>
            <div class="col-md-6 pull-right">
                <div class="search_bar input-group"><!--/.search_bar header -->
                    <form action="<?php echo $this->createUrl("product/search") ?>" method="get">
                        <input type="text" name="q" id="q" value="<?php echo $_GET['q'] ?>" autocomplete="off" data-provide="typeahead" class="form-control">
						<input type="hidden" name="r" id="r" value="product/search" autocomplete="off" data-provide="typeahead" class="form-control">

                        <span class="input-group-btn">
                            <button class="btn btn-inverse" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </form>
                    <!--/.search_bar header --></div>
            </div>
        </div><!--/.row-fluid header -->
        <div class="clearfix"></div>
    </div>
</section>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal'));  ?>
<a class="close" data-dismiss="modal"></a><div id="desc" class="content-page"><?php echo $this->global['content'];?></div>
<?php $this->endWidget(); ?>