<div class="row col-md-12 sp-os">
<div class="module-main-div">

<div class="module-content">
	
	<?php 
	foreach($data['banners'] as $banner)	{
	?>
	<div class="single-banner col-md-<?php echo $data['info']['box_size'];?> ">
	<div class="sp-image">
	<a href="<?php echo  $banner['link']?>" target="_blank" title="<?php echo  $banner['name'];?>" ><img src="<?php echo $banner['path'].$banner['image']?>"  alt="<?php echo  $banner['label'];?>" /></a>
	</div>
	</div>
	<?php } ?>
   
   </div>  
</div></div> <div class="clearfix"></div>