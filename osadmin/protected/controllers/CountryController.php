<?php

class CountryController extends Controller
{


	public function actionCreate()
	{
		$model=new Country;
		//if(isset($_POST['Country']))
		if(Yii::app()->request->isPostRequest)
		{
			$model->attributes=$_POST['Country'];
			if($model->save())
				Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
				$this->redirect('index');
		}
		$this->render('create',array('model'=>$model));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Country']))
		{
			$model->attributes=$_POST['Country'];
			if($model->save())
				 Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                    $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
		}
		$this->render('update',array('model'=>$model));
	}

    public function actionDelete()//($id)
	{
            $arrayRowId=  is_array(Yii::app()->request->getParam('id'))?Yii::app()->request->getParam('id'):array(Yii::app()->request->getParam('id'));
            if(sizeof($arrayRowId)>0)
            {
                $arrayRowId=$this->findRelated($arrayRowId);
                
                $criteria=new CDbCriteria;
                 $criteria->addInCondition('id_country', $arrayRowId);
                                
                if(CActiveRecord::model('Country')->deleteAll($criteria))
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
	
        public function findRelated($input)
        {
            $criteria=new CDbCriteria;
            $criteria->condition='t.id_country IN ( '.implode(",",$input).' )';
            $states=State::model()->findAll($criteria); 
            if(sizeof($states)>0)
            {
                $items="";
                $input=array_flip($input);
                foreach($states as $state):
                    $items.=$prefix.strip_tags($state->name);
                    $prefix=",";
                    unset($input[$state->id_country]);
                endforeach;
                $input=array_flip($input);

                Yii::app()->user->setFlash('alert',Yii::t('countries','warning_country', array('{details}'=>$items)));
            }
            return $input; 
        }
        
	public function actionIndex()
	{
               /*echo '<pre>';
      
                $data = array('id'=>'2','replace'=>array('%userName%'=>'Suresh Babu'), //optional
		'mail'=>array("to"=>array("suresh.k@rsoftindia.com"=>"suresh",),
			    "bcc"=>array("mahindra.mj@gmail.com"=>"mahindra","suresh@sporanzo.com"=>"sporanzo"),//optional
                            "cc"=>array("sureshbabu.kokkonda@gmail.com"=>"suresh personal"),//optional
                            "from"=>array("mahindra.mj@gmail.com"=>"from_name"),  //optional
                            "reply"=>array("mahindra.mj@gmail.com"=>"reply_name"), //optional
		));
           print_r(Mail::send($data));
            exit('in country');*/
            /*print_r(Yii::app()->shipping->getMethods());
            print_r(Yii::app()->payment->getMethods());
            exit;
            Yii::app()->shipping->loadMethods();
            exit;
            $directory = new Category('.');
            if(method_exists($directory,'getCategories'))
            {
                echo 'exits';
            }
            exit('in country');*/
            /*echo '<pre>';
            print_r(Yii::app()->cartRules->loadRules());
            exit;*/
            /*echo   Yii::app()->imageSize->productList[w]."<br>";
            echo   Yii::app()->imageSize->productThumb."<br>";
            echo   Yii::app()->imageSize->categoryThumb."<br>";
            echo   Yii::app()->imageSize->productPopup."<br>";
            echo   Yii::app()->imageSize->productAdditional."<br>";
            echo   Yii::app()->imageSize->productCompare."<br>";
            echo   Yii::app()->imageSize->productWishlist."<br>";
            echo   Yii::app()->imageSize->productCart."<br>";
            echo   Yii::app()->imageSize->brandList."<br>";
            exit;*/
                                
            $model=new Country('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Country']))
                    $model->attributes=$_GET['Country'];

            $this->render('index',array('model'=>$model));
	}


	public function loadModel($id)
	{
		$model=Country::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='country-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
