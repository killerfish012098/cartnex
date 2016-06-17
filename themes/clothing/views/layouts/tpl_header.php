<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->metatitle;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <meta name="description" content="<?php echo $this->metadescription;?>">
        <meta name="keywords" content="<?php echo $this->metakeywords;?>" >
        <meta name="author" content="<?php echo $this->metatitle;?> - Cartnex.com" />
            <!-- The fav and touch icons -->
        <link rel="shortcut icon" href="<?php echo Library::getMiscUploadLink().Yii::app()->config->getData('CONFIG_STORE_FAVI_IMAGE'); ?>" />
        <?php $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
        Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/common.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/jquery.total-storage.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->params['config']['site_url']; ?>js/jquery.form.min.js"></script>
        <script type="text/javascript">
        var site_url="<?php echo Yii::app()->params['config']['site_url']; ?>";
        var product_list="<?php echo Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE'); ?>";
            $(document).ready(function() { 
                    var options = { 
                                    target:   '#output',   
                                    beforeSubmit:  beforeSubmit,
                                    success:       afterSuccess, 
                                    resetForm: true       
                            }; 
			
                     $('#MyUploadForm').submit(function() { 
                                    $(this).ajaxSubmit(options);  			
                            return false; 
                            }); 
                    function afterSuccess()
                    {
                            $.ajax({
                            url: site_url+'index.php/product/imageupload',
                            type: 'post',
                            data: '',
                                    complete: function(data) {
                                                      $("#image_upload").val(data.responseText);
                                     }
                        });
                    }
        function beforeSubmit(){
               if (window.File && window.FileReader && window.FileList && window.Blob)
                    {
                            if( !$('#FileInput').val()) 
                            {
                                    $("#output").html("Are you kidding me?");
                                    return false
                            }
			
                            var fsize = $('#FileInput')[0].files[0].size; 
                            var ftype = $('#FileInput')[0].files[0].type; 
                            switch(ftype)
                            {
                                    case 'image/png': 
                                    case 'image/gif': 
                                    case 'image/jpeg': 
                                    case 'image/pjpeg':
                                    case 'text/plain':
                                    case 'text/html':
                                    case 'application/x-zip-compressed':
                                    case 'application/pdf':
                                    case 'application/msword':
                                    case 'application/vnd.ms-excel':
                                    case 'video/mp4':
                                    case 'video/x-ms-wmv':
                                            break;
                                    default:
                                            $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                                            return false
                            }
			
                            //Allowed file size is less than 5 MB (1048576)
                            if(fsize>5242880) 
                            {
        $("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
                                    return false
                            }
                            $('#submit-btn').hide();
                            $('#loading-img').show(); 
                            $("#output").html("");  
                    }
                    else
                    {
        $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
                            return false;
                    }
            }
            function bytesToSize(bytes) {
               var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
               if (bytes == 0) return '0 Bytes';
               var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
               return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            }
	
            }); 
            
        </script>
        
        <!-- the styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['config']['site_url']; ?>css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/style.css" />
        <!-- style switcher -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['config']['site_url']; ?>css/jquery.datetimepicker.css" />
        
        
        
      </head>
    <body>
        <section id="header">
            <!-- Include the header bar -->

<?php include_once('header.php'); ?>

            <!-- /.container -->  
        </section><!-- /#header -->
