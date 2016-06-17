<?php //echo $form->errorSummary($model[0])."".$form->errorSummary($model[1]);   ?>
<div class="row-fluid">
          <div class="span2 pull-right fixed_top_buttons design_fixed_top" >
            <span class="btn open-and-close"><i class="icon-chevron-right"></i> <i class="icon-chevron-left"></i>  </span>
			<?php
            Library::saveButton(array('label'=>Yii::t('common','button_save'),'permission'=>$this->addPerm)); 
            Library::cancelButton(array('label'=>Yii::t('common','button_cancel'),'url'=> $this->createUrl('index')));            
            ?>
        </div>


        <div class="row-fluid">

        <div class="tab-pane active" id="Information">

                <div class="span12">


                     <fieldset class="portlet " >

                         <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                            <div class="span11"><?php echo $form->title;?></div>
                            <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" type="button"></button> </div>
                            <div class="clearfix"></div>
                        </div> 
                        <div class="portlet-content" id="hide_box_line1">
                            <?php 
                            
echo $form->renderBegin();
    foreach($form->getElements() as $element)
    echo $element->render();
echo $form->renderEnd();
?>
                            <?php
                            
                            
                            /*echo '<pre>';
                            print_r($form);
                            echo '</pre>';*/
                            //echo $form;
                            //echo $form['CARTRULE_TOTAL_TITLE'];
                            //$this->renderPartial('_form',array('form'=>$form));
                            ?>

                        </div>
                     </fieldset> 
            </div>
        </div>

    </div>
</div>        
 