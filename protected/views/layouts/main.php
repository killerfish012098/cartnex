<!-- Require the header -->
<?php require_once('tpl_header.php') ?>
<!-- Require the navigation -->

<?php require_once('tpl_navigation.php') ?>
<div class="notification-msg-div" id="notification">
<?php $this->widget('ext.FlashMessage.FlashMessage');   ?>
</div>
<!-- Include content pages -->
<section class="main-body-wrappers" >
	<div class="container">
        <div class="row "> <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs,)); ?> </div>

  
<!-- top-full-width start --><div class="row top-full-width"> <?php Yii::app()->module->load($this->position['top']); ?> </div>
<!-- top-full-width  end -->

 <div class="row sp-wrapper-2" id="nc-div-middle"> 
	<!-- nc-left start --><div class="col-md-3 left-wrapper" id="nc-left"><?php Yii::app()->module->load($this->position['left']); ?> </div>
    <!-- nc-left end -->
  
		<div class="col-md-6 center-wrapper" id="nc-middle">
			<!-- top-content start --> <div class="center-wrapper top-content"> <?php Yii::app()->module->load($this->position['top-center']); ?> </div>  <!-- top-content end -->
 
			<?php echo $content; ?>

			<!-- bottom-content start --><div class="center-wrapper bottom-content"> <?php Yii::app()->module->load($this->position['bottom-center']); ?> </div> <!-- bottom-content end -->
		</div>

	<!-- nc-right start --> <div class="col-md-3 right-wrapper" id="nc-right"> <?php Yii::app()->module->load($this->position['right']); ?> </div> <!-- nc-right end -->
  </div>

<!-- bottom-full-width start --> <div class="row bottom-full-width"> <?php Yii::app()->module->load($this->position['bottom']); ?> </div> 
<!-- bottom-full-width end -->
</div>

<!--    <div class="row sp-wrapper-3 container-main">
    <p>sp-wrapper-3</p>
    </div>-->


</section>
<!-- Require the footer -->
<?php require_once('tpl_footer.php');?>
