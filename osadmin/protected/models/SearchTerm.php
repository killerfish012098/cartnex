<?php
class SearchTerm extends CActiveRecord
{
    public $percent;
	public function tableName()
	{
		return '{{search_keyword}}';
	}

	public function rules()
	{
		return array(
			array('hits', 'numerical', 'integerOnly'=>true),
			array('keyword', 'length', 'max'=>255),
			array('percent,id_search_keyword, keyword, hits', 'safe', 'on'=>'search'),
		);
	}

	public function report()
	{
        $count = Yii::app()->db->createCommand('SELECT sum( hits )AS sum FROM {{search_keyword}}')->queryScalar();
        $total_sum = $count==""?0:$count;        
		$criteria=new CDbCriteria;
		$criteria->compare('hits',$this->hits);
		$criteria->compare('floor(round((t.hits/'.$total_sum.')*100,2))',$this->percent);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->select='keyword,hits,round((t.hits/'.$total_sum.')*100,2) as percent';
        //$criteria->order='hits desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'hits DESC',
			),
			
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
