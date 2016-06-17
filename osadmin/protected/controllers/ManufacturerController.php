<?php

class ManufacturerController extends Controller {

    public function actionCreate() {
        $model[0] = new Manufacturer;
        $model[1] = new ManufacturerDescription;

        if (Yii::app()->request->isPostRequest) {
            $maxid = Manufacturer::getMaxId();
            $data = $_FILES['image'];
            $data['input']['prefix'] = 'brand_' . Library::customName($_POST['ManufacturerDescription']['name']) . '_' . $maxid . '_';
            $data['input']['path'] = Library::getCatalogUploadPath();

            $data['input']['prev_file'] = $_POST['prev_file'];
            $upload = $this->fileUpload($data);
            /* echo '<pre>';
              print_r($upload);
              print_r($_FILES);
              exit; */
            $model[0]->image = $upload['file'];

            $model[0]->attributes = $_POST['Manufacturer'];
            $model[1]->attributes = $_POST['ManufacturerDescription'];


            if ($model[0]->validate() && $model[1]->validate()):
                $model[0]->save(false);
                foreach (Language::getLanguages() as $language) {
                    $insert = new ManufacturerDescription;
                    $insert->attributes = $_POST['ManufacturerDescription'];
                    $insert->id_manufacturer = $model[0]->id_manufacturer;
                    $insert->id_language = $language->id_language;
                    $insert->save(false);
                }
                Yii::app()->user->setFlash('success', Yii::t('common', 'message_create_success'));
                $this->redirect('index');
            endif;
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    function fileUpload($data) {
        if (is_uploaded_file($data['tmp_name'])) {
            $fileExt = end(explode(".", $data[name]));
            if (in_array($fileExt, explode(",", 'png,jpg'))) {
                $file = $data['input']['prefix'] . strtotime("now") . '.' . $fileExt;
                copy($data['tmp_name'], $data['input']['path'] . $file);
                if (isset($data['input']['prev_file']) && file_exists($data['input']['path'] . $data['input']['prev_file'])) {
                    @unlink($data['input']['path'] . $data['input']['prev_file']);
                }
                return array('status' => '1', 'file' => $file, 'msg' => 'upload successfull!!');
            } else {
                return array('status' => '0', 'file' => $data['input']['prev_file'],
                    'msg' => 'Invalid file extension');
            }
        } else {
            return array('status' => '0', 'file' => $data['input']['prev_file'],
                'msg' => 'No file to upload!!');
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (Yii::app()->request->isPostRequest) {

            $data = $_FILES['image'];
            $data['input']['prefix'] = 'brand_' . Library::customName($_POST['ManufacturerDescription']['name']) . '_' . $id . '_'; //'manufacturer_' . $id . '_';
            $data['input']['path'] = Library::getCatalogUploadPath();
            $data['input']['prev_file'] = $_POST['prev_file'];
            $upload = $this->fileUpload($data);
            $model[0]->attributes = $_POST['Manufacturer'];
            $model[0]->image = $upload['file'];
            //$model[0]->attributes=$_POST['Manufacturer'];
            $model[1]->attributes = $_POST['ManufacturerDescription'];
            if ($model[0]->validate() && $model[1]->validate()):
                //if($model[0]->save() && $model[1]->save()):
                $model[0]->save(false);
                $model[1]->save(false);
                Yii::app()->user->setFlash('success', Yii::t('common', 'message_modify_success'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
            endIf;
        }

        $this->render('update', array('model' => $model));
    }

    public function setUploadData($file) {

        $data = array();
        foreach ($file['name'] as $key => $value) {
            $data[$key]['name'] = $value;
            $data[$key]['type'] = $file['type'][$key];
            $data[$key]['tmp_name'] = $file['tmp_name'][$key];
            $data[$key]['error'] = $file['error'][$key];
            $data[$key]['size'] = $file['size'][$key];
        }
    }

    public function deleteAttachment($condition) {
        foreach (Manufacturer::model()->findAll($condition) as $Manufacturer):
            unlink(Library::getCatalogUploadPath() . $Manufacturer->image);
        endforeach;
    }

    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $arrayRowId = $this->findRelated($arrayRowId);

            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_manufacturer', $arrayRowId);
            $this->deleteAttachment($criteria);
            //exit;
            if (CActiveRecord::model('Manufacturer')->deleteAll($criteria) && CActiveRecord::model('ManufacturerDescription')->deleteAll($criteria)) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'message_delete_success'));
            } else {
                Yii::app()->user->setFlash('error', Yii::t('common', 'message_delete_fail'));
            }
        } else {
            Yii::app()->user->setFlash('alert', Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error', Yii::t('common', 'message_delete_fail'));
        }

        if (!isset($_GET['ajax']))
            $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
    }

    public function findRelated($input) {
        $criteria = new CDbCriteria;
        $criteria->select = "DISTINCT t.id_manufacturer, md.name";
        $criteria->join = "INNER JOIN r_manufacturer_description md on t.id_manufacturer = md.id_manufacturer";
        $criteria->condition = 'md.id_language =  "' . Yii::app()->session['language'] . '" AND t.id_manufacturer   IN ( ' . implode(",", $input) . ' )';
        $products = Product::model()->findAll($criteria);
        if (sizeof($products) > 0) {
            $items = "";
            $input = array_flip($input);
            foreach ($products as $product):
                $items.=$prefix . strip_tags($product->name);
                $prefix = ",";
                unset($input[$product->id_manufacturer]);
            endforeach;
            $input = array_flip($input);

            Yii::app()->user->setFlash('alert', 'Cannot delete "' . $items . '" as some of the products are associated with it.'); //Yii::t('common','message_checkboxValidation_alert')
        }
        return $input;
    }

    public function actionIndex() {
        $model = new Manufacturer('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Manufacturer']))
            $model->attributes = $_GET['Manufacturer'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $modelp = Manufacturer::model()->find('t.id_manufacturer=' . $id);
        $modelc = ManufacturerDescription::model()->find('t.id_manufacturer=' . $id);
        if ($modelp === null || $modelc === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return array($modelp, $modelc);
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
