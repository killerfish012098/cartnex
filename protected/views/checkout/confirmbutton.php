<form name='frmConfirmOrder' id='frmConfirmOrder' action="<?php echo $data['addParams']['action'];?>" method="post">
<?php 
if($data['addParams']['hiddenData'])
{
	echo $data['addParams']['hiddenData'];
}

if ($data['addParams']['inputFields'])
	{?>
		<h2>Credit Card Details</h2>
		<div class="contentText">
			<table border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td colspan="4"><?php echo $confirmation['title']; ?></td>
			</tr>
		<?php
		for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++)
		{
		?>
		<tr>
			<td><?php //echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
			<td class="main"><?php //echo $confirmation['fields'][$i]['title']; ?></td>
			<td><?php //echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
			<td class="main"><?php //echo $confirmation['fields'][$i]['field']; ?></td>
		</tr>
		<?php
		}
		?>
		</table>
		</div>
<?php }?>

		<button name="yt0" type="submit" id="yw0" url="http://sun-network/front_end/index.php?r=account/orderdetails&amp;id=" class="addtocart pull-right btn btn-inverse">Confirm order</button>
		</form>