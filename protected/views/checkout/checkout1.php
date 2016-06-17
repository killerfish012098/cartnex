
        <script>
            $(document).ready(function() {
                $(".billing-address-btn").click(function() {
                    $(".chackout-div-Billing").toggle();
                });


            });
        </script>
      

                <div class="Categories-inner-pages"> 

                    <div class="check_out_page">


                        <div class="tab-main-div">
                            <div class="tab-main col-md-3 actave "><a href="<?php echo $this->createUrl('checkout/checkout');?>" >Checkout options </a></div>
                            <div class="tab-main col-md-3 color-div "><a href="<?php echo $this->createUrl('checkout/billing');?>" > Billing & Shipping Info </a></div>
                            <div class="tab-main col-md-3 "><a href="<?php echo $this->createUrl('checkout/payment') ?>" > Shipping  & Payment </a></div>
                            <div class="tab-main col-md-3 "><a href="<?php echo $this->createUrl('checkout/order') ?>" > Confirm order </a></div>
                            <div class="clearfix" ></div>
                        </div>

                        <div class="checkout_options_div">

                            <div class=" checkout_main_div">

                                <div class="col-md-8 border-line-div">

                                    <form name="address" method="post" action="<?php echo $this->createUrl('checkout/ordermethod');?>">  
                                        <div id="guest_billing_form" class="col-md-6">
                                            <h4>Billing Info</h4>

                                            <h5 class="header-Existing-main">I want to use an Existing Address  </h5>

                                            <div class="col-md-12 row Existing-main-hide ">
                                                <?php foreach ($data['address'] as
                                                            $address) { ?> 
                                                    <div class="Billing-info-div">
                                                        <div class="col-md-1"><input type="radio" title="" name="billing_address" value="<?php echo $address['id_customer_address']; ?>"/></div>
                                                        <div class="col-md-10 design-box-mian pull-right">
                                                            <strong><?php echo $address[firstname] ?> <?php echo $address[lastname] ?></strong>
    <?php echo $address[address_1] ?> <?php echo $address[city] ?>, <?php echo $address[state] ?> - <?php echo $address[postcode] ?> Mobile: <?php echo $address[telephone] ?>
                                                        </div>
                                                        <div class="clearfix"></div>

                                                    </div>
<?php } ?>
                                            </div>

                                            <div class="clearfix"></div>

                                        </div>

                                        <div id="guest_shipping_form"  class="col-md-6">
                                            <h4>Shipping Info</h4>

                                            <h5 class="shipping-header-Existing-main ">I want to use an Existing Address  </h5>

                                            <div class="col-md-12 row shipping-Existing-main-hide ">

                                                <?php
                                                foreach ($data['address'] as
                                                            $address) {
                                                    ?> 
                                                    <div class="Billing-info-div">
                                                        <div class="col-md-1"><input type="radio" title="" name="shipping_address" value="<?php echo $address['id_customer_address']; ?>"/></div>
                                                        <div class="col-md-10 design-box-mian pull-right">
                                                            <strong><?php echo $address[firstname] ?> <?php echo $address[lastname] ?></strong> <?php echo $address[address_1] ?> 
    <?php echo $address[city] ?>, <?php echo $address['state'] ?> - <?php echo $address[postcode] ?>
                                                            Mobile: <?php echo $address[telephone] ?>
                                                        </div>
                                                        <div class="clearfix"></div>

                                                    </div>

<?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 right-divbtn">
                                         <div class="billing-main-btn pull-left">
                                        <a class="btn btn-inverse billing-address-btn"> Add New Address </a>
                                    </div>
<?php $this->widget('bootstrap.widgets.TbButton',
        array('type' => 'inverse', 'buttonType' => 'submit', 'size' => 'large', 'label' => 'Continue',));
?>
                                        </div>
                                    </form>


                                   
                                    <div class="clearfix"></div>

                                    <div class="chackout-div-Billing">
                                        <div class="col-md-8 checkout-main-center">
                                            <form title="">
                                                <div class="row">
                                                    <div class="col-md-4"><strong>Address For :	</strong></div>
                                                    <div class="col-md-8"> Billing <input type="radio" name="type" value="billing"> | Shipping <input type="radio" name="type" value="shipping"> | Both <input type="radio" name="type" value="both"> </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong>First Name :	</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong>Last Name :	</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong>E-Mail :</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong>Telephone :</strong>	</div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong>Fax :	</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>






                                                <div class="row">
                                                    <div class="col-md-4"><strong>Company :</strong>	</div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong><span style="color:red">*</span> Address 1 :</strong>	</div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong>Address 2:</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong><span style="color:red">*</span> City :</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4"><strong><span style="color:red">*</span> Post Code :</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array('ac1',
                                                                'ac2', 'ac3')));
                                                        ?></div>
                                                </div> 

                                                <div class="row">
                                                    <div class="col-md-4"><strong><span style="color:red">*</span> Country :</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array(
                                                                'ac1', 'ac2', 'ac3')));
                                                        ?></div>
                                                </div> 

                                                <div class="row">
                                                    <div class="col-md-4"><strong><span style="color:red">*</span> Region / State :</strong></div>
                                                    <div class="col-md-8">  <?php
                                                        $this->widget('zii.widgets.jui.CJuiAutoComplete',
                                                                array('name' => 'city',
                                                            'htmlOptions' => array(
                                                                'class' => 'form-control'),
                                                            'source' => array(
                                                                'ac1', 'ac2', 'ac3')));
                                                        ?></div>
                                                    <div class="clearfix"></div>
                                                </div> 
                                                <div class="col-md-12 right-divbtn">
<?php $this->widget('bootstrap.widgets.TbButton',
        array('type' => 'inverse', 'size' => 'large', 'label' => 'Add address',));
?>
                                                </div><div class="clearfix"></div>
                                            </form>
                                            <div class="clearfix"></div>
                                        </div>	  <div class="clearfix"></div> </div>	


                                    <div class="clearfix"></div>
                                </div>



                                <div class="col-md-4 checkout-right-div">  <?php $this->renderPartial('/models/rightcart',
        array("data" => $data));
?></div>



                                <div class="clearfix" ></div>
                            </div>

                            <div class="clearfix" ></div>
                        </div>
                        <div class="clearfix" ></div>
                    </div>
                    
                         <div class="clearfix" ></div>
                    </div>
