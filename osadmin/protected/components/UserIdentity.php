<?php

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
		$user=Admin::model()->find('status=1 and LOWER(email)=?',array(strtolower($this->username)));
		/*echo "<pre>";
		print_r($user);
		exit;*/
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->id_admin;
		    //$this->setState('first_name', $user->first_name);
			//$this->setState('last_name', $user->last_name);
			Yii::app()->session['first_name'] =$user->first_name;
            Yii::app()->session['id_admin_role'] =$user->id_admin_role;
			Yii::app()->session['last_name'] =$user->last_name;
			//Yii::app()->session->set('user.first_name',$user->first_name);
			//Yii::app()->session->set('user.last_name',$user->last_name);
 			$this->username=$user->email;
			$this->errorCode=self::ERROR_NONE;
			Yii::app()->db->createCommand('UPDATE {{admin}} SET last_visit_date = present_visit_date,present_visit_date = NOW( ) WHERE id_admin ="'.$user->id_admin.'"')->query();
			$cookie = new CHttpCookie('cNmC', $user->present_visit_date);
			$cookie->expire = time()+60*60;
			Yii::app()->request->cookies['cNmC'] = $cookie;
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