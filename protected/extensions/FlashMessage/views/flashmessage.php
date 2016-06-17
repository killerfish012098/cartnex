<!--<div class="notification-msg-div" id="notification"><div id="success" class="alert in fade alert-success">successfully add to cart<a data-dismiss="alert" class="close" style="cursor:pointer">×</a></div></div>-->
<?php  
foreach($this->flashMessages as $key => $message): $exp=explode('_',$key);?>
<div class="alert in fade alert-<?php echo $exp[0];?>"><?php echo $message;?><a data-dismiss="alert" class="close" style="cursor:pointer">×</a></div>	
<?php   endforeach;?>
