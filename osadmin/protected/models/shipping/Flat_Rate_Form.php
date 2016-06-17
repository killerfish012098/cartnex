<?php
 return array('title' => 'Flat Rate Shipping',
    'showErrorSummary' => true,
    'elements' => array(
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_FLAT_TITLE' => array(
            'type' => 'text',
            'class' => 'controls'
        ),
		'</div>',
		'<div class="control-group span5 latble-divrequi">',
        'SHIPPING_FLAT_COST' => array(
            'type' => 'text',
            'class' => 'controls'
        ),
		'</div>',
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_FLAT_REGION' => array('type' => 'dropdownlist','items'=>array_merge(array("0"=>"All Regions"),CHtml::listData(Region::getRegions(),'id_region', 'name')), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
		'</div>',
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_FLAT_TAX_CLASS' => array('type' => 'dropdownlist','items'=>array_merge(array("0"=>"None"),CHtml::listData(TaxClass::getTaxClasses(),'id_tax_class', 'name')), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_FLAT_STATUS' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_FLAT_SORT_ORDER' => array(
            'type' => 'text', 'class' => 'controls'
        ),
        '</div>'
    ),
);
/*return array('title' => 'Contact Us',
 'showErrorSummary'  => true,
'elements' => array(
    
'SHIPPING_FLAT_TITLE' => array(
'type' => 'text',
'maxlength' => '80'
),
'SHIPPING_FLAT_STATUS' => array(
'type' => 'text','hint' => 'If you want a reply, you must...','maxlength' => '80'
),
'SHIPPING_FLAT_COST' => array(
'type' => 'text',
'maxlength' => '120'
),
'SHIPPING_FLAT_TAX_CLASS' => array(
'type' => 'text',
),
'SHIPPING_FLAT_REGION' => array(
'type' => 'text',
),
'SHIPPING_FLAT_SORT_ORDER' => array(
'type' => 'text',
)
),
);*/
