<?php

class ProductViewController extends Controller
{
 	public function actionIndex()
	{
            $model=new Product('productViewsReport');
                
            $model->unsetAttributes(); 
		if(isset($_GET['Product']))
                	$model->attributes=$_GET['Product'];
                $this->render('index',array('model'=>$model,));
         }
         
        protected function grid($data,$row,$dataColumn)
        {
             switch ($dataColumn->name)
             {
                 case 'percent':$return=$data->percent."%";
                                break;
             }
             return $return;
        }
}
