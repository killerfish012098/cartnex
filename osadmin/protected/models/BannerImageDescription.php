<?php


class BannerImageDescription extends CActiveRecord
{

	public function tableName()
	{
		return '{{banner_image_description}}';
	}

	public function rules()
	{
		return array(
			array('id_banner_image, id_language, id_banner, title', 'required'),
			array('id_banner_image, id_language, id_banner', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>64),
			array('id_banner_image, id_language, id_banner, title', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
            'bannerimage'=>array(self::BELONGS_TO,'BannerImage','id_banner_image'),
        );
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes(){
        return array(
            'lang'=>array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']),
        );
    }
}
