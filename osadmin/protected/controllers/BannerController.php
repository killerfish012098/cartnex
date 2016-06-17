<?php

class BannerController extends Controller {

    public function actionCreate() {
        $model['b'] = new Banner;
 
        if (Yii::app()->request->isPostRequest)
            {
                $model['b']->attributes = $_POST['Banner'];
                if ($model['b']->validate())
                {
                    $model['b']->save(false);
                    if (isset($_POST['banner_image']))
                    {
                        foreach ($_POST['banner_image'] as $k=> $bannerImage) 
                        {
                            $fUploadImage = array("name" => $_FILES['banner_image']['name'][$k]['image'],"type" => $_FILES['banner_image']['type'][$k]['image'],
                            "tmp_name" => $_FILES['banner_image']['tmp_name'][$k]['image'],"error" => $_FILES['banner_image']['error'][$k]['image'],
                            "size" => $_FILES['banner_image']['size'][$k]['image'],);
                            $fUploadImage['input']['prefix'] = 'banner_' . Library::customName($bannerImage['title']) . '-' . $bannerImage['id_banner_image'] . '_';
                            $fUploadImage['input']['path'] = Library::getMiscUploadPath();
                            $fUploadImage['input']['prev_file'] = $bannerImage['prev_image'];
                            $upload = Library::fileUpload($fUploadImage);
                                if ($bannerImage['id_banner_image'] == '') //new option value
                                {
                                    $this->addBannerImage(array('id'=>$model['b']->id_banner,'title'=>$bannerImage['title'],'link'=>$bannerImage['link'],'image'=>$upload['file']));
                                }
                        }
                    }
                    
                    Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
                    $this->redirect('index');
                }
            }
        $this->render('create', array(
            'model' => $model,
        ));
    }
	public function filterData($data)
    {
        $rows=array();
        foreach($data['banner_image'] as $bannerimage)
        {
            if($bannerimage['id_banner_image']!="")
            $rows[]=$bannerimage['id_banner_image'];
        }
        if(sizeof($rows)>0)
        {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_banner = "'.$data['id'].'" and id_banner_image not in ('.@implode(",",$rows).')';
            BannerImage::model()->deleteAll($criteria);
            BannerImageDescription::model()->deleteAll($criteria);
        }
    }

    public function actionUpdate($id) 
    {
	$model = $this->loadModel($id);
        if (Yii::app()->request->isPostRequest)
            {
                $model['b']->attributes = $_POST['Banner'];
                if ($model['b']->validate())
                {
                    $model['b']->save(false);
                    $this->filterData(array("banner_image"=>$_POST['banner_image'],"id"=>$id));  
                    if (isset($_POST['banner_image']))
                    {
                           foreach ($_POST['banner_image'] as $k=>$bannerImage) 
                            {
                                /*echo $_FILES['banner_image']['name'][$k]['image'].'<pre>';
                                print_r($_FILES);
                                print_r($bannerImage);*/
                                
                                
                                $fUploadImage = array("name" => $_FILES['banner_image']['name'][$k]['image'],"type" => $_FILES['banner_image']['type'][$k]['image'],
                                "tmp_name" => $_FILES['banner_image']['tmp_name'][$k]['image'],"error" => $_FILES['banner_image']['error'][$k]['image'],
                                "size" => $_FILES['banner_image']['size'][$k]['image'],);
                                $fUploadImage['input']['prefix'] = 'banner_' . Library::customName($bannerImage['title']) . '-' . $bannerImage['id_banner_image'] . '_';
                                $fUploadImage['input']['path'] = Library::getMiscUploadPath();
                                $fUploadImage['input']['prev_file'] = $bannerImage['prev_image'];
                                $upload = Library::fileUpload($fUploadImage);
                                
                                if ($bannerImage['id_banner_image'] == '') //new option value
                                {
                                        $this->addBannerImage(array('id'=>$model['b']->id_banner,'title'=>$bannerImage['title'],'link'=>$bannerImage['link'],'image'=>$upload['file']));
                                }
                                else
                                {
                                    BannerImage::model()->updateAll(array('link' => $bannerImage['link'],'image' => $upload['file']),'id_banner_image="' . $bannerImage['id_banner_image'] . '" and id_banner="' . $id . '"');

                                    BannerImageDescription::model()->updateAll(array('title' => $bannerImage['title']),
                                    'id_language="' . Yii::app()->session['language'] . '" and id_banner_image=' . $bannerImage['id_banner_image'] . ' and id_banner=' . $id);  
                                }
                            }
                                /*echo '<pre>';
                                print_r($fUploadImage);
                                print_r($upload);
                                exit('here at last');*/
                    }
                    else
                    {
                        BannerImage::model()->deleteAll(array('condition' => 'id_banner=:io','params' => array('io' => $id)));
                        BannerImageDescription::model()->deleteAll(array('condition' => 'id_banner=:io','params' => array('io' => $id)));
                    }
                    Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                    $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
                }
            }
        $this->render('update', array('model' => $model,)); 
    }
    
    public function setUploadMultipleImages($data) 
    {
        $fUploadImage = "";
        BannerImage::model()->deleteAll('id_banner=' . $data['id']);
        foreach ($data['multiImage']['name']['upload'] as $k => $v) 
        {
            //foreach($data['imageData'] as $k=>$v)
            if ($data['multiImage']['name']['upload'][$k]['image'] == "" && $data['imageData'][$k]['prev_image'] == "") {
                continue;
            }

            $fUploadImage = array("name" => $data['multiImage']['name']['upload'][$k]['image'],
                "type" => $data['multiImage']['type']['upload'][$k]['image'],
                "tmp_name" => $data['multiImage']['tmp_name']['upload'][$k]['image'],
                "error" => $data['multiImage']['error']['upload'][$k]['image'],
                "size" => $data['multiImage']['size']['upload'][$k]['image'],);

            $fUploadImage['input']['prefix'] = 'banner_' . Library::customName($data['name']) . '-' . $data['id'] . '_' . $k . '_';
            $fUploadImage['input']['path'] = Library::getMiscUploadPath();
            $fUploadImage['input']['prev_file'] = $data['imageData'][$k]['prev_image'];

            return Library::fileUpload($fUploadImage);
        }
    }

    public function addBannerImage($value)
    {
			$bannerimage = new BannerImage;
			$bannerimage->id_banner = $value['id'];//$id;
			$bannerimage->link = $value['link'];
			$bannerimage->image = $value['image'];
			$bannerimage->save(false);
			
            foreach (Language::getLanguages() as $language) 
            {
                    $bannerimageDescription = new BannerImageDescription;
                    $bannerimageDescription->id_banner_image = $bannerimage->id_banner_image;
                    $bannerimageDescription->id_banner = $value['id'];
                    $bannerimageDescription->title = $value['title'];
                    $bannerimageDescription->id_language = $language->id_language;
                    $bannerimageDescription->save(false);
            }
    }
    
    public function deleteAttachments($rows)
    {
        foreach($rows as $id)
        {
            foreach(BannerImage::model()->findAll('id_banner='.$id) as $bImage):
               unlink(Library::getMiscUploadPath().$bImage->image); 
            endforeach;
        }
    }
    
    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_banner', $arrayRowId);
            CActiveRecord::model('Banner')->deleteAll($criteria);
             $this->deleteAttachments($arrayRowId);
            CActiveRecord::model('BannerImage')->deleteAll($criteria);
            CActiveRecord::model('BannerImageDescription')->deleteAll($criteria);
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_delete_success'));
            
        } else {
            Yii::app()->user->setFlash('alert',
                    Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',
                    Yii::t('common', 'message_delete_fail'));
        }
        
        if (!isset($_GET['ajax']))
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
    }

    public function actionIndex() {
        $model = new Banner('search');
		if (isset($_GET['Banner'])) {
            $model->attributes=$_GET['Banner'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
	{
            $model['b']=Banner::model()->find(array("condition"=>"id_banner=".$id));
            $model['bi'] = BannerImageDescription::model()->with(array(
                                                                    'bannerimage' => array(
                                                                    'joinType' => 'INNER JOIN',
                                                                    'condition' => 'bannerimage.id_banner='.$id,
                                                                    ),
                                                                    )
                                                                )->lang()->findAll();
            return $model;
	}
    
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banner-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
