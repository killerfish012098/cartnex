<?php
class CustomerOrderTotalController extends Controller
{
	public function actionIndex()
	{
            $model=new Order('customerOrderTotalReport');
            $model->unsetAttributes();
            if(isset($_GET['Order']))
            {
                /*echo '<pre>';
                print_r($_GET);
                echo '</pre>';*/
                $model->date_from=$_GET['Order']['date_from'];
                $model->date_to=$_GET['Order']['date_to'];

            }

            $this->render('index',array('model'=>$model,));
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