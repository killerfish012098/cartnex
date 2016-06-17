<div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">  
	<div class="heading-box"><h2><?php echo Yii::t('account','heading_title_order_list')?></h2></div>

		<div class="col-md-12 oder-main-div">
			<?php 
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$dataProvider,
					//'itemView'=>'webroot.themes.default.views.accounts._orderview',
					'itemView'=>'application.views.account._orderview',
			)); ?>
		</div>
	 </div>
  <div class="center-wrapper bottom-content"><?php Yii::app()->module->load($this->position['bottom-center']); ?></div>
  </div>
 