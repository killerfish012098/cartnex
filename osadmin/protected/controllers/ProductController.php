<?php

class ProductController extends Controller {

    public function accessRules() {
        return $this->addActions(array('download','copyproduct'));
    }
    
    public function actioncopyproduct() {
        echo '<pre>';
        //print_r($_POST['id']);
        //print_r($_GET);
        if (Yii::app()->request->isPostRequest) 
        {
            foreach($_POST['id'] as $id)
            {
                $productRow=Product::model()->find('id_product='.$id);
                //print_r($productRow->getAttributes());
                $Product=new Product;
                $Product->attributes=$productRow->getAttributes();
                $Product->date_created="";
                $Product->date_modified="";
                $Product->save();
                $pid=$Product->id_product;
                if(isset($pid))
                {
                    //exit($pid);
                    //start product description
                    
                    $productDescRows=ProductDescription::model()->findAll('id_product='.$id);
                    foreach($productDescRows as $productDescRow)
                    {
                        $productDesc=new ProductDescription;
                        $productDesc->attributes=$productDescRow->getAttributes();
                        $productDesc->id_product=$pid;
                        $productDesc->save();
                    }
                    //end product description

                    //start product category
                    $productCatRows=ProductCategory::model()->findAll('id_product='.$id);
                    foreach($productCatRows as $productCatRow)
                    {
                        $productCat=new ProductCategory;
                        $productCat->attributes=$productCatRow->getAttributes();
                        $productCat->id_product=$pid;
                        $productCat->save();
                    }
                    //end product category
                    

                    //start product attribute
                    $productAttrRows=  ProductAttribute::model()->findAll('id_product='.$id);
                    foreach($productAttrRows as $productAttrRow)
                    {
                        //print_r($productAttrRow->getAttributes());
                        $productAttr=new ProductAttribute;
                        $productAttr->attributes=$productAttrRow->getAttributes();
                        $productAttr->id_product=$pid;
                        $productAttr->save(false);
                    }
                    
                    //exit;
                    //end product attribute

                    //start product image
                    $productImageRows=  ProductImage::model()->findAll('id_product='.$id);
                    foreach($productImageRows as $productImageRow)
                    {
                        $productImage=new ProductImage;
                        $productImage->attributes=$productImageRow->getAttributes();
                        $productImage->id_product=$pid;
                        $productImage->save();
                    }
                    //end product image

                    //start product special
                    $productSpecialRows= ProductSpecial::model()->findAll('id_product='.$id);
                    foreach($productSpecialRows as $productSpecialRow)
                    {
                        $productSpecial=new ProductSpecial;
                        $productSpecial->attributes=$productSpecialRow->getAttributes();
                        $productSpecial->id_product=$pid;
                        $productSpecial->save();
                    }
                    //end product special

                    //start product option
                    $productOptionRows= ProductOption::model()->findAll('id_product='.$id);
                    foreach($productOptionRows as $productOptionRow)
                    {
                        $productOption=new ProductOption;
                        $productOption->attributes=$productOptionRow->getAttributes();
                        print_r($productOptionRow->getAttributes());
                        unset($productOption->id_product_option);
                        $productOption->id_product=$pid;
                        $productOption->save();
                        $poid=$productOption->id_product_option;
                        //echo "valu eo f".$poid;        
                        foreach(ProductOptionValue::model()->findAll('id_product_option='.$productOptionRow->id_product_option) as $productOptionValueRow)
                        {
                            print_r($productOptionValueRow->getAttributes());
                            $productOptionValue=new ProductOptionValue;
                            $productOptionValue->attributes=$productOptionValueRow->getAttributes();
                            $productOptionValue->id_product=$pid;
                            $productOptionValue->id_product_option_value="";
                            $productOptionValue->id_product_option=$poid;
                            $productOptionValue->save();
                            //print_r($productOptionValue->getErrors());
                        }
                    }
                    //end product option
                    //exit;
                }

               // echo "value of id_product ".$Product->id_product;
            }
            Yii::app()->user->setFlash('success', "Selected products copied successfully!!");
        }else
        {
            Yii::app()->user->setFlash('failure', "Invalid submission!!");
        }
        $this->redirect('index');
        exit;
    }
    
    public function actiondownload() {
        Library::download(array('file' => base64_decode($_GET['file']), 'path' => Library::getCatalogUploadPath()));
    }

    public function actionCreate() {
        $model['p'] = new Product;
        $model['pd'] = new ProductDescription;
        $model['pc'] = new ProductCategory;


        if (Yii::app()->request->isPostRequest) {
            //echo '<pre>';
                $model['p']->attributes = $_POST['Product'];
            if ($model['p']->validate()) {
                
                $fUploadImage = $_FILES['image'];
                $fUploadImage['input']['prefix'] = 'product_' . Library::customName($_POST['ProductDescription']['name']) . '-' . $id . '_';
                $fUploadImage['input']['path'] = Library::getCatalogUploadPath();
                $fUploadImage['input']['prev_file'] = $_POST['prev_file'];
                $uploadImage = Library::fileUpload($fUploadImage);
                $model['p']->image = $uploadImage['file'];
                $model['p']->sku=$this->isSkuUnique(array('sku'=>$_POST['Product']['sku']));
                /*print_r($uploadImage['file']);
                print_r($_FILES);
                print_r($_POST);
                exit;*/
                //start download
                $fUploadDFile = $_FILES['download_filename'];
                $fUploadDFile['input']['prefix'] = 'product_download_' . Library::customName($_POST['ProductDescription']['name']) . '-' . $id . '_';
                $fUploadDFile['input']['path'] = Library::getCatalogUploadPath();
                $fUploadDFile['input']['prev_file'] = $_POST['download_prev_file'];
                $uploadDFile = Library::fileUpload($fUploadDFile);
                $model['p']->download_filename = $uploadDFile['file'];
                //$model['p']->download_allowed_count=
                //end download
                $model['p']->save(false);
                $id = $model['p']->id_product;

                foreach (Language::getLanguages() as $language):
                    $model['pd'] = new ProductDescription();
                    $model['pd']->attributes = $_POST['ProductDescription'];
                    $model['pd']->id_product = $id;
                    $model['pd']->id_language = $language->id_language;
                    $model['pd']->save(false);
                endforeach;
                
                $this->setUploadMultipleImages(array('name' => $_POST['ProductDescription']['name'],
                    'id' => $id, 'multiImage' => $_FILES['ProductImage'],'imageData' => $_POST['ProductImage']['upload']));
                
                $this->setAttributes(array('id' => $id, 'attribute' => $_POST['attribute']));

                $this->setSpecial(array('id' => $id, 'special' => $_POST['special']));

                $this->setCategory(array('id' => $id, 'category' => $_POST['ProductCategory']['id_category']));

                $this->setProductOption(array('id' => $id, 'input' => $_POST['ProductOptionInput'],
                    'multiple' => $_POST['ProductOptionMultiple'],
                    'verify' => $_POST['ProductOptionMultipleVerify']));
                CustomUrl::setCustomUrl(array('string' => $_POST['CustomUrl']['string'],
                    'type' => 'product', 'id' => $id, 'alt' => $_POST['ProductDescription']['name']));
                Yii::app()->user->setFlash('success', Yii::t('common', 'message_create_success'));
                //exit;
                $this->redirect('index');
            }
        }


        $input = $this->getProductOptions(array('text', 'textarea', 'date', 'datetime',
            'time', 'file'));
        $multiple = $this->getProductOptions(array('select', 'image', 'radio', 'checkbox'));
        $model['cu'] = CustomUrl::getCustomUrl();
        $this->render('create',
                array(
            'model' => $model, 'pCategories' => array(), 'input' => array('optionValues' => $input,
                'options' => $input),
            'multiple' => array('optionValues' => $multiple, 'options' => $multiple),
        ));
    }

    public function setProductOption($data) {

        ProductOption::model()->deleteAll('id_product=' . $data['id']);
        ProductOptionValue::model()->deleteAll('id_product=' . $data['id']);

        //single
        foreach ($data['input'] as $input):
            if ($input['activate'] != '1') {
                continue;
            }
            $ProductOptionModel = new ProductOption;
            $ProductOptionModel->id_option = $input['id_option'];
            $ProductOptionModel->id_product = $data['id'];
            $ProductOptionModel->id_product_option = $input['id_product_option'];
            $ProductOptionModel->required = $input['required'];
            $ProductOptionModel->option_value = $input['option_value'];
            $ProductOptionModel->save(false);
        endforeach;
        /* echo '<pre>';
          //print_r($_POST);
          print_r($data);
          exit; */
        //multiple
        foreach ($data['verify'] as $POKey => $POValue) {

            if ($POValue['active'] != 1) {
                continue;
            }

            $productOptionModelM = new ProductOption;

            $productOptionModelM->id_product = $data['id'];
            $productOptionModelM->id_option = $POKey;
            $productOptionModelM->option_value = '';
            $productOptionModelM->required = $POValue['required'];
            $productOptionModelM->save(false);
            // echo "<br/>value of id_product option ".$productOptionModelM->id_product_option;

            /* echo 'here<pre>';
              print_r($data['multiple'][$POKey]);
              exit; */
            foreach ($data['multiple'][$POKey] as $POMValue) {
                $productOptionValueModel = new ProductOptionValue;
                $productOptionValueModel->id_product_option_value = $POMValue[id_product_option_value];
                $productOptionValueModel->id_product_option = $productOptionModelM->id_product_option;
                $productOptionValueModel->id_product = $data['id'];
                $productOptionValueModel->id_option = $POKey;
                $productOptionValueModel->id_option_value = $POMValue[id_option_value];
                $productOptionValueModel->quantity = $POMValue[quantity];
                $productOptionValueModel->subtract = $POMValue[subtract];
                $productOptionValueModel->price = substr($POMValue[price], 1);
                $productOptionValueModel->price_prefix = substr($POMValue[price],
                        0, 1);
                $productOptionValueModel->weight = substr($POMValue[weight], 1);
                $productOptionValueModel->weight_prefix = substr($POMValue[weight],
                        0, 1);
                $productOptionValueModel->save(false);
            }
        }
        /* echo '<pre>';
          print_r($data);
          exit; */
    }

    public function setCategory($data) {
        ProductCategory::model()->deleteAll('id_product=' . $data['id']);
        foreach ($data['category'] as $category) {
            $model = new ProductCategory;
            $model->id_product = $data['id'];
            $model->id_category = $category;
            $model->save(false);
        }
    }

    public function setSpecial($data) {
        ProductSpecial::model()->deleteAll('id_product=' . $data['id']);
        foreach ($data['special'] as $special) {
            $model = new ProductSpecial;
            $model->attributes = $special;
            $model->id_product = $data['id'];
            $model->save(false);
        }
    }

    public function setAttributes($data) {
 
        //$data=array('id'=>'id_product','attribute'=>'attributedetailsarray');
        if(!sizeof($data['attribute']))
        {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_product = "' . $data['id'] . '"';
            ProductAttribute::model()->deleteAll($criteria);
        }
        
        $del = array();
        foreach ($data['attribute'] as $attr) {
            if ($attr['id_attribute'] != "") $del[] = $attr['id_attribute'];
        }

        if (sizeof($del) > 0) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_product = "' . $data['id'] . '" and id_attribute not in (' . @implode(",",
                            $del) . ')';
            ProductAttribute::model()->deleteAll($criteria);
        }


        $rows = array();
        foreach ($data['attribute'] as $option) {
            if ($option['id_attribute'] != "") $rows[] = $option['id_attribute'];
        }
        if (sizeof($rows) > 0) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_attribute_group = "' . $data['id'] . '" and id_attribute not in (' . @implode(",",
                            $rows) . ')';

            Attribute::model()->deleteAll($criteria);
            AttributeDescription::model()->deleteAll($criteria);
        }

        foreach ($data['attribute'] as $attribute) {
            if ($attribute['pk'] != '') {
                ProductAttribute::model()->updateByPk(array("id_attribute" => $attribute['id_attribute'],
                    "id_product" => $data['id'], "id_language" => Yii::app()->session['language']),
                        array("text" => $attribute['text']));
            } else {
                foreach (Language::getLanguages() as $language) {
                    $model = new ProductAttribute;
                    $model->id_attribute = $attribute['id_attribute'];
                    $model->id_language = $language->id_language;
                    $model->id_product = $data['id'];
                    $model->text = $attribute['text'];
                    $model->save(false);
                }
            }
        }
        //echo '<pre>';print_r($data);print_r($_POST['special']);exit;
        }
    
    public function isSkuUnique($input)
    {
        if($input['id']=="" && $input['sku']!="")
        {
            $count=Product::model()->count('sku = "'.$input['sku'].'"');
        }else if($input['sku']!="")
        {
            $count=Product::model()->count('id_product!="'.$input['id'].'" and  sku = "'.$input['sku'].'"');
        }
        
        if($count!=0 || $count!="")
        {
            Yii::app()->user->setFlash('alert','Sku already Exists.Please cross check once again!!');
            $return=""; 
        }else
        {
            $return=$input['sku']; 
        }
        
        return $return;
    }
    
    public function actionUpdate($id) {
        /* $group=AttributeGroupDescription::model()->lang()->findAll(array('select'=>'t.id_attribute_group,t.name,ag.filter','join'=>'inner join {{attribute_group}} ag on  ag.id_attribute_group=t.id_attribute_group'));
          echo '<pre>';
          print_r($group);
          exit; */
        $model = $this->loadModel($id);

        if (Yii::app()->request->isPostRequest) {
            
              /*echo "product id ".$_GET['id'];               
              echo '<pre>';
              print_r($_POST);
              exit;*/ 
            //$this->setProductDownload();
            $model['p']->attributes = $_POST['Product'];
            if ($model['p']->validate()) {
                $fUploadImage = $_FILES['image'];
                $fUploadImage['input']['prefix'] = 'product_' . Library::customName($_POST['ProductDescription']['name']) . '-' . $id . '_';
                $fUploadImage['input']['path'] = Library::getCatalogUploadPath();
                $fUploadImage['input']['prev_file'] = $_POST['prev_file'];
                $uploadImage = Library::fileUpload($fUploadImage);
                $model['p']->image = $uploadImage['file'];
                /* echo '<pre>';
                  print_r($uploadImage);
                  exit; */

                //start download
                $fUploadDFile = $_FILES['download_filename'];
                $fUploadDFile['input']['prefix'] = 'product_download_' . Library::customName($_POST['ProductDescription']['name']) . '-' . $id . '_';
                $fUploadDFile['input']['path'] = Library::getCatalogUploadPath();
                $fUploadDFile['input']['prev_file'] = $_POST['download_prev_file'];
                $uploadDFile = Library::fileUpload($fUploadDFile);
                $model['p']->download_filename = $uploadDFile['file'];
                //$model['p']->download_allowed_count=
                //end download
                $model['p']->sku=$this->isSkuUnique(array('id'=>$id,'sku'=>$_POST['Product']['sku']));

                $model['p']->save(false);
                /* echo '<pre>';
                  print_r($_POST);
                  exit; */
                $model['pd']->attributes = $_POST['ProductDescription'];
                $model['pd']->save(false);

                $this->setUploadMultipleImages(array('name' => $_POST['ProductDescription']['name'],
                    'id' => $_GET['id'], 'multiImage' => $_FILES['ProductImage'],
                    'imageData' => $_POST['ProductImage']['upload']));
                $this->setAttributes(array('id' => $id, 'attribute' => $_POST['attribute']));
                //exit;    
                $this->setSpecial(array('id' => $id, 'special' => $_POST['special']));

                $this->setCategory(array('id' => $id, 'category' => $_POST['ProductCategory']['id_category']));

                $this->setProductOption(array('id' => $id, 'input' => $_POST['ProductOptionInput'],
                    'multiple' => $_POST['ProductOptionMultiple'],
                    'verify' => $_POST['ProductOptionMultipleVerify']));
                CustomUrl::setCustomUrl(array('string' => $_POST['CustomUrl']['string'],
                    'type' => 'product', 'id' => $id, 'alt' => $_POST['ProductDescription']['name']));
                Yii::app()->user->setFlash('success',
                        Yii::t('common', 'message_modify_success'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
            }
        }

        $multiple = $this->getProductOptionDetails($id,
                array('select', 'image', 'radio', 'checkbox'));
        $input = $this->getProductOptionDetails($id,
                array('date', 'time', 'datetime', 'text', 'textarea', 'file'));

        $pCatagories = ProductCategory::getProductCategories($id);

        $this->render('update',
                array('model' => $model, 'id' => $id, 'input' => $input, 'multiple' => $multiple,
            'pCategories' => $pCatagories));
    }

    public function setUploadMultipleImages($data) {
        //echo '<pre>';
        //print_r($_FILES);
        //print_r($_POST);
        //print_r($data);
        //exit;
        $fUploadImage = "";
        ProductImage::model()->deleteAll('id_product=' . $data['id']);
        foreach ($data['multiImage']['name']['upload'] as $k => $v) {
            //foreach($data['imageData'] as $k=>$v)
            if ($data['multiImage']['name']['upload'][$k]['image'] == "" && $data['imageData'][$k]['prev_image'] == "") {
                continue;
            }

            $fUploadImage = array("name" => $data['multiImage']['name']['upload'][$k]['image'],
                "type" => $data['multiImage']['type']['upload'][$k]['image'],
                "tmp_name" => $data['multiImage']['tmp_name']['upload'][$k]['image'],
                "error" => $data['multiImage']['error']['upload'][$k]['image'],
                "size" => $data['multiImage']['size']['upload'][$k]['image'],);

            $fUploadImage['input']['prefix'] = 'product_multi_' . Library::customName($data['name']) . '-' . $data['id'] . '_' . $k . '_';
            $fUploadImage['input']['path'] = Library::getCatalogUploadPath();
            $fUploadImage['input']['prev_file'] = $data['imageData'][$k]['prev_image'];

            $uploadImage = Library::fileUpload($fUploadImage);
            //echo "file ".$uploadImage['file']."<br/>";
            $model = new ProductImage;
            $model->sort_order = $data['imageData'][$k]['sort_order'];
            $model->id_product = $data['id'];
            $model->image = $uploadImage['file'];
            $model->save(false);
        }
        // exit;
        //exit;
        /* foreach($_FILES['ProductImage']['name']['upload'] as $k=>$v)
          {
          $images[]=array("name"=>$_FILES['ProductImage']['name']['upload'][$k]['image'],"type"=>$_FILES['ProductImage']['type']['upload'][$k]['image'],
          "tmp_name"=>$_FILES['ProductImage']['tmp_name']['upload'][$k]['image'],"error"=>$_FILES['ProductImage']['error']['upload'][$k]['image'],
          "size"=>$_FILES['ProductImage']['size']['upload'][$k]['image'],);
          } */
        print_r($images);
        /* $fUploadImage=$_FILES['image'];
          $fUploadImage['input']['prefix'] = 'product_' .Library::customName($_POST['ProductDescription']['name']).'-'. $id . '_';
          $fUploadImage['input']['path'] = Library::getCatalogUploadPath();
          $fUploadImage['input']['prev_file'] = $_POST['prev_file'];
          $uploadImage = Library::fileUpload($fUploadImage);
          $model['p']->image = $uploadImage['file'];
          echo '<pre>';
          print_r($uploadImage);
          exit;
          $model['p']->save(false); */

        // EXIT;
    }

    public function deleteAttachments($rows)
    {
        foreach($rows as $id)
        {
            $product=Product::model()->find('id_product='.$id);
            unlink(Library::getCatalogUploadPath().$product->image);
            unlink(Library::getCatalogUploadPath().$product->download_filename);
            foreach(ProductImage::model()->findAll('id_product='.$id) as $pImage):
               unlink(Library::getCatalogUploadPath().$pImage->image); 
            endforeach;
        }
    }
    
    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
            Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_product', $arrayRowId);
            CustomUrl::deleteCustomUrl(array('type' => 'product', 'id' => $arrayRowId));
            $this->deleteAttachments($arrayRowId);
            //exit;
            CActiveRecord::model('Product')->deleteAll($criteria);
            CActiveRecord::model('ProductDescription')->deleteAll($criteria);
            CActiveRecord::model('ProductImage')->deleteAll($criteria);
            CActiveRecord::model('ProductCategory')->deleteAll($criteria);
            CActiveRecord::model('ProductAttribute')->deleteAll($criteria);
            CActiveRecord::model('ProductOption')->deleteAll($criteria);
            CActiveRecord::model('ProductOptionValue')->deleteAll($criteria);
            CActiveRecord::model('ProductGroupList')->deleteAll($criteria);
            CActiveRecord::model('ProductSpecial')->deleteAll($criteria);
            //exit;
            Yii::app()->user->setFlash('success',
                    Yii::t('common', 'message_delete_success'));
        } else {
            Yii::app()->user->setFlash('alert',
                    Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',
                    Yii::t('common', 'message_delete_fail'));
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
    }

    public function actionIndex() {
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) $model->attributes = $_GET['Product'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model['p'] = Product::model()->find('id_product=' . $id);

        $model['pd'] = ProductDescription::model()->find('id_product=' . $id);

        $model['pc'] = new ProductCategory;
        //$model['pc']=ProductCategory::model()->findAll('id_product='.$id);
        $model['pa'] = ProductAttribute::model()->lang()->findAll('id_product=' . $id);
        $model['ps'] = ProductSpecial::model()->findAll('id_product=' . $id);
        $model['pi'] = ProductImage::model()->findAll('id_product=' . $id);
        $model['cu'] = CustomUrl::getCustomUrl(array('type' => 'product', 'id' => $id));
        //$model['po']=ProductOption::model()->findAll('id_product='.$id);
        //$model['pov']=ProductOptionValue::model()->findAll('t.id_product='.$id);

        /* if($modelp===null || $modelpd===null)
          throw new CHttpException(';)','No Record Found!!'); */
        //return array($modelp,$modelpd,$modelpc);

        /* echo "<pre>";
          print_r($model['pc']);
          exit; */
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function getProductOptionDetails($id, $typeArray) {
        $options = $this->getProductOptions($typeArray);
        $optionValues = ProductOption::getProductOptionMultipleData($id);

        $optionIds = array_keys($options);
        foreach ($optionValues as $key => $val) {
            if (!in_array($key, $optionIds)) {
                unset($optionValues[$key]);
            }
        }

        $diff = array_diff(array_keys($options), array_keys($optionValues));
        foreach ($diff as $k => $v) {
            $optionValues[$v] = array();
        }

        return array("optionValues" => $optionValues, "options" => $options);
    }

    /* public function getProductOptionDetails($id,$typeArray)
      {
      $options=OptionDescription::getOptions();
      foreach($options as $key=>$option):
      if(!in_array($option[type],$typeArray))
      {
      unset($options[$key]);
      }
      endforeach;

      $optionValues=ProductOption::getProductOptionMultipleData($id);

      $optionIds=array_keys($options);
      foreach($optionValues as $key=>$val)
      {
      if(!in_array($key,$optionIds))
      {
      unset($optionValues[$key]);
      }
      }

      $diff=array_diff(array_keys($options),array_keys($optionValues));
      foreach($diff as $k=>$v)
      {
      $optionValues[$v]=array();
      }

      return array("optionValues"=>$optionValues,"options"=>$options);
      } */

    public function getProductOptions($typeArray) {
        $options = array();
        $options = OptionDescription::getOptions();
        foreach ($options as $key => $option):
            if (!in_array($option[type], $typeArray)) {
                unset($options[$key]);
            }
        endforeach;
        return $options;
    }

}
