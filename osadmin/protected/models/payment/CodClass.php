<?php
/*return array(
'title' => 'Contact Us',
'elements' => array(
'name' => array(),
'email' => array(),
'subject' => array(),
'body' => array()
),
'buttons' => array(
'submit' => array()
)
);*/
return array('title' => 'Contact Us',
'elements' => array(
'name' => array(
'type' => 'text',
'maxlength' => '80'
),
'email' => array(
'type' => 'email','hint' => 'If you want a reply, you must...','maxlength' => '80'
),
'subject' => array(
'type' => 'text',
'maxlength' => '120'
),
'body' => array(
'type' => 'textarea',
'attributes' => array('rows'=>20,'cols'=>80)
)
),
'buttons' => array(
'submit' => array(
'type' => 'submit',
'label' => 'Submit'
)
));

?>