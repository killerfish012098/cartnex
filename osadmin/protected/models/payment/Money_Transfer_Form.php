<?php
return array('title' => 'Money Transfer',
    'showErrorSummary' => true,
    'elements' => array(
        '<div class="control-group span5 latble-divrequi">',
        'PAYMENT_MT_TITLE' => array(
            'type' => 'text',
            'class' => 'controls'
        ),
		'</div>',
        '<div class="control-group span5 latble-divrequi">',
        'PAYMENT_MT_ORDER_STATUS_ID' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
		'</div>',
        '<div class="control-group span5 latble-divrequi">',
        'PAYMENT_MT_REGION' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'PAYMENT_MT_STATUS' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'PAYMENT_MT_SORT_ORDER' => array(
            'type' => 'text', 'class' => 'controls'
        ),
        '</div>'
    ),
);

/*return array('title' => 'Money Transfer',
  'showErrorSummary'  => true,
'elements' => array(
    
'PAYMENT_MT_TITLE' => array(
'type' => 'text',
'maxlength' => '80'
),
'PAYMENT_MT_SORT_ORDER' => array(
'type' => 'text','hint' => 'If you want a reply, you must...','maxlength' => '80'
),
'PAYMENT_MT_ORDER_STATUS_ID' => array(
'type' => 'text',
'maxlength' => '120'
),
'PAYMENT_MT_REGION' => array(
'type' => 'text',
'attributes' => array('rows'=>20,'cols'=>80)
),
'PAYMENT_MT_STATUS' => array(
'type' => 'text',
'attributes' => array('rows'=>20,'cols'=>80)
)
),
    'buttons' => array(
	'submit' => array(
	'type' => 'submit',
	'label' => 'Submit'
	),),
);*/