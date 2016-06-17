<fieldset class="portlet " >
    <div class="portlet-decoration" onclick=" $('#hide_box_line99').slideToggle();">
        <div class="span11"><?php echo yii::t('products',
            'entry_add_edit_special'); ?> </div>
        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn9" type="button"></button> </div>
        <div class="clearfix"></div>	
    </div>
    <div class="portlet-content" id="hide_box_line99" style="display:none">
        <table class="tablespecial">
            <thead>
                <tr>
                    <th width="15%"><?php echo yii::t('products',
            'entry_customer_group'); ?></th>
                    <th><?php echo yii::t('products', 'entry_priority'); ?></th>
                    <th width="10%"><?php echo yii::t('products',
            'entry_quantity'); ?></th>
                    <th width="10%"><?php echo yii::t('products', 'entry_price'); ?></th>
                    <th><?php echo yii::t('products', 'entry_date_start'); ?></th>
                    <th><?php echo yii::t('products', 'entry_date_end'); ?></th>
                    <th><?php echo yii::t('products', 'entry_action'); ?></th>
                </tr>
            </thead>

            <?php
            $getCustomerGroups = CHtml::listData(CustomerGroup::getCustomerGroups(),'id_customer_group', 'name');
            $row = 0;
            if (is_array($model['ps'])) {

                foreach ($model['ps'] as $special):
                    ?>
                    <tbody id='rowSpecial-<?php echo $row; ?>'>
                        <tr >
                    <input type='hidden' name='special[<?php echo $row; ?>][id_product_special]' value="<?php echo $special->id_product_special; ?>">
                    <td style="width: 60px"><?php echo CHtml::dropDownList('special[' . $row . '][id_customer_group]',
                    $special['id_customer_group'], $getCustomerGroups); ?></td>
                    <td><?php echo CHtml::textField('special[' . $row . '][priority]',
                    $special->priority,
                    array('width' => 100, 'maxlength' => 100)); ?></td>
                    <td><?php echo CHtml::textField('special[' . $row . '][quantity]',
                    $special->quantity,
                    array('width' => 100, 'maxlength' => 100)); ?></td>
                    <td><?php echo CHtml::textField('special[' . $row . '][price]',
                        $special->price,
                        array('width' => 100, 'maxlength' => 100)); ?></td>
                    <td>

                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker',
                                array(
                            'model' => $model['ps'],
                            'attribute' => 'start_date',
                            'name' => 'special[' . $row . '][start_date]', // This is how it works for me.
                            'value' => $special['start_date'],
                            'options' => array('dateFormat' => 'yy-mm-dd',
                                'altFormat' => 'dd-mm-yy',
                                'changeMonth' => 'true',
                                'changeYear' => 'true',
                            //'yearRange'=>'1920:2010', 
                            //          'showOn'=>'both',
                            //'buttonText'=>'...',
                            ),
                            'htmlOptions' => array('size' => '10')
                        ));
                        ?></td>
                    <td><?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker',
                                array(
                            'model' => $model['ps'],
                            'attribute' => 'end_date',
                            'name' => 'special[' . $row . '][end_date]', // This is how it works for me.
                            'value' => $special['end_date'],
                            'options' => array('dateFormat' => 'yy-mm-dd',
                                'altFormat' => 'dd-mm-yy',
                                'changeMonth' => 'true',
                                'changeYear' => 'true',
                            //'yearRange'=>'1920:2010', 
                            //          'showOn'=>'both',
                            //'buttonText'=>'...',
                            ),
                            'htmlOptions' => array('size' => '10')
                        ));
                        ?></td>
                    <td> <a onclick="$('#rowSpecial-<?php echo $row; ?>').remove()" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>
                    </tr>
                    </tbody>
                                <?php
                                $row++;
                            endforeach;
                        }
                        ?>
            <tfoot>
                <tr>
                    <td colspan="6"><?php
                        $this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                            'label' => 'Add ',
                            'type' => 'btn-info',
                            'htmlOptions' => array('onclick' => 'addSpecial()'),
                                )
                        );
                        ?></td>
                </tr>
            </tfoot>
        </table>
    </div></fieldset>
<?php
$select = "";
foreach ($getCustomerGroups as $id => $name) {
    $select.="<option value='" . $id . "'>" . $name . "</option>";
}
?>
<script type='text/javascript'>
    var rowSpec_no = '<?php echo $row; ?>';
    function addSpecial()
    {
        // alert('hell');
        row = '<tbody id="rowSpecial-' + rowSpec_no + '">';
        row += '<tr>';
        row += '<input type="hidden" value="" id="special_' + rowSpec_no + '_id_product_special" name="special[' + rowSpec_no + '][id_product_special]">';
        row += '<td style="width: 60px">';
        row += '<select id="attribute_' + rowSpec_no + '_id_customer_group" name="special[' + rowSpec_no + '][id_customer_group]">';
        row += "<?php echo $select; ?>";
        row += '</select>';
        row += '</td>';
        row += '<td><input type="text" id="special_' + rowSpec_no + '_priority" name="special[' + rowSpec_no + '][priority]"value="1" ></td>';
        row += '<td><input type="text" id="special_' + rowSpec_no + '_quantity" name="special[' + rowSpec_no + '][quantity]" value="1"></td>';
        row += '<td><input type="text" id="special_' + rowSpec_no + '_price" name="special[' + rowSpec_no + '][price]" ></td>';
        row += '<td><input type="text" class="date" id="special_' + rowSpec_no + '_start_date" name="special[' + rowSpec_no + '][start_date]" ></td>';
        row += '<td><input type="text" class="date" id="special_' + rowSpec_no + '_end_date" name="special[' + rowSpec_no + '][end_date]" ></td>';
        row += '<td> <a onclick="$(\'#rowSpecial-' + rowSpec_no + '\').remove();" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>';
        row += '</tr>';
        row += '</tbody>';
        $('.tablespecial tfoot').before(row);
        rowSpec_no++;
        jQuery('.date').datepicker({'dateFormat': 'yy-mm-dd', 'altFormat': 'dd-mm-yy', 'changeMonth': 'true', 'changeYear': 'true'});
    }

</script>