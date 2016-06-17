<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>%store_name%</title>
</head>
<body>
<div id="" style="width: 680px; color: #000000;	font-family: Arial, Helvetica, sans-serif; font-size: 12px;line-height:13px;">
<a href="%store_url%" title="%store_name%"><img src="%store_logo%" alt="%store_name%" id="" style="margin-bottom: 0px;text-align:center;"/></a>
<p>Thank you for your interest in our products. Your order has been received and will be processed once payment has been confirmed.</p>
<?php
if ($id_customer) {?>
  <p><?php
    echo "To view your order <a href='".$link."' target='_blank' style='color: #378DC1;	text-decoration: underline;	cursor: pointer;'>click here</a>";?></p>
<?php
}?>
<?php
if ($download) {
?>
  <p><?php echo "Once your payment has been confirmed you can click on the link below to access your downloadable products:";?></p>
  <p><a href="<?php echo $link;?>" style="color: #378DC1;	text-decoration: underline;	cursor: pointer;">Click here</a></p>
  <?php
}
?>
 <table style="border-collapse: collapse;	width: 100%;	border-top: 1px solid #DDDDDD;	border-left: 1px solid #DDDDDD;	margin-bottom: 15px; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD;">
    <thead>
      <tr>
        <td class="" style=" background-color: #EFEFEF;	padding: 0px 5px; border-right: 1px solid #DDDDDD; font-weight:bold;padding:7px;">Product</td>
        <td class="" style=" background-color: #EFEFEF;	padding: 0px 5px; border-right: 1px solid #DDDDDD; font-weight:bold;padding:7px;">Model</td>
        <td class="" style=" background-color: #EFEFEF;	padding: 0px 5px; border-right: 1px solid #DDDDDD; font-weight:bold;padding:7px;">Quantity</td>
        <td class="" style=" background-color: #EFEFEF;	padding: 0px 5px; border-right: 1px solid #DDDDDD; font-weight:bold;padding:7px;">Price</td>
   		<td class="" style=" background-color: #EFEFEF;	padding: 0px 5px; border-right: 1px solid #DDDDDD; font-weight:bold;padding:7px;">Total</td>
      </tr>
    </thead>
    <tbody>
      <?php
foreach ($products as $product) {
?>
      <tr>
        <td class="" style="border-right: 1px solid #DDDDDD;	border-bottom: 1px solid #DDDDDD;text-align: left;	padding: 7px;"><?php
    echo $product['name'];
?>
          <?php
    foreach ($product['option'] as $option) {
?>
          <br />
           <small> - <?php
        echo $option['name'];
?>: <?php
        echo $option['value'];
?></small>
          <?php
    }
?></td>
        <td class="" style="border-right: 1px solid #DDDDDD;	border-bottom: 1px solid #DDDDDD; text-align: left;	padding: 7px;"><?php
    echo $product['model'];
?></td>
        <td class="" style="border-right: 1px solid #DDDDDD;	border-bottom: 1px solid #DDDDDD; text-align: right;padding: 7px;" ><?php
    echo $product['quantity'];
?></td>
        <td class="" style="border-right: 1px solid #DDDDDD;	border-bottom: 1px solid #DDDDDD; text-align: right;padding: 7px;" ><?php
    echo $product['price'];
?></td>
        <td class="" style="border-right: 1px solid #DDDDDD;	border-bottom: 1px solid #DDDDDD; text-align: right;padding: 7px;" ><?php
    echo $product['total'];
?></td>
      </tr>
      <?php
}
?>
    </tbody>
    <tfoot  style="border-bottom:1px solid #ddd; ">
      <?php
foreach ($cartrules as $cartrule) {
?>
      <tr>
        <td colspan="4" class="" style="text-align: right;	padding: 7px; border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><b>
		<?php echo $cartrule['title'];?></b></td>
        <td class="" style="text-align: right; padding: 7px;border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><?php
    echo $cartrule['text'];?></td>
      </tr>
      <?php
}
?>
    </tfoot>
  </table>
  <table class="" style="border-collapse: collapse;	width: 100%; margin-bottom: 15px;  border:1px solid #DDDDDD;">
    <thead>
      <tr>
        <td class="" colspan="2" style="text-align: left;	padding: 7px; background-color: #EFEFEF; border:1px solid #DDDDDD; font-weight:bold;"><?php
echo 'Order Details';
?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="" style="text-align: left; padding: 7px; border-right:1px solid #DDDDDD;font-weight:bold; "><?php if ($invoice_no) { ?>
          <b><?php
    echo 'Invoice No.:'; ?></b> <?php
    echo $invoice_no;
?><br />
          <?php
}
?>
          <b><?php
echo 'Order No:';
?></b> <?php
echo $id_order;
?><br />
          <b><?php
echo 'Order Placed On:';
?></b> <?php
echo $date_created;?><br />
          <b><?php
echo 'Payment Method:';
?></b> <?php
echo $payment_method;
?></td>
        <td class="left" style="text-align: left;	padding: 7px; "><b><?php
echo 'Email:';
?></b> <?php
echo $email;
?><br />
          <b><?php
echo 'Telephone:';
?></b> <?php
echo $telephone;
?><br />
          <?php
if ($shipping_method) {
?>
          <b><?php
    echo 'Shipping Method:';
?></b> <?php
    echo $shipping_method;
?>
          <?php
}
?>
        </td>
      </tr>
    </tbody>
  </table>
  <table class="" style="border-collapse: collapse;	width: 100%;	border-top: 1px solid #DDDDDD;	border-left: 1px solid #DDDDDD;	margin-bottom: 10px;">
    <thead>
      <tr>
        <td class="left" style="text-align: left;	padding: 7px; border-right:1px solid #DDDDDD;background:#efefef; border:1px solid #ddd; font-weight:bold;"><?php echo 'Payment Address'; ?></td>
        <?php if ($shipping_address) {
?>
        <td class="left" style="text-align: left; padding: 7px; background:#efefef;border:1px solid #ddd; font-weight:bold;"><?php    echo 'Shipping Address'; ?></td>
        <?php
}
?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="" style="text-align: left;	padding: 7px; border-right:1px solid #ddd; border-bottom:1px solid #ddd; font-weight:bold;"><?php echo $payment_address; ?></td>
        <?php if ($shipping_address) { ?>        
        <td class="" style="text-align: left;	padding: 7px; border-right:1px solid #ddd; border-bottom:1px solid #ddd; "><?php   echo $shipping_address; ?></td>
        <?php
}
?>
      </tr>
    </tbody>
  </table>
  <table align="left" width="100%"  style="margin-bottom:15px;">
  <tr>
  	<td align="left" style="float:left;"><p>Please reply to this email if you have any questions</p></td>
<td align="right" style=" float:right; text-align:right;"><p>Powered By <a href="%store_url%" target="_blank" style="color: #378DC1;text-decoration: underline; cursor: pointer" >%store_name%</a></p></td>
</tr>
  </table>
</div>
</body>
</html>