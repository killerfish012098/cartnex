<?php
return array('title' => 'Contact Us',
'elements' => array(
    
'PAYMENT_COD_TITLE' => array(
'type' => 'text',
'maxlength' => '80'
),
'PAYMENT_COD_SORT_ORDER' => array(
'type' => 'text','hint' => 'If you want a reply, you must...','maxlength' => '80'
),
'PAYMENT_COD_ORDER_STATUS_ID' => array(
'type' => 'text',
'maxlength' => '120'
),
'PAYMENT_COD_REGION' => array(
'type' => 'textarea',
'attributes' => array('rows'=>20,'cols'=>80)
),
'PAYMENT_COD_STATUS' => array(
'type' => 'textarea',
'attributes' => array('rows'=>20,'cols'=>80)
)
),
    'buttons' => array(
	'submit' => array(
	'type' => 'submit',
	'label' => 'Submit'
	),),
);
