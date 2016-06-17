<?php

class AttributeController extends Controller {

    public function actionCreate() {
        $model['o'] = new AttributeGroup;
        $model['od'] = new AttributeGroupDescription;

        if (Yii::app()->request->isPostRequest) {
            $model['o']->attributes = $_POST['AttributeGroup'];
            $model['od']->attributes = $_POST['AttributeGroupDescription'];

            if ($model['od']->validate()) {

                $model['o']->save(false);
                foreach (Language::getLanguages() as $language):
                    $model['od'] = new AttributeGroupDescription;
                    $model['od']->id_attribute_group = $model['o']->id_attribute_group;
                    $model['od']->id_language = $language->id_language;
                    $model['od']->name = $_POST['AttributeGroupDescription']['name'];
                    $model['od']->save(false);
                endforeach;
                if (isset($_POST['attribute'])) {
                    foreach ($_POST['attribute'] as $optionValue) {
                        if ($optionValue['id_attribute'] == '') { //new option value
                            $this->addAttribute(array('id' => $model['o']->id_attribute_group, 'sort_order' => $optionValue['sort_order'], 'name' => $optionValue['name']));
                        }
                    }
                }
                Yii::app()->user->setFlash('success', Yii::t('common', 'message_create_success'));
                $this->redirect('index');
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function filterData($data) {
        $rows = array();
        foreach ($data['attribute'] as $option) {
            if ($option['id_attribute'] != "")
                $rows[] = $option['id_attribute'];
        }
        if (sizeof($rows) > 0) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_attribute_group = "' . $data['id'] . '" and id_attribute not in (' . @implode(",", $rows) . ')';

            Attribute::model()->deleteAll($criteria);
            AttributeDescription::model()->deleteAll($criteria);
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (Yii::app()->request->isPostRequest) {
            $model['o']->attributes = $_POST['AttributeGroup'];
            $model['od']->attributes = $_POST['AttributeGroupDescription'];

            if ($model['od']->validate()) {
                $model['o']->save(false);
                $model['od']->save(false);
                $this->filterData(array("attribute" => $_POST['attribute'], "id" => $id));
                if (isset($_POST['attribute'])) {
                    foreach ($_POST['attribute'] as $optionValue) {
                        if ($optionValue['id_attribute'] == '') { //new option value
                            $this->addAttribute(array('id' => $id, 'sort_order' => $optionValue['sort_order'], 'name' => $optionValue['name']));
                        } else {
                            Attribute::model()->updateAll(array('sort_order' => $optionValue['sort_order']), 'id_attribute="' . $optionValue['id_attribute'] . '" and id_attribute_group="' . $id . '"');

                            AttributeDescription::model()->updateAll(array('name' => $optionValue['name']), 'id_language="' . Yii::app()->session['language'] . '" and id_attribute=' . $optionValue['id_attribute'] . ' and id_attribute_group=' . $id);
                        }
                    }
                } else {
                    Attribute::model()->deleteAll(array('condition' => 'id_attribute_group=:io', 'params' => array('io' => $id)));
                    AttributeDescription::model()->deleteAll(array('condition' => 'id_attribute_group=:io', 'params' => array('io' => $id)));
                }
                Yii::app()->user->setFlash('success', Yii::t('common', 'message_modify_success'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
            }
        }
        $this->render('update', array('model' => $model,));
    }

    public function addAttribute($value) {
        $attribute = new Attribute;
        $attribute->id_attribute_group = $value['id']; //$id;
        $attribute->sort_order = $value['sort_order'];
        $attribute->save(false);

        foreach (Language::getLanguages() as $language) {
            $modelAttributeDescription = new AttributeDescription;
            $modelAttributeDescription->id_attribute = $attribute->id_attribute;
            $modelAttributeDescription->id_attribute_group = $value['id']; //$id;
            $modelAttributeDescription->name = $value['name']; //$optionValue['name'];
            $modelAttributeDescription->id_language = $language->id_language;
            $modelAttributeDescription->save();
        }
    }

    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
            Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_attribute_group', $arrayRowId);
            CActiveRecord::model('AttributeGroup')->deleteAll($criteria);
            CActiveRecord::model('AttributeGroupDescription')->deleteAll($criteria);
            CActiveRecord::model('Attribute')->deleteAll($criteria);
            CActiveRecord::model('AttributeDescription')->deleteAll($criteria);
            Yii::app()->user->setFlash('success', Yii::t('common', 'message_delete_success'));
        } else {
            Yii::app()->user->setFlash('alert', Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error', Yii::t('common', 'message_delete_fail'));
        }
        //exit;
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
    }

    public function actionIndex() {
        $model = new AttributeGroup('search');
        if (isset($_GET['AttributeGroup'])) {
            $model->attributes = $_GET['AttributeGroup'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model['od'] = AttributeGroupDescription::model()->lang()->find(array("condition" => "id_attribute_group=" . $id));
        $model['o'] = AttributeGroup::model()->find(array("condition" => "id_attribute_group=" . $id)); //validation
        $model['ov'] = AttributeDescription::model()->with(array(
                    'attribute' => array(
                        'joinType' => 'INNER JOIN',
                        'condition' => 'attribute.id_attribute_group=' . $id,
                    ),
                        )
                )->lang()->findAll();
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'attribute-group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    protected function grid($data, $row, $dataColumn) {
        switch ($dataColumn->name) {
            case 'name':
                $str=$data->filter==1?' (filter)':'';
                $return = $data->name.$str;
                break;
        }
        return $return;
    }
}
