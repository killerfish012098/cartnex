<?php
		// $url=Yii::app()->getBaseUrl(true).'/osadmin/protected/models/Customer.php';
		// echo $url;
		// require $url;
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{	

		$user=Customer::model()->find('LOWER(email)=?',array(strtolower($this->username)));
		// echo "hi";
		// echo "<pre>";
		// print_r($user);
		// exit;
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->id_customer;
			Yii::app()->session['user_first_name'] = $user->firstname;
			Yii::app()->session['user_id'] = $user->id_customer;
			Yii::app()->session['user_last_name'] = $user->lastname;
			Yii::app()->session['user_email'] = $user->email;
			Yii::app()->session['user_telephone'] = $user->telephone;
			Yii::app()->session['user_customer_group_id'] = $user->id_customer_group;
			Yii::app()->session['user_id_customer_address_default'] = $user->id_customer_address_default;

			if ($user->cart && is_string($user->cart)) {
				$cart = unserialize($user->cart);

				foreach ($cart as $key => $value) {
					if (!array_key_exists($key, $_SESSION['cart'])) {
						$_SESSION['cart'][$key] = $value;
					} else {
						$_SESSION['cart'][$key] += $value;
					}
				}			
			}

			if ($user->wishlist && is_string($user->wishlist)) {
				if (!isset($_SESSION['wishlist'])) {
					$_SESSION['wishlist'] = array();
				}

				$wishlist = unserialize($user->wishlist);

				foreach ($wishlist as $id_product) {
					if (!in_array($id_product, $_SESSION['wishlist'])) {
						$_SESSION['wishlist'][] = $id_product;
					}
				}			
			}
			
			Yii::app()->db->createCommand()->update('{{customer}}',array('ip'=>$_SERVER['REMOTE_ADDR']),'id_customer=:id',array(':id'=>(int)$user->id_customer));
                        
		    $this->username=$user->email;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}

	 
}