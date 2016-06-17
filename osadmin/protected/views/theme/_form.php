<script type="text/javascript" src="http://localhost/Cartnex/cartnex/osadmin/js/jscolor/jscolor.js"></script>
<div class="tab-pane active" id="Information">
    <div class="span12">
        <fieldset class="portlet " >
            <div class="portlet-decoration arrow-minus" onclick=" $('#hide_box_line1').slideToggle();">
                <div class="span11">
                    <?php echo Yii::t('themes',
                            'heading_sub_title') ?></div>
                <div class="span1 Dev-arrow"><button class="btn btn-info arrow_main" id="hide_box_btn1" type="button"></button> </div>
                <div class="clearfix"></div>	
            </div>
            <div class="portlet-content " id="hide_box_line1">
               <div class="span5">
                    <div class="control-group">
                        <label class="control-label required" for="theme">Theme Name: </label>
                        <div class="controls">
                            <label class="control-label required" for="theme"><?php echo $id;?> </label>                   </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label for="theme" class="control-label required">Apply Theme: </label>
                        <div class="controls">
                            <?php echo CHtml::checkbox('theme',$default,array('value'=>1));?>
                        </div>
                    </div>
                   
                </div>
                
                <div class="span5">
                    <div class="control-group">
                        <label for="settings" class="control-label required">Apply Default Settings: </label>
                        <div class="controls">
                            <?php //echo CHtml::checkbox('settings',$default,array('value'=>1));                          ?>
                            <input type="checkbox" name="settings" value="1" onchange="if(this.checked){$('#params').hide()}else{$('#params').show()}">
                        </div>
                    </div>
                   
                </div>
                <!--<input type="text" name="color" value="#fff" class="color {hash:true,caps:false,required:false}">-->
                <div id="params">
                <?php foreach($data as $element):?>
                <div class="span5">
                    <div class="control-group">
                        <label for="<?php echo $element['name'];?>" class="control-label required"><?php echo $element['label'];?>: </label>
                        <div class="controls">
                            <?php //echo strtolower(substr($element['name'],-7,7))."<br/>";
                            $class="_color%"==strtolower(substr($element['name'],-7,7))?"class='color {hash:true,caps:false,required:false}'":"";?>
                            <input type="text" value="<?php echo $element['value'];?>"  name="params[<?php echo $element['name'];?>]" <?php echo $class;?> >
                            
                        </div>
                    </div>
                   
                </div>
                 <?php endforeach;?>
                </div>
            </div>
        </fieldset>
    </div>   
</div>