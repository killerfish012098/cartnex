<?php

class PageController extends BaseController
{
	public $position;
	public $data;
	
        public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			/*'page'=>array(
				'class'=>'CViewAction',
			),*/
		);
	}
        
	public function ActionContent(){
	   $data=Yii::app()->page->getContent((int)$_GET['id_page']);
           //echo '<pre>';print_r($data);echo '</pre>';exit;
           $this->breadcrumbs=array($data['title']=>Yii::app()->request->requestUri);
           $this->metatitle=$data['meta_title'];
           $this->metakeywords=$data['meta_keywords'];
           $this->metadescription=$data['meta_description'];
           $this->render("page/content",array('data'=>$data));
	}
        
	public function ActionPages(){
		$id_page=(int)$_POST['id_page'];
		$page=new page();
	    $data=$page->getContent($id_page);
	    $this->renderPartial("page/pages",array('data'=>$data));
	}

	public function ActionContactus(){
	   $this->breadcrumbs=array('Contact Us'=>Yii::app()->request->requestUri);
           //$model=new ContactForm;
           //if(isset($_POST['ContactForm']) && )
            if(!empty($_POST['ContactForm']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            {
                $error=array();
                if (empty($_POST['ContactForm']['name'])) {
                    $error['name'] = 'Please enter your name';
                }

                if(!filter_var($_POST['ContactForm']['email'], FILTER_VALIDATE_EMAIL)) {
                    $error['email'] = 'Invalid email!!';
                }

                if (empty($_POST['ContactForm']['enquiry']) || strlen($_POST['ContactForm']['enquiry']) < 25 && strlen($_POST['ContactForm']['enquiry']) > 1000)          {
                    $error['enquiry'] = 'enquiry should be greater than 25 characters and less than 1000 characters!!';
                }

                if (empty($_POST['ContactForm']['verification']) || (Yii::app()->session['captcha_code'] != $_POST['ContactForm']['verification'])) {
                    $error['verification'] = 'verification code does not match!!';
                }        
                //echo '<pre>';print_r($error);exit;
                if(!sizeof($error))
                {
                    //echo '<pre>';print_r($_POST['ContactForm']);echo '</pre>';
                    $data = array('subject'=>'Enquiry!!','description'=>$_POST['ContactForm']['enquiry'], 'mail' => array("to" => array(Yii::app()->config->getData('CONFIG_STORE_SUPPORT_EMAIL_ADDRESS') => Yii::app()->config->getData('CONFIG_STORE_NAME'))));
                    Mail::send($data);
                    Yii::app()->user->setFlash('success','Thanks for contacting us. Will get back to you soon!!');
                    $this->refresh();
                }else
                {
                    foreach($error as $k=>$v)
                    {
                        Yii::app()->user->setFlash('danger_'.$k,$v);
                    }
                }
            }
            $this->render("page/contactus");
        }

	public function ActionSitemap(){
            
            $this->breadcrumbs=array('Site Map'=>Yii::app()->request->requestUri);
            $this->render("page/sitemap",array('data'=>$data));
	}
}