<?php

class ProductGroupController extends Controller
{
   
        public function actionCreate()
	{
            
				$model[0]=new ProductGroup;
                $model[1]= new ProductGroupDescription;
               
                if (Yii::app()->request->isPostRequest)
				{
                    	$model[0]->attributes=$_POST['ProductGroup'];
                        $model[1]->attributes=$_POST['ProductGroupDescription'];
                        
              
                        if($model[0]->validate() && $model[1]->validate()):

                            $model[0]->save(false);
                            foreach(Language::getLanguages() as $language){
                                $insert=new ProductGroupDescription;
                                $insert->attributes=$_POST['ProductGroupDescription'];
                                $insert->id_product_group=$model[0]->id_product_group;
                                $insert->id_language=$language->id_language;
                                $insert->save(false);
                            }
                            // add product id in the list table
                            if(isset($_POST['product_group'])){
                                foreach($_POST['product_group'] as $product)
                                {
                                $productgrouplist=new ProductGroupList;
                                $productgrouplist->id_product_group=$model[0]->id_product_group;
                                $productgrouplist->id_product=$product;
                                $productgroup[] = $productgrouplist;
                                }
                                
                                foreach($productgroup as $product){
                                $product->save();
                                }
                            }
                            
                        Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
                        $this->redirect('index');
                        endif;
				}

		$this->render('create',array(
			'model'=>$model,
		));
		
	}

	public function actionUpdate($id)
	{
               
		$model=$this->loadModel($id);

		if (Yii::app()->request->isPostRequest)
		{
        		$model[0]->attributes=$_POST['ProductGroup'];
				$model[1]->attributes=$_POST['ProductGroupDescription'];
                       
                        if($model[0]->validate() && $model[1]->validate()):
                            $model[0]->save(false);
                            $model[1]->save(false);
							
                            if(isset($_POST['product_group'])){
							
								ProductGroupList::model()->deleteAll(array('condition' => 'id_product_group=:io','params' => array('io' => $model[0]->id_product_group)));
								
                                foreach($_POST['product_group'] as $product)
                                {
                                $productgrouplist=new ProductGroupList;
                                $productgrouplist->id_product_group=$model[0]->id_product_group;
                                $productgrouplist->id_product=$product;
                                $productgroup[] = $productgrouplist;
                                }
                                
                                foreach($productgroup as $product){
                                $product->save();
                                }
                            }
                            
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
                $criteria->addInCondition('id_product_group',$arrayRowId);
                
                
                /*if(CActiveRecord::model('ProductGroup')->deleteAll($criteria) && CActiveRecord::model('ProductGroupDescription')->deleteAll($criteria) && CActiveRecord::model('ProductGroupList')->deleteAll($criteria)) */
				
                if(CActiveRecord::model('ProductGroup')->deleteAll($criteria) && CActiveRecord::model('ProductGroupDescription')->deleteAll($criteria))
                {
					CActiveRecord::model('ProductGroupList')->deleteAll($criteria);
                    Yii::app()->user->setFlash('success',Yii::t('common','message_delete_success'));
                }else
                {
                    //Yii::app()->user->setFlash('alert',Yii::t('common','message_checkboxValidation_alert'));
                    Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
                }
            }else
            {
                Yii::app()->user->setFlash('alert',Yii::t('common','message_checkboxValidation_alert'));
                Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
            }
            //exit;
  	    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
	}

	public function actionIndex()
	{
	
		$model=new ProductGroup('search');
	        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProductGroup']))
			$model->attributes=$_GET['ProductGroup'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
	
			$modelp=ProductGroup::model()->find('t.id_product_group='.$id);
            $modelc=ProductGroupDescription::model()->lang()->find('t.id_product_group='.$id);
            $modell=ProductGroupList::model()->findAll('t.id_product_group='.$id);

		if($modelp===null || $modelc===null || $modell===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return array($modelp,$modelc,$modell);
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='manufacturer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	} 
}
