<?php

class Controller extends CController {

    public $defaultAction = 'index';
    public $layout = '//layouts/column1';
    public $addPerm = false;
    public $editPerm = false;
    public $deletePerm = false;
    public $menuItemsList = array();
    public $menuTopItemsList = array();
    public $accessPermissions = array();
    public $gridPerm = array();
    public $menu = array();
    public $breadcrumbs = array();

    public function init() {
        //echo "value of ".Yii::app()->session['language'];
		//exit;
		//$this->setLanguage();
        //if(isset(Yii::app()->user->id)){
		
			$this->getPermissions();
		//}else{}
		 /*echo "value of ".Yii::app()->user->id;exit;
		
		echo '<pre>';print_r($_SESSION);echo '</pre>';*/
		
    }

    public function setLanguage() {
        if (isset($_GET['lang'])) {
            if (sizeof(Yii::app()->config->getData('languages')) > 0) {
                Yii::app()->session['language'] = Yii::app()->config->getData('languages')[$_GET['lang']]['id_language'];
                Yii::app()->session['languagecode'] = Yii::app()->config->getData('languages')[$_GET['lang']]['code'];
                Yii::app()->language = Yii::app()->config->getData('languages')[$_GET['lang']]['code'];
            }
        } else {
            if (Yii::app()->session['language'] == '' || Yii::app()->session['languagecode'] == '') {
                Yii::app()->session['language'] = Yii::app()->config->getData('languages')[Yii::app()->config->getData('CONFIG_STORE_DEFAULT_LANGUAGE')]['id_language'];
                Yii::app()->language = Yii::app()->config->getData('CONFIG_STORE_DEFAULT_LANGUAGE');
                Yii::app()->session['languagecode'] = Yii::app()->config->getData('CONFIG_STORE_DEFAULT_LANGUAGE');
            } else {
                Yii::app()->session['language'] = Yii::app()->session['language'];
                Yii::app()->language = Yii::app()->session['languagecode'];
            }
        }
    }

    public function getPermissions() {
		//exit($this->uniqueid);
		//echo ."<br/>";exit;
		//exit(trim(Yii::t('common','menu_item_stockstatus')));
        //exit(Yii::app()->user->id);
		 //echo CController::getAction()->id."<br/>";
           // echo Yii::app()->getController()->getId()."<br/>"; //controller name
           /*echo Yii::app()->getRequest()->getUrl()."<br/>";
            
            //echo Yii::app()->controller->id ."and". Yii::app()->controller->action->id."<br/>";
            //echo $this->uniqueid." ".$this->action->id."<br/>";
		exit($this->uniqueid." ".$this->action->id);*/
		
        $rows = AdminPermissions::getAdminPermissions(array('order' => 'module_sort_order asc,file_sort_order asc', 'condition' => 'id_admin_role=:id_admin_role', 'params' => array(':id_admin_role' => (int) Yii::app()->session['id_admin_role'])));
        
		//$rows = AdminPermissions::model()->findAll(array('order' => 'module_sort_order asc,file_sort_order asc', 'condition' => 'id_admin_role=:id_admin_role', 'params' => array(':id_admin_role' => (int) Yii::app()->session['id_admin_role'])));

        $menu = array();
        $file_permissions = array();

        foreach ($rows as $row) {
            $file_permissions[$row->file_name] = array("view" => $row->view, "add" => $row->add, "edit" => $row->edit, "trash" => $row->trash);
            $menu[$row->menu_type][$row->module_name][] = $row->file_name;
            if ($row->file_name == $this->uniqueid):
                $this->breadcrumbs = array(Yii::t('common', 'menu_section_' . $row->module_name), Yii::t('common', 'menu_item_' . $row->file_name)); //ucfirst($row->file_name));
            endif;
        }
        //start menu
        $widjetMenuArray = array();
        foreach ($menu['0'] as $sectionName => $itemArray):
            //echo $sectionName."<br/>";
            unset($widjetMenuArrayItem);
            $widjetMenuArrayItem['label'] = '<i class="icon-' . $sectionName . '"></i>' . Yii::t('common', 'menu_section_' . $sectionName) . '<span class="caret"></span>';
            $widjetMenuArrayItem['url'] = '#';

            $widjetMenuArrayItem['linkOptions'] = array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown');
            if (sizeof($itemArray) > 0):
                foreach ($itemArray as $key => $item):
                    $widjetMenuArrayItem['items'][] = array('label' => '<i class="icon-chevron-right"></i>' . Yii::t('common', 'menu_item_' . $item), 'url' => $this->createUrl($item . '/'), 'active' => $item == $this->uniqueid ? 1 : 0);
                endforeach;
            endif;
            $widjetMenuArrayItem['itemOptions'] = array('class' => in_array($this->uniqueid, $itemArray) ? 'dropdown item-test open' : 'dropdown', 'tabindex' => '-1', 'onclick' => 'waitForCheckScroll(this)');
            $widjetMenuArray[] = $widjetMenuArrayItem;
            //($active=='1')?'dropdown item-test open':'dropdown'
        endforeach;
        //end menu

        $this->menuItemsList = $widjetMenuArray;

        //start top menu array
        $widjetTopMenuArray = array();
        foreach ($menu['1'] as $sectionName => $itemArray):
            //echo $sectionName."<br>";
            unset($widjetMenuArrayItem);
            $widjetMenuArrayItem['label'] = '<i class="icon-' . $sectionName . '"></i>' . Yii::t('common', 'menu_section_' . $sectionName) . '<span class="caret"></span>';
            $widjetMenuArrayItem['url'] = '#';
            $widjetMenuArrayItem['itemOptions'] = array('class' => in_array($this->uniqueid, $itemArray) ? 'dropdown item-test active-top' : 'dropdown', 'tabindex' => '-1');
            $widjetMenuArrayItem['linkOptions'] = array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown');
            if (sizeof($itemArray) > 0):
                foreach ($itemArray as $key => $item):
                    $widjetMenuArrayItem['items'][] = array('label' => Yii::t('common', 'menu_item_' . $item), 'url' => $this->createUrl($item . '/'), 'itemOptions' => $this->uniqueid == $item ? array('class' => 'active-top') : ''); //'index.php?r='.$item);
                endforeach;
            endif;
            $widjetTopMenuArray[] = $widjetMenuArrayItem;
        endforeach;
        // exit;
        $language = array();
        //echo '<pre>';
        foreach (Yii::app()->config->getData('languages') as $lang) {
            //print_r($lang);
            if ($lang['id_language'] == Yii::app()->session['language']) {
                $language['label'] = ' ' . $lang['code'] . ' <span class="caret"></span>';
                $language['url'] = '';
                $language['itemOptions'] = array('class' => 'dropdown', 'tabindex' => "-1");
                $language['linkOptions'] = array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown");
            } else {

                $language['items'][] = array('label' => $lang['code'], 'url' => $this->createUrl('index', array('lang' => $lang['code'])));
            }
        }


        $widjetTopMenuArray[] = array('label' => '<i class="icon-help"></i>  Help', 'url' => array('/site/help', 'view' => 'forms'));
        $widjetTopMenuArray[] = $language;
        $widjetTopMenuArray[] = array('label' => '<a href="'.Yii::app()->params['config']['site_url'].'" target="_blank"><button class="btn btn-xs">Visit Site</button></a>');
        /* echo "<pre>";
          print_r($widjetTopMenuArray);
          echo '</pre>'; */
        $this->menuTopItemsList = $widjetTopMenuArray;
        //end top menu array



        /* $array=array(

          array('allow', // allow authenticated user to perform 'create' and 'update' actions
          'actions'=>array('create','update'),
          'users'=>array('@'),
          ),
          array('allow', // allow admin user to perform 'admin' and 'delete' actions
          'actions'=>array('admin','delete'),
          'users'=>array('admin'),
          ),
          array('deny',  // deny all users
          'users'=>array('*'),
          ),
          ); */

        $permissions = array();
        $actions[] = $file_permissions[$this->uniqueid]['view'] == "Y" ? "index" : "";
        $actions[] = $file_permissions[$this->uniqueid]['add'] == "Y" ? "create" : "";
        $actions[] = $file_permissions[$this->uniqueid]['edit'] == "Y" ? "update" : "";
        $actions[] = $file_permissions[$this->uniqueid]['trash'] == "Y" ? "delete" : "";

        $this->addPerm = $file_permissions[$this->uniqueid]['add'] == "Y" ? true : false;
        $this->editPerm = $file_permissions[$this->uniqueid]['edit'] == "Y" ? true : false;
        $this->deletePerm = $file_permissions[$this->uniqueid]['trash'] == "Y" ? true : false;

        //start grid permissions
        $templateString = "";
        $buttonsArray = array();
        if ($this->editPerm == true || $file_permissions[$this->uniqueid]['view'] == 'Y') {
            $templateString.="{update} ";
        }

        $templateString.=$this->deletePerm == true ? '{delete}' : '';

        if ($this->editPerm == false && $file_permissions[$this->uniqueid]['view'] == 'Y') {
            $buttonsArray = array('update' => array('label' => 'view'));
        }
        $buttonsArray['delete'][url] = "";
        //$buttonsArray=array("update"=>array("label"=>"view"));
        $gridPerm = array();
        $gridPerm['template'] = $templateString;
        $gridPerm['buttons'] = $buttonsArray;
        $this->gridPerm = $gridPerm;
        //end grid permissions


        $permissions[] = array('allow', // allow authenticated user to perform 'create' and 'update' actions
            'actions' => array_filter($actions),
            'users' => array('@'),
        );
        $permissions[] = array('deny', // deny all users
            'users' => array('*'),
            'message' => "Sorry! You Dont Have Access Permissions.",
        );
        $this->accessPermissions = $permissions;
    }

    public function accessRules() {
        return $this->accessPermissions;
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    protected function afterAction($action) {
		
		
		//exit('after action');
        $request = Yii::app()->getRequest();
        if (!$request->getIsAjaxRequest())
            Yii::app()->user->setReturnUrl($request->getUrl());
        return parent::afterAction($action);
    }

    protected function beforeAction($action) {
		//start log
		//exit(Yii::t('common','menu_item_stockstatus'));
		if('adminloghistory'!=$this->uniqueid){
		if('menu_item_'!=Yii::t('common','menu_item_'.$this->uniqueid))
		{
			$page_accessed=Yii::t('common','menu_item_'.$this->uniqueid);
		}else
		{
			$page_accessed=Yii::t('common','menu_section_'.$this->uniqueid);
		}
		
		//exit($page_accessed." ".$_SERVER['REQUEST_METHOD'].$action->id." ".Yii::t('common','menu_item_'.$this->uniqueid));
		if($action->id=='index')
		{
			$actionName="View";
		}else if($action->id=='create')
		{
			$actionName=$_SERVER['REQUEST_METHOD']!='GET'?'Create':'';
		}else if($action->id=='update')
		{
			$actionName=$_SERVER['REQUEST_METHOD']!='GET'?'Update':'';
		}
		else if($action->id=='delete')
		{
			$actionName="Delete";
		}
			if($actionName!="")
			{
				$adminLogHistory=new AdminLogHistory;		
				$adminLogHistory->id_admin=Yii::app()->user->id;
				$adminLogHistory->page_accessed=$page_accessed;
				$adminLogHistory->page_url=$this->createUrl();//Yii::app()->getRequest()->getUrl();
				$adminLogHistory->action=$actionName;
				$adminLogHistory->ip_address=$_SERVER['REMOTE_ADDR'];
				$adminLogHistory->save();
			}
		}
		//end log

		//exit("in before action");
        return parent::beforeAction($action);
    }

    public function addActions($actions) {
        if (is_array($actions)) {
            foreach ($actions as $action) {
                $return = array_push($this->accessPermissions[0][actions], $action);
            }
        }
        return $this->accessPermissions;
    }

}
