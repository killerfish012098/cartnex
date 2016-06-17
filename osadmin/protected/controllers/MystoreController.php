<?php
class MystoreController extends Controller {

        public function actionIndex()
	{
		$model = new MystoreForm();
                if (Yii::app()->request->isPostRequest)
                {
                    $model->unSetAttributes();
                    foreach($_POST['MystoreForm'] as $key=>$config):
                    $model->$key=$config;
                    endforeach;
                    
                    $update=$_POST['MystoreForm'];
                    foreach($_FILES as $k=>$v)
                    {
                        $data = $v;
                        $data['input']['prefix'] = 'store_';
                        $data['input']['path'] = Library::getMiscUploadPath();
                        $data['input']['prev_file'] = $_POST[$k];
                        $upload="";
                        //print_r($data);
                        $upload = Library::fileUpload($data);
                       //print_r($upload);
                        $model->$k=$upload['file'];
                        $update[$k]=$upload['file'];
                    }
                     
                    
                    /*print_r($update);
                    exit;*/
                    
                    if($model->validate())
                    {
                        //foreach($_POST['MystoreForm'] as $key=>$config):
                        foreach($update as $key=>$config):
                        Configuration::model()->updateAll(array('value'=>$config),"`key`='".$key."'");
                        endforeach;

						ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='CONFIG' and `code`='CONFIG'");
                        Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                        $this->redirect($this->createUrl('mystore/index'));
                    }
                }
				
					//,array('prompt' => Yii::t('common','text_none')))
				$data['pages']=CHtml::listData(Page::getPages(),'id_page', 'title');
				$data['pages'][0]=Yii::t('common','text_none');
				$data['states']=State::getStates('id_country="'.$model->CONFIG_STORE_COUNTRY.'"');
				//echo '<pre>';print_r($data);exit;
                $this->render('index', array('model'=>$model,'data'=>$data));
	}
        
        public function actionIndextemp()
	{
		$model = new MystoreForm();
                if(isset($_POST[MystoreForm]))
                {
                    $model->attributes=$_POST['MystoreForm'];
                   //$model->_dynamicFields=$_POST['MystoreForm'];
                    /*echo '<pre>';
                    print_r($_POST);
                    echo '</pre>';
                    exit;*/
                    if($model->validate())
                    {
                        foreach($_POST['MystoreForm'] as $config):
                        Configuration::model()->updateAll($config,"`key`='".$config['key']."'");
                        endforeach;
                        Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                        $this->redirect('index');
                    }

                    echo '<pre>';
                    print_r($model->getErrors());
                    print_r($_POST);
                    echo '</pre>';
                    exit;
                    
                    
                }
		//$form = new CForm('application.views.mystore._Form', $model);
		/*if($form->submitted('MystoreForm') && $form->validate())
		{
			echo '<pre>';
			print_r($_REQUEST);
			exit;
			$this->redirect(array('site/index'));
		}*/

		//$this->render('index', array('form'=>$form,'model'=>$model));
                $this->render('index', array('model'=>$model));
	}
}