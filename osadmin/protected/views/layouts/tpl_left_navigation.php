<div class="pull-left span3" id="test">
    <div class="navbare_left_bg">
    <div class=" navbare_left">
        	<div class="style-switcher pull-left">
         <i class="icon-user"></i>
		  <?php echo Yii::t('common','text_welcome',array('{user}'=>Yii::app()->session['first_name'],'{link}'=>$this->createUrl('site/logout'),'{link_title}'=>'logout'));?>
          	</div>
    </div>
		<div class="sidebar-nav">
                <?php 
                    $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
		  			'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=>$this->menuItemsList,//$this->itemArray,
                  )); ?>
		</div>
	</div>
</div>