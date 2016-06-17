<?php

class ProductReportController extends Controller
{
    public function actionIndex()
    {
        $model = new Order('productReport');
	$model->unsetAttributes();
        
        
        if(isset($_GET['Order']))
        {
            /*$model->product_name=$_GET['Order']['product_name'];
            $model->date_from=$_GET['Order']['date_from'];
            $model->date_to=$_GET['Order']['date_to'];*/
            $model->attributes=$_GET['Order'];
            $productOrdersTotal=Order::getOrderInfo(array('data'=>'ProductOrdersTotal','input'=>array('id_product'=>$_GET['Order']['product_name'],
                'date_from'=>$_GET['Order']['date_from'],'date_to'=>$_GET['Order']['date_to'])));
            
            $productQuantitySold=Order::getOrderInfo(array('data'=>'ProductQuantitySold','input'=>array('id_product'=>$_GET['Order']['product_name'],
                'date_from'=>$_GET['Order']['date_from'],'date_to'=>$_GET['Order']['date_to'])));
            
            $productOrderedCustomers=Order::getOrderInfo(array('data'=>'ProductOrderedCustomers','input'=>array('id_product'=>$_GET['Order']['product_name'],
                'date_from'=>$_GET['Order']['date_from'],'date_to'=>$_GET['Order']['date_to'])));
            
            $productRevenue=Order::getOrderInfo(array('data'=>'ProductRevenue','input'=>array('id_product'=>$_GET['Order']['product_name'],
                'date_from'=>$_GET['Order']['date_from'],'date_to'=>$_GET['Order']['date_to'])));
            
            $stockOfProduct=Product::getProductInfo(array('data'=>'StockOfProduct','input'=>array('id_product'=>$_GET['Order']['product_name'])));
        }
        $this->render('index',array('model'=>$model,'data'=>array('productOrdersTotal'=>$productOrdersTotal,'productQuantitySold'=>$productQuantitySold,
            'productOrderedCustomers'=>$productOrderedCustomers,'productRevenue'=>$productRevenue,'stockOfProduct'=>$stockOfProduct)));
     }
     
    protected function grid($data,$row,$dataColumn)
    {
        switch ($dataColumn->name)
        {
            case 'total':$return=Yii::app()->currency->format($data[total],Yii::app()->config->getData('CONFIG_STORE_DEFAULT_CURRENCY'));
                            break;
        }
        return $return;
    }
}      