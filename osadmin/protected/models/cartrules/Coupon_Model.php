<?php
class Coupon_Model extends CFormModel
{
    public $CARTRULE_COUPON_TITLE;
    public $CARTRULE_COUPON_STATUS;
    public $CARTRULE_COUPON_SORT_ORDER;

    public function rules()
    {
            return array(
                    array('CARTRULE_COUPON_TITLE,CARTRULE_COUPON_STATUS,CARTRULE_COUPON_SORT_ORDER','required'),
                    );
    }

    public function attributeLabels()
    {
            return array('CARTRULE_COUPON_TITLE'=>Yii::t('cartrules','entry_title'),
				'CARTRULE_COUPON_STATUS'=>Yii::t('cartrules','entry_status'),
				'CARTRULE_COUPON_SORT_ORDER'=>Yii::t('cartrules','entry_sort_order'),);
    }

    public function getCode()
    {
            return 'COUPON';
    }
}