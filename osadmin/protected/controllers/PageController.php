<?php
class PageController extends Controller
{
   
        public function actionCreate()
	{
		$model[0]=new Page;
                $model[1]= new PageDescription;
                
        if (Yii::app()->request->isPostRequest)
		{
                    	$model[0]->attributes=$_POST['Page'];
                        $model[1]->attributes=$_POST['PageDescription'];
                        
                        
                        if($model[0]->validate() && $model[1]->validate()):
                            $model[0]->save(false);
                            foreach(Language::getLanguages() as $language){
                                $insert=new PageDescription;
                                $insert->attributes=$_POST['PageDescription'];
                                $insert->id_page=$model[0]->id_page;
                                $insert->id_language=$language->id_language;
                                $insert->save(false);
                            }
                        CustomUrl::setCustomUrl(array('string'=>$_POST['CustomUrl']['string'],'type'=>'page','id'=>$model[0]->id_page,'alt'=>$_POST['PageDescription']['title']));
                        Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
                        $this->redirect('index');
                        endif;
		}
                
                $model[2] = CustomUrl::getCustomUrl();
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if (Yii::app()->request->isPostRequest)
		{
        		$model[0]->attributes=$_POST['Page'];
				$model[1]->attributes=$_POST['PageDescription'];
                        if($model[0]->validate() && $model[1]->validate()):
                        //if($model[0]->save() && $model[1]->save()):
                            $model[0]->save(false);
                            $model[1]->save(false);
                            CustomUrl::setCustomUrl(array('string'=>$_POST['CustomUrl']['string'],'type'=>'page','id'=>$id,'alt'=>$_POST['PageDescription']['title']));
                             Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                            $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
                        endIf;
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

        public function actionDelete()//($id)
	{
            $arrayRowId=  is_array(Yii::app()->request->getParam('id'))?Yii::app()->request->getParam('id'):array(Yii::app()->request->getParam('id'));
            if(sizeof($arrayRowId)>0)
            {
                $criteria=new CDbCriteria;
                $criteria->addInCondition('id_page',$arrayRowId);
                CustomUrl::deleteCustomUrl(array('type'=>'page','id'=>$arrayRowId));
                if(CActiveRecord::model('Page')->deleteAll($criteria) && CActiveRecord::model('PageDescription')->deleteAll($criteria))
                {
                    Yii::app()->user->setFlash('success',Yii::t('common','message_delete_success'));
                }else
                {
                    Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
                }
            }else
            {
                Yii::app()->user->setFlash('alert',Yii::t('common','message_checkboxValidation_alert'));
                Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
            }
           
            if(!isset($_GET['ajax']))
                $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
	}


	public function actionIndex()
	{
		$model=new Page('search');
	        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['Page']))
			$model->attributes=$_GET['Page'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$modelp=Page::model()->find('t.id_page='.$id);
                $modelc=PageDescription::model()->find('t.id_page='.$id);
                $modelcu=  CustomUrl::getCustomUrl(array('type'=>'page','id'=>$id));
		if($modelp===null || $modelc===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return array($modelp,$modelc,$modelcu);
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionlist(){
            echo "in list action";            
        }
}