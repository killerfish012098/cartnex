

<?php
/*echo '<pre>';
print_r($multiple);
echo '</pre>';*/
foreach($multiple['optionValues'] as $key=>$optionValue):
    if($optionValue['id_product_option']=="")
    {
        $class="class='portlet-decoration'";
        $style="style='display:none'";
        $active=false;
    }else
    {
        $class="class='portlet-decoration arrow-minus'";
        $style="";
        $active=true;
    }?>
    <fieldset class="portlet span12" >
        <div <?php echo $class;?> onclick=" $('#hide_box_line<?php echo "_" . $key ?>').slideToggle();">
            <div class="span11"><?php echo $multiple['options'][$key]['name']; ?></div>
            <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn<?php echo "_" . $key ?>" type="button"></button> </div>
            <div class="clearfix"></div>	
        </div>
        <div class="portlet-content" id="hide_box_line<?php echo "_" . $key ?>" <?php echo $style;?>>
        <div class="row-fluid design-optons">
        <div class="span1 optons-text">Active</div>
        <div class="make-switch span1" data-on="default" data-off="danger">
        <?php echo CHtml::checkbox('ProductOptionMultipleVerify[' . $key . '][active]',$active); ?>
        </div>
           <div class="span1 optons-text">Required</div>
        <div  class="make-switch span1" data-on="default" data-off="danger">
        <?php echo CHtml::checkbox('ProductOptionMultipleVerify[' . $key . '][required]',$optionValue['required']);?> 
      </div>
      <div class="clearfix"></div>
        </div>
                <table class="table" id="table_<?php echo $key; ?>">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Quantity</th>
                            <th>Less Stock</th>
                            <th>Price</th>
                            <th>Weight</th>	
                            <th></th>
                        </tr>
                    </thead>
                    <?
                    $optionValueRow=0;
                    $optionValueListData=CHtml::listData(OptionValueDescription::getOptionValues($key),id_option_value,name);
					$hiddenIdProductOption="";         
                    foreach($optionValue['productOptionValue'] as $value):?>
                    <tbody id="row_<?php echo $key . '_' . $optionValueRow; ?>">
                        <tr>
                         <?php echo CHtml::hiddenField('ProductOptionMultiple['.$key.']['.$optionValueRow.'][id_product_option_value]',$value['id_product_option_value']);?>
                    
                    <td><?php echo CHtml::dropDownList('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][id_option_value]', $value['id_option_value'], $optionValueListData); ?></td>
                    <td><?php echo CHtml::textField('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][quantity]', $value['quantity'], array('size' => '4')); ?></td>
                    <td><?php echo CHtml::checkbox('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][subtract]', $value['subtract'] == 0 ? false : true); ?></td>
                    <td><?php echo CHtml::textField('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][price]', $value['price_prefix'] . $value['price'], array('size' => '4')); ?></td>
                    <td><?php echo CHtml::textField('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][weight]', $value['weight_prefix'] . $value['weight'], array('size' => '4')); ?></td>
                    <td> <a onclick="$('#row_<?php echo $key . '_' . $optionValueRow; ?>').remove()" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>
                    </tr>

                    </tbody>
                    <?php
                    $hiddenIdProductOption=$optionValue['id_product_option'];
                    $optionValueRow++;
                endforeach;
                
                echo CHtml::dropDownList('ProductOptionMultiple[' . $key . ']', $value['id_option_value'], $optionValueListData, array('style' => 'display:none'));
                
                echo CHtml::hiddenField('ProductOptionMultipleVerify['.$key.'][id_product_option]',$hiddenIdProductOption);
                
                ?>
                <input type='hidden' id='row_<?php echo $key; ?>' name='row_<?php echo $key . '_' . $optionValueRow; ?>' value='<?php echo $optionValueRow; ?>'>
                <tfoot>
                    <tr>
                        <td colspan="6"><a id="yw11" class="btn" onclick="addOptionValue(<?php echo $key . ',' . $optionValueRow; ?>)">Add </a></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </fieldset>
<?php endforeach;?>
<?php

/*foreach($multiple['optionValues'] as $key=>$optionValue):
    //echo $key.'<pre>';print_r($optionValue);echo '</pre>';
    ?>

    <div id="product_option_value" class="span12">
        <div class="bootstrap-widget portlet-decoration	">
                    <div class="bootstrap-widget-header"><?php echo CHtml::checkbox('ProductOptionMultipleVerify[' . $key . '][active]', $optionValue['id_product_option']!=''?true:false); ?>
                    <h3> <?php echo $multiple['options'][$key]['name']; ?></h3> <?php echo CHtml::checkbox('ProductOptionMultipleVerify[' . $key . '][required]',$optionValue['required']);?></div>
                <div id="yw10" class="bootstrap-widget-content">    
                <table class="table" id="table_<?php echo $key; ?>">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Quantity</th>
                            <th>Less Stock</th>
                            <th>Price</th>
                            <th>Weight</th>	
                            <th></th>
                        </tr>
                    </thead>
                    <?
                    $optionValueRow=0;
                    $optionValueListData=CHtml::listData(OptionValueDescription::getOptionValues($key),id_option_value,name);
           $hiddenIdProductOption="";         
                    foreach($optionValue['productOptionValue'] as $value):?>
                    <tbody id="row_<?php echo $key . '_' . $optionValueRow; ?>">
                        <tr>
                         <?php echo CHtml::hiddenField('ProductOptionMultiple['.$key.']['.$optionValueRow.'][id_product_option_value]',$value['id_product_option_value']);?>
                    
                    <td><?php echo CHtml::dropDownList('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][id_option_value]', $value['id_option_value'], $optionValueListData); ?></td>
                    <td><?php echo CHtml::textField('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][quantity]', $value['quantity'], array('size' => '4')); ?></td>
                    <td><?php echo CHtml::checkbox('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][subtract]', $value['subtract'] == 0 ? false : true); ?></td>
                    <td><?php echo CHtml::textField('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][price]', $value['price_prefix'] . $value['price'], array('size' => '4')); ?></td>
                    <td><?php echo CHtml::textField('ProductOptionMultiple[' . $key . '][' . $optionValueRow . '][weight]', $value['weight_prefix'] . $value['weight'], array('size' => '4')); ?></td>
                    <td> <a onclick="$('#row_<?php echo $key . '_' . $optionValueRow; ?>').remove()" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>
                    </tr>

                    </tbody>
                    <?php
                    $hiddenIdProductOption=$optionValue['id_product_option'];
                    $optionValueRow++;
                endforeach;
                
                echo CHtml::dropDownList('ProductOptionMultiple[' . $key . ']', $value['id_option_value'], $optionValueListData, array('style' => 'display:none'));
                
                echo CHtml::hiddenField('ProductOptionMultipleVerify['.$key.'][id_product_option]',$hiddenIdProductOption);
                
                ?>
                <input type='hidden' id='row_<?php echo $key; ?>' name='row_<?php echo $key . '_' . $optionValueRow; ?>' value='<?php echo $optionValueRow; ?>'>
                <tfoot>
                    <tr>
                        <td colspan="5"><a id="yw11" class="btn" onclick="addOptionValue(<?php echo $key . ',' . $optionValueRow; ?>)">Add </a></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php endforeach; */?>

<script type='text/javascript'>
    function addOptionValue(id)
    {
        row_no = $('#row_' + id).val();
        row = '<tbody id="row_' + id + '_' + row_no + '">';
        row += '<tr>';
        row += '<input type="hidden" value="" id="ProductOptionMultiple_' + id + '_' + row_no + '_id_product_option_value" name="ProductOptionMultiple[' + id + '][' + row_no + '][id_product_option_value]">';
        //select
        row += '<td><select id="ProductOptionMultiple_' + id + '_' + row_no + '_id_option_value" name="ProductOptionMultiple[' + id + '][' + row_no + '][id_option_value]">';
        row += $('#ProductOptionMultiple_' + id).html()
        row += '</select></td>';
        row += '<td><input type="text" value="" id="ProductOptionMultiple_' + id + '_' + row_no + '_id_quantity" name="ProductOptionMultiple[' + id + '][' + row_no + '][quantity]" size="4"></td>';
        row += '<td><input type="checkbox" value="1" id="ProductOptionMultiple_' + id + '_' + row_no + '_subtract" name="ProductOptionMultiple[' + id + '][' + row_no + '][subtract]" size="4"></td>';
        row += '<td><input type="text" value="" id="ProductOptionMultiple_' + id + '_' + row_no + '_id_price" name="ProductOptionMultiple[' + id + '][' + row_no + '][price]" size="4"></td>';
        row += '<td><input type="text" value="" id="ProductOptionMultiple_' + id + '_' + row_no + '_id_weight" name="ProductOptionMultiple[' + id + '][' + row_no + '][weight]" size="4"></td>';
        row += '<td> <a onclick="$(\'#row_' + id + '_' + row_no + '\').remove();" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>';
        row += '</tr>';
        row += '</tbody>';
        $('#table_' + id + ' tfoot').before(row);
        $('#row_' + id).val(parseInt(row_no) + 1);
    }
</script>