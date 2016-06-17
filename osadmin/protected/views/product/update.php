	 <?php
    
    $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm',
            array(
                'id' => 'horizontalForm',
                'type' => 'horizontal',
                'enableClientValidation' => true,
                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                    ),
                'htmlOptions'=>array('enctype' => 'multipart/form-data'),
                )
            );
    ?>
<?php echo $form->errorSummary($model['p']) . "" . $form->errorSummary($model['pd']); ?>

    <div class="row-fluid">
            <div class="span2 pull-right fixed_top_buttons design_fixed_top" >
            <span class="btn open-and-close"><i class="icon-chevron-right"></i> <i class="icon-chevron-left"></i>  </span>
                <?php Library::saveButton(array('label'=>Yii::t('common','button_save'),'permission'=>$this->editPerm)); ?>
				<?php Library::cancelButton(array('label'=>Yii::t('common','button_cancel'),'url'=> base64_decode(Yii::app()->request->getParam('backurl'))));  ?> 
            </div>

        <?php
         $this->widget(
          'bootstrap.widgets.TbTabs',
          array(
          'type' => 'pills',
          'tabs' => array(
                        array( 'label' => 'Standard','active' => true ,'content' => $this->renderPartial('_standardForm', array('form'=>$form,'model'=>$model,'pCategories'=>$pCategories),true)),
              
                        array( 'label' => 'Advanced',  'content' => $this->renderPartial('_Advancedform', array('form'=>$form,'model'=>$model),true)),
              
                        array( 'label' => 'Image', 'content' => $this->renderPartial('_multipleimage', array('form'=>$form,'model'=>$model),true)),
              
                        array( 'label' => 'Customised Data', 'content' => $this->renderPartial('_options', array('form'=>$form,'model'=>$model,'input'=>$input),true)),
              
                       array( 'label' => 'Customised Options',  'content' => $this->renderPartial('_optionsmultiple', array('form'=>$form,'model'=>$model,'multiple'=>$multiple),true)),
                      ),
                )
          );
        ?>
<?php
$this->endWidget();
unset($form);
?>
    </div>