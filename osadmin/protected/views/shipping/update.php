<?php //echo $form->errorSummary($model[0])."".$form->errorSummary($model[1]);   ?>
<div class="row-fluid">
    <div class="span2 pull-right fixed_top_buttons design_fixed_top" >
            
            <span class="btn open-and-close"><i class="icon-chevron-right"></i> <i class="icon-chevron-left"></i>  </span>
            <?php
        $this->widget(
                'bootstrap.widgets.TbButton',
                array(
            'label' => 'Save',
            'buttonType' => 'button',
            'visible' => $this->addPerm,
            'type' => 'info',
            'htmlOptions'=>array(
                    'onclick'=>'$(\'form\').submit()'),
                )
        );
        ?>
        <?php
        $this->widget(
                'bootstrap.widgets.TbButton',
                array(
            'label' => 'Cancel',
            'type' => 'danger',
            'url' => $this->createUrl('shipping/index'))
        );
        ?>
                
            <?php //Library::saveButton(array('label'=>Yii::t('common','button_save'),'permission'=>$this->editPerm)); ?>
            <?php //Library::cancelButton(array('label'=>Yii::t('common','button_cancel'),'url'=> base64_decode(Yii::app()->request->getParam('backurl'))));  ?>
        </div>

        <div class="row-fluid">
    		<div class="tab-pane active" id="Information">
				<div class="span12">
					<fieldset class="portlet" >
                    
						 <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                            <div class="span11"><?php echo Yii::t('shipping','heading_sub_title');?></div>
                            <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>						<div class="clearfix"></div>
                        </div> 
                        
                        <div class="portlet-content" id="hide_box_line1">
                            <?php
                            echo $form;
							//echo $form->title;//'<pre>';print_r($form);echo '</pre>';
                            ?>

                        </div>
                     </fieldset> 

                </div>  
            </div>
        </div>
</div>        
 