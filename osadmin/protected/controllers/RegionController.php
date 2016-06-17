<?php

class RegionController extends Controller {

    public function actionCreate() {
        $model['r'] = new Region;

       if (Yii::app()->request->isPostRequest) {

            $model['r']->attributes = $_POST['Region'];
            if ($model['r']->validate()) {
                $model['r']->save(false);
                foreach($_POST['region_list'] as $k=>$v):
                    foreach($v['state'] as $state):
                        $insert=new RegionList();
                        $insert->id_region=$model['r']->id_region;
                        $insert->id_country=$v['country'];
                        $insert->id_state=$state;
                        $insert->save(false);
                    endforeach;
                endforeach;
				 Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
                $this->redirect('index');
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);


		if (Yii::app()->request->isPostRequest){ 
            $model['r']->attributes = $_POST['Region'];
            if ($model['r']->validate()) {
                $model['r']->save(false);
                
                RegionList::model()->deleteAll(array('condition' => 'id_region=:io','params' => array('io' => $id)));
                foreach($_POST['region_list'] as $k=>$v):
                    foreach($v['state'] as $state):
                        $insert=new RegionList();
                        $insert->id_region=$id;
                        $insert->id_country=$v['country'];
                        $insert->id_state=$state;
                        $insert->save(false);
                    endforeach;
                endforeach;
				 Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
            }
        }
        $this->render('update', array('model' => $model,));
    }

    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
            Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_region', $arrayRowId);
            CActiveRecord::model('Region')->deleteAll($criteria);
            CActiveRecord::model('RegionList')->deleteAll($criteria);

            Yii::app()->user->setFlash('success',
                    Yii::t('common', 'message_delete_success'));
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
        $model = new Region('search');
		if (isset($_GET['Region'])) {
            $model->attributes=$_GET['Region'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model['r'] = Region::model()->find(array("condition" => "id_region=" . $id));
        $model['rl'] = RegionList::model()->findAll(array("select"=>"GROUP_CONCAT( DISTINCT id_state SEPARATOR  ',' ) AS id_state,id_country","condition" => "id_region=" . $id,"group"=>"id_country"));

        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
