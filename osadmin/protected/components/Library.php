<?php
class Library
{
   
    public function download($input)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($input['file']));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($input['path'].$input['file']));
        ob_clean();
        flush();
        readfile($input['path'].$input['file']);
        exit;
    }
    
    function fileUpload($data)
    {
        if (is_uploaded_file($data['tmp_name']))
        {
            $fileExt=substr(strrchr($data['name'], '.'), 1);//end(explode(".", $data['name']));
            //if(in_array($fileExt,explode(",",'png,jpg')))
			//if(1)
					
				//$types = Yii::app()->config->getData('CONFIG_WEBSITE_ALLOWED_FILE_TYPES');

				//exit($data['name']." ".substr(strrchr($data['name'], '.'), 1)." ".$fileExt);
				//echo '<pre>';
				//print_r(Yii::app()->config->getData('CONFIG_WEBSITE_ALLOWED_FILE_TYPES'));

				//exit($fileExt);
				if (in_array($fileExt, Yii::app()->config->getData('CONFIG_WEBSITE_ALLOWED_FILE_TYPES'))) {
				$file= $data['input']['prefix'].strtotime("now").'.'.$fileExt;
                copy($data['tmp_name'], $data['input']['path'].$file);
                if(isset($data['input']['prev_file']) && file_exists($data['input']['path'].$data['input']['prev_file']))
                {
                        @unlink($data['input']['path'].$data['input']['prev_file']);
                }
                return array('status'=>'1','file'=>$file,'msg'=>'upload successfull!!');
            }else
            {
				return  array('status'=>'0','file'=>$data['input']['prev_file'],'msg'=>'Invalid file extension');
            }
        }
        else
        {
            return array('status'=>'0','file'=>$data['input']['prev_file'],'msg'=>'No file to upload!!');
        }
    }
    
    public function getLayouts()
    {
        //return array("Home","ProductListing","ProductDetails","Account","Checkout","Information");
	return array("home"=>"Home","productlisting"=>"ProductListing","productdetails"=>"ProductDetails","account"=>"Account","checkout"=>"Checkout","inform   ation"=>"Information");
    }
    
    public function getBoxSizes()
    {
        
	return array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12');
    }
    
    public function getPositions()
    {
        //return array("Top","Left","Bottom","Right");
	return array("top-center"=>"Top Center","top"=>"Top","left"=>"Left","bottom-center"=>"Bottom Center","bottom"=>"Bottom","right"=>"Right");
    }
    
    public function getPaymentPath()
    {
        return Yii::getpathofalias('application.models.payment');
    }
    
    public function getThemePath()
    {
        return Yii::app()->params['config']['document_root'].'themes/';
        //return Yii::getpathofalias('webroot.themes')."/";
    }
    
    public function getThemeLink()
    {
        return Yii::app()->params['config']['site_url'].'themes/';
        //return "http://sun-network/osadmin/themes/";
    }
    
    public function getShippingPath()
    {
        return Yii::getpathofalias('application.models.shipping');
    }
    
    public function getModulesPath()
    {
        return Yii::getpathofalias('application.views.modules.installer');
    }
        
    public function getCartRulesPath()
    {
        return Yii::getpathofalias('application.models.cartrules');
    }
    
    public function getCatalogUploadPath()
    {
        return Yii::app()->params['config']['document_root'].Yii::app()->params['config']['upload_path'].'catalog/';
    }
    
    public function getCatalogUploadLink()
    {
        return Yii::app()->params['config']['site_url'].Yii::app()->params['config']['upload_path'].'catalog/';
    }
    
    public function getMiscUploadPath()
    {
        return Yii::app()->params['config']['document_root'].Yii::app()->params['config']['upload_path'].'misc/';
    }
    
    public function getMiscUploadLink()
    {
        return Yii::app()->params['config']['site_url'].Yii::app()->params['config']['upload_path'].'misc/';
    }
    
    /*public function getFilterType()
    {
        return array('general'=>"General","attribute"=>"Attribute","option"=>"Option");
    }*/
    
    public function getPageList($input)
    {
        //echo Yii::app()->getController()->getId()."<br/>"; //controller name
        //exit("inside");
        //echo "getparam ".Yii::app()->request->getParam('page')."<br/>";
        //echo "get".$_GET['page']."<br/>";
        $currentPage=Yii::app()->request->getParam('page',10);
        //exit;
        /*echo "page value  ".Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN');
        echo $currentPage;
        exit;*/
        $pageValues=array('5'=>'5','10'=>'10','30'=>'30','50'=>'50','100'=>'100','200'=>'200');
        if(min($pageValues)<$input['totalItemCount']):
            echo 'List '.CHtml::dropDownList('no-width','page',$pageValues,
            array('options' => array(Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN')=>array('selected'=>true)),'class'=>'no-bg-color',
        'onchange'=>"if(this.value!='')". " {". " href=window.location.href;    if(href.search('".Yii::app()->getController()->getId()."/index')=='-1')"
                . "{url=href.replace('/page/".$currentPage."','')+'/index/page/'+this.value;}else { url=href.replace('/page/".$currentPage."','')+'/page/'+this.value;} "
                . "window.location=url;}")
        );	 
        endif;
    }
    
    public function AddButton($input)
    {
		//exit("value of ".$input['url']);
        $this->widget(
                    'bootstrap.widgets.TbButton',
                    array(
                    'label' => $input['label'],
                    'visible' => $input['permission']==""?$this->addPerm:$input['permission'],//$this->addPerm,
                    'type' => 'info',
                    'icon' => 'icon-plus icon-white',
                    'url' =>$input['url']//('create')
                        )
                );
    }

    public function cancelButton($input)
    {
        $this->widget(
                    'bootstrap.widgets.TbButton',
                    array(
                'label' => $input['label'],
                'type' => 'danger',
                'url' => $input['url'])
            );
    }
    
    public function saveButton($input)
    {
            $this->widget(
                    'bootstrap.widgets.TbButton',
                    array(
                'label' => $input['label'],
                'buttonType' => 'submit',
                'visible' => $input['permission'],
                'type' => 'info',
                    )
            );
    }
    
    public function buttonBulk($input)
    {
        $this->widget(
                        'bootstrap.widgets.TbButton',
                        array(
                    'buttonType' => 'Submit',
                    'label' => $input['label'],
                    'visible' => $input['permission'],
                    'type' => $input['type']==''?'danger':$input['type'],//'danger',
                    'icon' => 'icon-remove icon-white',
                    'htmlOptions' => array('onclick' => 'var flag=validateGridCheckbox("id[]");
        if(flag)
        {
                document.getElementById("gridForm").method="post";
                document.getElementById("gridForm").action="' . $input['url'] . '";
                document.getElementById("gridForm").submit();
        }'),
                        )
                );    
    }
    
    public function flag()
    {
        $lang=Yii::app()->language;
        return '<img src="http://sun-network/osadmin/img/language/'.$lang.'.png"> ';
    }
    
    public function customName($name)
    {
        return preg_replace('/[^a-zA-Z0-9&-]/', '-', trim($name));
    }
    
    public function getGroupType()
    {
        return array("GROUP"=>"Group","SIMPROD"=>"Similar Products",""=>"",""=>"",""=>"",""=>"",);
    }
    
    public function shortString($data)
    {
        if(strlen($data['str'])>$data['len'])
        {
            $return=substr($data['str'],0,$data['len'])."..";
        }else
        {
            $return=$data['str'];
        }
        return $return;
    }
}