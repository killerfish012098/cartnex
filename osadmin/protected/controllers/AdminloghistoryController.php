<?php
class AdminLogHistoryController extends Controller
{
	public function actionDelete()//($id)
	{
            $arrayRowId=  is_array(Yii::app()->request->getParam('id'))?Yii::app()->request->getParam('id'):array(Yii::app()->request->getParam('id'));
            if(sizeof($arrayRowId)>0)
            {
                $criteria=new CDbCriteria;
                 $criteria->addInCondition('id_log', $arrayRowId);
                                
                if(CActiveRecord::model('AdminLogHistory')->deleteAll($criteria))
                {
                    Yii::app()->user->setFlash('success',Yii::t('common','message_delete_success'));
                }else
                {
                    Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
                }
            }else
            {
                Yii::app()->user->setFlash('alert',Yii::t('common','message_checkboxValidation_alert'));
                Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
            }
        
            if(!isset($_GET['ajax']))
                $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
	}	

	public function actionIndex()
	{
		$model=new AdminLogHistory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminLogHistory']))
			$model->attributes=$_GET['AdminLogHistory'];

		$this->render('index',array('model'=>$model));
	}
	
	protected function grid($data, $row, $dataColumn) {
        switch ($dataColumn->name) {
            case 'page_accessed':
                $return = '<a href="'.$data->page_url.'" target="_blank">'.$data->page_accessed.'</a>';
                break;
        }
        return $return;
    }

}
