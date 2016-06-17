
   <div class="Categories-inner-pages"> 
   
   <div class="check_out_page">
   
   <div class="tab-main-div">
   <div class="tab-main col-md-3 actave "><a href="index.php?r=site/page&view=Chackout"  >Checkout options </a></div>
   <div class="tab-main col-md-3 actave "><a href="index.php?r=site/page&view=Chackout1" > Billing & Shipping Info </a></div>
   <div class="tab-main col-md-3 color-div "><a href="index.php?r=site/page&view=Chackout2" > Shipping  & Payment </a></div>
   <div class="tab-main col-md-3 "><a href="index.php?r=site/page&view=Chackout3" > Confirm order </a></div>
   <div class="clearfix" ></div>
   </div>
   
   <div class="checkout_options_div">
   
   <div class="row col-md-12 checkout_main_div">
   
    <div class="col-md-8 border-line-div">
    <div class="col-md-6">
    <h4>Shipping Method</h4>
    
    <div class="">
    <p>Please select the preferred service to use on this order.</p>
 	<h6>Choose Shipping Method</h6>
    
  <h5>  Shipping Method</h5>

<table class="table">
<tr>
<td>Express</td>
<td> Rs.5.00</td>
<td><input type="radio" class=""  /></td>
</tr>


<tr>
<td>Express</td>
<td> Rs.5.00</td>
<td><input type="radio" class=""  /></td>
</tr>

</table>

    
    </div>
    
    </div>
    
     <div class="col-md-6">
    <h4>Payment Method</h4>
    
        <div class="">
    <p>Please select the preferred service to use on this order.</p>
 	
    <table class="table">
<tr>
<td>  Cash On Delivery</td>

<td><input type="radio" class=""  /></td>
</tr>


<tr>
<td>Credit Card  |  Debit Card  |  Internet Banking</td>
<td><input type="radio" class=""  /></td>
</tr>



</table>
  <p>I have read and agree to the Privacy Policy  <input type="radio" class=""  /></p>
    
  <p> <?php $this->widget('bootstrap.widgets.TbButton', array('type' => 'primary','size' => 'inverse', 'label' => 'Confirm order', 'htmlOptions'=>array('class'=>'addtocart', 'url' => $this->createAbsoluteUrl('account/orderdetails',array('id'=>$data->id_order))), )); ?></p>
    
    </div>
    
    </div>
    
    </div>

<div class="col-md-4">

<table width="100%" border="0" cellspacing="0" class="table table-online-div" cellpadding="0">

 <tr class="prodct-div-main" >
  <th scope="col"><strong>Product(s)</strong></th>
  <th scope="col"><strong>Qty</strong></th>
  <th scope="col" class="table-online-midel"><strong>Price</strong></th>
 </tr>
 
 <tr>
  <td style="text-align:center">
  <img src="/themelite/themes/sproanzoOS/img/crt-1.jpg" height="50" width="36"  alt="" /><br />
  Nokia Lumia 520 Black</td>
  <td><strong>1</strong></td>
  <td class="table-online-right"><strong>Rs 7999</strong></td>
 </tr>
 
 <tr>
  <td style="text-align:center">
  <img src="/themelite/themes/sproanzoOS/img/crt-1.jpg" height="50" width="36"  alt="" /><br />
  Nokia Lumia 520 Black</td>
  <td><strong>1</strong></td>
  <td class="table-online-right"><strong>Rs 7999</strong></td>
 </tr>
 
  
 <tr class="table-online-main">
  <td colspan="2">Subtotal     </td>
  <td><strong> Rs.15998</strong></td>
 </tr>
 
  <tr class="table-online-main">
  <td colspan="2">Shipping Charges		     </td>
  <td><strong>Free</strong></td>
 </tr>
 
  <tr class="table-online-main">
  <td colspan="2">Vat Charges  </td>
  <td><strong> Free </strong></td>
 </tr>
 
  <tr class="total-div-main table-online-main">
  <td colspan="2">TOTAL </td>
  <td><strong> Rs   15998 </strong></td>
 </tr>


</table>

</div>


   
   <div class="clearfix" ></div>
   </div>
   
   <div class="clearfix" ></div>
   </div>
   <div class="clearfix" ></div>
   </div>
   <div class="clearfix"></div>
   </div>
   
