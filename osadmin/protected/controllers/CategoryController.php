<?php

class CategoryController extends Controller {

    public $categoryNames = array();

    public function actionCreate() {
        $model[0] = new Category;
        $model[1] = new CategoryDescription;
        //$model[2] = new CategoryFilter;

        if (Yii::app()->request->isPostRequest) {

            $maxid = Category::getMaxId();
            $data = $_FILES['image'];
            $data['input']['prefix'] = 'category_' . $maxid . '_';
            $data['input']['path'] = Library::getCatalogUploadPath();

            $data['input']['prev_file'] = $_POST['prev_file'];
            $upload = Library::fileUpload($data);
            $model[0]->image = $upload['file'];
            $model[0]->attributes = $_POST['Category'];
            $model[1]->attributes = $_POST['CategoryDescription'];

            if ($model[0]->validate() && $model[1]->validate()):
                $model[0]->save(false);
                foreach (Language::getLanguages() as $language) {
                    $insert = new CategoryDescription;
                    $insert->attributes = $_POST['CategoryDescription'];
                    $insert->id_category = $model[0]->id_category;
                    $insert->id_language = $language->id_language;
                    $insert->save(false);
                }

                CustomUrl::setCustomUrl(array('string' => $_POST['CustomUrl']['string'], 'type' => 'category', 'id' => $model[0]->id_category, 'alt' => $_POST['CategoryDescription']['name']));

                foreach ($_POST['filter'] as $k => $v) {
                    foreach ($v as $sk => $sv) {
                        if ($sv['active'] == '1') {
                            $insert = new CategoryFilter();
                            $insert->id_category = $model[0]->id_category;
                            $insert->sort_order = $sv['sort_order'];
                            $insert->id = $sk;
                            $insert->type = $k;
                            $insert->save(false);
                        }
                    }
                }
                Yii::app()->user->setFlash('success', Yii::t('common', 'message_create_success'));
                $this->redirect('index');
            endif;
        }

        $model[2] = CustomUrl::getCustomUrl();
        $this->render('create', array('model' => $model));
    }

    /*function fileUpload($data) {
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
    }*/

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

    public function actionUpdate($id) {


        $model = $this->loadModel($id);
        if (Yii::app()->request->isPostRequest) {
            //echo "<pre>";
            //print_r($_POST);
            //exit;
            CategoryFilter::model()->deleteAll(array('condition' => 'id_category=:io', 'params' => array('io' => $id)));
            foreach ($_POST['filter'] as $k => $v) {
                foreach ($v as $sk => $sv) {
                    if ($sv['active'] == '1') {
                        $insert = new CategoryFilter();
                        $insert->id_category = $id;
                        $insert->sort_order = $sv['sort_order'];
                        $insert->id = $sk;
                        $insert->type = $k;
                        $insert->save(false);
                    }
                }
            }

            $data = $_FILES['image'];
            $data['input']['prefix'] = 'category_' . $id . '_';
            $data['input']['path'] = Library::getCatalogUploadPath();
            $data['input']['prev_file'] = $_POST['prev_file'];
            $upload = Library::fileUpload($data);
            $model[0]->attributes = $_POST['Category'];
            $model[0]->image = $upload['file'];
            $model[1]->attributes = $_POST['CategoryDescription'];
            if ($model[0]->validate() && $model[1]->validate()):
                //if($model[0]->save() && $model[1]->save()):
                $model[0]->save(false);
                $model[1]->save(false);
                CustomUrl::setCustomUrl(array('string' => $_POST['CustomUrl']['string'], 'type' => 'category', 'id' => $id, 'alt' => $_POST['CategoryDescription']['name']));
                Yii::app()->user->setFlash('success', Yii::t('common', 'message_modify_success'));
                /* echo '<pre>';
                  print_r($_POST);
                  exit; */
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
            endIf;
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function deleteAttachment($condition) {
        foreach (Category::model()->findAll($condition) as $category):
            unlink(Library::getCatalogUploadPath() . $category->image);
        endforeach;
    }

    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
            Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_category', $arrayRowId);
            CustomUrl::deleteCustomUrl(array('type' => 'category', 'id' => $arrayRowId));
            $this->deleteAttachment($criteria);
            if (CActiveRecord::model('Category')->deleteAll($criteria) && CActiveRecord::model('CategoryDescription')->deleteAll($criteria)) {
                CActiveRecord::model('CategoryFilter')->deleteAll($criteria);
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

    public function actionIndex() {
        //$this->getCustomUrl(array('type'=>'category','id'=>12));
        //CustomUrl::setCustomUrl(array('type'=>'category','id'=>1,'string'=>'rebook'));
        //exit;
        $model = new Category('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Category'])) {
            $model->attributes = $_GET['Category'];
        }
        $this->categoryNames = $model->getCategoryNames();
        $this->render('index', array('model' => $model, 'format' => $categoryName,));
    }

    protected function grid($data, $row, $dataColumn) {
        switch ($dataColumn->name) {
            case 'name':
                $return = $this->categoryNames[$data->id_category];
                break;
        }
        return $return;
    }

    /* public function getCategoryNames()
      {
      foreach(Category::getCategories() as $category):
      $general[$category->id_category]=$category->name;
      $parent[$category->id_category]=$category->id_parent;
      endforeach;

      foreach($general as $gKey=>$gValue)
      {
      $data[$gKey]=substr($this->formatCategory($gKey,$general,$parent),2);
      }

      return $data;
      }

      public function formatCategory($gk,$general,$parent)
      {
      if ($gk==0 )
      {
      return $general[$gk];
      }
      else
      {
      return ($this->formatCategory($parent[$gk],$general,$parent)."->".$general[$gk]);
      }
      } */

    public function loadModel($id) {
        $modelp = Category::model()->find('t.id_category=' . $id);
        $modelc = CategoryDescription::model()->find('t.id_category=' . $id);
        //$modelf = CategoryFilter::model()->findAll('t.id_category=' . $id);
        //$modelf = CategoryFilter::model()->findAll(array("select"=>"GROUP_CONCAT( DISTINCT id SEPARATOR  ',' ) AS id,GROUP_CONCAT( DISTINCT sort_order SEPARATOR  ',' ) AS sort_order","condition" => "id_category=" . $id,"group"=>"type"));

        $modelf = CategoryFilter::model()->findAll(array("condition" => "id_category=" . $id));
        $filterData = array();
        foreach ($modelf as $filter) {
            $filterData[$filter->type][$filter->id]['sort_order'] = $filter->sort_order;
        }
        /* echo '<pre>';
          print_r($filterData);
          exit; */

        //$modelcl=CustomUrl::model()->find('type="category" and  id="5"');
        $modelcl = CustomUrl::getCustomUrl(array('type' => 'category', 'id' => $id));
        if ($modelp === null || $modelc === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return array($modelp, $modelc, $modelcl, $filterData);
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
