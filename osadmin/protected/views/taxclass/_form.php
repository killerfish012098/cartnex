	<div class="tab-pane active" id="Information">
        <div class="span12 pull-left">
            <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line2').slideToggle();">
                        <div class="span11"><?php echo Yii::t('taxclasses','heading_sub_title');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line2">
                        
					 <div class="span5"> 	<?php
                        echo $form->textFieldRow(
                                $model['tc'], 'name',
                                array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>       </div>
       
 <div class="span5"> 
	   <?php echo $form->textFieldRow(
                                $model['tc'], 'description',
                                array('rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",)
                        );?>       </div>
       
 <div class="span5"> 
	   <?php echo $form->radioButtonListRow($model['tc'], 'status',array('1'=>'Enable','0'=>'Disable'));
                        ?> </div>


                    </div>
                    <!--<input type="button" name="add_rule" id="add_rule" value="Add Rule">
                    <input type="text" name="add_rule_count" id="add_rule_count" value="0">-->
                    
                    <!-- start rule -->
                   <div class="span12 pull-right" id="option_value">
  <?php
    $box = $this->beginWidget(
            'bootstrap.widgets.TbBox',
            array(
        'title' => 'Add/Edit Tax Class Rule',
        'htmlOptions' => array('class' => 'portlet-decoration	')
            )
    );
    ?>
    <table class="table">
        <thead>
            <tr>
                <th><?php echo Library::flag().Yii::t('taxclasses','entry_rule_name');?></th>
                <th><?php echo Yii::t('taxclasses','entry_type');?></th>
                <th><?php echo Yii::t('taxclasses','entry_rate');?></th>
                <th><?php echo Yii::t('taxclasses','entry_basedon');?></th>
                <th><?php echo Yii::t('taxclasses','entry_region');?></th>
            </tr>
        </thead>

        <?php
        
        $getRegions=Region::getRegions();
        $row = 0;
        if(is_array($model['tcrd']))
        {
        foreach ($model['tcrd'] as $rule):
            ?>
            <tbody id='rowRule-<?php echo $row; ?>'>
            <tr >
            <input type='hidden' name='tax_class_rule[<?php echo $row; ?>][id_tax_class_rule]' value="<?php echo $rule->id_tax_class_rule; ?>">
            <td ><?php
            echo CHtml::textField('tax_class_rule[' . $row . '][name]', $rule->name,array('size'=>'10') );
            ?></td>
            <td width="120px"><?php 
            echo CHtml::dropDownList('tax_class_rule[' . $row . '][type]', $rule->taxClassRule->type,array('PERCENT'=>'Percentage','FIXED'=>'Fixed') );?></td>
            <td ><?php
            echo CHtml::textField('tax_class_rule[' . $row . '][rate]', $rule->taxClassRule->rate,array('size'=>'4') );
            ?></td>
            <td width="170px"><?php 
            echo CHtml::dropDownList('tax_class_rule[' . $row . '][based_on]', $rule->taxClassRule->based_on,array('STORE_ADDR'=>'Store Address','SHIPPING_ADDR'=>'Shipping Address','PAYMENT_ADDR'=>'Payment Address') );?></td>
            <td width="200px"><?php 
            echo CHtml::dropDownList('tax_class_rule[' . $row . '][id_region]', $rule->taxClassRule->id_region,
                    CHtml::listData($getRegions, 'id_region', 'name') );            
?></td>
            <td><a onclick="$('#rowRule-<?php echo $row; ?>').remove()" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>
            </tr>
            </tbody>
            <?php
            $row++;
        endforeach;
        }
        ?>
        <tfoot>
            <tr>
                <td colspan="5"><?php
                    $this->widget(
                            'bootstrap.widgets.TbButton',
                            array(
                        'label' => Yii::t('taxclasses','entry_add_rule'),
                        'type' => 'btn-danger',
                        'htmlOptions' => array('onclick' => 'addRule()'),
                            )
                    );
                    ?></td>
            </tr>
        </tfoot>
    </table>
<?php $this->endWidget(); ?>
</div>
                    <!-- end rule -->
                    
                </fieldset>

            </div>   

        </div>
    </div>
    <?php
$select="";
foreach($getRegions as $region)
{ 
    $select.="<option value='".$region->id_region."'>".$region->name."</option>";
}
?>
  <script type='text/javascript'>
    var row_no =<?php echo $row; ?>;
    function addRule()
    {
        row = '<tbody id="rowRule-' + row_no + '">';
        row += '<tr>';
        row += '<input type="hidden" value="" name="tax_class_rule[' + row_no + '][id_tax_class_rule]">';
        row += '<td><input type="text" id="tax_class_rule_' + row_no + '_name" name="tax_class_rule[' + row_no + '][name]" size="10"></td>';
        row += '<td width="120px">';
        row += '<select id="tax_class_rule_' + row_no + '_type" name="tax_class_rule[' + row_no + '][type]">';
        row+="<option value='PERCENT'>Percentage</option><option value='FIXED'>Fixed</option>";
	row += '</select>';
        row += '</td>';
        
        row += '<td><input type="text" id="tax_class_rule_' + row_no + '_rate" name="tax_class_rule[' + row_no + '][rate]" size="4"></td>';
        
        row += '<td width="170px">';
        row += '<select id="tax_class_rule_' + row_no + '_based_on" name="tax_class_rule[' + row_no + '][based_on]">';
        row+="<option value='STORE_ADDR'>Store Address</option><option value='SHIPPING_ADDR'>Shipping Address</option><option value='PAYMENT_ADDR'>Payment Address</option>";
	row += '</select>';
        row += '</td>';
        
        row += '<td width="200px">';
        row += '<select id="tax_class_rule_' + row_no + '_id_region" name="tax_class_rule[' + row_no + '][id_region]">';
        row+="<?php echo $select;?>";
	
        row += '</select>';
       
        row += '</td>';
         row += '<td> <a onclick="$(\'#rowRule-' + row_no + '\').remove();" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>';
        row += '</tr>';
        row += '</tbody>';
        $('.table tfoot').before(row);
        row_no++;
    }

</script>