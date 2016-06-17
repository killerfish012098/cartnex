<?php

class CouponController extends Controller {

    public function actionCreate() {
        $model['c'] = new Coupon;
        
        if (Yii::app()->request->isPostRequest)
            {

                $model['c']->attributes = $_POST['Coupon'];
				$model['c']->save();
				if(isset($_POST['product_group'])){
                    foreach($_POST['product_group'] as $product)
                    {
                        $productcoupon=new CouponProduct;
                        $productcoupon->id_coupon=$model['c']->id_coupon;
                        $productcoupon->id_product=$product;
                        $productgroup[] = $productcoupon;
                    }

                    foreach($productgroup as $product){
                        $product->save();
                    }
                }
		Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));					
		$this->redirect('index');
            }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    public function filterData($data)
    {
        $rows=array();
        foreach($data['option_value'] as $option)
        {
            if($option['option_value_id']!="")
            $rows[]=$option['option_value_id'];
        }
        if(sizeof($rows)>0)
        {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_option = "'.$data['id'].'" and id_option_value not in ('.@implode(",",$rows).')';

            OptionValue::model()->deleteAll($criteria);
            OptionValueDescription::model()->deleteAll($criteria);
        }
    }

    public function actionUpdate($id) 
    {
			$model = $this->loadModel($id);

            if (Yii::app()->request->isPostRequest)
            {
                    $model['c']->attributes = $_POST['Coupon'];
					 $model['c']->save();
					 
					 //echo '<pre>';print_r($_POST['product_group']);exit;
					 //if(isset($_POST['product_group'])){
						//delete previosus fields
						CouponProduct::model()->deleteAll(array('condition' => 'id_coupon=:io','params' => array('io' => $model['c']->id_coupon)));
 
						foreach($_POST['product_group'] as $key=>$value)
						{
							$productcoupon=new CouponProduct;
							$productcoupon->id_coupon=$model['c']->id_coupon;
							$productcoupon->id_product=$value;
							//$productgroup[] = $productcoupon;
							$productcoupon->save();
						}

						/*foreach($productgroup as $product){
							$product->save();
						}*/
					//}
                                         Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
					$this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
            }

            $this->render('update', array('model' => $model,));
    }

    public function addOptionValue($value)
    {
            $modelOptionValue = new OptionValue;
            $modelOptionValue->id_option = $value['id'];//$id;
            $modelOptionValue->sort_order = $value['sort_order'];
            $modelOptionValue->save(false);

            foreach (Language::getLanguages() as $language) 
            {
                    $modelOptionValueDescription = new OptionValueDescription;
                    $modelOptionValueDescription->id_option_value = $modelOptionValue->id_option_value;
                    $modelOptionValueDescription->id_option = $value['id'];//$id;
                    $modelOptionValueDescription->name = $value['name'];//$optionValue['name'];
                    $modelOptionValueDescription->id_language = $language->id_language;
                    $modelOptionValueDescription->save(false);
            }
    }
    
    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_coupon', $arrayRowId);
            CActiveRecord::model('Coupon')->deleteAll($criteria);
            CActiveRecord::model('CouponHistory')->deleteAll($criteria);
            CActiveRecord::model('CouponProduct')->deleteAll($criteria);
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
        $model = new Coupon('search');
        if (isset($_GET['Coupon'])) {
            $model->attributes=$_GET['Coupon'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }
	protected function grid($data,$row,$dataColumn) {
             switch ($dataColumn->name)
             {
                 case 'discount':
					 $return=$data->type=='F'?round($data->discount):round($data->discount)."%"; 
					 break;
             }
             return $return;
        }

    public function loadModel($id)
	{
            //$model['p']=CouponProduct::model()->find(array("condition"=>"id_coupon=".$id));
            $model['c']=Coupon::model()->find(array("condition"=>"id_coupon=".$id));
            $model['ch']=CouponHistory::model()->findAll(array("condition"=>"id_coupon=".$id));
            return $model;
	}
    
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
