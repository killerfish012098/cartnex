<?php

class SiteController extends BaseController {

    public $position;
    public $data;

    /**
     * Declares class-based actions.

      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'postOnly + delete, create',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      } */
    public function actionTest() {
        //Library::setSearchKeyword('');
		//exit;
		
		/* echo Yii::app()->currency->format('100');
          echo '<pre>';
          print_r($_SESSION); */
        /*echo Yii::app()->imageSize->productList[w] . " " . Yii::app()->imageSize->productList[h] . "<br>";
        echo Yii::app()->imageSize->productThumb[w] . " " . Yii::app()->imageSize->productThumb[h] . "<br>";
        echo Yii::app()->imageSize->categoryThumb[w] . " " . Yii::app()->imageSize->categoryThumb[h] . "<br>";
        echo Yii::app()->imageSize->productPopup[w] . " " . Yii::app()->imageSize->productPopup[h] . "<br>";
        echo Yii::app()->imageSize->productAdditional[w] . " " . Yii::app()->imageSize->productAdditional[h] . "<br>";
        echo Yii::app()->imageSize->productCompare[w] . " " . Yii::app()->imageSize->productCompare[h] . "<br>";
        echo Yii::app()->imageSize->productWishlist[w] . " " . Yii::app()->imageSize->productWishlist[h] . "<br>";
        echo Yii::app()->imageSize->productCart[w] . " " . Yii::app()->imageSize->productCart[h] . "<br>";
        echo Yii::app()->imageSize->brandList[w] . " " . Yii::app()->imageSize->brandList[h] . "<br>";
        exit;*/
    }

    public function init() {
        parent::init();
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        //$this->metatitle='Welcome to CartNex';
        //$this->setMetaDetails(array('metatitle'=>'Welcome to CartNex'));
        //Library::metatitle="hellow world";
        //echo "value of".Yii::app()->config->getData('CONFIG_STORE_NAME');
        //echo "value of ".Yii::getPathOfAlias('application.views');
        //exit;
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        //$this->renderPartial('/default/site/index');
        //if (file_exists(DIR_TEMPLATE.'/'.CONFIG_WEBSITE_TEMPLATE.'/site/index.php')) {
        //$this->render('/'.CONFIG_WEBSITE_TEMPLATE.'/site/index');
        //}else{
        /*if(Yii::app()->config->getData('CONFIG_WEBSITE_MAINTENANCE_MODE'))
        {
            $data['title']='Maintenance';
            $data['description']=Yii::app()->config->getData('CONFIG_WEBSITE_MAINTENANCE_MESSAGE');
            echo $this->renderPartial("page/content",array('data'=>$data));
        }else
        {    
            $this->position = Yii::app()->module->prepare('home');
            $this->render('site/index');
        }*/
        //}
    //
           $this->position = Yii::app()->module->prepare('home');
            $this->render('site/index'); 
	}
        
        public function actionMaintenance()
        {
            //exit;
            if(Yii::app()->config->getData('CONFIG_WEBSITE_MAINTENANCE_MODE'))
            {
                $data['title']='Maintenance';
                $data['description']=Yii::app()->config->getData('CONFIG_WEBSITE_MAINTENANCE_MESSAGE');
                echo $this->renderPartial("page/content",array('data'=>$data));
            }else
            {
                $this->redirect($this->createUrl('site/index'));
            }
        }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) echo $error['message'];
            else $this->render('site/error', $error);
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
    
    public function actionMail()
    {
        echo '<pre>';
            /*$data = array('id'=>'2','replace'=>array('%userName%'=>'Suresh Babu'), //optional
		'mail'=>array("to"=>array(array("name"=>"suresh","email"=>"suresh.k@rsoftindia.com"),array("name"=>"suresh personal","email"=>"sureshbabu.kokkonda@gmail.com"),),
			     "bcc"=>array(array("name"=>"mahindra","email"=>"mahindra.mj@gmail.com"),array("name"=>"sporanzo","email"=>"suresh@sporanzo.com")),//optional
				//"cc"=>array(array("name"=>"mahindra","email"=>"mahindra.mj@gmail.com"),array("name"=>"sporanzo","email"=>"suresh@sporanzo.com")),//optional
				//"from"=>array("name"=>"From User","email"=>"from@dispostable.com"),  //optional
				//"reply"=>array("name"=>"Reply User","email"=>"reply@dispostable.com"), //optional
		));*/
        
                $data = array('id'=>'2','replace'=>array('%userName%'=>'Suresh Babu'), //optional
		'mail'=>array("to"=>array("suresh.k@rsoftindia.com"=>"suresh",),
			    "bcc"=>array("mahindra.mj@gmail.com"=>"mahindra","suresh@sporanzo.com"=>"sporanzo"),//optional
                            "cc"=>array("sureshbabu.kokkonda@gmail.com"=>"suresh personal"),//optional
                            "from"=>array("mahindra.mj@gmail.com"=>"from_name"),  //optional
                            "reply"=>array("mahindra.mj@gmail.com"=>"reply_name"), //optional
		));
           Mail::send($data);
            exit('in country');
    }

}
