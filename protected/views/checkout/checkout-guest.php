<?php //echo '<pre>';print_r($data); echo '</pre>';?>
<div class=" checkout_main_div">
    <div class="col-md-12 border-line-div">
        <form method="post" action="" id="guest-form" class="guest-div-checkout">
            <div class="col-md-6" id="guest_billing_form">
                <h4>Billing Details111</h4>
                <!--<p><strong>Your Personal Details</strong> </p>-->
                <div class="row">
                    <div class="col-md-4">* First Name :	</div>
                    <div class="col-md-8"> <input type="text" name="billing[firstname]" id="billing_firstname" class="form-control" value="<?php echo $data['billing']['firstname'];?>" ></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Last Name:	</div>
                    <div class="col-md-8">  <input type="text" name="billing[lastname]" id="billing_lastname" class="form-control"  value="<?php echo $data['billing']['lastname'];?>">
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">* E-Mail :</div>
                    <div class="col-md-8"> <input type="text" name="billing[email]" id="billing_email" class="form-control"  value="<?php echo $data['billing']['email'];?>" ></div>

                </div>

                <div class="row">
                    <div class="col-md-4">* Telephone :	</div>
                    <div class="col-md-8"><input type="text" name="billing[telephone]" id="billing_telephone" class="form-control"  value="<?php echo $data['billing']['telephone'];?>"></div>
                </div>

                <!--<div class="row">
                    <div class="col-md-4">Fax :	</div>
                    <div class="col-md-8"> <input type="text" name="billing[fax]" id="billing_fax" class="form-control"  value="<?php echo $data['billing']['fax'];?>"></div>
                </div>

                <h4></h4>


                <p><strong>Your Address</strong></p>  --> 
                <div class="row">
                    <div class="col-md-4">Company:	</div>
                    <div class="col-md-8"><input type="text" name="billing[company]" id="billing_company" class="form-control"  value="<?php echo $data['billing']['company'];?>"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Address 1:	</div>
                    <div class="col-md-8"><input type="text" name="billing[address_1]" id="billing_address_1" class="form-control"  value="<?php echo $data['billing']['address_1'];?>"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">Address 2:</div>
                    <div class="col-md-8"><input type="text" name="billing[address_2]" id="billing_address_2" class="form-control"  value="<?php echo $data['billing']['address_2'];?>"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* City:</div>
                    <div class="col-md-8"><input type="text" name="billing[city]" id="billing_city" class="form-control"  value="<?php echo $data['billing']['city'];?>"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Post Code:</div>
                    <div class="col-md-8"><input type="text" name="billing[postcode]" id="billing_postcode" class="form-control"  value="<?php echo $data['billing']['postcode'];?>">
                        </div>
                </div> 

                <div class="row">
                    <div class="col-md-4">* Country:</div>
                    <div class="col-md-8"><select name="billing[id_country]" id="billing_id_country" class="form-control">
                            <option value="">--Select Country--</option>
                            <?php foreach ($data['countries'] as $country): ?>
                                <option value="<?php echo $country['id_country'] ?>" <?php if($country['id_country']==$data['billing']['id_country']){ echo 'selected';}?> ><?php echo $country['name'] ?></option>
                            <?php endforeach; ?>
                        </select></div>
                </div> 

                <div class="row">
                    <div class="col-md-4">* Region / State:</div>
                    <div class="col-md-8">
                        <select name="billing[id_state]" id="billing_id_state" class="form-control">
                            <option value="">--Select State--</option>
                            <?php foreach ($data['states'] as $state): ?>
                                <option value="<?php echo $state['id_state'] ?>" <?php  if($state['id_state']==$data['billing']['id_state']){ echo 'selected';}?>><?php echo $state['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div> 

				<?php if($data['shipping_required']){?>
                <div class="row">
                    <div class="col-md-12"> <input type="checkbox"  onchange="fnSameAddr(this)" id="shipping_address" name="shipping[address]" /> <label for="check1"> My delivery and billing addresses are the same.</label>
                        
                    </div>
                </div>    
				<?php } ?>
            </div>
            <?php if($data['shipping_required']){?>
            <div class="col-md-6" id="guest_shipping_form">
                <h4>Shipping Details</h4>


                <div class="row">
                    <div class="col-md-4">* First Name :	</div>
                    <div class="col-md-8"> <input type="text" name="shipping[firstname]" id="shipping_firstname" class="form-control"   value="<?php echo $data['shipping']['firstname'];?>" ></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Last Name:	</div>
                    <div class="col-md-8">  <input type="text" name="shipping[lastname]" id="shipping_lastname" class="form-control" value="<?php echo $data['shipping']['lastname'];?>" >
                        
                    </div>
                </div>

                <!--<div class="row">
                    <div class="col-md-4">* E-Mail :</div>
                    <div class="col-md-8"> <input type="text" name="shipping[email]" id="shipping_email" class="form-control" value="<?php echo $data['shipping']['email'];?>" ></div>

                </div>-->

                <div class="row">
                    <div class="col-md-4">* Telephone :	</div>
                    <div class="col-md-8"><input type="text" name="shipping[telephone]" id="shipping_telephone" class="form-control" value="<?php echo $data['shipping']['telephone'];?>" ></div>
                </div>

                <!--<div class="row">
                    <div class="col-md-4">Fax :	</div>
                    <div class="col-md-8"> <input type="text" name="shipping[fax]" id="shipping_fax" class="form-control"></div>
                </div>-->

                <h4></h4>




                <div class="row">
                    <div class="col-md-4">Company:	</div>
                    <div class="col-md-8"><input type="text" name="shipping[company]" id="shipping_company" value="<?php echo $data['shipping']['company'];?>"  class="form-control"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Address 1:	</div>
                    <div class="col-md-8"><input type="text" name="shipping[address_1]" id="shipping_address_1" class="form-control" value="<?php echo $data['shipping']['address_1'];?>"  ></div>
                </div>

                <div class="row">
                    <div class="col-md-4">Address 2:</div>
                    <div class="col-md-8"><input type="text" name="shipping[address_2]" id="shipping_address_2" class="form-control" value="<?php echo $data['shipping']['address_2'];?>" ></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* City:</div>
                    <div class="col-md-8"><input type="text" name="shipping[city]" id="shipping_city" class="form-control" value="<?php echo $data['shipping']['city'];?>"  ></div>
                </div>

                <div class="row">
                    <div class="col-md-4">* Post Code:</div>
                    <div class="col-md-8"><input type="text" name="shipping[postcode]" id="shipping_postcode" class="form-control" value="<?php echo $data['shipping']['postcode'];?>" ></div>
                </div> 

                <div class="row">
                    <div class="col-md-4">* Country:</div>
                    <div class="col-md-8"><select name="shipping[id_country]" id="shipping_id_country" class="form-control">
                            <option value="">--Select Country--</option>
                            <?php foreach ($data['countries'] as $country): ?>
                                <option value="<?php echo $country['id_country']; ?>" <?php if($data['shipping']['id_country']==$country['id_country']){ echo 'selected';}?> ><?php echo $country['name'] ?></option>
                            <?php endforeach; ?>
                        </select></div>
                </div> 

                <div class="row">
                    <div class="col-md-4">* Region / State:</div>
                    <div class="col-md-8">
                        <select name="shipping[id_state]" id="shipping_id_state" class="form-control">
                            <option value="">--Select State--</option>
                            <?php foreach ($data['states'] as $state): ?>
                                <option value="<?php echo $state['id_state'] ?>" <?php if($state['id_state']==$data['shipping']['state']){ echo 'selected';} ?> ><?php echo $state['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div> 
            </div><?php }?>

            <div class="col-md-12 right-divbtn">
                <input type="button" name="guest-checkout" id="guest_form_submit" value="Continue" class="btn btn-inverse" /> 
            </div> </form> 
    </div>



    


    <div class="clearfix" ></div>
</div>



<script type="text/javascript">
    $("#billing_id_country").change(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl("account/getstatedependencylist") ?>",
            data: "id_country=" + $("#billing_id_country").val(),
            complete: function(data) {
                $("#billing_id_state").html(data.responseText);
            }
        });
    });
    $("#shipping_id_country").change(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl("account/getstatedependencylist") ?>",
            data: "id_country=" + $("#shipping_id_country").val(),
            complete: function(data) {
                $("#shipping_id_state").html(data.responseText);
            }
        });
    });

function fnSameAddr(data)
{
	if (data.checked)
	{
		$('#shipping_firstname').val($('#billing_firstname').val());
		$('#shipping_lastname').val($('#billing_lastname').val());
		$('#shipping_email').val($('#billing_email').val());
		$('#shipping_telephone').val($('#billing_telephone').val());
		$('#shipping_company').val($('#billing_company').val());
		$('#shipping_address_1').val($('#billing_address_1').val());
		$('#shipping_address_2').val($('#billing_address_2').val());
		$('#shipping_city').val($('#billing_city').val());
		$('#shipping_postcode').val($('#billing_postcode').val());
		$('#shipping_id_country').val($('#billing_id_country').val());
		/*$("#billing_id_state").each(function()
		{
			$('#shipping_id_state').val($(this).val());
		});*/
		$('#billing_id_state option').clone().appendTo('#shipping_id_state');
		$('#shipping_id_state').val($('#billing_id_state').val());
	} else
	{
		$('#shipping_firstname').val('');
		$('#shipping_lastname').val('');
		$('#shipping_email').val('');
		$('#shipping_telephone').val('');
		$('#shipping_company').val('');
		$('#shipping_address_1').val('');
		$('#shipping_address_2').val('');
		$('#shipping_city').val('');
		$('#shipping_postcode').val('');
		$('#shipping_id_country').val('');
		$('#shipping_id_state').val('');
	}
}
$(document).ready(function(){
	var divs = $("#customer_select_form").find('#guest_shipping_form');
	var divs1 = $("#customer_select_form").find('#guest_billing_form');
	if (divs.length == 0 || divs.length < 0) {
		divs1.removeClass("col-md-6").addClass("col-md-12");
	}
});
</script>

<script type="text/javascript">
<!--
$('#guest_billing_form select[id=\'billing_id_state\']').load('<?php echo $this->createAbsoluteUrl("account/getstatedependencylist",array("id_country"=>$data['billing']['id_country'],"id_state"=>$data['billing']['id_state'])) ?>');
$('#guest_shipping_form select[id=\'shipping_id_state\']').load('<?php echo $this->createAbsoluteUrl("account/getstatedependencylist",array("id_country"=>$data['shipping']['id_country'],"id_state"=>$data['shipping']['id_state'])) ?>');

-->

</script>
