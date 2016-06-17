<?php

class ThemeController extends Controller
{
    public function updateStyle($input)
    {
        //start update style.css
        /*$pathToTempCss=Yii::getpathofalias('webroot.themes.'.$input['id'].'.css')."/template.css";
        $pathToStyleCss=Yii::getpathofalias('webroot.themes.'.$input['id'].'.css')."/style.css";*/
        
        $pathToTempCss=Library::getThemePath().$input['id'].'/css/template.css';
        $pathToStyleCss=Library::getThemePath().$input['id'].'/css/style.css'; 
        
        $readHandle = fopen($pathToTempCss, 'r');
        $data = fread($readHandle,filesize($pathToTempCss));

        foreach($input['params'] as $const=>$value)
        {
            $data=str_replace($const,$value,$data);
        }

        $writeHandle = fopen($pathToStyleCss, 'w') or die('Cannot open file:  '.$pathToStyleCss);
        fwrite($writeHandle, $data);
        //end update style.css
    }
    
    public function updateCustomFile($input)
    {
        //start update custom-template-params.txt
        $pathToTxt=Library::getThemePath().$input['id'].'/css/custom-template-params.txt';//Yii::getpathofalias('webroot.themes.'.$input['id'].'.css')."/custom-template-params.txt";
        $data="";
        foreach($input['params'] as $k=>$v)
        {
            $data.=trim($k)."==".trim($v)."\n";
        }
        $handle = fopen($pathToTxt, 'w') or die('Cannot open file:  '.$pathToTxt);
        fwrite($handle, $data);
        //end update custom-template-params.txt
    }
    
    public function doApplyTheme($input)
    {
        
        if($input['type']=='Apply' && isset($input['theme']))
        {
            Configuration::model()->updateAll(array('value'=>$input['theme']),"`key`='CONFIG_WEBSITE_TEMPLATE'");
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_modify_success'));
			ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='CONFIG' and `code`='CONFIG'");
            $this->redirect($this->createUrl('index'));
        }
    }
    
    public function actionUpdate()//($id)
    {
        $theme=base64_decode($_GET['str']);
        
        $this->doApplyTheme(array('type'=>$_GET['type'],'theme'=>$theme));
        
        if ($_SERVER['REQUEST_METHOD']=='POST')//(isset($_POST['params'])) 
        {
            if($_POST['theme'])
            {
               Configuration::model()->updateAll(array('value'=>$theme),"`key`='CONFIG_WEBSITE_TEMPLATE'");
			   ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='CONFIG' and `code`='CONFIG'");
               if($_POST['settings'])
               {
                    //$file='http://sun-network/osadmin/themes/'.$theme.'/css/default-template-params.txt';
                    //$template=file($file);
                    $params=array();    
                    //foreach($template as $string)
                    foreach($this->getFileParams(array('id'=>$theme,'file'=>'default-template-params.txt')) as $string)
                    {
                        $stringExp=explode("==",$string);
                        $params[$stringExp[0]]=$stringExp[1];
                    } 
               }else
               {
                   $params=$_POST['params']; 
               }
               
                $this->updateStyle(array('id'=>$theme,'params'=>$params));
                $this->updateCustomFile(array('id'=>$theme,'params'=>$params));
                Yii::app()->user->setFlash('success',Yii::t('common', 'message_modify_success'));
            }else
            {
                Yii::app()->user->setFlash('alert','Select the theme to apply modifications!!');//Yii::t('common', 'message_checkboxValidation_alert'));
                Yii::app()->user->setFlash('error',Yii::t('common', 'message_modify_fail'));
            }

            $this->redirect($this->createUrl('index'));    
        }
        //$file='http://sun-network/osadmin/themes/'.$theme.'/css/custom-template-params.txt';
        //$template=file($file);
        
        //foreach($template as $string)
        foreach($this->getFileParams(array('id'=>$theme,'file'=>'custom-template-params.txt')) as $string)
        {
            $stringExp=explode("==",$string);
            $params[]=array("label"=>ucwords(str_replace("_"," ",str_replace("%","",$stringExp[0]))),'name'=>$stringExp[0],"value"=>$stringExp[1]);
        }
        
        $default=$theme==Yii::app()->config->getData('CONFIG_WEBSITE_TEMPLATE')?true:false;
        $this->render('update',array('data'=>$params,'default'=>$default,'id'=>ucwords($theme)));
    }
    
    public function getFileParams($input)
    {
        //$file='http://sun-network/osadmin/themes/'.$input['id'].'/css/'.$input['file'];
        $file=Library::getThemeLink().$input['id'].'/css/'.$input['file'];
        return file($file);
    }

    public function actionIndex()
    {
        $scanThemeDir=scandir(Library::getThemePath());
        unset($scanThemeDir[0]);
        unset($scanThemeDir[1]);
        $model=array();
        
        foreach($scanThemeDir as $file)
        {
            $title=ucfirst(str_replace("_"," ",$file));
            $default=Yii::app()->config->getData('CONFIG_WEBSITE_TEMPLATE')==$file?true:false;
            $model[]=array('template'=>$file,'title'=>$title,'mockup'=>Library::getThemeLink().$file.'/mockup.png','default'=>$default);
        }
        $arrayDataProvider=new CArrayDataProvider($model, array(
		'pagination'=>array(
			'pageSize'=>10,
		),
	));

        $this->render('index', array('dataProvider'=>$arrayDataProvider));    
    }
 
    protected function grid($data, $row, $dataColumn) {
        switch ($dataColumn->name) {
            case 'mockup':
                $return = '<img src="'.$data['mockup'].'" width="100" height="100" />';
                break;
            case 'title':
                $buttonName=$data['template']==Yii::app()->config->getData('CONFIG_WEBSITE_TEMPLATE')?'Applied':'Apply';
                //$return = $data[title].' | <input type="radio" name="default" '.$checked.' value="'.$data['template'].'" /> | <a href="'.$this->createUrl('theme/update',array('str'=>base64_encode($data['template']))).'">Edit</a>';
                //$return = '<input type="radio" name="default" '.$checked.' value="'.$data['template'].'" />'. $data[title].'    <a href="'.$this->createUrl('theme/update',array('str'=>base64_encode($data['template']))).'" class="update" ><i class="icon-pencil"></i></a>';
                  $return = '<div class="theme-apply"><a href="'.$this->createUrl('theme/update',array('str'=>base64_encode($data[template]),'type'=>'Apply')).'" class="btn btn-info">'.$buttonName.'</a></div>'. $data[title].' <a href="'.$this->createUrl('theme/update',array('str'=>base64_encode($data['template']))).'" class="update" ><i class="icon-pencil"></i></a>';             
                break;
        }
        return $return;
    }
}
