    <fieldset class="portlet " >
    <div class="portlet-decoration" onclick=" $('#hide_box_line88').slideToggle();">
        <div class="span11"><?php echo yii::t('products',
            'entry_add_edit_attributes'); ?> </div>
        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn88" type="button"></button> </div>
        <div class="clearfix"></div>	
    </div>
        <div class="portlet-content" id="hide_box_line88" style="display:none">
            
        <table class="table" id="attribute_table">
        <thead>
            <tr>
                <th width="25%"><?php echo yii::t('products','entry_attribute_name');?></th>
                <th><?php echo yii::t('products','entry_attribute_text');?></th>
                <th width="9%"></th>
            </tr>
        </thead>

        <?php
        
        $getAttributes=Attribute::getAttributeValues();
        $row = 0;
        if(is_array($model['pa']))
        {
        foreach ($model['pa'] as $attribute):
            ?>
            <tbody id='rowAttribute-<?php echo $row; ?>'>
                <tr >
            <input type='hidden' name='attribute[<?php echo $row; ?>][pk]' value="<?php echo $attribute->id_attribute; ?>">
            <td style="width: 60px"><?php 
            echo CHtml::dropDownList('attribute[' . $row . '][id_attribute]', $attribute['id_attribute'],$getAttributes );            
?></td>
            <td><?php
            echo CHtml::textArea('attribute[' . $row . '][text]', $attribute->text,array('rows'=>'3','cols'=>'20'));
            ?></td>
            <td> <a onclick="$('#rowAttribute-<?php echo $row; ?>').remove()" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>
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
                        'label' => Yii::t('products','entry_add'),
                        'type' => 'btn-info',
                        'htmlOptions' => array('onclick' => 'addAttribute()'),
                            )
                    );
                    ?></td>
            </tr>
        </tfoot>
    </table>
</div></fieldset>
<?php
$select="";
foreach($getAttributes as $group=>$attributes)
{ 
    $select.="<optgroup label='".$group."'>";
        foreach($attributes as $k=>$v):
        $select.="<option value='".$k."'>".$v."</option>";
        endforeach;
    $select.="</optgroup>";
            
}
?>
<script type='text/javascript'>
    var row_no =<?php echo $row; ?>;
    function addAttribute()
    {
        row = '<tbody id="rowAttribute-' + row_no + '">';
        row += '<tr>';
        row += '<input type="hidden" value="" name="attribute[' + row_no + '][pk]">';
        row += '<td style="width: 60px">';
        row += '<select id="attribute_' + row_no + '_id_attribute" name="attribute[' + row_no + '][id_attribute]">';
        row+="<?php echo $select;?>";
	
        row += '</select>';
       
        row += '</td>';
        row += '<td><textarea id="attribute_' + row_no + '_text" name="attribute[' + row_no + '][text]"></textarea></td>';
        row += '<td> <a onclick="$(\'#rowAttribute-' + row_no + '\').remove();" class="btn btn-danger"><i class="delete-iconall"></i></a> </td>';
        row += '</tr>';
        row += '</tbody>';
        $('#attribute_table tfoot').before(row);
        row_no++;
    }

</script>