<?php
class SubTotal_Model extends CFormModel
{
    public $CARTRULE_SUBTOTAL_TITLE;
    public $CARTRULE_SUBTOTAL_STATUS;
    public $CARTRULE_SUBTOTAL_SORT_ORDER;

	public function rules()
	{
		return array(
			array('CARTRULE_SUBTOTAL_TITLE,CARTRULE_SUBTOTAL_STATUS,CARTRULE_SUBTOTAL_SORT_ORDER','required'),
			);
	}

	public function attributeLabels()
	{
		return array('CARTRULE_SUBTOTAL_TITLE'=>Yii::t('cartrules','entry_title'),
			'CARTRULE_SUBTOTAL_STATUS'=>Yii::t('cartrules','entry_status'),
			'CARTRULE_SUBTOTAL_SORT_ORDER'=>Yii::t('cartrules','entry_sort_order'),);
	}

	public function getCode()
	{
		return 'SUBTOTAL';
	}
}