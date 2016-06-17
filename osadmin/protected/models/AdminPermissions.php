<?php

class AdminPermissions  extends CActiveRecord
{
	public function tableName()
	{
		return '{{admin_permissions}}';
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

		public function rules() {
		return array(
			array('admin_roles_id, module_name, file_name, all, view, add, edit, trash, sortorder', 'required'),
			array('admin_roles_id, sortorder', 'numerical', 'integerOnly'=>true),
			array('module_name, file_name', 'length', 'max'=>100),
			array('all, view, add, edit, trash', 'length', 'max'=>1),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false),
			array('admin_roles_id, module_name, file_name, all, view, add, edit, trash, sortorder', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels() {
		return array(
			'admin_roles_id' => Yii::t('app', 'Admin Roles'),
			'module_name' => Yii::t('app', 'Module Name'),
			'file_name' => Yii::t('app', 'File Name'),
			'all' => Yii::t('app', 'All'),
			'view' => Yii::t('app', 'View'),
			'add' => Yii::t('app', 'Add'),
			'edit' => Yii::t('app', 'Edit'),
			'trash' => Yii::t('app', 'Trash'),
			'sortorder' => Yii::t('app', 'Sortorder'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('admin_roles_id', $this->admin_roles_id);
		$criteria->compare('module_name', $this->module_name, true);
		$criteria->compare('file_name', $this->file_name, true);
		$criteria->compare('all', $this->all, true);
		$criteria->compare('view', $this->view, true);
		$criteria->compare('add', $this->add, true);
		$criteria->compare('edit', $this->edit, true);
		$criteria->compare('trash', $this->trash, true);
		$criteria->compare('sortorder', $this->sortorder);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	public static function getAdminPermissions($criteria){
		$cache=Yii::app()->cache;
        $adminpermissions=$cache->get('a_adminpermissions');
        if($adminpermissions===false)
        {
			if(Yii::app()->session['id_admin_role'])
			{
			
				$adminpermissions=AdminPermissions::model()->findAll($criteria);
				$cache->set('a_adminpermissions',$adminpermissions ,Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_admin_permission)) as date_modified FROM {{admin_permissions}}'));
			}
        }
        return $adminpermissions;
	}
	
}