<?php
/*echo '<pre>';
print_r($input['optionValues']);
echo '</pre>';*/
foreach ($input['optionValues'] as $key => $value):
    if($value['id_product_option']=="")
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
    <fieldset class="portlet span4 date-box-portlet"  >
        <div <?php echo $class;?> onclick=" $('#hide_box_line<?php echo "-" . $key ?>').slideToggle();">
            <div class="span10"><?php echo $input[options][$key][name]; ?> </div>
            <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn<?php echo "-" . $key ?>" type="button"></button> </div>
            <div class="clearfix"></div>	
        </div>
        <div class="portlet-content portlet-content design-optionmultiple" id="hide_box_line<?php echo "-" . $key ?>" <?php echo $style;?>>
            <table class="table">
                <thead>
                    <tr>
                        <th>Enable</th>
                        <th><?php echo yii::t('products', 'entry_required'); ?></th>
						<th>&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tbody id="row">
                    <tr>
                        <?php
                        echo CHtml::hiddenField('ProductOptionInput[' . $key . '][id_option]', $key);
                        echo CHtml::hiddenField('ProductOptionInput[' . $key . '][id_product_option]', $value['id_product_option']);  ?>
                        <td><?php echo CHtml::checkbox('ProductOptionInput[' . $key . '][activate]', $active); ?></td>
                        <td><?php echo CHtml::checkbox('ProductOptionInput[' . $key . '][required]', $value['required']); ?></td>
                         <td>&nbsp;&nbsp;&nbsp;</td> 
                    </tr>
                </tbody>
            </table>
        </div>
    </fieldset>
    <?php
    $loop++;
endforeach;
?>

<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="<?php echo Yii::app()->baseUrl ?>/js/jquery-ui-1.8.16.custom.css" rel="stylesheet" /> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/jquery-ui-timepicker-addon.js"></script> -->
<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.7.1.min.js',CClientScript::POS_BEGIN);
/*Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui-1.8.16.custom.min.js',
        CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/jquery-ui-1.8.16.custom.css',
        CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui-timepicker-addon.js',
        CClientScript::POS_BEGIN);
echo CHtml::script("<!--
$('.optiondate').datepicker({dateFormat: 'yy-mm-dd'});
    $('.optiondatetime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'h:m'
    });
    $('.optiontime').timepicker({timeFormat: 'h:m'});
//-->");*/
?>


