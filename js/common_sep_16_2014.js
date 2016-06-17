// JavaScript Document
// add product to a wishlist
function addToWishList(product_id) {
	$.ajax({
		url: site_url+'index.php/account/wishlistajax',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				$('#notification').html('<div class="alert in fade alert-success" id="success">' + json['success'] + '<a style="cursor:pointer" class="close" data-dismiss="alert">×</a></div>');
				$('#success').fadeIn('slow').delay(2000).fadeOut(2000);
				//$('#wishlist-total').html(json['total']);
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
}
function addToCompare(product_id) {
	$.ajax({
		url: site_url+'index.php/product/compareajax',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				$('#notification').html('<div class="alert in fade alert-success" id="success">' + json['success'] + '<a style="cursor:pointer" class="close" data-dismiss="alert">×</a></div>');
				$('#success').fadeIn('slow').delay(2000).fadeOut(2000);
				//$('#wishlist-total').html(json['total']);
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
}


//remove Products from Wishlist
function removeWishlist(product_id){
    $.ajax({
		url: site_url+'index.php/account/removewishlist',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			if(json['total']==0){
				$("#wishlist-list-"+product_id).remove();
				$('#notification').html('<div class="alert in fade alert-success" id="success">' + json['success'] + '<a style="cursor:pointer" class="close" data-dismiss="alert">×</a></div>');
				$('#success').fadeIn('slow').delay(2000).fadeOut(2000);
				$("#block-new-div").append('<li class="col-md-4 product-main-container">No Products Found!!</li>');
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}else if (json['success']) {
				$("#wishlist-list-"+product_id).remove();
				$('#notification').html('<div class="alert in fade alert-success" id="success">' + json['success'] + '<a style="cursor:pointer" class="close" data-dismiss="alert">×</a></div>');
				$('#success').fadeIn('slow').delay(2000).fadeOut(2000);
				//$('#wishlist-total').html(json['total']);
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
}

// Add to Cart Functionality
function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: site_url+'index.php/checkout/cart',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
		
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$("#total_price").html(json['total_price']);
				$("#total_qty").html(json['total_qty']);
				$('#notification').html('<div class="alert in fade alert-success" id="success">' + json['success'] + '<a style="cursor:pointer" class="close" data-dismiss="alert">×</a></div>');
				
				$('#success').fadeIn('slow').delay(2000).fadeOut(2000);
				
				$('#cart-total').html(json['total']);
				
				//$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}

//view cart plugin

$(document).ready(function(){
						   
	$("#q").autocomplete({
		source: site_url+'index.php/product/autosuggest',
		minLength: 1
	});	
	
//shipping
if ($.trim($("#shipping-left-div").html()).length == 0) {
      $("#shipping-right-div").removeClass("col-md-6").addClass("col-md-12");
}
// remove of left and right div module if it not content, and append the classes
if ($.trim($("#nc-right").html()).length == 0) {
     $('#nc-right').remove();
	 if($("#nc-div-middle > .col-md-6").length==1){
	  $("#nc-middle").removeClass("col-md-6").addClass("col-md-9");
	 }else{
	  $("#nc-middle").removeClass("col-md-9").addClass("col-md-12");
	 }
} 
if ($.trim($("#nc-left").html()).length == 0) {
     $('#nc-left').remove();
     if($("#nc-div-middle > .col-md-6").length==1){
	  $("#nc-middle").removeClass("col-md-6").addClass("col-md-9");
	 }else{
	  $("#nc-middle").removeClass("col-md-9").addClass("col-md-12");
	 }
} 

if ($.trim($(".top-full-width").html()).length == 0) {
   $('.top-full-width').remove();
}

if ($.trim($(".top-content").html()).length == 0) {
   $('.top-content').remove();
}

if ($.trim($(".bottom-content").html()).length == 0) {
   $('.bottom-content').remove();
}
//guest-checkout validation 
//errorMessage
$("#guest-checkout").click(function(){
	//billing
    if($("#firstname").val()==''){
		$("#errorfirstname").show();
	}
	if($("#lastname").val()==''){
		$("#errorlastname").show();
	}
	if($("#email").val()==''){
		$("#erroremail").show();
	}
	if($("#telephone_value").val()==''){
		$("#errortelephone").show();
	}
	if($("#address_1").val()==''){
		$("#erroraddress").show();
	}
	if($("#city_val").val()==''){
		$("#errorcity").show();
	}
	if($("#postcode").val()==''){
		$("#errorpostcode").show();
	}
	if($("#id_country").val()==''){
		$("#errorcountry").show();
	}
	if($("#is_state").val()==''){
		$("#errorstate").show();
	}
	//shipping
    if($("#shipping_firstname").val()==''){
		$("#errorsfirstname").show();
	}
	if($("#shipping_lastname").val()==''){
		$("#errorslastname").show();
	}
	if($("#shipping_email").val()==''){
		$("#errorsemail").show();
	}
	if($("#shipping_telephone_value").val()==''){
		$("#errorstelephone").show();
	}
	if($("#shipping_address_1").val()==''){
		$("#errorsaddress").show();
	}
	if($("#shipping_city_val").val()==''){
		$("#errorscity").show();
	}
	if($("#shipping_postcode").val()==''){
		$("#errorspostcode").show();
	}
	if($("#shipping_id_country").val()==''){
		$("#errorscountry").show();
	}
	if($("#shipping_is_state").val()==''){
		$("#errorsstate").show();
	}
	//
	if($("#firstname").val()==''){
		$("#firstname").focus();	
		return false;
	}
	if($("#lastname").val()==''){
		$("#lastname").focus();
		return false;
	}
	if($("#email").val()==''){
		$("#email").focus();	
		return false;
	}
	if($("#telephone_value").val()==''){
		$("#telephone_value").focus();	
		return false;
	}
	if($("#address_1").val()==''){
		$("#address_1").focus();	
		return false;
	}
	if($("#city_val").val()==''){
		$("#city_val").focus();
		return false;
	}
	if($("#postcode").val()==''){
		$("#postcode").focus();
		return false;
	}
	if($("#id_country").val()==''){
		$("#id_country").focus();
		return false;
	}
	if($("#is_state").val()==''){
		$("#is_state").focus();
		return false;
	}
	
	if($("#shipping_firstname").val()==''){
		$("#shipping_firstname").focus();	
		return false;
	}
	if($("#shipping_lastname").val()==''){
		$("#shipping_lastname").focus();
		return false;
	}
	if($("#shipping_email").val()==''){
		$("#shipping_email").focus();	
		return false;
	}
	if($("#shipping_telephone_value").val()==''){
		$("#shipping_telephone_value").focus();	
		return false;
	}
	if($("#shipping_address_1").val()==''){
		$("#shipping_address_1").focus();	
		return false;
	}
	if($("#shipping_city_val").val()==''){
		$("#shipping_city_val").focus();
		return false;
	}
	if($("#shipping_postcode").val()==''){
		$("#shipping_postcode").focus();
		return false;
	}
	if($("#shipping_id_country").val()==''){
		$("#shipping_id_country").focus();
		return false;
	}
	if($("#shipping_is_state").val()==''){
		$("#shipping_is_state").focus();
		return false;
	}
	
});



$("#view-cart").mouseenter(function(){
	 $.ajax({
			type:"POST",
			url: site_url+'index.php/checkout/viewcart',
			data: "",
			complete: function(data){
				checkCartOption();
			  $("#inner-cart-list").html(data.responseText);
	        }
	});
});

//page navigation class adding 
$('.clinkPagerCss').find('ul').addClass('btn-group');
$('.clinkPagerCss').find('ul').find('li').addClass('btn');

	   $('#datetimepicker').datetimepicker({
			step:10
	   });
	   $('#datetimepicker8').datetimepicker({
			timepicker:false,
			format:'Y/m/d',
       });
	   $('#datetimepicker1').datetimepicker({
			datepicker:false,
			format:'H:i',
			step:10
       });

$("#post-rating").click(function(){
	review_title=$("#review_title").val();
	review_description=$("#review_description").val();
	rating=$("#ratings").val();
	review_code=$("#review_code").val();
	product_id=$("#product_id").val();
	$.ajax({
			type:"POST",
			url: site_url+'index.php/product/review',
			data: "review_title="+review_title+"&review_description="+review_description+"&rating="+rating+"&review_code="+review_code+"&product_id="+product_id,
			dataType: 'json',
			success: function(json){
				
				if(json['response_text']){
				   $("#response-text").html(json['response_text']);
				}else if(json['success_text']){
					$("#review_title").val('');
				$("#review_description").val('');
				$("#review_code").val('');
				   $("#response-text").html(json['success_text']);
				}
			  
	        }
	});
});


});


$(document).ready(function(){

$('#demo5').scrollbox({direction: 'h',distance: 134});
$('#demo5-backward').click(function () {$('#demo5').trigger('backward');});
$('#demo5-forward').click(function () { $('#demo5').trigger('forward'); });
$cnw=$("#cn-width-0").width();
$demoli=$(".scroll-img ul > li").length;
$cnw=$cnw*$demoli+$cnh+$cnh
$("#block-new-div").width($cnw);
});

//get more products
function moreProducts(category_id){
	$start=$("#start").val();
	document.getElementById('show-more').disabled=true;
	$start++;
	$loop_id=$("#loop-id").val();
	$product_style_type=$("#product-style-type").val();
	$.ajax({
			type:"POST",
			url: site_url+'index.php/checkout/moreproducts',
			data: "category_id="+category_id+"&moreproduct=true&page="+$start+"&product_style="+$product_style_type+"&loop_id="+$loop_id,

			complete: function(data){
				$("#start").val($start);
				$loop_id=parseInt($loop_id)+parseInt(product_list);
				$("#loop-id").val($loop_id)
				document.getElementById('show-more').disabled=false;
				$("#block-new-div").append(data.responseText);
				countProducts()
	        }
	});
}
//product count
function countProducts(){
	$li=$("#block-new-div > li").length;
	$.ajax({
			type:"POST",
			url: site_url+'index.php/checkout/countproducts',
			data: "",
            complete: function(data){
				$li=parseInt(data.responseText)-parseInt($li);
			    $("#count-list").html($li);
	        }
	});
}
// product remove form view cart
function removeFromCart(product_id){
	 $.ajax({
			type:"POST",
			url: site_url+'index.php/checkout/removefromcart',
			data: "product_id="+product_id,
			complete: function(data){
			$.ajax({
				type:"POST",
				url: site_url+'index.php/checkout/viewcart',
				data: "",
				complete: function(data){
				checkCartOption();
				$("#inner-cart-list").html(data.responseText);
				location.reload();
				}
			});
	        }
	});
}
function checkCartOption(){
      $.ajax({
		url: site_url+'index.php/checkout/checkcartoption',
		type: 'post',
		data: '',
		dataType: 'json',
		success: function(json) {
			$("#total_price").html(json['total_price']);
			$("#total_qty").html(json['total_qty']);
		}
	  });
}
//
function getProductList(product_id,current_id,loop_id){
$("#product-list"+loop_id).css("height", $("#left-"+loop_id).height()); 
  product_style_type=$("#product-style-type").val();
  $.ajax({
		url: site_url+'index.php/product/getproduct',
		type: 'post',
		data: 'product_id='+product_id+"&product_style_type="+product_style_type+"&loop_id="+loop_id,
		complete: function(data) {
          $("#product-list-"+current_id).html(data.responseText);
		}
	  });
}

//increment and decrement of product values\
function quantityIncrement(){
quantity=$("#quantity").val();
quantity=++quantity;
$("#quantity").val(quantity);
}
function quantityDecrement(){
quantity=$("#quantity").val();
quantity=--quantity;
if(quantity>0){
$("#quantity").val(quantity);
}
}


function quickView(product_id){
	$.ajax({
		url: site_url+'index.php/product/quickview',
		type: 'post',
		data: 'product_id='+product_id,
		complete: function(data) {
          $("#myModal").html(data.responseText);
		}
	  });
}

//image change 
function showImage(img){
   $("#images_view").html('<img title="Sporanzo image" alt="Sporanzo image" src="'+img+'">');
}
function submitForm(){
	document.getElementById("myForm").submit();
}

//
function getPages(id_page){
   $.ajax({
		url: site_url+'index.php/page/pages',
		type: 'post',
		data: 'id_page='+id_page,
		complete: function(data) {
          $("#myModal #desc").html(data.responseText);
		}
	  });
}
//remove product list from cart
function trashProduct(key,product_id){
    $.ajax({
		url: site_url+'index.php/checkout/trashproduct',
		type: 'post',
		data: 'product_id='+key,
		complete: function(data) {
		  if(data.responseText==1){
			  $("#product-"+product_id).remove();
			  location.reload();
		  }
		 }
	  });
}

<!--  tpl-header -->
    jQuery(document).ready(function() {

        jQuery('#cart_drop li').hover(
                function() {
                    //show its submenu
                    jQuery('ul', this).stop().slideDown(100);

                },
                function() {
                    //hide its submenu
                    jQuery('ul', this).stop().slideUp(100);
                }
        );

    });
<!--  tpl-header -->