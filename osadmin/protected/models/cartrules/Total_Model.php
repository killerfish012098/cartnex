<?php
class Total_Model extends CFormModel
{
	public $CARTRULE_TOTAL_TITLE;
    public $CARTRULE_TOTAL_STATUS;
	public $CARTRULE_TOTAL_SORT_ORDER;

	public function rules()
	{
		return array(
			array('CARTRULE_TOTAL_TITLE,CARTRULE_TOTAL_STATUS,CARTRULE_TOTAL_SORT_ORDER','required'),
			);
	}

	public function attributeLabels()
	{
		return array('CARTRULE_TOTAL_TITLE'=>Yii::t('cartrules','entry_title'),
			'CARTRULE_TOTAL_STATUS'=>Yii::t('cartrules','entry_status'),
			'CARTRULE_TOTAL_SORT_ORDER'=>Yii::t('cartrules','entry_sort_order'));
	}

	public function getCode()
	{
		return 'TOTAL';
	}
}