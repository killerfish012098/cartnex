<div class="row col-md-12 sp-os">
    <div class="module-main-div">
        <div class="account-div-wapper">
            <div class="heading-box "> <h2><?php echo Yii::t('modules','heading_title_account')?></h2>  </div>
                <div class="module-content">
                <ul class="accordion-list">	
				<?php if(empty(Yii::app()->session['user_id'])){?>
                    <li> <a href="<?php echo $this->createAbsoluteUrl($data['link_login']); ?>"><?php echo $data['label_login']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_register']); ?>"><?php echo $data['label_register']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_profile']); ?>"><?php echo $data['label_profile']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_address']); ?>"><?php echo $data['label_address']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_forgotpassword']); ?>"><?php echo $data['label_forgotpassword']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_wishlist']); ?>"><?php echo $data['label_wishlist']?></a> </li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_orderhistory']); ?>"><?php echo $data['label_orderhistory']?></a></li>
				<?php }else{?>	
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_home']); ?>"><?php echo $data['label_home']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_profile']); ?>"><?php echo $data['label_profile']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_address']); ?>"><?php echo $data['label_address']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_wishlist']); ?>"><?php echo $data['label_wishlist']?></a> </li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_orderhistory']); ?>"><?php echo $data['label_orderhistory']?></a></li>
					<li> <a href="<?php echo $this->createAbsoluteUrl($data['link_logout']); ?>"><?php echo $data['label_logout']?></a></li>
				<?php  } ?>	
                </ul>
            </div>
        </div>
    </div>
</div> <div class="clearfix"></div>