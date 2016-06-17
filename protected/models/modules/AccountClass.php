<?php
class AccountClass
{
	public $data;
	public function __construct($data=null) {
 
  		$this->data=array(
		'label_home'=>Yii::t('modules','label_home'),
		"label_login"=>Yii::t('modules','label_login'),
		"label_register"=>Yii::t('modules','label_register'),
		"label_profile"=>Yii::t('modules','label_profile'),
		"label_address"=>Yii::t('modules','label_address'),
		"label_forgotpassword"=>Yii::t('modules','label_forgotpassword'),
		"label_wishlist"=>Yii::t('modules','label_wishlist',array('count'=>count($_SESSION['wishlist']))),
		"label_orderhistory"=>Yii::t('modules','label_orderhistory'),
		"label_logout"=>Yii::t('modules','label_logout'),

		"link_home"=>'account/index',
		"link_login"=>'account/login',
		"link_register"=>'account/register',
		"link_profile"=>'account/profile',
		"link_address"=>'account/address',
		"link_forgotpassword"=>'account/forgotpassword',
		"link_wishlist"=>'account/wishlist',
		"link_orderhistory"=>'account/orderhistory',
		"link_logout"=>'account/logout',
		);
	}
}
