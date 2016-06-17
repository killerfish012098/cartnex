<?php 
echo $form->renderBegin();
	foreach($form->getElements() as $element)
	echo $element->render();
echo $form->renderEnd();
?>