<?php

class TaxClassController extends Controller {

    public function actionCreate() 
    {
        $model['tc'] = new TaxClass;
        $model['tcrd'] = new TaxClassRuleDescription;
        
        if (Yii::app()->request->isPostRequest)
        {
            $model['tc']->attributes=$_POST['TaxClass'];
            if($model['tc']->validate())
            {
                $model['tc']->save(false);
                foreach($_POST['tax_class_rule'] as $rule)
                {
                    $this->addTaxClassRule(array('id'=>$model['tc']->id_tax_class,'tax_class_rule'=>$rule));
                }
                Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
                $this->redirect('index');
            }
        }
        $this->render('update', array('model' => $model,));
    }
	
	public function filterData($data)
    {
		//echo '<pre>';print_r($_POST);print_r($data);echo '</pre>';
        $rows=array();
        foreach($data['tax_class_rule'] as $taxclassrule)
        {
            if($taxclassrule['id_tax_class_rule']!="")
            $rows[]=$taxclassrule['id_tax_class_rule'];
        }
		
        if(sizeof($rows)>0)
        {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id_tax_class = "'.$data['id'].'" and id_tax_class_rule not in ('.@implode(",",$rows).')';

            TaxClassRule::model()->deleteAll($criteria);
            TaxClassRuleDescription::model()->deleteAll($criteria);
        }else
		{
			$criteria = new CDbCriteria;
            $criteria->condition = 'id_tax_class = "'.$data['id'].'"';

            TaxClassRule::model()->deleteAll($criteria);
            TaxClassRuleDescription::model()->deleteAll($criteria);
		}
    }


    public function actionUpdate($id) 
    {
      
            $model = $this->loadModel($id);
            
            if (Yii::app()->request->isPostRequest)
            {
                $model['tc']->attributes=$_POST['TaxClass'];
                if($model['tc']->validate())
                {
                    $model['tc']->save(false);
					$this->filterData(array("tax_class_rule"=>$_POST['tax_class_rule'],"id"=>$id));      
                    foreach($_POST['tax_class_rule'] as $rule)
                    {
                        if($rule['id_tax_class_rule']!='')
                        {
                            TaxClassRuleDescription::model()->updateAll(array('name'=>$rule['name']),'id_language="'.Yii::app()->session['language'].'" and id_tax_class_rule='.$rule['id_tax_class_rule']);
                            unset($rule['name']);
                            TaxClassRule::model()->updateAll($rule,'id_tax_class_rule='.$rule['id_tax_class_rule']);
                        }else
                        {
                           $this->addTaxClassRule(array('id'=>$id,'tax_class_rule'=>$rule));
                        }
                    }
					//exit;
                    Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                    $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
                }
            }

            $this->render('update', array('model' => $model,));
    }
    
    
    
    public function addTaxClassRule($value)
    {
            $modelTaxClassRule = new TaxClassRule;
            $modelTaxClassRule->id_tax_class = $value['id'];//$id;
            $modelTaxClassRule->rate = $value['tax_class_rule']['rate'];
            $modelTaxClassRule->type = $value['tax_class_rule']['type'];
            $modelTaxClassRule->based_on = $value['tax_class_rule']['based_on'];
            $modelTaxClassRule->id_region = $value['tax_class_rule']['id_region'];
            $modelTaxClassRule->save(false);

            foreach (Language::getLanguages() as $language) 
            {
                    $modelTaxClassRuleDescription = new TaxClassRuleDescription;
                    $modelTaxClassRuleDescription->id_tax_class_rule = $modelTaxClassRule->id_tax_class_rule;
                    $modelTaxClassRuleDescription->name = $value['tax_class_rule']['name'];
                    $modelTaxClassRuleDescription->id_tax_class = $value['id'];
                    $modelTaxClassRuleDescription->id_language = $language->id_language;
                    $modelTaxClassRuleDescription->save(false);
            }
    }
    
    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_tax_class', $arrayRowId);
            CActiveRecord::model('TaxClass')->deleteAll($criteria);
            CActiveRecord::model('TaxClassRule')->deleteAll($criteria);
            CActiveRecord::model('TaxClassRuleDescription')->deleteAll($criteria);
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_delete_success'));
            
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
        $model = new TaxClass('search');
        if (isset($_GET['TaxClass'])) {
            $model->attributes=$_GET['TaxClass'];
        }
        $this->render('index', array('model' => $model,
        ));
    }

    public function loadModel($id)
	{
            $model['tc']=TaxClass::model()->find(array("condition"=>"id_tax_class=".$id));
            $model['tcrd'] = TaxClassRuleDescription::model()->with(array(
                                                                    'taxClassRule' => array(
                                                                        // 'select'=>'t.name',
                                                                        'joinType' => 'INNER JOIN',
                                                                        'condition' => 'taxClassRule.id_tax_class=' . $id,
                                                                                    ),
                                                                        )
                                                                )->lang()->findAll();
            /*echo '<pre>';
            print_r($model['ov']);
            exit;*/
            return $model;
	}
    
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tax_class-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
