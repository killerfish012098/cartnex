<div class="row-fluid">
    <div class="tab-pane active" id="Information">
        <div class="span12">
            <fieldset class="portlet " >
                <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                    <div class="span11"><?php echo Yii::t('categories',
        'heading_sub_title_details') ?></div>
                    <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                    <div class="clearfix"></div>
                </div>
                <div class="portlet-content span12" id="hide_box_line1">

                    <div class="span5"> <?php
                        echo $form->textFieldRow(
                                $model[1], 'name',
                                array('rel' => 'tooltip',
                                'data-toggle' => "tooltip",
                                'data-placement' => "right",)
                        );
                        ?></div>

                    <div class="span5 uploading-img-main"> <?php
                        /* if(Yii::app()->controller->action->id=='update'){ */
                        echo $form->fileFieldRow(
                                $model[0], 'image',
                                array('name' => 'image', 'rel' => 'tooltip', 
                            'data-toggle' => "tooltip", 'data-placement' => "right",
                            'class' => 'Options_design'),
                                array('hint' => '<div class="logo-img"><img src="' . Library::getCatalogUploadLink() . $model[0]->image . '"><input type="hidden" name="prev_file" value="' . $model[0]->image . '"></div>')
                        );
                        echo '<p class="image-name-display">' . $model[0]->image . '</p>';
                        /* }else{
                          echo $form->fileFieldRow($model[0],'image');
                          } */
                        ?>
                    </div>


                    <div class="span5"><div class="control-group roupndlable"> <?php
                            echo $form->labelEx($model[0], 'Top');
                            echo $form->checkbox($model[0], 'top');
                            ?></div>
                    </div>
					      
                    <div class="span5"> <?php
                        $categoryTree = Category::model()->getCategoryTree();
                        $categoryTree[0] = Yii::t('common', 'text_top');
                        echo $form->dropDownListRow($model['0'], 'id_parent',
                                $categoryTree, array('encode' => false));
                        ?>
                    </div>



                    <div class="span5"> <?php
                        echo $form->textFieldRow(
                                $model[0], 'sort_order',
                                array('rel' => 'tooltip', 
                            'data-toggle' => "tooltip", 'data-placement' => "right",)
                        );
                        ?></div>
						              <div class="span5"> <?php
                             
                            echo $form->textFieldRow(
                                $model[0], 'column',
                                array('rel' => 'tooltip',
                                'data-toggle' => "tooltip",
                                'data-placement' => "right",)
                        );
							?>
							
							 
                    </div>

					                    <div class="span5"> 
                        <?php echo $form->radioButtonListRow($model[0],
                                'status', array('1' => 'Enable', '0' => 'Disable')); ?>
                    </div>
                </div>
            </fieldset>



            <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line2').slideToggle();">
                        <div class="span11"><?php echo Library::flag() . Yii::t('categories',
                                'entry_description') ?></div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-content" id="hide_box_line2">
                        <div class="span11"> <?php
                            $this->widget('bootstrap.widgets.TbCKEditor',
                                    array('editorOptions' => array('height' => '100px',
                                    'width' => '100%',),
                                'model' => '$model[1]',
                                'name' => 'CategoryDescription[description]',
                                'id' => 'CategoryDescription_description',
                                'value' => $model[1]->description
                                    )
                            );
                            echo $form->error($model[1], 'description');
                            echo '</div>';
                            ?>
                        </div>
                    </div>
                </fieldset>
            </div>





            <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line3').slideToggle();">
                        <div class="span11"><?php echo Yii::t('categories',
                                    'heading_sub_title_seo') ?></div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-content span12" id="hide_box_line3">

                        <div class="span5"> <?php
                            echo $form->textFieldRow(
                                    $model[1], 'meta_title',
                                    array('rel' => 'tooltip', 
                                'data-toggle' => "tooltip", 'data-placement' => "right",)
                            );
                            ?></div>


                        <div class="span5"> <?php
                            echo $form->textFieldRow(
                                    $model[1], 'meta_keyword',
                                    array('rel' => 'tooltip', 
                                'data-toggle' => "tooltip", 'data-placement' => "right",)
                            );
                            ?></div>


                        <div class="span5"> <?php
                            echo $form->textFieldRow(
                                    $model[1], 'meta_description',
                                    array('rel' => 'tooltip',
                                'data-toggle' => "tooltip", 'data-placement' => "right",)
                            );
                            ?></div>

                        <div class="span5"> <?php
                            /* echo '<pre>';
                              print_r($model);
                              echo '</pre>'; */
                            echo $form->textFieldRow(
                                    $model[2], 'string',
                                    array('rel' => 'tooltip',
                                'data-toggle' => "tooltip", 'data-placement' => "right",)
                            );
                            ?></div>

                </fieldset>
            </div>




            <div class="span12">
                <fieldset class="portlet " >
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line8').slideToggle();">
                        <div class="span11">Enable Filters</div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-content span12" id="hide_box_line8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Type</th>
                                    <th>Sort Order</th>
                                    <th>Active</th>
                                </tr>
                            </thead>
                            <?php
//echo "<pre>";
//print_r($model[3][0]);exit;
//echo $model[3][0]; exit;
//foreach($model[3] as $m){
                            //echo "type :".$m['type']." - id is :".$m['id']." - sort : ".$m['sort_order']."<br/ >";
//}

                            /* echo '<pre>';
                              print_r($model[3]);
                              echo '</pre>'; */
                            ?>
                            <tbody>
<?php // for general  ?>
                                <tr >
                                    <td colspan="4">General</td></tr >
                                <tr ><td></td>
                                    <td >Price</td>

                                    <td>
<?php echo CHtml::textField('filter[general][0][sort_order]',
        $model['3']['general']['0']['sort_order']); ?>
                                    </td>
                                    <td ><?php echo CHtml::checkbox('filter[general][0][active]',
        array_key_exists("0", $model['3']['general'])); ?></td>
                                </tr>

                                <tr ><td></td>
                                    <td >Brand</td>
                                    <td><?php echo CHtml::textField('filter[general][1][sort_order]',
        $model['3']['general']['1']['sort_order']); ?></td>
                                    <td ><?php echo CHtml::checkbox('filter[general][1][active]',
        array_key_exists("1", $model['3']['general'])); ?></td></tr>

                                <tr ><td></td>
                                    <td >Discount</td>
                                    <td>
<?php echo CHtml::textField('filter[general][2][sort_order]',
        $model['3']['general']['2']['sort_order']); ?>
                                    </td>
                                    <td >
                                        <?php echo CHtml::checkbox('filter[general][2][active]',
                                                array_key_exists("2",
                                                        $model['3']['general'])); ?>
                                    </td></tr>

<?php // for optional  ?>	
                                <tr >

                                    <td colspan="4" >Option</td></tr >
                                <?php
                                $options = Option::getFilterOptions();
                                foreach ($options as $op) {
                                    ?>
                                    <tr ><td></td>
                                        <td ><?php echo $op['name'] ?></td>
                                        <td ><?php echo CHtml::textField('filter[option][' . $op->id_option . '][sort_order]',
                                        $model['3']['option'][$op->id_option]['sort_order'],
                                        array('width' => 100, 'maxlength' => 100)); ?></td>

                                        <td >
                                    <?php echo CHtml::checkbox('filter[option][' . $op->id_option . '][active]',
                                            array_key_exists($op->id_option,
                                                    $model['3']['option'])); ?>
                                        </td>
                                    </tr>
<?php } ?>


<?php // for attribute  ?>	
                                <tr ><td colspan="4" >Attribute</td></tr >
<?php
$attributes = AttributeGroup::getFilterAttributes();
foreach ($attributes as $att) {
    ?>
                                    <tr ><td></td>
                                        <td ><?php echo $att['name']; ?></td>
                                        <td ><?php echo CHtml::textField('filter[attribute][' . $att->id_attribute_group . '][sort_order]',
            $model['3']['attribute'][$att->id_attribute_group]['sort_order'],
            array('width' => 100, 'maxlength' => 100)); ?></td>
                                        <td >
    <?php echo CHtml::checkbox('filter[attribute][' . $att->id_attribute_group . '][active]',
            array_key_exists($att->id_attribute_group, $model['3']['attribute'])); ?>
                                        </td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>
                </fieldset>
            </div>

        </div>       </div>
</div>