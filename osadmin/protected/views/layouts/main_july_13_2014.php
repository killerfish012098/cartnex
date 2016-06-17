<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo Yii::app()->name;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--	<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700' rel='stylesheet' type='text/css'>
    -->
<!-- <link href='http://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet' type='text/css'>
 -->
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php
	  //$baseUrl = Yii::app()->theme->baseUrl; 
	  $baseUrl = Yii::app()->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-57-precomposed.png">
	<?php  
	  $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css'); /*bootstrap total css*/
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');  /*bootstrap responsive css*/
	  $cs->registerCssFile($baseUrl.'/css/abound.css');  /*our edit design css*/
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-switch.css');  /*our edit design css*/
	  ?>
      


 <?php
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');  /* bootstrap js*/
      $cs->registerScriptFile($baseUrl.'/js/bootstrap-editable.min.js');  /* grid Contect editable js */
	//$cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');  /* grid Contect editable js */
  	//$cs->registerScriptFile($baseUrl.'/js/styleswitcher.js');
      $cs->registerScriptFile($baseUrl.'/js/main.js'); /* our add js code  js */
	   $cs->registerScriptFile($baseUrl.'/js/main.js'); /* our add js code  js */
	   $cs->registerScriptFile($baseUrl.'/js/bootstrap-switch.js'); /* our add js code  js */
	?>

    
  </head>

<body>

<section id="navigation-main" class="">   
<!-- Require the navigation -->
<div class="container-fluid ">
<?php require_once('tpl_top_navigation.php')?>
</div>
</section><!-- /#navigation-main -->
    
<section class="main-body">
<div class="container-fluid now_padding">
 <?php echo $content; ?>           
</div>
</section>

<!-- Require the footer -->
<?php require_once('tpl_footer.php')?>
</body>
</html>