<?php
return array('title' => 'Cart Rules Shipping',
    'showErrorSummary' => true,
    'elements' => array(
        '<div class="control-group span5 latble-divrequi">',
        'CARTRULE_SHIPPING_TITLE' => array(
            'type' => 'text',
            'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'CARTRULE_SHIPPING_STATUS' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'CARTRULE_SHIPPING_SORT_ORDER' => array(
            'type' => 'text', 'class' => 'controls'
        ),
        '</div>'
    ),
);