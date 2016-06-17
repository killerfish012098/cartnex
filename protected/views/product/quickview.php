<?php //echo '<pre>';print_r($data);echo '</pre>';exit;?>
<script type='text/javascript'>var site_url="<?php echo Yii::app()->params['config']['site_url']; ?>";
var product_list="<?php echo Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE'); ?>";</script>
<script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/common.js"></script>
<a class="close" data-dismiss="modal"></a>
<div id="myModal" class="quick-view-div" >
    <div class="col-md-5 image-details">
        <div class="img-blouse">
            <div id="main">
                <div class="col-md-2 style-div">
                    <ul class="pin-bring">
                        <li> <a id="demo-trigger" style="cursor:pointer;" onclick="return showImage('<?php echo $data['product']['image']; ?>')"><img src="<?php echo $data['product']['image']
?>" alt="<?php echo $data['product']['name']; ?> " title="<?php echo $data['product']['name']; ?> "   />
                            </a>
                        </li>
                        <?php foreach ($data['product']['images'] as $image): ?>
                            <li> <a id="demo-trigger" style="cursor:pointer;" onclick="return showImage('<?php echo $image['image']; ?>')">
                                    <img src="<?php echo $image['thumb']; ?>"  
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="panel col-md-10 ">
                    <ul id="images">
                        <li id="images_view"> 
                            <img src="<?php echo $data['product']['image']; ?>"  alt="<?php echo $data['product']['name']; ?>" 
                                 title="<?php echo $data['product']['name']; ?>"  />
                        </li>
                    </ul>
                    <div id="controls"></div>
                    <div class="clear"></div>
                </div>
                <div id="exposure"></div>			
                <div class="clear"></div>			
            </div>
        </div>
    </div>

    <div class="col-md-4 product-details">
            <?php if ($data['product']['manufacturer'] != '') { ?>
            <p class="brand-name"><?php echo $data['product']['manufacturer']; ?>
            <img title="<?php echo $data['product']['manufacturer'] ?>" alt="<?php echo $data['product']['manufacturer'] ?>" 
            class="brand-img" src="<?php  echo $data['product']['manufacturer_image'];?>"> </p><?php } ?>
        <p class="name-div"><h3><?php echo $data['product']['name']; ?> </h3> </p>
        <p class="product-code-div"><?php echo $data['product']['model']; ?></p>
         <?php if ($data['product']['quantity']<=0) { ?>

                    
					<div class="stock-main-div">
                                                <span class="stock-div">
                                                    <span class="label label-danger"><?php echo $data['product']['stock_status']; ?></span>
                                                </span> 
                                            </div>
					<?php } ?>

<?php if ($data['product']['reviews']) { ?>
            <div class="rating-div"><strong><?php echo Yii::t('product','text_overall_rating'); ?></strong>
                <img src="<?php echo Yii::app()->params['config']['site_url'] . 'images/' . $data['product']['rating'] . "-star.png"; ?>"/>
            </div>
<?php } ?>

    </div>
    <div class="col-md-3 buy-details">
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

            <div class="col-md-12 size-div-window picer-div-window">
                            <?php if (is_array($data['product']['options'])) { ?>
                                <?php
                                foreach ($data['product']['options'] as $options) {
                                    if ($options['type'] == 'select') {
                                        ?>
                            <div class="product-items">
                                <div id="option-<?php echo $options['id_product_option'] ?>" class="option product-selects">
                                    <label class="attribute_label product-select-label" > <?php
                            echo $options['name'];
                                        ?>  <?php
                            if ($options['required'] == '1') { echo "<span style='color:red'>*</span>";}
                            ?> </label>
                                    <select name="option[<?php echo $options['id_product_option'] ?>]" class="product-item product-select form-control" >
                                        <option value=''><?php echo Yii::t('common',
                                    'text_select') ?></option>
                            <?php foreach ($options['option_value'] as
                                        $option_value) { ?>
                                            <option value='<?php echo $option_value['id_product_option_value'] ?>'><?php echo $option_value[name] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                                        <?php
                                    }
                                    if ($options['type'] == 'radio') {
                                        ?>
                            <div class="product-items">
                                <div id="option-<?php echo $options['id_product_option'] ?>" class="option product-inputtext">
                                    <label class="attribute_label product-radio-label " ><?php
                                    echo $options['name'];
                                    ?><?php
                            if ($options['required'] == '1') {
                                echo "<span style='color:red'>*</span>";
                            }
                            ?> </label> 
            <?php foreach ($options['option_value'] as
                        $option_value) {
                ?>
                                        <div class="col-md-12 product-input-text-boxs"> 
                                            <input type="radio"  class="product-items product-input-text-box " name="option[<?php echo $options['id_product_option'] ?>]" value="<?php echo $option_value['id_product_option_value'] ?>" />
                                                <?php echo $option_value['name']; ?></div>
                                        <?php } ?>
                                </div></div>
                                    <?php
                                }
                                if ($options['type'] == 'checkbox') {?>
                                 <div class="clearfix"></div> 
                            <div class="product-items">
                                <div id="option-<?php echo $options['id_product_option'] ?>"  class="option product-radio">
                                    <label class="attribute_label product-checkbox-label" ><?php echo $options['name']; ?><?php
                        if ($options['required'] == '1') {
                            echo "<span style='color:red'>*</span>";
                        }
                                    ?>  </label> 
                            <?php                            foreach ($options['option_value'] as $option_value) {?>

                                        <?php echo $option_value['name'];?>:<input type="checkbox" class="product-items product-checkbox-input" name="option[<?php echo $options['id_product_option'] ?>][]" 
                                               value="<?php echo $option_value['id_product_option_value']; ?>" /><br/>

                                        <?php } ?>
                                </div></div>
                                        <?php
                                    }
                                    if ($options['type'] == 'datetime') {
                                        ?>
                            <div class="product-items">
                                <div id="option-<?php echo $options['id_product_option'] ?>" class="option product-radio">
                                    <label class="attribute_label product-Datetime-label" ><?php
                            echo Yii::t('product', 'text_datetime')
                            ?><?php
                if ($options['required'] == '1') {
                    echo "<span style='color:red'>*</span>";
                }
                            ?>  </label> 

                                    <input type="text" class="product-items product-radio-input form-control" id="datetimepicker" name="option[<?php echo $options['id_product_option'] ?>]" value="<?php echo $options['option_value'] ?>" class="datetime"/>
                                </div></div>

                                        <?php
                                    }
                                    if ($options['type'] == 'textarea') {
                                        ?>
                            <div class="product-items">
                                <div id="option-<?php echo $options['id_product_option'] ?>" class="option product-textarea">
                                    <label class="attribute_label product-Datetime-label " ><?php
                            echo $options['name'];
                            ?><?php
                            if ($options['required'] == '1') {
                                echo "<span style='color:red'>*</span>";
                            }
                            ?> </label>

                                    <textarea class="product-items product-textarea-div form-control" name="option[<?php echo $options['id_product_option'] ?>]"><?php echo $options['option_value'] ?></textarea>
                                </div></div>

            <?php
        }
        if ($options['type'] == 'text') {
            ?>
                            <div class="product-items">
                                <div id="option-<?php echo $options['id_product_option'] ?>" class="option product-option">
                                    <label class="attribute_label product-Datetime-label" ><?php
                            echo $options['name'];
                            ?><?php
                            if ($options['required'] == '1') {
                                echo "<span style='color:red'>*</span>";
                            }
                            ?> </label>

                                    <input type="text" class="product-items product-option-div form-control" name="option[<?php echo $options['id_product_option'] ?>]" value="<?php echo $options['option_value'] ?>">
                                </div></div>

            <?php
        }
        if ($options['type'] == 'date') {
            ?>
                            <div class="product-items">
                                <div id="option-<?php echo $options['id_product_option'] ?>" class="option product-date">
                                    <label class="attribute_label product-Datetime-label" ><?php
                            echo $options['name'];
                            ?><?php
                            if ($options['required'] == '1') {
                                echo "<span style='color:red'>*</span>";
                            }
                            ?> </label>

                                    <input type="text" class="product-items product-date-div  form-control" id="date" name="option[<?php echo $options['id_product_option'] ?>]" value="<?php echo $options['option_value'] ?>" class="date" value="<?php echo $options['option_value'] ?>"/>
                                </div></div>

            <?php
        }
        if ($options['type'] == 'time') {
            ?>
                            <div class="product-items">
                                <div id="option-<?php echo $options['id_product_option'] ?>" class="option product-datetime">
                                    <label class="attribute_label product-Datetime-label" ><?php
                            echo $options['name'];
                            ?><?php  if ($options['required'] == '1') { echo "<span style='color:red'>*</span>";
                            }
                            ?> </label>

                                    <input type="text" class="product-items product-datetime-div  form-control" id="time" name="option[<?php echo $options['id_product_option'] ?>]" value="<?php echo $options['option_value'] ?>" class="time"/>
                                </div>
                            </div>
                                        <?php
                                    }
                                    if ($options['type'] == 'file') {
                                        ?>
                            <div class="product-items">
<div id="option-<?php echo $options['id_product_option'] ?>" class="option product-datetime">
<label class="attribute_label product-Datetime-label" ><?php echo $options['name'] ?> <?php
if ($options['required'] == '1') {
echo "<span style='color:red'>*</span>";
}
?> </label>
<a style="cursor:pointer" onclick="$('#FileInput_<?php echo $options['id_product_option'] ?>').click();" class="btn btn-inverse"><?php echo $options['name'] ?> </a>
<form action="<?php echo $this->createUrl("product/uploadfile"); ?>" method="post" enctype="multipart/form-data" id="MyUploadForm_<?php echo $options['id_product_option'] ?>" name="file_form_file_<?php echo $options['id_product_option'] ?>">
<input name="FileInput_<?php echo $options['id_product_option'] ?>" id="FileInput_<?php echo $options['id_product_option'] ?>" type="file" onChange="$('#MyUploadForm_<?php echo $options['id_product_option'] ?>').submit()" style="display:none;"/>
<input type='hidden' id="file_id" name='file_id[<?php echo $options['id_product_option'] ?>]' value="<?php echo $options['id_product_option'] ?>">
</form>
<input type="hidden" class="product-items product-datetime-div  form-control" id="file_<?php echo $options['id_product_option'] ?>" name="option[<?php echo $options['id_product_option'] ?>]" value=""/>
<div id="output_<?php echo $options['id_product_option'] ?>"></div>
</div>
</div>
                        <?php }
                        ?>
                        <?php
                    }
                }
                ?></div>

            
                <input type="hidden" name="product_id" value="<?php echo $data['product']['id_product']; ?>" id="product_id" />
                <h3 class="quantity-div"><?php
                echo Yii::t('product', 'text_quantity')
                ?></h3>
                <input id="quantity" class="quantity-box" type="text" name="quantity" value="<?php echo $data['product']['minimum'];?>">
                <a id="yw6" class="btn btn-inverse" onclick="return quantityDecrement();">-</a>
                <a id="yw6" class="btn btn-inverse" onclick="return quantityIncrement();">+</a>
                <div class="clearfix"></div>
          
            <div class="col-md-12 addtocart-div-close">
                <div class="addtocart-div"><?php $this->widget('bootstrap.widgets.TbButton',
        array(
		'visible'=>(($data['product']['quantity']<=0) && !(Yii::app()->config->getData('CONFIG_STORE_ALLOW_CHECKOUT')))?false:true,
		'type' => 'inverse', 'size' => 'inverse', 'label' => Yii::t('common',
            'button_cart'), 'htmlOptions' => array('class' => 'addtocart', 'alt' => 'Add To Cart',
        'tital' => 'Add To Cart', 'id' => "button-cart"),));
?></div>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12  Addbtns-div">
                <span class="write-a-review"> <span class="glyphicon glyphicon-pencil"></span> <a style="cursor:pointer;" 
                onclick="return addToCompare('<?php echo $data['product']['id_product']; ?>')";><?php echo Yii::t('common', 'button_compare')
?></a></span> 
               <span class="add-to-my-wishlist"> <span class="glyphicon glyphicon-heart"></span> <a style="cursor:pointer;" 
              onclick="return addToWishList('<?php echo $data['product']['id_product']; ?>')";><?php
echo Yii::t('common', 'button_wishlist')
?></a></span>
            </div>

            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
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

</script>
<script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/jquery.form.min.js"></script>
<script type="text/javascript">
                    $('#button-cart').bind('click', function() {
                        $.ajax({
                        url: '<?php echo $this->createUrl("checkout/cart",array("cpage"=>"productdetails"));?>',
                            type: 'post',
                            data: $('.quick-view-div input[type=\'text\'], .quick-view-div input[type=\'hidden\'], .quick-view-div input[type=\'radio\']:checked, .quick-view-div input[type=\'checkbox\']:checked, .quick-view-div select, .quick-view-div textarea'),
                            dataType: 'json',
                            success: function(json) {
                                $('.success, .warning, .attention, information, .error').remove();
                                if (json['error']) {
                                    if (json['error']['option']) {
                                        for (i in json['error']['option']) {
                                            $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
                                        }
                                    }

                                    /*if (json['error']['profile']) {
                                        $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                                    }*/
                                }
                                if (json['redirect']) {
                                    location = json['redirect'];
                                }
                                if (json['success']) {
                                    location = '<?php echo $this->createUrl("checkout/carts");?>';
                                    /*$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

                                    $('.success').fadeIn('slow');

                                    $('#cart-total').html(json['total']);

                                    $('html, body').animate({scrollTop: 0}, 'slow');*/
                                }
                            }
                        });
                    });
 
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