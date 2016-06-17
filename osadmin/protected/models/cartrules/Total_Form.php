<?php
return array('title' => 'Cart Rules Total',
    'showErrorSummary' => true,
    'elements' => array(
        '<div class="control-group span5 latble-divrequi">',
        'CARTRULE_TOTAL_TITLE' => array(
            'type' => 'text',
            'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'CARTRULE_TOTAL_STATUS' => array('type' => 'dropdownlist','items'=>array('1'=>'Enable','0'=>'Disable'), 
        //'hint' => 'If you want a reply, you must...', 
        'class' => 'controls'
        ),
        '</div>',
        '<div class="control-group span5 latble-divrequi">',
        'CARTRULE_TOTAL_SORT_ORDER' => array(
            'type' => 'text', 'class' => 'controls'
        ),
        '</div>'
    ),
);