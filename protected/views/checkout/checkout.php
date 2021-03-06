<?php //echo $data['shipping_required'].'<pre>';print_r($data);echo '</pre>';?>
<div class="Categories-inner-pages"> 
<div class="col-md-8">
    <div class="check_out_page">
        <div class="tab-main-div">
            <div class="tab-main col-md-4 color-div " id="step1"><a href="#" onclick="fnStep(1);" ><?php echo 'Checkout Options';//Yii::t('checkout', 'text_checkout_options'); ?></a></div>
            <div class="tab-main col-md-4 "  id="step2" ><a href="#"  onclick="fnStep(2);" ><?php echo 'Billing & Shipping Details';//Yii::t('checkout', 'text_billing_shipping'); ?></a></div>
            <div class="tab-main col-md-4 "  id="step3" ><a href="#"  onclick="fnStep(3);" ><?php echo 'Shipping & Payment Method';//Yii::t('checkout', 'text_shipping_payment'); ?></a></div>
           
            <div class="clearfix" ></div>
        </div>
		<div class="notification-msg-div" id="notification"></div>
        <div class="checkout_options_div">
            <!--Content Loads Here-->
            <div class="clearfix" ></div>
        </div>
        <div class="clearfix" ></div>
    </div>
        </div>
        
            <div class="col-md-4 checkout-right-div ">
            <div class="tab-main confirm-right-div" ><a > Confirm order </a></div>
			<div id="confirm_order_div">
        <?php $this->renderPartial('checkout/checkoutorder', array("data" => $data)); ?>
   			 </div></div>
        
    <div class="clearfix" ></div>
</div>

<script type="text/javascript"><!--

function fnStep(val)
{
	if(val=='1')
	{
		$(document).ready(function() {
			$.ajax({
				url: '<?php if($data[logged]) { echo $this->createUrl("checkout/customer"); } else { echo $this->createUrl("checkout/login"); }?>',
				dataType: 'json',
				beforeSend: function() {
					$('#step1 a').after('<span class="wait">&nbsp;<img src="<?php echo Yii::app()->params[config][site_url];?>images/loading.gif" alt="" /></span>');
				},
				success: function(json) {
					if (json['redirect']) {
						location = json['redirect'];
					}

					if (json['output']) {
					$('.wait').remove();
						$('.checkout_options_div').html(json['output']);
						$("#step1").addClass("color-div");
						<?php if($data[logged]) {?>
						$("#step2").addClass("color-div");
						<?php } else {?>
						$("#step2").removeClass("color-div");
						<?php } ?>
						$("#step3").removeClass("color-div");
					}
				}
			});
		});
	}else if(val =='2')
	{
 	$(document).ready(function() {
	$.ajax({
		url: '<?php if(isset(Yii::app()->session['user_id'])){ echo $this->createUrl("checkout/customer"); }else{ echo $this->createUrl("checkout/guest"); }?>',
		dataType: 'json',
		beforeSend: function() {
			$('#step2  a').after('<span class="wait">&nbsp;<img src="<?php echo Yii::app()->params[config][site_url];?>images/loading.gif" alt="" /></span>');
		},
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['output']) {
				$('.wait').remove();
				$('.checkout_options_div').html(json['output']);
				$("#step1").addClass("color-div");
				$("#step2").addClass("color-div");
				$("#step3").removeClass("color-div");
				if ($('#guest_shipping_form').length == 0 || $('#guest_shipping_form').length < 0) {
				  $("#guest_billing_form").removeClass("col-md-6").addClass("col-md-12");
				}
				
			}
		}
	});
});

 
	}else if(val=='3')
	{
	$(document).ready(function() {
	$.ajax({
		url: '<?php echo $this->createUrl("checkout/ordermethod"); ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#step3  a').after('<span class="wait">&nbsp;<img src="<?php echo Yii::app()->params[config][site_url];?>images/loading.gif" alt="" /></span>');
		},
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['output']) {
			$('.wait').remove();
			$('.checkout_options_div').html(json['output']);
			$("#step1").addClass("color-div");
			$("#step2").addClass("color-div");
			$("#step3").addClass("color-div");
			if ($('#shipping-left-div').length == 0 || $('#shipping-left-div').length < 0) {
				$("#shipping-right-div").removeClass("col-md-6").addClass("col-md-12");
			}		
		}
		}
	});
});


	}
}

<?php if (!$data['logged']) { ?>
$(document).ready(function() {
//alert("hell");
	$.ajax({
		url: '<?php echo $this->createUrl('checkout/login');?>',
		dataType: 'json',
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['output']) {
                            $('.checkout_options_div').html(json['output']);
			}
		}
	});
});
<?php } else { ?>
$(document).ready(function() {
	$.ajax({
		url: '<?php echo $this->createUrl("checkout/customer");?>',
		dataType: 'json',
		success: function(json) {
			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['output']) {
				$('.checkout_options_div').html(json['output']);
				$("#step2").addClass("color-div");
			}
		}
	});
});
<?php } ?>

// $('#button_guest').live('click', function() {
	$(document).on('click','#button_guest',function(){
	$.ajax({
		url: '<?echo $this->createUrl("checkout/guest");?>',
		dataType: 'json',
		beforeSend: function() {
	/*		
        //$('#button-account').attr('disabled', true);

			$('#button-account').after('<span class="wait">&nbsp;<img src="/includes/images/loading.gif" alt="" /></span>');*/
		},
		complete: function() {
			/*$('#button-account').attr('disabled', false);
			$('.wait').remove();*/
		},
		success: function(json) {
			//$('.warning').remove();

			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['output']) {
				$('.checkout_options_div').html(json['output']);
				$("#step2").addClass("color-div");
				if ($('#guest_shipping_form').length == 0 || $('#guest_shipping_form').length < 0) {
				  $("#guest_billing_form").removeClass("col-md-6").addClass("col-md-12");
				}
			}
		}
	});
});

// Guest
// $('#guest_form_submit').live('click', function() {
	$(document).on('click','#guest_form_submit',function(){
	$.ajax({
		url: '<?php echo $this->createUrl("checkout/guest");?>',
		type: 'post',
		<?php if($data['shipping_required']){?>
		data: $('#guest_billing_form input[type=\'text\'],  #guest_billing_form select , #guest_shipping_form input[type=\'text\'],  #guest_shipping_form select'),
		<?php }else{?>
		data: $('#guest_billing_form input[type=\'text\'],  #guest_billing_form select'),
		<?php }?>
		
		dataType: 'json',
		beforeSend: function() {
			/*$('#button-guest').attr('disabled', true);
			$('#button-guest').after('<span class="wait">&nbsp;<img src="/includes/images/loading.gif" alt="" /></span>');*/
		},
		complete: function() {
			/*$('#button-guest').attr('disabled', false);
			$('.wait').remove();*/
		},
		success: function(json) {
			$('.errorMessage').remove();
                        //return;
			if (json['redirect']) {
				//location = json['redirect'];
			}

			if (json['error']) {
                            for (var key in json['error']['billing']) 
                            {
                                $('#billing_'+key).after('<div class="errorMessage">' + json['error']['billing'][key] + '</div>');
                            }
                            
                            for (var key in json['error']['shipping']) 
                            {
                                $('#shipping_'+key).after('<div class="errorMessage">' + json['error']['shipping'][key] + '</div>');
                            }
                            
			} else {
                                    $.ajax({

					url: '<?php echo $this->createUrl("checkout/ordermethod");?>',
					dataType: 'json',
					success: function(json) {
						/*if (json['redirect']) {
							location = json['redirect'];
						}*/

						if (json['output']) {
						$('.checkout_options_div').html(json['output']);
						$("#step3").addClass("color-div");
						if ($('#shipping-left-div').length == 0 || $('#shipping-left-div').length < 0) {
							$("#shipping-right-div").removeClass("col-md-6").addClass("col-md-12");
						}	
						}
						//$('#confirm_order_div').html('amazing');
						//alert("at last")
					}
				});
                               
                               }
		}
	});
});

// Login
// $('#button-login').live('click', function() {
	$(document).on('click','#button-login',function(){
	//alert('in login');return;
	$.ajax({
		url: '<?echo $this->createUrl("checkout/login");?>',
		type: 'post',
		data: $('.mailid-div :input'),
		dataType: 'json',
		beforeSend: function() {
			//$('#button-login').attr('disabled', true);

			$('#button-login').after('<span class="wait">&nbsp;<img src="<?php echo Yii::app()->params[config][site_url];?>images/loading.gif"  /></span>');

		},
		complete: function() {
			$('#button-login').attr('disabled', false);
			//$('.wait').remove();
		},
		success: function(json) {
			$('.wait').remove();
			$('.alert-danger').remove();

			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['error']) {
				//$('.checkout_options_div').prepend('<div class="warning">' + json['error']['warning'] + '</div>');
				$('#notification').prepend('<div class="alert in fade alert-danger">' + json['error']['warning'] + '<a data-dismiss="alert" class="close" style="cursor:pointer">×</a></div>');

			} else {
				$.ajax({
					url: '<?echo $this->createUrl("checkout/customer");?>',
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}

						if (json['output']) {
							$('.checkout_options_div').html(json['output']);
							$("#step2").addClass("color-div");
							if ($('#guest_shipping_form').length == 0 || $('#guest_shipping_form').length < 0) {
				  				$("#guest_billing_form").removeClass("col-md-6").addClass("col-md-12");
							}
						 }
					}
				});
			}
		}
	});
});


// Address
// $('#button_customer').live('click', function() {
	$(document).on('click','#button_customer',function(){
	$.ajax({
		url: '<?php echo $this->createUrl("checkout/customer");?>',
		type: 'post',
		data: $('#customer_address_form input[type=\'text\'],  #customer_address_form select'),
		dataType: 'json',
		beforeSend: function() {
			/*$('#button-guest').attr('disabled', true);
			$('#button-guest').after('<span class="wait">&nbsp;<img src="/includes/images/loading.gif" alt="" /></span>');*/
		},
		complete: function() {
			/*$('#button-guest').attr('disabled', false);
			$('.wait').remove();*/
		},
		success: function(json) {
			$('.errorMessage').remove();
                        //return;
			if (json['redirect']) {
				//location = json['redirect'];
			}

			if (json['error']) {
				for (var key in json['error']['address']) 
				{
					$('#address_'+key).after('<div class="errorMessage">' + json['error']['address'][key] + '</div>');
				}
            }

			if (json['output']) {
			$('.checkout_options_div').html(json['output']);
			}
		}
	});
});

// $('#button_select_address').live('click', function() {
	$(document).on('click','#button_select_address',function(){
	$.ajax({
		url: '<?php echo $this->createUrl("checkout/customeraddress");?>',
		type: 'post',
		//data: $('#customer_select_form input[type=\'radio\']'),
		data: $('#customer_select_form input[type=\'radio\']:checked'),
		dataType: 'json',
		beforeSend: function() {
			/*$('#button-guest').attr('disabled', true);
			$('#button-guest').after('<span class="wait">&nbsp;<img src="/includes/images/loading.gif" alt="" /></span>');*/
		},
		complete: function() {
			/*$('#button-guest').attr('disabled', false);
			$('.wait').remove();*/
		},
		success: function(json) {
		//$('.warning').remove();
		$('.alert-danger').remove();
			if (json['error']) {
				//$('.checkout_options_div').prepend('<div class="warning">' + json['error'] + '</div>');	
				$('#notification').prepend('<div class="alert in fade alert-danger">' + json['error'] + '<a data-dismiss="alert" class="close" style="cursor:pointer">×</a></div>');
            } else {
				$.ajax({
					url: '<?echo $this->createUrl("checkout/ordermethod");?>',
					dataType: 'json',
					success: function(json) {
						if (json['redirect']) {
							location = json['redirect'];
						}

						if (json['output']) {
							$('.checkout_options_div').html(json['output']);
							$("#step3").addClass("color-div");
						 }
						//$('#confirm_order_div').html('amazing');
						//alert("at last")
					}
				});
			}
		}
	});
});

// $('#shipping_method , #payment_method , #agree').live('click', function() {
	$(document).on('click','#shipping_method , #payment_method , #agree',function(){
	$.ajax({
		url: '<?echo $this->createUrl("checkout/ordermethod");?>',
		type: 'post',
		//data: $('#frmcheckoutmethod :input'),
		data: $('#frmcheckoutmethod input[type=\'radio\']:checked,#frmcheckoutmethod input[type=\'checkbox\']:checked'),
		dataType: 'json',
		beforeSend: function() {
	/*		
        //$('#button-account').attr('disabled', true);

			$('#button-account').after('<span class="wait">&nbsp;<img src="/includes/images/loading.gif" alt="" /></span>');*/
		},
		complete: function() {
			/*$('#button-account').attr('disabled', false);
			$('.wait').remove();*/
		},
		success: function(json) {
			//$('.warning').remove();
			$('.alert-danger').remove();

			if (json['redirect']) {
				location = json['redirect'];
			}

			if (json['error']) 
			{
				for (var key in json['error']) 
				{
					//$('.checkout_options_div').prepend('<div class="warning">' + json['error'][key] + '</div>');
					$('#notification').prepend('<div class="alert in fade alert-danger">' + json['error'][key] + '<a data-dismiss="alert" class="close" style="cursor:pointer">×</a></div>');
				}
			}

			if (json['checkoutOrder']) {
				//alert(json['checkoutOrder'])
				//$('.checkout_options_div').html(json['output']);
				$('#confirm_order_div').html(json['checkoutOrder']);
				$("#step2").addClass("color-div");
			}
			//alert(json['confirmButton'])
			$('#confirmButton').html(json['confirmButton']);
			
			
		}
	});
});
//--></script>
