<?php

class ProductinfoController extends Controller
{
	function actions()
	{
		return array(
			'delete' => array(
			'class' => 'application.components.actions.DeleteAction',
			'modelClass' => 'Productinfo',
			//'redirectTo'=>'zones/index'
			),
			/*'create' => array(
			'class' => 'application.components.actions.CreateAction',
			'modelClass' => 'Zones',
			'formName'=>'zones-form',
			),
			'index' => array(
			'class' => 'application.components.actions.IndexAction',
			'modelClass' => 'Zones',
			'getForm'=>'Zones',
			),
			'update' => array(
			'class' => 'application.components.actions.UpdateAction',
			'modelClass' => 'Zones',
			'formName'=>'zones-form',
			),*/
		);
	}
        
        /*public function accessRules()
	{
            $this->accessPermissions[0][actions][]='list';
            return $this->accessPermissions;
	}*/
        
        public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
                    //'postOnly + update',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Productinfo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productinfo']))
		{
			$model->attributes=$_POST['Productinfo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
        
        /*public function beforeAction($action) {
          //echo "in before action";
            if(Yii::app()->request->getIsAjaxRequest())
            {
                echo "yes in before aciton".$this->action->id;
               return false;
                 //Yii::app()->end;
            }
            
            return parent::beforeAction($action);
        }*/
        
	public function actionUpdate($id)
	{
            //exit("in update aciton");
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productinfo']))
		{
                    echo "<pre>";print_r($_REQUEST);               echo "</pre>";exit;	
                    $model->attributes=$_POST['Productinfo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
                $this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
        
        /*public function actionDelete()//($id)
	{
            $arrayRowId=  is_array(Yii::app()->request->getParam('id'))?Yii::app()->request->getParam('id'):array(Yii::app()->request->getParam('id'));
            if(sizeof($arrayRowId)>0)
            {
                $criteria=new CDbCriteria;
                $criteria->addInCondition('id',$arrayRowId);
                Productinfo::model()->deleteAll($criteria);
                Yii::app()->user->setFlash('success',Yii::t('common','message_delete_success'));    
            }else
            {
                Yii::app()->user->setFlash('alert',Yii::t('common','message_checkboxValidation_alert'));
                Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
            }
  	    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
	}*/
        
        /**
	 * Lists all models.
	 */
	
        public function actionindex()
	{
            //Yii::app()->user->setFlash('error',Yii::t('common','message_delete_success'));
            /*$criteria=new CDbCriteria;
            $criteria->addInCondition('id',array(8,9,10));
            //$this->loadModel($criteria)->deleteAll();
            Productinfo::model()->deleteAll($criteria);
            exit("inside admin");*/
                $model=new Productinfo('search');
                $model->pageSize = 10;
                if(isset($_GET['page']))
                    $model->pageSize = $_GET['page'];
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productinfo']))
			$model->attributes=$_GET['Productinfo'];

		$this->render('admin',array(
			'model'=>$model,
                        'pageSize'=>$model->pageSize
		));
	}
        /*public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Productinfo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            //Yii::app()->user->setFlash('error',Yii::t('common','message_delete_success'));
            /*$criteria=new CDbCriteria;
            $criteria->addInCondition('id',array(8,9,10));
            //$this->loadModel($criteria)->deleteAll();
            Productinfo::model()->deleteAll($criteria);
            exit("inside admin");*/
                $model=new Productinfo('search');
                $model->pageSize = 10;
                if(isset($_GET['page']))
                    $model->pageSize = $_GET['page'];
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productinfo']))
			$model->attributes=$_GET['Productinfo'];

		$this->render('admin',array(
			'model'=>$model,
                        'pageSize'=>$model->pageSize
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Productinfo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Productinfo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Productinfo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='productinfo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
