<?php

class SearchTermController extends Controller
{  
	public function actionIndex()
	{
        $model=new SearchTerm('report');
        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['SearchTerm']))
		$model->attributes=$_GET['SearchTerm'];
                
                $this->render('index',array('model'=>$model));
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