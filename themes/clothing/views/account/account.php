
  <div class="center-wrapper register-inner-pages"> 
    <div class="col-md-12">
  
<div class="heading-box"><h2> My Account </h2></div>
<div class="">
<?php echo Yii::t('Account', '<p>From your My Account Dashboard you have the ability have an overview of your reccent account activity and update your account information. click on link below to view or edit onformtion.</p>'); ?>


<div class="row ">
 <div class="col-md-6"> <?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
    'title' => 'Contact Information',
    'headerButtons' => array(
array(
'class' => 'bootstrap.widgets.TbButtonGroup',
'type' => '',
'buttons' => array(
array('label' => '',  'htmlOptions'=>array(
        'class'=>'glyphicon glyphicon-pencil' 
    ), 'url' => Yii::app()->params['config']['site_url'].'/index.php/account/address'),
)), 
),
)
);
	?>
    
    <table class="table">
    <tr>
    <td><strong>Name</strong></td>
    <td>:</td>
    <td><?php echo $data['account']['firstname']." ".$data['account']['lastname']?></td>
    </tr>
    
    <tr>
    <td><strong>Email </strong></td>
    <td>:</td>
    <td><?php echo $data['account']['email']?>
</td>
    </tr>
    
    <tr>
    <td><strong>Phone </strong></td>
    <td>:</td>
    <td><?php echo $data['account']['telephone']?></td>
    </tr>
    
    </table>
    <?php $this->endWidget(); ?>
    </div>
    
    
    
    
      <div class="col-md-6"> 
      
      <?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
    'title' => 'Address Book',
    'headerButtons' => array(
array(
'class' => 'bootstrap.widgets.TbButtonGroup',
'type' => 'info',
// '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
'buttons' => array(
array('label' => '', 'htmlOptions'=>array('class'=>'glyphicon glyphicon-pencil'), 'url' => '#'),
// this makes it split :)
)),
),
)
);
	?>
    <?php echo Yii::t('Address Book', '<p>'.$data['account']['address_1'].', '.$data['account']['city'].', '.$data['account']['sname'].', '.$data['account']['cname'].',</p>'); ?>

    
    
    
    <?php $this->endWidget(); ?>
      
      </div>
      
        <div class="col-md-12"> 
      
      <?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
    'title' => 'Newsletter',
    'headerButtons' => array(
array(
'class' => 'bootstrap.widgets.TbButtonGroup',
'type' => 'info',
// '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
),
),
)
);
	?>
    <!--<?php echo Yii::t('Newsletter', '<p>You Are Currently Not Subscribed To Newsletter.</p>'); ?>-->
    <input type="checkbox" name="newsletter" id="newsletter" style=" float: left; margin-right:10px;"/><p>You Are Currently Not Subscribed To Newsletter.</p>

   
    
    
    <?php $this->endWidget(); ?>
      
      </div>
      

      </div>

</div>
  </div>
   
   </div>
