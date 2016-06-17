<?php

class OptionController extends Controller {

    public function actionCreate() {
        $model['o'] = new Option;
        $model['od'] = new OptionDescription;
 
       if (Yii::app()->request->isPostRequest)
            {
                $model['o']->attributes = $_POST['Option'];
                $model['od']->attributes = $_POST['OptionDescription'];
                if ($model['od']->validate())
                {
                    $model['o']->save(false);
                    foreach(Language::getLanguages() as $language):
                        $model['od'] = new OptionDescription;
                        $model['od']->id_option=$model['o']->id_option;
                        $model['od']->id_language=$language->id_language;
                        $model['od']->name=$_POST['OptionDescription']['name'];
                        $model['od']->save(false);
                    endforeach;
                   
                    if (in_array($_POST['Option']['type'],  array('select', 'radio', 'checkbox', 'image')) && isset($_POST['option_value']))
                    {
                        foreach ($_POST['option_value'] as $optionValue) 
                        {
                                if ($optionValue['option_value_id'] == '') //new option value
                                {
                                    $this->addOptionValue(array('id'=>$model['o']->id_option,'sort_order'=>$optionValue['sort_order'],'name'=>$optionValue['name']));
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
                    $model['o']->attributes = $_POST['Option'];
                    $model['od']->attributes = $_POST['OptionDescription'];

                    if ($model['od']->validate())
                    {
                            $model['o']->save(false);
                            $model['od']->save(false);
                            $this->filterData(array("option_value"=>$_POST['option_value'],"id"=>$id));      
							
                            if (in_array($_POST['Option']['type'],  array('select', 'radio', 'checkbox', 'image')) && isset($_POST['option_value']))
                            {
                                    foreach ($_POST['option_value'] as $optionValue) 
                                    {
                                            if ($optionValue['option_value_id'] == '')
                                            {
                                                    $this->addOptionValue(array('id'=>$id,'sort_order'=>$optionValue['sort_order'],'name'=>$optionValue['name']));
                                            }
                                            else
                                            {
                                                    OptionValueDescription::model()->updateAll(array('name' => $optionValue['name']),
                                                    'id_language="' . Yii::app()->session['language'] . '" and id_option_value=' . $optionValue['option_value_id'] . ' and id_option=' . $id);

                                                    OptionValue::model()->updateAll(array('sort_order' => $optionValue['sort_order']),
                                                    'id_option_value="' . $optionValue['option_value_id'] . '" and id_option="' . $id . '"');
                                            }

                                    }
                            }
                            else
                            {
                                    OptionValue::model()->deleteAll(array('condition' => 'id_option=:io','params' => array('io' => $id)));
                                    OptionValueDescription::model()->deleteAll(array('condition' => 'id_option=:io','params' => array('io' => $id)));
                            }
							 Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                            $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
                    }
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
                    $modelOptionValueDescription->save();
            }
    }
    
    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_option', $arrayRowId);
            CActiveRecord::model('Option')->deleteAll($criteria);
            CActiveRecord::model('OptionDescription')->deleteAll($criteria);
            CActiveRecord::model('OptionValue')->deleteAll($criteria);
            CActiveRecord::model('OptionValueDescription')->deleteAll($criteria);
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_delete_success'));
            
        } else {
            Yii::app()->user->setFlash('alert',
                    Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',
                    Yii::t('common', 'message_delete_fail'));
        }
        //exit;
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
    }

    public function actionIndex() {
        $model = new Option('search');
		if (isset($_GET['Option'])) {
            $model->attributes=$_GET['Option'];
        }
        $this->render('index', array('model' => $model,));
    }

    public function loadModel($id)
	{
            $model['od']=OptionDescription::model()->lang()->find(array("condition"=>"id_option=".$id)); //validation
            $model['o']=Option::model()->find(array("condition"=>"id_option=".$id));
            if (in_array($model['o']->type, array('checkbox', 'radio', 'select', 'image'))):
            $model['ov'] = OptionValueDescription::model()->with(array(
                                                                    'optionvalue' => array(
                                                                        // 'select'=>'t.name',
                                                                        'joinType' => 'INNER JOIN',
                                                                        'condition' => 'optionvalue.id_option=' . $id,
                                                                                    ),
                                                                        )
                                                                )->lang()->findAll();
            endif;

            return $model;
	}
    
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
