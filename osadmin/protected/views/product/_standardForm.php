<div class="row-fluid">
    <div class="tab-pane active" id="Information">
			<div class="span12">
                <fieldset class="portlet">
                    <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line2').slideToggle();">
                        <div class="span11"><?php echo yii::t('products','heading_sub_general');?></div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn1" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line2">
                       <div class="span5">  <?php
                        echo $form->textFieldRow(
                                $model['pd'], 'name',
                                array(
                                     'rel' => 'tooltip',  'data-toggle' => "tooltip",
                                    'data-placement' => "right",
                                )
                            );
                        ?></div>
                        
                       <div class="span5">  <?php
                        echo $form->textFieldRow(
                                $model['p'], 'quantity',
                                array(
                                     'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                    'data-placement' => "right",
                                )
                            );
                        ?></div>
                        
                        <div class="span5 uploading-img-main"> <?php
				echo $form->fileFieldRow(
				$model['p'], 'image',
				array('name'=>'image', 'rel'=>'tooltip','data-toggle'=>"tooltip",'data-placement'=>"right", 
                                    'class'=>'Options_design'),
				array('hint' => '<div id="image-name-display-id"> '.$model[p]->image.' 
								 <div class="logo-img"><img src="'.Library::getCatalogUploadLink().$model['p']->image.'" >' . '<input type="hidden" name="prev_file" value="'.$model['p']->image.'"></div></div>')
				); ?>
                        </div>
                        
                       <div class="span5">  <?php
                        echo $form->textFieldRow(
                                $model['p'], 'model',
                                array(
                                     'rel' => 'tooltip',  'data-toggle' => "tooltip",
                                    'data-placement' => "right",
                                )
                            );
                        ?></div>
                        
                       <div class="span5"> <?php
                        echo $form->textFieldRow(
                                $model['p'], 'price',
                                array(
                                     'rel' => 'tooltip', 'data-toggle' => "tooltip",
                                    'data-placement' => "right",
                                )
                            );
                        ?></div>
                        
                      <div class="span5">
<?php  
foreach ($pCategories as $category) 
{
    $pcSelected[$category->id_category] = array("selected" => "selected");
}

echo $form->dropDownListRow($model['pc'], 'id_category', Category::model()->getCategoryTree(), array('prompt' => Yii::t('common', 'text_none'), 'multiple' => true, 'encode' => false, 'options' => $pcSelected));
?>
</div>
                       <div class="span5">  <?php
                        echo $form->dropDownListRow($model['p'], 'status',
                                array('0' => Yii::t('common','text_disabled'), '1' => Yii::t('common','text_enabled')));
                        ?></div><div class="span5"> <?php  echo $form->textFieldRow(
                                $model['p'], 'sort_order', array(
                            'rel' => 'tooltip', 'data-toggle' => "tooltip",
                            'data-placement' => "right",
                                )
                        ); ?></div>
                        
                    </div>
                </fieldset>
               
                 <fieldset class="portlet " >
                    <div class="portlet-decoration" onclick=" $('#hide_box_line9').slideToggle();">
                        <div class="span11"><?php echo  Library::flag().Yii::t('products','entry_description');?></div>
                        <div class="span1 Dev-arrow" ><button class="btn btn-info arrow_main" id="hide_box_btn2" type="button" ></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line9" style="display:none">
                 <div class="span11"> <?php echo $form->ckEditorRow(
                                    $model['pd'],
                                    'description',
                                    array(
                                        'editorOptions' => array(
                                            'fullpage' => 'js:true',
                                            'width' => '100%',
                                        )
                                    )
                                ); ?></div>
                    </div>
                </fieldset>
                        
                         
                <fieldset class="portlet " >
                    <div class="portlet-decoration" onclick=" $('#hide_box_line3').slideToggle();">
                        <div class="span11"><?php echo yii::t('products','heading_sub_seo');?></div>
                        <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn3" type="button"></button> </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="portlet-content" id="hide_box_line3" style="display:none">
               
                <div class="span11"> <?php
                        echo $form->textAreaRow(
                                $model['pd'], 'meta_keywords',
                                array('rel' => 'tooltip',
                            'data-toggle' => "tooltip", 'data-placement' => "right",'class'=>'span 4','rows'=>'4')
//            array('hint' => 'In addition to freeform text, any HTML5 text-based input appears like so.')
                        );
                        ?></div>
                        
                       <div class="span11">  <?php
                        echo $form->textAreaRow(
                                $model['pd'], 'meta_description',
                                array('rel' => 'tooltip',
                            'data-toggle' => "tooltip", 'data-placement' => "right",'class'=>'span 4','rows'=>'4')
//            array('hint' => 'In addition to freeform text, any HTML5 text-based input appears like so.')
                        );
                        ?></div>

						<div class="span11">  <?php
                        echo $form->textFieldRow(
                                $model['cu'], 'string',
                                array('rel' => 'tooltip',
                            'data-toggle' => "tooltip", 'data-placement' => "right",'class'=>'span 4','rows'=>'4')
                        );
                        ?></div>
               
                    </div>
                </fieldset>

        </div>
    </div>
    </div>