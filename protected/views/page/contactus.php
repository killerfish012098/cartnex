<div class="center-wrapper sitemap-pages-main"> 

<div class="heading-box"><h2><?php echo Yii::t('page','heading_title_contactus')?></h2></div>
<form name="ContactForm" method="post">
<div class="col-md-8">

<div class="row controls">
	<div class="col-md-6 control-group">
	      <label>Name:</label>
		  <input type="text" id="name" name="ContactForm[name]" class="form-control" maxlength="100" value="<?php echo $_POST['ContactForm']['name'];?>">
	</div>
	<div class="col-md-6 control-group">
		<label>Email:</label>
		<input type="email" id="email" name="ContactForm[email]" class="form-control" maxlength="100" value="<?php echo $_POST['ContactForm']['email'];?>">
	</div>
</div>
<div class="row controls">
	<div class="col-md-12 control-group">
        <label>Telephone</label>
        <input type="text" id="telephone" name="ContactForm[telephone]" class="form-control" maxlength="100" value="<?php echo $_POST['ContactForm']['telephone'];?>">
	</div>
</div> 

<div class="row controls">
	<div class="col-md-12 control-group">
		<label>Enquiry</label>
		<textarea id="enquiry" name="ContactForm[enquiry]" class="form-control" rows="5" maxlength="5000"><?php echo $_POST['ContactForm']['enquiry'];?></textarea>
	</div>
</div>

	<div class="row controls">
		<div class="col-md-8 control-group">
			<label>Enter the below Image</label>
			<input type="text" id="verification" name="ContactForm[verification]" class="form-control" maxlength="100" value="">
			
		</div>
		
		<div class="col-md-4 control-group">
		<label></label>
		<img src="<?php echo $this->createUrl('product/captcha'); ?>" alt="captcha" />
		</div>
		
	</div>



	<div class="btn-toolbar"><input type="submit" data-loading-text="text_loading" class="btn btn-inverse" value="Submit Form"></div>

</div>
</form>
<div class="col-md-4">

<div class="heading-box line-one"><h2><?php echo Yii::t('page','text_locations')?></h2></div>

<div class="location-divmain">
 <p><i class="glyphicon glyphicon-map-marker"></i> <strong><?php echo Yii::t('page','text_store_address')?></strong><?php echo Yii::app()->config->getData('CONFIG_STORE_ADDRESS'); ?></p>
 <p><i class="glyphicon glyphicon-earphone"></i> <strong><?php echo Yii::t('page','text_store_number')?></strong> <?php echo Yii::app()->config->getData('CONFIG_STORE_TELEPHONE_NUMBER'); ?></p>
  <p><i class="glyphicon glyphicon-envelope"></i> <strong><?php echo Yii::t('page','text_store_email')?></strong> <?php echo Yii::app()->config->getData('CONFIG_STORE_SUPPORT_EMAIL_ADDRESS'); ?></p>
</div>

<div class="map-div">
<iframe width="100%" height="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d30454.729250238426!2d78.47013755!3d17.419409!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1404379836432"></iframe>
</div>

</div>

  <div class="clearfix"></div>
   </div>