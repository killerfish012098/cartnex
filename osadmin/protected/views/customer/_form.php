<div class="row-fluid">
 <div class="tab-pane active" id="Personal Details">
	<div class="span12 ">
     <fieldset class="portlet" >
	   <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
		 <div class="span11"><?php echo yii::t('customers','heading_sub_title_personal');?> </div>
		 <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button></div>
	   <div class="clearfix"></div>
	   </div>
 <div class="portlet-content" id="hide_box_line1">
   <div class="span5">  <?php echo $form->textFieldRow(
           $model['c'],'firstname',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       ); ?></div>
       
  <div class="span5">  <?php  echo $form->textFieldRow(
           $model['c'],'lastname',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       ); ?></div>
       
  <div class="span5">  <?php echo $form->textFieldRow(
           $model['c'],'telephone',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",)
       ); ?></div>
       
  <div class="span5">  <?php //$model->gender='1'; 
	   echo $form->radioButtonListRow( $model['c'], 'gender',    array('1'=>'Male','0'=>'Female')
        );  ?></div>
       </div>
   </fieldset>


  </div>
  
  <div class="span12">
   <fieldset class="portlet" >
     <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line3').slideToggle();">
		<div class="span11"><?php echo yii::t('customers','heading_sub_title_login');?> </div>
		<div class="span1 Dev-arrow"><button class="btn btn-info arrow_main"  type="button"></button> </div>
		<div class="clearfix"></div>
	</div>
 <div class="portlet-content" id="hide_box_line3">
       
   	<div class="span5">  <?php
		$list=CHtml::listData(CustomerGroup::getCustomerGroups(),'id_customer_group','name');
        echo $form->dropDownListRow($model['c'],'id_customer_group', $list);
		?>
	</div>
	
  <div class="span5">  <?php
		if(Yii::app()->controller->action->id=='update'){  
		echo $form->textFieldRow(
           $model['c'],'email',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",'readonly'=>'readonly')
		); 
		}else{
		echo $form->textFieldRow(
           $model['c'],'email',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right")
		); 
		
		}?></div>
       

	
	<div class="span5"><?php
		 if(Yii::app()->controller->action->id=='update'){  
		 
			echo $form->passwordFieldRow(
			   $model['c'],'password',
			   array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",'value'=>'')
			);
		}else{
			echo $form->passwordFieldRow(
			   $model['c'],'password',
			   array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right"));
		
		}?>
	</div>
	   
		 <div class="span5">  <?php
			echo $form->passwordFieldRow(
           $model['c'],'confirm',
           array('rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right",'value'=>'')
        );
		?></div>
	   
		<div class="span5">  <?php
		echo $form->radioButtonListRow($model['c'], 'status',array('1'=>'Enable','0'=>'Disable'));
		
		?></div>
 
  
  <div class="span5">  <?php
		echo $form->radioButtonListRow($model['c'], 'newsletter', array('1'=>'Subscribe','0'=>'UnSubscribe' ,)  ); 
		?></div>  
       </div>
   </fieldset>
   

       </div>  
  
  
<div class="span12">


     <fieldset class="portlet " >
                   <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line4').slideToggle();">
                        <div class="span11"><?php echo yii::t('customers','heading_sub_title_address');?> </div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main"  type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>


                  <div class="span12 pull-right" id="hide_box_line4">
<!--  <div id="option_value">-->
                        <?php
                        /*$box = $this->beginWidget(
                                'bootstrap.widgets.TbBox',
                                array(
                            'title' => Yii::t('customers','entry_address_add_edit'),
                            'htmlOptions' => array('class' => 'portlet-decoration	')
                                )
                        );*/
						
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><?php echo  Yii::t('customers','entry_address_firstname');?></th>
                                    <th><?php echo  Yii::t('customers','entry_address_lastname');?></th>
                                    <th><?php echo  Yii::t('customers','entry_address_telephone');?></th>
                                    <th><?php echo  Yii::t('customers','entry_address_company');?></th>
                                    <th><?php echo  Yii::t('customers','entry_address_address_1');?></th>
                                    <th><?php echo  Yii::t('customers','entry_address_address_2');?></th>
                                    <th><?php echo  Yii::t('customers','entry_address_city');?></th>
                                    <th><?php echo  Yii::t('customers','entry_address_country');?></th>
									<th><?php echo  Yii::t('customers','entry_address_state');?></th>
                                    
                                    <th><?php echo  Yii::t('customers','entry_address_postcode');?></th>
                                </tr>
                            </thead>
											
                            <?php
                            $getCounties = Country::getCountries();
                            $default=$model['c']->id_customer_address_default;
                            $row = 0;
                            foreach ($model['add'] as $model):
                                ?>
								
                               
                                <tbody id='row-<?php echo $row; ?>'>
								<!-- <input type='hidden' name='customer_address[<?php echo $row; ?>][customer_address_id]' value="<?php echo $model->id_customer_address; ?>"> -->
                                <tr >
							    <td style="width: 60px">

								<?php if($default==$model->id_customer_address){ ?>
								<input type="radio"   name="default" value="<?php echo $model->id_customer_address; ?>" checked>
								<?php }else{ ?>
								<input type="radio"   name="default" value="<?php echo $row; ?>">
								<?php } ?>
							   
								
								</td>
								<td ><?php echo CHtml::textField('customer_address[' . $row . '][firstname]',
                                        $model->firstname,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
								<td ><?php echo CHtml::textField('customer_address[' . $row . '][lastname]',
                                        $model->lastname,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
								<td ><?php echo CHtml::textField('customer_address[' . $row . '][telephone]',
                                        $model->telephone,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
								<td ><?php echo CHtml::textField('customer_address[' . $row . '][company]',
                                        $model->company,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
								<td ><?php echo CHtml::textField('customer_address[' . $row . '][address_1]',
                                        $model->address_1,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
								<td ><?php echo CHtml::textField('customer_address[' . $row . '][address_2]',
                                        $model->address_2,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
								<td ><?php echo CHtml::textField('customer_address[' . $row . '][city]',
                                        $model->city,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
                                <td width="200px"><?php
                                            echo CHtml::dropDownList('customer_address[' . $row . '][id_country]',
                                                    $model->id_country,
                                                    CHtml::listData($getCounties,'id_country', 'name'),
                                                    array('onchange' => 'getStates(this.value,this.id)'));
                                            ?></td>
                                        <td width="200px"><?php
                                echo CHtml::dropDownList('customer_address[' . $row . '][id_state]',
                                        explode(",",$model->id_state),
                                        CHtml::listData(State::getStates(array('condition'=>'id_country='.$model->id_country)), 'id_state',
                                                'name'));
                                ?></td>
                                                               
                                <td><?php echo CHtml::textField('customer_address[' . $row . '][postcode]',
                                        $model->postcode,
                                        array('width' => 100, 'maxlength' => 100));
                                ?></td>
                                <td><a onclick="$('#row-<?php echo $row; ?>').remove()" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>
                                </tr>
                                </tbody>
                                            <?php
                                            $row++;
                                        endforeach;
										
										
                                        ?>


                            <tfoot>
                                <tr>
                                    <td colspan="11"><?php
                                        $this->widget(
                                                'bootstrap.widgets.TbButton',
                                                array(
                                            'label' => Yii::t('customers','entry_address_add'),
                                            'type' => 'btn-info',
                                            'htmlOptions' => array('onclick' => 'addAddress()'),
                                                )
                                        );
                                        ?></td>
                                </tr>
                            </tfoot>
                        </table>
<?php //$this->endWidget(); ?>
                    </div><!--  </div>-->
                </fieldset>
   
   

        
  </div>
  </div>
  
  </div>

<?php
$select = "";
foreach ($getCounties as $country) {
    $countrylist.="<option value='" . $country->id_country . "'>" . $country->name . "</option>";
}
?>
    <script type='text/javascript'>
        var row_no =<?php echo $row; ?>;
        function addAddress()
        {
            row = '<tbody id="row-' + row_no + '">';
            row += '<tr>';
            row += '<input type="hidden" value="" name="customer_address[' + row_no + '][customer_address_id]">';
            row += '<td ><input width="100" type="radio"  name="default" value='+row_no+'></td>';
            row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_firstname" name="customer_address[' + row_no + '][firstname]" value="" maxlength="100"></td>';
            row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_lastname" name="customer_address[' + row_no + '][lastname]" value="" maxlength="100"></td>';
            row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_telephone" name="customer_address[' + row_no + '][telephone]" value="" maxlength="100"></td>';
            row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_company" name="customer_address[' + row_no + '][company]" value="" maxlength="100"></td>';
            row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_address_1" name="customer_address[' + row_no + '][address_1]" value="" maxlength="100"></td>';
            row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_address_2" name="customer_address[' + row_no + '][address_2]" value="" maxlength="100"></td>';
            row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_city" name="customer_address[' + row_no + '][city]" value="" maxlength="100"></td>';
            //row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_id_country" name="customer_address[' + row_no + '][id_country]" value="" maxlength="100"></td>';
            //row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_id_state" name="customer_address[' + row_no + '][id_state]" value="" maxlength="100"></td>';
            row += '<td width="100px">';
            row += '<select id="customer_address_' + row_no + '_id_country" name="customer_address[' + row_no + '][id_country]" onchange="getStates(this.value,this.id)" >';
            row += "<?php echo $countrylist; ?>";
            row += '</select>';
            row += '</td>';


            row += '<td width="100px">';
            row += '<select id="customer_address_' + row_no + '_id_state" name="customer_address[' + row_no + '][id_state]"><option value="0">None</option>';
            row += '</select>';
            row += '</td>';

            
            row += '<td ><input width="100" type="text" id="customer_address_' + row_no + '_postcode" name="customer_address[' + row_no + '][postcode]" value="" maxlength="100"></td>';
            row += '<td> <a onclick="$(\'#row-' + row_no + '\').remove();" href="#" class="btn btn-danger" ><i class="delete-iconall"></i></a> </td>';
            row += '</tr>';
            row += '</tbody>';
            $('.table tfoot').before(row);
            row_no++;
        }

        function getStates(val, id)
        {
            //alert(val+" "+id.replace('country','state'));
            inputId = id.replace('country', 'state');
            $.ajax({
                //url: 'http://sun-network/osadmin/index.php/site/getStates/' + val,
			url: '<?php echo $this->createUrl("site/getStates");?>',

				data: "id="+val,
				type: 'get',
                dataType: 'json',
                success: function(json) {
                    var html;
                    if (json['states'] != '')
                    {
                        for (i = 0; i < json['states'].length; i++)
                        {
                            html += '<option value="' + json['states'][i]['id_state'] + '"';
                            html += '>' + json['states'][i]['name'] + '</option>';
                        }
                    } else
                    {
                        html += '<option value="0" selected="selected">None</option>';
                    }
                    $('#' + inputId).html(html);
                }
            });
        }
		
		
    </script>