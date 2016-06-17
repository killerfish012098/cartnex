<?php //echo '<pre>';print_r($data['product']['options']);echo '</pre>';
//echo "image title ". Yii::app()->session['image_upload'];?>
<script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/sporanzo.min.js" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/jquery.elevatezoom.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params['config']['site_url']; ?>css/popup.css" type="text/css">
<div class="center-wrapper Categories-inner-pages"> 
    <div class="detail-page col-md-12 row">
       <div class="col-md-9">
        <div class="image-details  col-xs-12 col-sm-4 col-md-7">
            <div class="product-detailes-main">
                <div class="col-md-2 mslider-right">
                    <?php
                    if (count($data['product']['images']) > 0) {
                        $i = 2; ?>
                        <div class="gallery">
                            <div id="gallery_01">
                                
                                <div class="slider-div-main" style="height:<?php echo Yii::app()->imageSize->productThumb[h] ?>px; overflow-y:scroll;" id="makeMeScrollable">
                                    <ul>
                                        <?php foreach ($data['product']['images'] as $image):?>
                                            <li><a  class="thumbnail" data-value='<?php echo $i;?>' data-image="<?php  echo $image['thumb'];?>" 
                                                    data-zoom-image="<?php echo $image['image'];?>" data-scroll-width='1000' data-scroll="<?php echo $image['image'];?>">
                                                <img src="<?php   echo $image['icon'];?>" alt="<?php echo $data['product']['name'];?>" title="<?php echo $data['product']['name'];?>" />
                                                </a>
                                            </li>
                    <?php $i++;    endforeach;?>
                                    </ul>
                                </div>
                            </div></div>
                    <?php } ?>
                </div>
                <div class="left col-md-10" id="prod-image"> 
                    <img id="img_01" class='topup1 highslide' src='<?php echo $data['product']['image']['thumb'];?>' data-zoom-image="<?php echo $data['product']['image']['image'];
?>" data-scroll-width='300' data-scroll="<?php echo $data['product']['image']['image'];?>"/> <!--pro_detailImgs --> </div>

                <div class="loader"></div>
                <div id="backgroundPopup"></div>
                <div id="toPopup"> 
                    <div class="close fancybox-close"></div><span class="ecs_tooltip"><?php echo Yii::t('common',    'text_esc_close')
?><span class="arrow"></span></span>
                    <div id="popup_content"> 
                        <img src='<?php echo Yii::app()->params['config']['site_url']; ?>images/arrow-delt-left.png' id='right' name='1'/>

                        <!--your content start-->
                        <div class='innerdiv'>
                                 <?php
                                 $j = 1;
                                 if(count($data['product']['images']) > 0) {
                                     foreach ($data['product']['images'] as  $image):?>
                                    <img id='image<?php echo $j ?>' src='<?php echo $image['image'];?>' data-zoom-image="<?php echo $image['image'];?>" data-scroll-width='300' 
                                         data-scroll="<?php echo $image['image'];?>" class='innerimg active '/>
        <?php
        ++$j;
    endforeach;
}?>                                             
                        </div> <img src='<?php echo Yii::app()->params['config']['site_url']; ?>/images/arrow-delt-right.png' id='left' name='1'/> </div> 
                </div>



            </div>

        </div>
 

        <div class="product-details col-xs-12 col-sm-5">
            <div class="brand-name"><?php echo $data['product']['manufacturer'] ?><img title="<?php echo $data['product']['manufacturer'] ?>"
            alt="<?php echo $data['product']['manufacturer'] ?>" class="brand-img"  src="<?php echo $data['product']['manufacturer_image'];?>"></div>
            <div class="name-div"><h3><?php echo $data['product']['full_name'] ?></h3> </div>
            <div class="product-code-div"><?php echo $data['product']['model'] ?></div>	
            <?php if ($data['product']['quantity']<=0) { ?>

                    
					<div class="stock-main-div">
                                                <span class="stock-div">
                                                    <span class="label label-danger"><?php echo $data['product']['stock_status']; ?></span>
                                                </span> 
                                            </div>
					<?php } ?>
                    <?php if (count($data['group']['products']) > 0) { ?>
                <div class="available-div"><strong><?php echo $data['group']['lable']; ?> </strong><br />
    <?php foreach ($data['group']['products'] as $product) { ?>
                        <a href="<?php echo $this->createUrl('product/productdetails',array('product_id'=> $product['id_product'])); ?>">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name'] ?>" 
                                 title="<?php echo $product['name'] ?>" class="available-div-img" />  </a>
    <?php } ?>
                </div>
<?php } ?>
<?php if ($data['reviews']) { ?>
                <p class="rating-div"><strong><?php echo Yii::t('product','text_overall_rating')
    ?></strong>
                    <img src="<?php echo Yii::app()->params['config']['site_url'] . 'images/' . $data['product']['rating'] . "-star.png"; ?>"/></p>

                <p class="Reviews-cm-div"><strong><?php echo Yii::t('product',
                                        'text_customer_reviews')
                                ?></strong><br /> <span class="allreviews-div"><a href="#review_report"><?php echo Yii::t('product',
                                    'text_read_reviews')
                                ?></a> </span> <span class="write-review-div"> <a href="#review_report"><?php echo Yii::t('product',
                                    'text_write_review')
                                ?> </a> </span></p>
<?php } ?>

        </div>
            <div class="product-like-these  col-xs-12 col-sm-12">
            <?php if (count($data['product']['otherGroup'])) {
    
foreach($data['product']['otherGroup'] as $key => $otherGroup){
	$groupName=explode("_",$key);
	?>
    <div class="row col-md-12 details-mail">
                <div class="heading-box heading-product hero-unit"><h2><?php echo $groupName[1]; ?></h2></div>
               
    <?php foreach ($otherGroup as $otherProduct) { //echo '<pre>';print_r($otherProduct);echo '</pre>';?>
                        <a href="<?php echo $this->createUrl('product/productdetails',array('product_id'=> $otherProduct['id_product'])); ?>">
                            <img src="<?php echo $otherProduct['image']; ?>" alt="<?php echo $otherProduct['name'] ?>" 
                                 title="<?php echo $otherProduct['name'] ?>" class="available-div-img" />  </a>
    <?php } ?>
                </div>
<?php } } ?>     
            </div>
        
          </div>
        <div class="buy-details col-xs-12 col-sm-4 col-md-3">
            <div class="right-detalies">

                <h4 class="tital-h4">
                    <?php if ($data['product']['price']) { ?>
<div class="price-div"><?php if ($data['product']['special']) { ?>
	<span class="new-price-div"><?php echo $data['product']['special']; ?></span> 
	<span class="price-old"><?php echo $data['product']['price']; ?></span> <br />
	<?php } else { ?><span class="new-price-div"><?php echo $data['product']['price']; ?></span><?php } ?>
	<?php foreach($data['product']['special_prices'] as $special){?>
	<span class="price-offer"><?php echo $special['label'];?></span><?php }?>
</div>
<?php } echo $data['product']['taxInfo'];?>                
                </h4>
                <div class="col-md-12 picer-div-window">
                    <?php if (is_array($data['product']['options'])) { ?>

    <?php
    foreach ($data['product']['options'] as $option) {
        if ($option['type'] == 'select') { ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['id_product_option'] ?>" class="option product-selects">
                                        <label class="attribute_label product-select-label" ><?php echo $option['name'] ?>  <?php
                            if ($option['required'] == '1') {
                                echo "<span style='color:red'>*</span>";
                            }
            ?> </label>
                                        <select name="option[<?php echo $option['id_product_option'] ?>]" class="product-item product-select form-control" >
                                            <option value=''><?php echo Yii::t('common','text_select')?> </option>
                                            <?php foreach ($option['option_value'] as $option_value) { ?>
                                                <option value='<?php echo $option_value['id_product_option_value'] ?>'><?php echo $option_value['name'] ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                            }
                            if ($option['type'] == 'radio') {
                                ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['id_product_option'] ?>" class="option product-inputtext">
                                        <label class="attribute_label product-radio-label " ><?php echo $option['name'] ?>  <?php
                                if ($option['required'] == '1') {
                                    echo "<span style='color:red'>*</span>";
                                }
                                ?> </label> 
                                <?php foreach ($option['option_value'] as    $option_value) {?>
                                            <div class="col-md-6 product-input-text-boxs"><input type="radio"  class="product-items product-input-text-box " 
                                           name="option[<?php echo $option['id_product_option'] ?>]" value="<?php echo $option_value['id_product_option_value'] ?>" />
                                               <?php echo $option_value['name']; ?> </div>
                                            <?php } ?>
                                    </div>	  <div class="clearfix"></div></div>
                                        <?php
                                        }
                                        if ($option['type'] == 'checkbox') {
                                            ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['id_product_option'] ?>"  class="option product-radio">
                                        <label class="attribute_label product-checkbox-label" ><?php echo $option['name'] ?>  <?php
                    if ($option['required'] == '1') {
                        echo "<span style='color:red'>*</span>";
                    }
                                            ?>  </label> 
                                            <?php foreach ($option['option_value'] as $option_value) { ?>

                                            <input type="checkbox" class="product-items product-checkbox-input" name="option[<?php echo $option['id_product_option'] ?>][]" 
                                                   value="<?php echo $option_value['id_product_option_value'] ?>" /><?php echo $option_value['name']; ?>

                                <?php } ?><br/>
                                    </div>  <div class="clearfix"></div></div>
                            <?php
                            }
                            if ($option['type'] == 'datetime') {
                                ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['id_product_option'] ?>" class="option product-radio">
                                        <label class="attribute_label product-Datetime-label" ><?php echo $option['name'] ?> <?php
                                if ($option['required'] == '1') {
                                    echo "<span style='color:red'>*</span>";
                                }
                                ?>  </label> 
                                        <input type="text" class="product-items product-radio-input form-control" id="datetimepicker" name="option[<?php echo $option['product_option_id'] ?>]" value="<?php echo $option['option_value'] ?>" class="datetime"/>
                                    </div>
                                </div>
                                        <?php
                                        }
                                        if ($option['type'] == 'textarea') {
                                            ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['id_product_option'] ?>" class="option product-textarea">
                                        <label class="attribute_label product-Datetime-label " ><?php echo $option['name'] ?>  <?php
                                if ($option['required'] == '1') {
                                    echo "<span style='color:red'>*</span>";
                                }
                                ?> </label>

                                        <textarea class="product-items product-textarea-div form-control" name="option[<?php echo $option['id_product_option'] ?>]">
                                            <?php echo $option['option_value'] ?></textarea>
                                    </div>
                                </div>
                                        <?php
                                        }
                                        if ($option['type'] == 'text') {   ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['product_option_id'] ?>" class="option product-option">
                                        <label class="attribute_label product-Datetime-label" ><?php echo $option['name'] ?>   <?php
                                if ($option['required'] == '1') {
                                    echo "<span style='color:red'>*</span>";
                                }
                                ?> </label>

                                        <input type="text" class="product-items product-option-div form-control" name="option[<?php echo $option['id_product_option'] ?>]" 
                                               value="<?php echo $option['option_value'] ?>">
                                    </div>
                                </div>
                                <?php
                                }
                                if ($option['type'] == 'date') {
                                    ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['id_product_option'] ?>" class="option product-date">
                                        <label class="attribute_label product-Datetime-label" ><?php echo $option['name'] ?> <?php
                                    if ($option['required'] == '1') {
                                        echo "<span style='color:red'>*</span>";
                                    }
                                    ?> </label>

                                        <input type="text" class="product-items product-date-div  form-control" id="date" name="option[<?php echo $option['id_product_option'] ?>]" value="<?php echo $option['option_value'] ?>" class="date" value="<?php echo $options['option_value'] ?>"/>
                                    </div>
                                </div>
        <?php
        }
        if ($option['type'] == 'time') {
            ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['id_product_option'] ?>" class="option product-datetime">
                                        <label class="attribute_label product-Datetime-label" ><?php echo $option['name'] ?>   <?php
                            if ($option['required'] == '1') {
                                echo "<span style='color:red'>*</span>";
                            }
                            ?> </label>

                                        <input type="text" class="product-items product-datetime-div  form-control" id="time" name="option[<?php echo $option['id_product_option'] ?>]" value="<?php echo $option['option_value'] ?>" class="time"/>
                                    </div>
                                </div>
                <?php
                }
                if ($option['type'] == 'file') {
                    ?>
                                <div class="product-items">
                                    <div id="option-<?php echo $option['id_product_option'] ?>" class="option product-datetime">
                                        <label class="attribute_label product-Datetime-label" ><?php echo $option['name'] ?> <?php
                            if ($option['required'] == '1') {
                                echo "<span style='color:red'>*</span>";
                            }
                        ?> </label>
                                        <a style="cursor:pointer" onclick="$('#FileInput_<?php echo $option['id_product_option'] ?>').click();" class="btn btn-inverse"><?php echo $option['name'] ?> </a>
                                        <form action="<?php echo $this->createUrl("product/uploadfile"); ?>" method="post" enctype="multipart/form-data" id="MyUploadForm_<?php echo $option['id_product_option'] ?>" name="file_form_file_<?php echo $option['id_product_option'] ?>">
                                            <input name="FileInput_<?php echo $option['id_product_option'] ?>" id="FileInput_<?php echo $option['id_product_option'] ?>" type="file" onChange="$('#MyUploadForm_<?php echo $option['id_product_option'] ?>').submit()" style="display:none;"/>
                                            <input type='hidden' id="file_id" name='file_id[<?php echo $option['id_product_option'] ?>]' value="<?php echo $option['id_product_option'] ?>">
                                        </form>
                                        <input type="hidden" class="product-items product-datetime-div  form-control" id="file_<?php echo $option['id_product_option'] ?>" name="option[<?php echo $option['id_product_option'] ?>]" value=""/>
                                        <div id="output_<?php echo $option['id_product_option'] ?>"></div>
                                    </div>
                                </div>
                   
                    <?php }   ?>
                <?php }
            }
            ?>

                </div>
                
               


                <div class="col-md-12 quantity-divs">
                    <h3 class="quantity-div"><?php echo Yii::t('product',
                    'text_quantity')
            ?>:</h3>  
                    <input type="text" name="quantity" id="quantity" class="quantity-box ui-autocomplete-input" autocomplete="off" value="<?php echo $data['product']['minimum']; ?>">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $_GET['product_id']; ?>">
                    <a id="yw6" class=" btn btn-inverse" onclick="return quantityDecrement();">-</a>
                    <a id="yw6" class="btn btn-inverse" onclick="return quantityIncrement();">+</a>

                    <div class="clearfix"></div>
                </div>

                <div class="col-md-12 addtocart-div-close">
                    <div class="addtocart-div"><?php
            $this->widget('bootstrap.widgets.TbButton',
                    array('visible'=>(($data['product']['quantity']<=0) && !(Yii::app()->config->getData('CONFIG_STORE_ALLOW_CHECKOUT')))?false:true,
					'type' => 'inverse', 'size' => 'large', 'label' => Yii::t('common',
                        'button_cart'), 'htmlOptions' => array('class' => 'addtocart',
                    'id' => 'button-cart'),));
            ?></div> 
                    <div class="clearfix"></div>
                </div>
                
                <div class="col-md-12  Addbtns-div">

                    <span class="write-a-review"> <span class="glyphicon glyphicon-pencil"></span> <a style="cursor:pointer;" onclick="return addToCompare('<?php echo $data['product']['id_product']; ?>')";><?php echo Yii::t('common',
                    'button_compare')
            ?></a></span> <span class="add-to-my-wishlist"> <span class="glyphicon glyphicon-heart"></span> <a style="cursor:pointer;" onclick="return addToWishList('<?php echo $data['product']['id_product']; ?>')";><?php echo Yii::t('common',
                                                    'button_wishlist')
            ?></a></span>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        
     
                                                <?php if ($data['product']['description'] != '') { ?>
            <div class="row col-md-12 details-mail">
                <div class="heading-box heading-product hero-unit"><h2><?php echo $data['product']['full_name'] ?></h2></div>
                <p><?php echo $data['product']['description'] ?></p>

            </div>
<?php } ?>

        <div class="row col-md-12 space-box ">
<?php if (count($data['attributes']) > 0) { ?>
                <div class=" col-md-6 " id="specification">
                    <div class="heading-box heading-product hero-unit"><h2><?php echo Yii::t('product',
            'heading_title_specifications')
    ?></h2></div>
<?php //echo '<pre>';print_r($data['attributes']);echo '</pre>';?>
<table cellpadding="0" class="table" cellspacing="0" >
<?php if($data['attributes']['General']){?>
    <tr>
			<td><strong>General</strong></td><td></td><td></td>
		</tr>
		<?php foreach ($data['attributes']['General'] as $details) {
                    foreach($details['attribute'] as $attribute) {?>
		<tr>
                    <td><?php echo $details['name']; ?>	</td><td>:</td><td><?php echo $attribute['name']; ?></td>
		</tr>
                    <?php }
                    
                    }
}?>
<?php 
    foreach($data['attributes']['Attribute'] as $group=>$details)
        {?>
		<tr>
			<td><strong><?php echo $details['name']; ?></strong></td><td></td><td></td>
		</tr>
		<?php foreach ($details['attribute'] as $attribute) {?>
		<tr>
                    <td><?php echo $attribute['name']; ?>	</td><td>:</td><td><?php echo $attribute['text']; ?></td>
		</tr>
		<?php } ?>
  <?php }?>
</table>

</div><?php }?>
               
                <?php if ($data['reviews']) { ?>
                <div class=" col-md-6" id="review_report">
                    <div class="heading-box heading-product hero-unit"><h2><?php echo Yii::t('product','heading_title_review')
                ?></h2></div> 
                    <table class="table review-product-div">


                        <tr>
                            <td width="372" colspan="2" style="padding:0px;">
                                <table width="100%">
                                    <tr>
                                        <td><div id="response-text"></div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><p><strong><?php echo Yii::t('product',
                        'text_your_name')
                ?></strong></p></td>

                                        <td><p>  <input type="text" size="40" id="review_title" class="form-control" value="" name="review_title" placeholder="Your Name"/>
                                            </p></td>
                                    </tr>
                                    <tr>
                                        <td width="42%" valign="top"> <strong><?php echo Yii::t('product',
                        'text_your_review')
                ?></strong> </p></td>

                                        <td><p>  <textarea rows="2"  class="form-control"  id="review_description" name="review_description" placeholder="Your Review:"></textarea><input type="hidden" name="product_id" id="product_id" value="<?php echo $_GET['product_id'] ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><?php echo Yii::t('product',
                        'text_review_yourrating')
                ?></strong></p></td>

                                        <td><p><?php echo Yii::t('product',
                        'text_review_bad')
                ?>
                                                <input type="radio" size="" name="rating" value="1" onclick="$('#ratings').val(this.value);"/>
                                                <input type="radio" size="" name="rating" value="2" onclick="$('#ratings').val(this.value);"/>
                                                <input type="radio" size="" name="rating" value="3" onclick="$('#ratings').val(this.value);"/>
                                                <input type="radio" size="" name="rating" value="4" onclick="$('#ratings').val(this.value);"/>
                                                <input type="radio" size="" name="rating" value="5" onclick="$('#ratings').val(this.value);"/>
                                                <input type="hidden" name="ratings" value="" id="ratings"/>
    <?php echo Yii::t('product', 'text_review_good') ?></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><p>
                                                <strong><?php echo Yii::t('product',
            'text_review_capcha')
    ?></strong></p></td>

                                        <td><p> <input type="text" size="" id="review_code" class="form-control" value="" name="review_code" placeholder="Please Enter the code in the box below"/>	 </p><p><img src="<?php echo $this->createUrl('product/captcha'); ?>" alt="captcha" /></p></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="text-align:right;"> <a id="post-rating" class="btn btn-inverse"><?php echo Yii::t('product',
            'text_review_post')
    ?></a></td>
                        </tr>


                    </table>  
    <?php
    
    if (count($data['reviews_data']) > 0) {
        foreach ($data['reviews_data'] as $review):
            ?>
                            <div class="col-md-12 row" style="border-bottom: 1px dotted #ccc;padding: 16px 0;">
                                <div class="col-md-2"><span><img src="<?php echo Yii::app()->params['config']['site_url'] . 'images/' . $review['rating'] . "-star.png"; ?>"/></span>
                                    <br />
                                    <strong><?php echo ucfirst($review['customer_name']); ?></strong></div>
                                <div class="col-md-10">
                                    <span class="data-review"> <strong><?php echo Yii::t('product', 'text_review_date')
            ?></strong> <?php echo date("d-m-Y",
                    strtotime($review['date_created']));
            ?></span> <br />
                                    <span><?php echo $review['text']; ?></span>

                                </div>
                            </div>
        <?php endforeach;
    }
    ?>
                </div>
<?php } ?>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php //echo '<pre>';print_r($data[product]); echo '</pre>';?>

<script type="text/javascript"><!--

//product thumbimage script
    function getthumbimage() {
        $("#prod-image").html("<img id='img_01' class='topup1 highslide' src='<?php
echo Yii::app()->image->resize($data['product']['image'],
        Yii::app()->imageSize->productThumb[w],
        Yii::app()->imageSize->productThumb[h]);
?>' data-zoom-image='<?php echo Yii::app()->image->resize($data['product']['image'],
        '1000', '1000');
?>'   data-scroll-width='1000' data-scroll='<?php echo Yii::app()->image->resize($data['product']['image'],
        '800', '800');
?>'/>")
    }
//--></script> 
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['config']['site_url']; ?>css/jquery.datetimepicker.css" />
<script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/jquery.datetimepicker.js"></script>
<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
                        format: 'Y-m-d H:i',
                        step: 10,
                    });
                    $('#date').datetimepicker({
                        timepicker: false,
                        format: 'Y-m-d',
                    });
                    $('#time').datetimepicker({
                        datepicker: false,
                        format: 'H:i',
                        step: 10
                    });
    
    
    $(document).ready(function() {
        $available = $("#specification").index();
        if ($available < 0) {
            $("#review_report").removeClass("col-md-6").addClass("col-md-12");
        }

    });
    $('#button-cart').bind('click', function() {

        $.ajax({
            url: '<?php echo $this->createUrl("checkout/cart",
        array("cpage" => "productdetails"));
?>',
            type: 'post',
            data: $('.row input[type=\'text\'], .row input[type=\'hidden\'], .row input[type=\'radio\']:checked, .row input[type=\'checkbox\']:checked, .row select, .row textarea'),
            dataType: 'json',
            success: function(json) {
                $('.success, .warning, .attention, information, .error').remove();
                if (json['error']) {
                    if (json['error']['option']) {
                        for (i in json['error']['option']) {
                            $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
                        }
                    }

                    if (json['error']['profile']) {
                        $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                    }
                }
                if (json['redirect']) {
                    location = json['redirect'];
                }
                if (json['success']) {
                //alert(json['success'])
                $('#notification').html('<div class="alert in fade alert-success">' + json['success'] + '<a data-dismiss="alert" class="close" style="cursor:pointer">×</a></div>');
                    //$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                    $('.success').fadeIn('slow');

                    $('#total_price').html(json['total_price']);
                    $('#total_qty').html(json['total_qty']);

                    $('html, body').animate({scrollTop: 0}, 'slow');
                }
            }
        });
    });
</script>
<script language=Javascript>

    $('.thumbnail').click(function() {
        $('.topup1').attr('data-scroll', $(this).attr('data-scroll'));
        $('.topup1').attr('data-scroll-width', $(this).attr('data-scroll-width'));
        $('.topup1').attr('data-value', $(this).attr('data-value'));
        $('.topup1').attr('data-zoom-image', $(this).attr('data-zoom-image'));
        $('.topup1').attr('src', $(this).attr('data-image'));
    });



    $(".topup1").click(function() {
        $('.zoomLens').css('display', 'none');
        $('.zoomWindow').css('display', 'none');
        $('#toPopup').css('background-image', 'url("' + $(this).attr('data-scroll') + '")');
        $('#toPopup').attr('data-scroll-width', $(this).attr('data-scroll-width'));
        if ($(this).attr('data-scroll-width') < 650) {
            $('#toPopup').css('background-position', 'center center');
        }
        ;
        $("#right").attr('name', $(this).attr('data-value'));

        loading(); // loading
        setTimeout(function() { // then show popup, deley in .5 second
            loadPopup(); // function show popup 
        }, 500); // .5 second
        return false;
    });

    /* event for close the popup */
    $("div.close").hover(
            function() {
                $('span.ecs_tooltip').show();
            },
            function() {
                $('span.ecs_tooltip').hide();
            }
    );

    $("div.close").click(function() {
        disablePopup();  // function close pop up
    });

    $(this).keyup(function(event) {
        if (event.which == 27) { // 27 is 'Ecs' in the keyboard
            disablePopup();  // function close pop up
        }
    });

    $("div#backgroundPopup").click(function() {
        disablePopup();  // function close pop up
    });

    $('a.livebox').click(function() {
        alert('Hello World!');
        return false;
    });


    /************** start: functions. **************/
    function loading() {
        $("div.loader").show();
    }
    function closeloading() {
        $("div.loader").fadeOut('normal');
    }

    var popupStatus = 0; // set value

    function loadPopup() {
        if (popupStatus == 0) { // if value is 0, show popup
            closeloading(); // fadeout loading
            $("#toPopup").fadeIn(0500); // fadein popup div
            $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
            $("#backgroundPopup").fadeIn(0001);
            popupStatus = 1; // and set value to 1
        }
    }

    function disablePopup() {
        if (popupStatus == 1) { // if value is 1, close popup
            $("#toPopup").fadeOut("normal");
            $("#backgroundPopup").fadeOut("normal");
            popupStatus = 0;  // and set value to 0
        }
    }

    /*--mouse over*/
    $("#toPopup").mousemove(function(e) {
        var x = $(this).position().left + ($(this).outerWidth(true) / 2);
        var y = ($(window).height() / 2);
        if (y == e.clientY) {
            e.clientY = "center";
        } else if (y > e.clientY) {

            e.clientY = "+" + parseInt(parseInt(y) - parseInt(e.clientY)) + "px";
        } else if (y < e.clientY) {
            e.clientY = "-" + parseInt(parseInt(e.clientY) - parseInt(y)) + "px";
        }
        $(this).css('background-position', 'center ' + e.clientY + '');
    }).mouseleave(function(e) {
        if ($(this).attr("data-scroll-width") < 650) {
            $.positionx = 120;
        } else if ($(this).attr('data-scroll-width') < 500) {
            $.positionx = 250;
        } else {
            $.positionx = 0;
        }
        $(this).css('background-position', 'center -' + e.clientY + 'px');
    });
    $('.innerimg').click(function() {
        $('#' + $('.active').attr('id')).css(' border-width', '4px').css('border-style', 'solid').css('border-color', '#666666');
        $('#' + $('.active').attr('id')).removeClass('active');
        $(this).addClass('active');
        $("#toPopup").fadeIn(1000).css('background-image', 'url("' + $(this).attr('data-scroll') + '")');
        $('#toPopup').attr('data-scroll-width', $(this).attr('data-scroll-width'));
        if ($('#toPopup').attr('data-scroll-width') > 500 && $('#toPopup').attr('data-scroll-width') < 650) {
            $('#toPopup').css('background-position', 'center 0px');
        } else if ($('#toPopup').attr('data-scroll-width') < 500) {
            $('#toPopup').css('background-position', 'center 0px');
        } else {
            $('#toPopup').css('background-position', 'center 0px');
        }
        ;
        $('.active').css(' border-width', '4px').css('border-style', 'solid').css('border-color', '#333');
    });
    $("#right").click(function() {
        var id = $(this).attr('name');

        id = parseInt(id) - parseInt(1);
        if (id >= 1) {
            $('#' + $('.active').attr('id')).css(' border-width', '4px').css('border-style', 'solid').css('border-color', '#666666');
            $('#' + $('.active').attr('id')).removeClass('active');
            $('.innerimg#image' + id).addClass('active');
            $("#toPopup").fadeIn(1000).css('background-image', 'url("' + $('.innerimg#image' + id).attr('data-scroll') + '")');
            $('#toPopup').attr('data-scroll-width', $('.innerimg#image' + id).attr('data-scroll-width'));
            if ($('#toPopup').attr('data-scroll-width') > 500 && $('#toPopup').attr('data-scroll-width') < 650) {
                $('#toPopup').css('background-position', 'center center');
            } else if ($('#toPopup').attr('data-scroll-width') < 500) {
                $('#toPopup').css('background-position', 'center center');
            } else {
                $('#toPopup').css('background-position', 'center center');
            }
            ;
            $('.active').css(' border-width', '1px').css('border-style', 'solid').css('border-color', '#333');
            $(this).attr('name', id);
        } else if ($(this).attr('name') == 1) {
            $('#' + $('.active').attr('id')).css(' border-width', '4px').css('border-style', 'solid').css('border-color', '#666666');
            $('#' + $('.active').attr('id')).removeClass('active');
            $('.innerimg#image' + $("#left").attr('count')).addClass('active');
            $("#toPopup").fadeIn(1000).css('background-image', 'url("' + $('.innerimg#image' + $("#left").attr('count')).attr('data-scroll') + '")');
            $('#toPopup').attr('data-scroll-width', $('.innerimg#image' + $("#left").attr('count')).attr('data-scroll-width'));

            if ($('#toPopup').attr('data-scroll-width') > 500 && $('#toPopup').attr('data-scroll-width') < 650) {
                $('#toPopup').css('background-position', 'center center');
            } else if ($('#toPopup').attr('data-scroll-width') < 500) {
                $('#toPopup').css('background-position', 'center center');
            } else {
                $('#toPopup').css('background-position', 'center center');
            }
            ;
            $('.active').css(' border-width', '1px').css('border-style', 'solid').css('border-color', '#333');
            $(this).attr('name', $("#left").attr('count'));
        }

    });
    $("#left").click(function() {
        if ($("#right").attr('name') < $(this).attr('count')) {
            var id = $("#right").attr('name');
            id = parseInt(id) + parseInt(1);
            $('#' + $('.active').attr('id')).css(' border-width', '4px').css('border-style', 'solid').css('border-color', '#666666');
            $('#' + $('.active').attr('id')).removeClass('active');
            $('.innerimg#image' + id).addClass('active');
            $("#toPopup").fadeIn(1000).css('background-image', 'url("' + $('.innerimg#image' + id).attr('data-scroll') + '")');
            $('#toPopup').attr('data-scroll-width', $('.innerimg#image' + id).attr('data-scroll-width'));
            if ($('#toPopup').attr('data-scroll-width') > 500 && $('#toPopup').attr('data-scroll-width') < 650) {
                $('#toPopup').css('background-position', 'center center');
            } else if ($('#toPopup').attr('data-scroll-width') < 500) {
                $('#toPopup').css('background-position', 'center center');
            } else {
                $('#toPopup').css('background-position', 'center center');
            }
            ;
            $('.active').css(' border-width', '1px').css('border-style', 'solid').css('border-color', '#333');
            $("#right").attr('name', id);
//alert($("#right").attr('name'));

        }
        if ($("#right").attr('name') == $(this).attr('count')) {
            $('#' + $('.active').attr('id')).css(' border-width', '4px').css('border-style', 'solid').css('border-color', '#666666');
            $('#' + $('.active').attr('id')).removeClass('active');
            $('.innerimg#image' + $(this).attr('count')).addClass('active');
            $("#toPopup").fadeIn(1000).css('background-image', 'url("' + $('.innerimg#image' + $(this).attr('count')).attr('data-scroll') + '")');
            $('#toPopup').attr('data-scroll-width', $('.innerimg#image' + $(this).attr('count')).attr('data-scroll-width'));
            if ($('#toPopup').attr('data-scroll-width') > 500 && $('#toPopup').attr('data-scroll-width') < 650) {
                $('#toPopup').css('background-position', 'center center');
            } else if ($('#toPopup').attr('data-scroll-width') < 500) {
                $('#toPopup').css('background-position', 'center center');
            } else {
                $('#toPopup').css('background-position', 'center center');
            }
            ;
            $('.active').css(' border-width', '1px').css('border-style', 'solid').css('border-color', '#333');
            $("#right").attr('name', 0);
        }

    });
    $("#img_01").elevateZoom({zoomType: "inner",
        cursor: "crosshair", gallery: 'gallery_01'
    });
    $("#img_01").bind("click", function(e) {
        var ez = $('#img_01').data('elevateZoom');
        $.fancybox(ez.getGalleryList());
        return false;
    });/**/
    var image = new Image(); // or document.createElement('img')
    var width, height;
    image.onload = function() {
        if ($(this).attr('id') == "img_01") {
            width = this.width;
            height = this.height;
        }
    };

</script>
<script type='text/javascript'>                    
  $(document).ready(function() { 
				var options = { 
                                  //  target:   '#output',  
                                  dataType: 'json', 
                                    //beforeSubmit:  beforeSubmit,
                                    success:       afterSuccess, 
                                    resetForm: true       
                            }; 
                      <?php foreach($data['product']['options'] as $option):?>      
                     $('#MyUploadForm_<?php echo $option["id_product_option"]?>').submit(function() { 
                                    $(this).ajaxSubmit(options);  			
                            return false; 
                            });
                      <?php endforeach;?>      
		    function afterSuccess(data)
                    {
                        //alert(data);
                        	 $('#output_'+data['id_product_option']).html(data['message']);
                        $('#file_'+data['id_product_option']).val(data['value']);
                    }
            }); 
 </script>