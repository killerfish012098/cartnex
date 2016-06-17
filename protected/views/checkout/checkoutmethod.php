<div class="row col-md-12 checkout_main_div">
    <div class="col-md-12 border-line-div">
        <form name="checkoutmethod" id="frmcheckoutmethod"  method="post">
            <?php if($data['shipping_required']){?>
			<div class="col-md-6 Shippingmethod-line" id="shipping-left-div">
                <h4 class="under-line-div">Shipping Method</h4>
                <p>Please select the preferred service to use on this order.</p>
                <?php if (sizeof($data['shipping_methods']) > 0) {
                    foreach ($data['shipping_methods'] as $shipping) {
                        ?>
                        <div class="box-list">
                            <h5>  <strong><?php echo $shipping['title']; ?></strong></h5>
                            <table class="table shippingmethod-table">
                                <?php if (!$shipping['error']) { ?>
            <?php foreach ($shipping['methods'] as $method) { ?>
                                        <tr>
                                            <td width="75%"><?php echo $method['title']; ?></td>
                                            <td width="15%"><?php echo $method['label']; ?></td>
                                            <td width="10%"><input type="radio" class=""  id='shipping_method' name='shipping_method' value='<?php echo $method['code'] ?>'/></td>
                                        </tr> 
                                        <?php }?>
            <?php } else { ?>
                                        <tr class="danger-msg">
                                            <td colspan='2'><?php echo $shipping['error']; ?></td>
                                        </tr> 
            <?php } ?>
                                </table>


                            </div>
                        <?php }
                    } else { ?>
                        <p> <i>No Shipping Gateway Available </i> </p>
    <?php } ?>


                </div><?php }?>

                <div class="col-md-6" id="shipping-right-div">
                    <h4 class="under-line-div">Payment Method</h4>

                    <div class="">
                        <p>Please select the preferred service to use on this order.</p>

                        <table class="table shippingmethod-table">
    <?php if (sizeof($data['payment_methods']) > 0) {
        foreach ($data['payment_methods'] as $payment) {
            ?>
                                    <tr>
                                        <td><?php echo $payment['title']; ?></td>

                                        <td><input type="radio" class="" name='payment_method' id='payment_method'  value='<?php echo $payment['code'] ?>'/></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan='2'>No Payment Gateway Available  </td>
                                </tr>
                            <?php } ?>   
                        </table>
                     <?php if($data['terms']) {?>   <p class="agree-link-main">I have read and agree to <a  data-toggle="modal" data-target="#myModal" class="popup-link-div"><?php echo $data['terms']['title'];?>  </a> <input type="checkbox" class="checkbox" name="agree" id="agree" value="1"/>
 </p><?php }?>
                        
						

                    </div>
                </div>
            </form>
			<div><p> <span id="confirmButton"><?php
                            /*$this->widget('bootstrap.widgets.TbButton', array('type' => 'inverse', 'buttonType' => 'submit', 'size' => 'inverse', 'label' => 'Confirm order',
                                'htmlOptions' => array('class' => 'addtocart pull-right', 'url' => $this->createAbsoluteUrl('account/orderdetails', array('id' => $data->id_order))),));*/
                            ?></span>
						</p></div>
        </div>

    <div class="clearfix" ></div>
</div>
<div class="clearfix" ></div>


<script type="text/javascript">
$(document).ready(function(){
if ($('#shipping-left-div').length == 0 || $('#shipping-left-div').length < 0) {
								$("#shipping-right-div").removeClass("col-md-6").addClass("col-md-12");
							}	
                            
                            });
							</script>