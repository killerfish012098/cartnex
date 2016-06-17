<?php
class Shipping_Model extends CFormModel
{
    public $CARTRULE_SHIPPING_TITLE;
    public $CARTRULE_SHIPPING_STATUS;
    public $CARTRULE_SHIPPING_SORT_ORDER;

    public function rules()
    {
            return array(
                    array('CARTRULE_SHIPPING_TITLE,CARTRULE_SHIPPING_STATUS,CARTRULE_SHIPPING_SORT_ORDER','required'),
                    );
    }

    public function attributeLabels()
    {
            return array('CARTRULE_SHIPPING_TITLE'=>Yii::t('cartrules','entry_title'),
				'CARTRULE_SHIPPING_STATUS'=>Yii::t('cartrules','entry_status'),
				'CARTRULE_SHIPPING_SORT_ORDER'=>Yii::t('cartrules','entry_sort_order'),);
    }

    public function getCode()
    {
            return 'SHIPPING';
    }
}