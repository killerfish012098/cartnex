<?php

class MystoreForm extends CActiveRecord //CFormModel
{
	private $_dynamicData=array();
        private $_dynamicFields = array();
        
        public function rules() 
        {

                return array(
                        array('CONFIG_STORE_NAME,CONFIG_STORE_OWNER,CONFIG_STORE_OWNER_EMAIL_ADDRESS,CONFIG_STORE_SUPPORT_EMAIL_ADDRESS', 'required'),
                        array(implode(",",array_keys($this->_dynamicFields)), 'safe'),
                );
        }
        public function tableName()
	{
		return '{{configuration}}';
	}
        public function attributeNames() 
        {
                return array_merge(
					
                        parent::attributeNames(),
                        array_keys($this->_dynamicFields)
                );
        }

    public function attributeLabels()
	{

            return array(
                    'CONFIG_STORE_NAME' => Yii::t('mystore','entry_CONFIG_STORE_NAME'),
					'CONFIG_STORE_OWNER' => Yii::t('mystore','entry_CONFIG_STORE_OWNER'),
					'CONFIG_STORE_OWNER_EMAIL_ADDRESS' => Yii::t('mystore','entry_CONFIG_STORE_OWNER_EMAIL_ADDRESS'),
					'CONFIG_STORE_REPLY_EMAIL' => Yii::t('mystore','entry_CONFIG_STORE_REPLY_EMAIL'),
					'CONFIG_STORE_NO_IMAGE' => Yii::t('mystore','entry_CONFIG_STORE_NO_IMAGE'),
					'CONFIG_STORE_LOGO_IMAGE' => Yii::t('mystore','entry_CONFIG_STORE_LOGO_IMAGE'),
					'CONFIG_STORE_SHOW_CATEGORY_PRODUCT_COUNT' => Yii::t('mystore','entry_CONFIG_STORE_SHOW_CATEGORY_PRODUCT_COUNT'),
					'CONFIG_STORE_FAVI_IMAGE' => Yii::t('mystore','entry_CONFIG_STORE_FAVI_IMAGE'),
					'CONFIG_STORE_SUPPORT_EMAIL_ADDRESS' => Yii::t('mystore','entry_CONFIG_STORE_SUPPORT_EMAIL_ADDRESS'),
					'CONFIG_STORE_STATE' => Yii::t('mystore','entry_CONFIG_STORE_STATE'),
					'CONFIG_STORE_TELEPHONE_NUMBER' => Yii::t('mystore','entry_CONFIG_STORE_TELEPHONE_NUMBER'),
					'CONFIG_STORE_FAX_NUMBER' => Yii::t('mystore','entry_CONFIG_STORE_FAX_NUMBER'),
					'CONFIG_STORE_ADDRESS' => Yii::t('mystore','entry_CONFIG_STORE_ADDRESS'),
					'CONFIG_STORE_COUNTRY' => Yii::t('mystore','entry_CONFIG_STORE_COUNTRY'),
					'CONFIG_STORE_ALLOW_CHECKOUT' => Yii::t('mystore','entry_CONFIG_STORE_ALLOW_CHECKOUT'),
					'CONFIG_STORE_LOGIN_SHOW_PRICE' => Yii::t('mystore','entry_CONFIG_STORE_LOGIN_SHOW_PRICE'),
					'CONFIG_STORE_INVOICE_PREFIX' => Yii::t('mystore','entry_CONFIG_STORE_INVOICE_PREFIX'),
					'CONFIG_STORE_APPROVE_NEW_CUSTOMER' => Yii::t('mystore','entry_CONFIG_STORE_APPROVE_NEW_CUSTOMER'),
					'CONFIG_STORE_ALLOW_GUEST_CHECKOUT' => Yii::t('mystore','entry_CONFIG_STORE_ALLOW_GUEST_CHECKOUT'),
					'CONFIG_STORE_ALLOW_REVIEWS' => Yii::t('mystore','entry_CONFIG_STORE_ALLOW_REVIEWS'),
					'CONFIG_STORE_ACCOUNT_TERMS' => Yii::t('mystore','entry_CONFIG_STORE_ACCOUNT_TERMS'),
					'CONFIG_STORE_CHECKOUT_TERMS' => Yii::t('mystore','entry_CONFIG_STORE_CHECKOUT_TERMS'),
					'CONFIG_STORE_ORDER_ALERT' => Yii::t('mystore','entry_CONFIG_STORE_ORDER_ALERT'),
					'CONFIG_STORE_ORDER_ALERT_MAILS' => Yii::t('mystore','entry_CONFIG_STORE_ORDER_ALERT_MAILS'),
                
            );
	}
        
        public function __get($name) 
        {
                if (!empty($this->_dynamicFields[$name])) {
                        /*if (!empty($this->_dynamicData[$name])) {
                                return $this->_dynamicData[$name];
                        } else {
                                return null;
                        }*/
                        return $this->_dynamicData[$name];
                } else {
                        return parent::__get($name);
                }
        }
        
        public function __set($name, $val) 
        {
                if (!empty($this->_dynamicFields[$name])) {
                        $this->_dynamicData[$name] = $val;
                } else {
                        parent::__set($name, $value);
                }
        }
        
        

        public function MystoreForm()
        {
            $configFields=array();
            foreach(Configuration::getConfigurations(array('condition'=>"code='CONFIG' and `key` like 'CONFIG_STORE_%'")) as $config):
                //$configFields[$config[key]]=1;
                $this->_dynamicFields[$config[key]]=1;
                $this->_dynamicData[$config[key]]=$config[value];
            endforeach;
            
            //echo '<pre>';print_r($this->_dynamicData);echo '</pre>';
			//echo "value of	".$this->_dynamicData[CONFIG_STORE_ALLOW_CHECKOUT];
            /*exit;
                
                 $this->_dynamicFields=array(
                                        'CONFIG_STORE_NAME' =>2,
                                        'CONFIG_STORE_OWNER_NAME' => 1,
                                        'CONFIG_STORE_EMAIL_ADDRESS' => 1,
                                        'CONFIG_STORE_SUPPORT_EMAIL_ADDRESS' => 1
                                    );*/
        }
}
