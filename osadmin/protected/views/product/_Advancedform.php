<div class="row-fluid">
    <div class="tab-pane active" id="Information">
        <div class="span12">
            <fieldset class="portlet">
                <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line6').slideToggle();">
                    <div class="span11"><?php echo yii::t('products',
        'heading_sub_general'); ?> </div>
                    <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn6" type="button"></button> </div>
                    <div class="clearfix"></div>	
                </div>
                <div class="portlet-content" id="hide_box_line6">
                    <div class="span5">
                        <div class="control-group">
                            <label for="Product_date_product_available" class="control-label"><?php echo $model['p']->getAttributeLabel('date_product_available'); ?></label>
                            <div class="controls"><?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker',
                            array(
                        'model' => $model['p'],
                        'attribute' => 'date_product_available',
                        'options' => array('dateFormat' => 'yy-mm-dd',
                            'altFormat' => 'dd-mm-yy',
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                        ),
                        'htmlOptions' => array('size' => '10')
                    ));
                    ?>		</div>
                            <div style="display:none" id="Product_weight_em_" class="help-inline error"><?php echo $form->error($model['p'],
                                        'date_product_available'); ?></div>

                        </div>
                    </div>

                    <div class="span5">
					
					<?php echo $form->dropDownListRow($model['p'],'id_tax_class',CHtml::listData(TaxClass::getTaxClasses(array('condition' => 'status=1')),'id_tax_class', 'name'),array('prompt' => Yii::t('common','text_none'))); ?></div>

                    <div class="span5"><?php
					$stockstatus = CHtml::listData(StockStatus::getStockStatus(), 'id_stock_status','name');
					echo $form->dropDownListRow($model['p'], 'id_stock_status', $stockstatus);
					?>
                    </div>

                    <div class="span5">  <?php
                        $manufacturers = CHtml::listData(Manufacturer::getManufacturers(),'id_manufacturer', 'name');
                        $manufacturers['0']=Yii::t('common','text_none');
                        echo $form->dropDownListRow($model['p'],'id_manufacturer', $manufacturers);
                        ?>
                    </div>


                   
                    <div class="span5"><?php
                        echo $form->textFieldRow($model['p'], 'sku',array('rel' => 'tooltip','data-toggle' => "tooltip",'data-placement' => "right",)); ?>
					</div>
                    
					<div class="span5"><?php
                        echo $form->textFieldRow($model['p'], 'upc',array('rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",)); ?>
					</div>
                    
                    <div class="span5"><?php
                        echo $form->textFieldRow(
                                $model['p'], 'width',
                                array(
                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?></div>
                    <div class="span5"><?php
                        echo $form->textFieldRow(
                                $model['p'], 'length',
                                array(
                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?></div>
                    
                    <div class="span5"><?php
                        echo $form->textFieldRow(
                                $model['p'], 'height',
                                array(
                            'rel' => 'tooltip',  'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?></div>
                    
                     <div class="span5"><?php
                        echo $form->textFieldRow(
                                $model['p'], 'weight',
                                array(
                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?></div>
                    <div class="span5"><?php
                        echo $form->textFieldRow(
                                $model['p'], 'minimum_quantity',
                                array(
                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        );
                        ?></div>

                    <div class="span5"><?php echo $form->dropDownListRow($model['p'],
                                'subtract_stock',
                                array('0' => Yii::t('common', 'text_no'), '1' => Yii::t('common',
                                    'text_yes'))); ?></div>
                    <div class="span5"><?php
                        echo $form->dropDownListRow($model['p'],
                                'shipping_required',
                                array('0' => Yii::t('common', 'text_no'), '1' => Yii::t('common',
                                    'text_yes')));
                        ?></div>

                </div>
            </fieldset>
<?php echo $this->renderPartial('_downloadInlineForm',
        array('form' => $form, 'model' => $model), true); ?>
<?php echo $this->renderPartial('_attribute',
        array('form' => $form, 'model' => $model), true); ?>
<?php echo $this->renderPartial('_special',
        array('form' => $form, 'model' => $model), true); ?>
        </div>
    </div>
</div>