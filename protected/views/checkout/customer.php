<script>
    $(document).ready(function() {
        $(".billing-address-btn").click(function() {
            $(".chackout-div-Billing").toggle();
        });


    });
</script>
<div class=" checkout_main_div">
    <div class="col-md-12 border-line-div">
        <form id="customer_select_form" name="address" method="post" action="<?php echo $this->createUrl('checkout/ordermethod'); ?>">  
            <div id="guest_billing_form" class="col-md-6">
                <h4>Billing Details</h4>
                <h5 class="header-Existing-main">I want to use an Existing Address  </h5>
                <div class="col-md-12 row Existing-main-hide ">
                    <?php foreach ($data['address'] as $address) {
                        ?> 
                        <div class="Billing-info-div">
                            <div class="col-md-1"><input type="radio" title="billing address" <?php if($_SESSION['billing']['id_address']==$address['id_customer_address']){ echo 'checked';}?> name="billing_address"  value="<?php echo $address['id_customer_address']; ?>"/></div>
                            <div class="col-md-10 design-box-mian pull-right">
                                <strong><?php echo $address[firstname] ?> <?php echo $address[lastname] ?></strong>
                                <?php echo $address[address_1] ?> <?php echo $address[city] ?>, <?php echo $address[statename] ?> - <?php echo $address[postcode] ?> Mobile: <?php echo $address[telephone] ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </div>
			<?php if($data['shipping_required']){?>
            <div  id="guest_shipping_form"  class="col-md-6">
                <h4>Shipping Details</h4>
                <h5 class="shipping-header-Existing-main ">I want to use an Existing Address  </h5>
                <div class="col-md-12 row shipping-Existing-main-hide ">
                    <?php
                    foreach ($data['address'] as $address) {
                        ?> 
                        <div class="Billing-info-div">
                            <div class="col-md-1"><input type="radio" title="shipping address" <?php if($_SESSION['shipping']['id_address']==$address['id_customer_address']){ echo 'checked';}?> name="shipping_address" value="<?php echo $address['id_customer_address']; ?>"/></div>
                            <div class="col-md-10 design-box-mian pull-right">
                                <strong><?php echo $address[firstname] ?> <?php echo $address[lastname] ?></strong> <?php echo $address[address_1] ?> 
                                <?php echo $address[city] ?>, <?php echo $address[state] ?> - <?php echo $address[postcode] ?>
                                Mobile: <?php echo $address[telephone] ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
			<?php }?>
            <div class="col-md-12 right-divbtn">
                <div class="billing-main-btn pull-left">
                    <a class="btn btn-inverse billing-address-btn"> Add New Address </a>
                </div>
                <?php
                $this->widget('bootstrap.widgets.TbButton', array('id'=>'button_select_address','type' => 'inverse', 'buttonType' => 'button', 'size' => 'large', 'label' => 'Continue',));
                ?>
            </div>
        </form>
        <div class="clearfix"></div>
        <div class="chackout-div-Billing" >
            <div class="col-md-8 checkout-main-center">
                <form id="customer_address_form" name="address" method="post" action="<?php echo $this->createUrl('account/address'); ?>">
                    <!--<div class="row">
                        <div class="col-md-4"><strong>Address For :	</strong></div>
                        <div class="col-md-8"> Billing <input type="radio" name="type" value="billing"> | Shipping <input type="radio" name="type" value="shipping"> | Both <input type="radio" name="type" value="both"> </div>
                    </div>-->

                    <div class="row">
                                       <div class="col-md-4">* First Name :	</div>
                                       <div class="col-md-8"> <input type="text" name="address[firstname]" id="address_firstname" class="form-control" value="<?php echo $data['address']['firstname'];?>" ></div>
                    </div>

                    <div class="row">
                    <div class="col-md-4">* Last Name:	</div>
                    <div class="col-md-8">  <input type="text" name="address[lastname]" id="address_lastname" class="form-control"  value="<?php echo $data['address']['lastname'];?>">
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Telephone :	</div>
                    <div class="col-md-8"><input type="text" name="address[telephone]" id="address_telephone" class="form-control"  value="<?php echo $data['address']['telephone'];?>"></div>
                </div>
  
                <div class="row">
                    <div class="col-md-4">Company:	</div>
                    <div class="col-md-8"><input type="text" name="address[company]" id="address_company" class="form-control"  value="<?php echo $data['address']['company'];?>"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Address 1:	</div>
                    <div class="col-md-8"><input type="text" name="address[address_1]" id="address_address_1" class="form-control"  value="<?php echo $data['address']['address_1'];?>"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">Address 2:</div>
                    <div class="col-md-8"><input type="text" name="address[address_2]" id="address_address_2" class="form-control"  value="<?php echo $data['address']['address_2'];?>"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* City:</div>
                    <div class="col-md-8"><input type="text" name="address[city]" id="address_city" class="form-control"  value="<?php echo $data['address']['city'];?>"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Post Code:</div>
                    <div class="col-md-8"><input type="text" name="address[postcode]" id="address_postcode" class="form-control"  value="<?php echo $data['address']['postcode'];?>">
                        </div>
                </div> 

                <div class="row">
                    <div class="col-md-4">* Country:</div>
                    <div class="col-md-8"><select name="address[id_country]" id="address_id_country" class="form-control">
                            <option value="">--Select Country--</option>
                            <?php foreach ($data['countries'] as $country): ?>
                                <option value="<?php echo $country['id_country'] ?>" <?php if($country['id_country']==$data['address']['id_country']){ echo 'selected';}?> ><?php echo $country['name'] ?></option>
                            <?php endforeach; ?>
                        </select></div>
                </div> 

                <div class="row">
                    <div class="col-md-4">* Region / State:</div>
                    <div class="col-md-8">
                        <select name="address[id_state]" id="address_id_state" class="form-control">
                            <option value="">--Select State--</option>
                            <?php foreach ($data['states'] as $state): ?>
                                <option value="<?php echo $state['id_state'] ?>" <?php  if($state['id_state']==$data['address']['id_state']){ echo 'selected';}?>><?php echo $state['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                    <div class="col-md-12 right-divbtn">
<?php
$this->widget('bootstrap.widgets.TbButton', array('id'=>'button_customer','type' => 'inverse', 'size' => 'large', 'label' => 'Add address',));
?>  
                    <!-- <input type="submit" value="Add address"> -->
                    </div><div class="clearfix"></div>
                </form>
                <div class="clearfix"></div>
            </div>	  <div class="clearfix"></div> </div>	
        <div class="clearfix"></div>
    </div>
    <!--<div class="col-md-4 checkout-right-div">  <?php
                        //$this->renderPartial('/models/rightcart', array("data" => $data));
                        ?></div>-->
    <div class="clearfix" ></div>
</div>
<div class="clearfix" ></div>
<script type="text/javascript">
<!--

$("#address_id_country").change(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl("account/getstatedependencylist") ?>",
            data: "id_country=" + $("#address_id_country").val(),
            complete: function(data) {
                $("#address_id_state").html(data.responseText);
            }
        });
    });
	

/*$('#customer_address_form select[id=\'address_id_state\']').load('<?php echo $this->createAbsoluteUrl("account/getstatedependencylist",array("id_country"=>$data['address']['id_country'],"id_state"=>$data['address']['id_state'])) ?>');*/
-->

$(document).ready(function(){
	var divs = $("#customer_select_form").find('#guest_shipping_form');
	var divs1 = $("#customer_select_form").find('#guest_billing_form');
	if (divs.length == 0 || divs.length < 0) {
		divs1.removeClass("col-md-6").addClass("col-md-12");
	}
});
</script>