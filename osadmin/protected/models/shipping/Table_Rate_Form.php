<?php
 return array('title' => 'Table Rate Shipping',
    'showErrorSummary' => true,
    'elements' => array(
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_TABLE_TITLE' => array(
            'type' => 'text',
            'class' => 'controls'
        ),
		'</div>',
		'<div class="control-group span5 latble-divrequi">',
        'SHIPPING_TABLE_COST' => array(
            'type' => 'text',
            'class' => 'controls'
        ),
		'</div>',
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_TABLE_REGION' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
		'</div>',
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_TABLE_TAX_CLASS' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_TABLE_STATUS' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'SHIPPING_TABLE_SORT_ORDER' => array(
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