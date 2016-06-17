<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends CController {
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    // public $layout='//default/layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $metatitle = null;
    public $metakeywords = null;
    public $metadescription = null;
    public $menu = array();
    public $global=array();
    //public $app=null;
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function setMetaDetails() {
        $this->metatitle = Yii::app()->config->getData('CONFIG_WEBSITE_META_TITLE');
        $this->metakeywords = Yii::app()->config->getData('CONFIG_WEBSITE_META_KEYWORDS');
        $this->metadescription = Yii::app()->config->getData('CONFIG_WEBSITE_META_DESCRIPTION');
    }

    public function __construct() {
        //print_r($_GET);
        //print(Yii::app()->getRequest()->getParam('lang'));
        //$this->app=Yii::app();
        
        //$this->getLanguage();
        //$this->getLayout();
        /*$this->getLangCurr();
        if (isset($_GET['lang'])) {
            $this->language();
        } elseif (isset($_GET['curr'])) {
            $this->currency();
        }*/
		$this->checkMaintenance();
        $this->setMetaDetails();
		$this->setLocale();
        $this->global=array();
        $this->global['text_cart_size']=Yii::app()->cart->countProducts();
        $this->global['text_cart_total']=Yii::app()->currency->format(Yii::app()->cart->getSubTotal());
        
        if(Yii::app()->user->isGuest)
        {
            $this->global['text_welcome']=Yii::t('common','text_guestuser');
            $this->global['url_welcome']=array('account/login');
            $this->global['text_login_logout']=Yii::t('common','text_login');
            $this->global['url_login_logout']=array('account/login');
        }else
        {
            $this->global['text_welcome']=Yii::t('common','text_loginuser',array('{user}'=>Yii::app()->session['user_first_name']." ".Yii::app()->session['user_last_name']));
            $this->global['url_welcome']=array('account/index');
            $this->global['text_login_logout']=Yii::t('common','text_logout');
            $this->global['url_login_logout']=array('account/logout');
        }
        
        
		//echo '<pre>';print_r($_SESSION);echo '</pre>';        
        
        
        parent::__construct();
    }

	public function checkMaintenance()
	{
		//exit("value of ".Yii::app()->user->id);
		//echo '<pre>';print_r($_COOKIE);print_r(Yii::app()->session);EXIT;
		
		if(Yii::app()->config->getData('CONFIG_WEBSITE_MAINTENANCE_MODE'))
        {
			$getMaintenanceData=Library::getMaintenanceData();
			if(isset($_COOKIE['cNmC']) && in_array($_COOKIE['cNmC'],Library::getMaintenanceData()) && sizeof($getMaintenanceData))
			{
				//exit('inside');
			}else if(Yii::app()->urlManager->parseUrl(Yii::app()->request)!='site/maintenance')
			{
				$this->redirect($this->createUrl('site/maintenance'));
			}
		}
	}

    public function setLocale()
    {

        //echo '<pre>';print_r($_SERVER);exit;
        if (isset($_GET['lang'])) { //language
           
            Yii::app()->session['language'] = $_GET['lang'];
			$this->redirect($_SERVER['HTTP_REFERER']);
            //$this->language();
        }else if(!isset(Yii::app()->session['language']))
        {
           
            Yii::app()->session['language'] = Yii::app()->config->getData('CONFIG_STORE_DEFAULT_LANGUAGE');
        } 
        
        if (isset($_GET['curr'])) {
            Yii::app()->session['currency'] = $_GET['curr'];
			$this->redirect($_SERVER['HTTP_REFERER']);
        }else  if(!isset(Yii::app()->session['currency']))
        {
            Yii::app()->session['currency'] = Yii::app()->config->getData('CONFIG_STORE_DEFAULT_CURRENCY');
        }
		Yii::app()->currency->set(Yii::app()->session['currency']);
    }  
    
    /*public function getLangCurr() {
        $criteria = new CDbCriteria;
        $criteria->condition = "t.key='CONFIG_STORE_DEFAULT_LANGUAGE' or t.key='CONFIG_STORE_DEFAULT_CURRENCY'";
        $getLangCurr = Configuration::model()->findAll($criteria);
        foreach ($getLangCurr as $langcurr) {
            Yii::app()->session[$langcurr['key']] = $langcurr['value'];
        }
    }*/

    /*public function language() {
        Yii::app()->session['CONFIG_STORE_DEFAULT_LANGUAGES'] = $_GET['lang'];
    }

    public function currency() {
        Yii::app()->session['CONFIG_STORE_DEFAULT_CURRENCYS'] = $_GET['curr'];
    }*/

    public function getLayout() {
        if (constant(CONFIG_WEBSITE_TEMPLATE) != '') {
            $this->layout = "//" . CONFIG_WEBSITE_TEMPLATE . '/layouts/main';
        }
    }

    /*public function getLanguage() {
        $criteria = new CDbCriteria;
        $criteria->condition = "t.code='" . Yii::app()->session['CONFIG_STORE_DEFAULT_LANGUAGES'] . "'";
        $getlanguageid = Language::model()->findAll($criteria);
        Yii::app()->session['CONFIG_STORE_DEFAULT_LANGUAGE_ID'] = $getlanguageid[0]['id_language'];
    }*/
}
