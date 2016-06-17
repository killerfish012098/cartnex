<?php
$pricerange=$_GET['priceranga'];
$pricerange=explode(",",$pricerange);
?>
<?php if(sizeof($data)>0){?>


<div class="row col-md-12 sp-os">
<form method="get" action="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>?category_id=<?php echo $_GET['category_id']?>" id="filter-form">
    <div class="module-main-div">
        <div class="filters-div  top-nav">
            <div class="module-content">
                <?php foreach($data as $filter)
                    {
						if($filter['filter']=='price' && $filter['type']=='general')
                {?>
                <div class="filter-price-div">
              
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree">
                                <div class="heading-box"> <h2 >Price <span class="glyphicon glyphicon-minus left-icon"></span><span class="glyphicon glyphicon-plus left-icon"></span></h2></div>
                            </a>
                        </div>
                        <div id="collapseThree" class="accordion-body collapse in">
                            <div class="accordion-inner">

                                <div class="filter-price">
                                    <p>Enter a Price Range</p>
                                    <div class="price-input-box">
                                        <span class="price-input"><input class="col-md-5 form-control" type="text" value="<?php if($pricerange[0]==''){echo "0";}else{echo $pricerange[0];}?>" name="from" id="from" maxlength="5"> </span> 
                                        <span  class="price-arrow"> - </span>  <span  class="price-input"><input class="col-md-5 form-control" type="text" value="<?php if($pricerange[1]==''){echo "0";}else{echo $pricerange[1];}?>" name="to" id="to" maxlength="5"> </span>
                                        <div class="col-md-3 btn-main-left-padding"><input type="button" value="Go" class="btn btn-inverse" onclick="return priceRange();"/></div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              
                </div>
                <?php }else{?>
                <div class="filter-price-div">
             
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse"
                               data-parent="#accordion2" href="#collapse<?php echo $filter['filter'];?>">
                                <div class="heading-box"> 
                                    <h2 ><?php echo $filter['filter'];?> <span class="glyphicon glyphicon-minus left-icon"></span><span class="glyphicon glyphicon-plus left-icon"></span></h2>
                                </div>
                            </a>
                        </div>
                        <div id="collapse<?php echo $filter['filter'];?>" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <div class="filter-price">
                                    <ul class="filter-list">
                                        <?php foreach($filter[data][values] as $k=>$v){?>
                                        <li><input name="<?php echo $filter['type'].'['.$k.']';?>" style="background:#993300;" type="checkbox" class=""  value="<?php echo $k;?>" onclick="return filters('<?php echo strtolower($filter['type']);?>','<?php echo $k;?>')" <?php if(in_array($k,explode(",",$_GET[strtolower($filter['type'])]))){?> checked="checked"<?php } ?>/> <?php echo $v;?> </li>                                        
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
           
                </div>
                <?php }?>
                <?php }?>
            </div>
        </div>
    </div>
    </form>
</div> <div class="clearfix"></div>

<?php }?>