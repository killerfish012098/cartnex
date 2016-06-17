<?
//echo '<pre>';print_r($data);echo '</pre>';exit;
$categories=$data[categories];
$category_id=$data[id_category];
$child_id=$data[child_id];
?>
 
<div class="row col-md-12 sp-os">
    <div class="module-main-div">
        <div class="categories-div-wapper">
            <div class="heading-box "> <h2>Categories</h2>  </div>

		 <div class="module-content">
                <ul class="categories-list">	
                
<?php foreach ($categories as $category) { ?>
<li>
<?php if ($category['id_category'] == $category_id) { ?>
<a href="<?php echo $category['href']; ?>" class="active"><span class="glyphicon glyphicon-chevron-right"> </span> <?php echo $category['name']; ?></a>
<?php } else { ?>
<a href="<?php echo $category['href']; ?>"><span class="glyphicon glyphicon-chevron-down"> </span> <?php echo $category['name']; ?></a>
<?php } ?>
<?php if ($category['children']) { ?>
   <div class="style-sub">

<?php foreach ($category['children'] as $child) { ?>
<ul>
<li>
<?php
if ($child['id_category'] == $child_id) { ?>
<a href="<?php echo $child['href']; ?>" class="active"> <span class="glyphicon glyphicon-chevron-down"> </span>  <?php echo $child['name']; ?></a>

<?php } else { ?>
<a href="<?php echo $child['href']; ?>"> <span class="glyphicon glyphicon-chevron-down"> </span>  <?php echo $child['name']; ?></a>
<?php } ?>
<?php if ($child['sub_child']) { ?>
<ul >

<?php foreach ($child['sub_child'] as $sub_child) { ?>
<li>
<?php
if ($sub_child['id_category'] == $sub_child_id) { ?>
<a href="<?php echo $sub_child['href']; ?>" class="active">  <span class="glyphicon glyphicon-chevron-down"> </span> <?php echo $sub_child['name']; ?></a>

<?php } else { ?>
<a href="<?php echo $sub_child['href']; ?>">  <span class="glyphicon glyphicon-chevron-down"> </span> <?php echo $sub_child['name']; ?></a>
<?php } ?>
</li>
<?php } ?>
<?if($child['view_more']=='1'){?>
<li class="more-view"><a href="<?php echo $child['href']; ?>">View More</a></li>
<?}?>
</ul>

<?php } ?>

</li>
</ul>
<?php } ?>

</div>
<?php } ?>
</li>
<?php } ?>
</ul>

		</div>
	</div></div>
</div>





