<section id="bottom" >
    <div class="main-footer-1 top-footer">
        <div class="container">
            <div class="col-md-4"> </div>
            <div class="col-md-4">
                <div class="row col-md-12 sp-os">
                    <div class="module-main-div">
                        <div class="cms-menu-links  top-nav">
                            <div class="module-content">
                                <div class="module-main-div">
                                    <?php
                                    $this->widget('zii.widgets.CMenu',
                                            array(
                                            'htmlOptions' => array('class' => 'nav navbar-nav top-nav'),
                                            'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                                            'itemCssClass' => 'item-test',
                                            'encodeLabel' => false,
                                            'items' => array(
                                            array('label' => Yii::t('common','text_termsofservice'),'url' => $this->createUrl('page/content',array('id_page'=>13))),
                                            array('label' => Yii::t('common','text_privacypolicy'),'url' =>$this->createUrl('page/content',array('id_page'=>12))),
                                            array('label' => Yii::t('common','text_refundpolicy'), 'url' => $this->createUrl('page/content',array('id_page'=>11))),
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
    <div class="main-footer-2 mid-footer ">
        <div class="container">
            <div class="row boxs-footer">
                <div class="col-md-3 box-footer">
                    <div class="row col-md-12 sp-os">
                        <div class="module-main-div">
                            <div class="content-module-wapper">
                                <div class="heading-box"><h2>About us</h2></div>
                                <div class="module-content">
                                    <div class="content-module">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lortem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 box-footer">
                    <div class="row col-md-12 sp-os">
                        <div class="module-main-div">
                            <div class="follow-us-module-wapper">
                                <div class="heading-box"><h2><?php echo Yii::t('common','text_followus')?></h2></div>
                                <div class="module-content">
                                    <div class="follow-module">
                                        <div class="icon pull-left"><a href="" target="_blank" class="glyphicon spo-icon footer-icon glyphicon-fb-icon" ></a></div>
                                        <div class="icon pull-left"><a href="" target="_blank" class="glyphicon spo-icon footer-icon glyphicon-tw-icon" ></a></div>
                                        <div class="icon pull-left"><a href="" target="_blank" class="glyphicon spo-icon footer-icon glyphicon-v-icon" ></a></div>
                                        <div class="icon pull-left"><a href="" target="_blank" class="glyphicon spo-icon footer-icon glyphicon-yu-icon" ></a></div>
                                        <div class="icon pull-left"><a href="" target="_blank" class="glyphicon spo-icon footer-icon glyphicon-p-icon" ></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12 sp-os">
                        <div class="module-main-div">
                            <div class="icons-list-wapper">
                                <div class="module-content">
                                    <div class="icon-list-main-div">
                                        <div class="shipping-icon"><span class="glyphicon spo-icon icon-list-icon glyphicon-free-shipping-icon" ></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 box-footer">
                    <div class="row col-md-12 sp-os">
                        <div class="module-main-div">
                            <div class="payment-us-module-wapper">
                                <div class="heading-box"><h2><?php echo Yii::t('common','text_payment')?></h2></div>
                                <div class="module-content">
                                    <div class="payment-module">
                                        <a href="" target="_blank" class="glyphicon spo-icon payment-icon glyphicon-pay-icon" ></a>
                                        <a href="" target="_blank" class="glyphicon spo-icon payment-icon glyphicon-ans-icon"></a>
                                        <a href="" target="_blank" class="glyphicon spo-icon payment-icon glyphicon-visa-icon"></a>
                                        <a href="" target="_blank" class="glyphicon spo-icon payment-icon glyphicon-miscard-icon"></a>
                                        <a href="" target="_blank" class="glyphicon spo-icon payment-icon glyphicon-net-bank-icon"></a>
                                        <a href="" target="_blank" class="glyphicon spo-icon payment-icon glyphicon-cash-and-icon"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 box-footer">
                    <div class="row col-md-12 sp-os">
                        <div class="module-main-div">
                            <div class="contact-box">
                                <div class="heading-box"><h2><?php echo Yii::t('common','text_contact')?></h2></div>
                                <div class="module-content">
                                    <div class="contact-module">
										<p> <?php echo Yii::app()->config->getData('CONFIG_STORE_ADDRESS'); ?></p>
                                        <p><span class="glyphicon glyphicon-earphone"></span> <?php echo Yii::app()->config->getData('CONFIG_STORE_TELEPHONE_NUMBER'); ?></p>
                                        <p><span class="glyphicon glyphicon-envelope"></span> <?php echo Yii::app()->config->getData('CONFIG_STORE_SUPPORT_EMAIL_ADDRESS'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /bottom-->

<footer>
    <div class="footer">
        <div class="container">
            <div class="row copyright_div">
                <p class="pull-left copyright">&copy; <?php echo Yii::app()->config->getData('CONFIG_WEBSITE_COPYRIGHTS'); ?></p>
                <p class=" pull-right col-md-2"> <a href="" class="poweed_by_main"><?php echo Yii::t('common','text_poweredby');?> <i class="glyphicon spo-icon poweed_by_main-iconn"></i></a> </p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>