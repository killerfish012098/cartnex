<table width="100%" border="0" cellspacing="0" class="table table-online-div" style="margin-bottom:0px;" cellpadding="0">
  <tr class="prodct-div-main" >
    <th scope="col"  width="45%"><strong>Product Name</strong></th>
	<th scope="col"  width="10%"><strong>Qty</strong></th>
    <th scope="col"  width="18%"><strong>Price</strong></th>
	<th scope="col"  width="25%"><strong>Total</strong></th>
  </tr>
  </table>
  <div class="table-main-overflow table-online-div">
  <table width="100%" border="0" cellspacing="0" class="table" style="margin-bottom:0px; border-top:0px;"  cellpadding="0">

  <?php foreach ($data['product'] as $key=>$product){?>
  <tr>
	<td width="50%"><?php 
	
	$model=$product['model']!=""?"(".$product['model'].")":"";
	echo $product['name'].$model;?><br />
	<?php
	   if (count($product['option']) > 0):
		   foreach ($product['option'] as $option):?>
			<span class="col-md-12"> - <?php echo $option[name] . " : " . $option[option_value]; ?></span> 
			<?php
		endforeach;
	endif;
	?><br/>
	<img src="<?php echo $product['image'];?>" alt="<?php echo $product['name']?>" /></td>
 
    <td width="10%"><strong><?php echo $product['quantity'];?></strong></td>
	<td  width="20%" class="price"><?php echo $product['price'];?></td>
	<td width="20%"><h5><?php echo $product['total'];?></h5></td>
  </tr>
  <?php } ?>

</table>
  </div>

  <table width="100%" border="0" cellspacing="0" class="table table-online-div" style="margin-bottom:0px;"  cellpadding="0">
  <?php 
  foreach ($data['cart_rules']['cartRule'] as $rule){?>
  <tr class="total-div-main table-online-main">
    <td colspan="3"><?php echo $rule['label']?> </td>
    <td><strong> <?php echo $rule['text']?></strong></td>
  </tr>
  <?php } ?>
</table>
