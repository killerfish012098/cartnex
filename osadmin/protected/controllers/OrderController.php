<?php

class OrderController extends Controller {

    
    public function accessRules()
    {
        return $this->addActions(array('city','state','country','updateStatus'));
    }
    
    public function actionCity()
    {
        //throw new CHttpException(404,'The requested page does not exist.');
    }
        
    public function actionCreate() {
        $model['o'] = new Option;
        $model['od'] = new OptionDescription;
 
        if (isset($_POST['OptionDescription'])) 
            {
               
            }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) 
    {
        //echo '<pre>';print_r(Yii::app()->config->getData('orderStatusDetails'));echo '</pre>';
        $model = $this->loadModel($id);
        $model['data']['order_status']=Yii::app()->db->createCommand('select concat(id_order_status,"#",name) as id,name from {{order_status}} where id_language="'.Yii::app()->session['language'].'"')->queryAll();        
        //echo '<pre>';print_r($model);exit;
            
        if (isset($_POST['OptionDescription'])) 
        {
            $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
        }
        
        $this->render('update', array('model' => $model['model'],'data'=>$model['data'],'id'=>$id));
    }

    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_order', $arrayRowId);
            CActiveRecord::model('Order')->deleteAll($criteria);
            CActiveRecord::model('OrderProduct')->deleteAll($criteria);
            CActiveRecord::model('OrderHistory')->deleteAll($criteria);
            CActiveRecord::model('OrderProductOption')->deleteAll($criteria);
            CActiveRecord::model('OrderTotal')->deleteAll($criteria);
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_delete_success'));
            
        } else {
            Yii::app()->user->setFlash('alert',
                    Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',
                    Yii::t('common', 'message_delete_fail'));
        }
        //exit;
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
    }
    
    public function actionUpdateStatus($id)
        {
                if(Yii::app()->request->getIsAjaxRequest() && isset($_POST))
                {
                    //echo '<pre>';print_r($_POST['OrderHistory']);
                    $exp=explode("#",$_POST['OrderHistory']['order_status_name']);
                    //print_r($exp);
                    //exit;
                    Order::model()->updateAll(array('id_order_status' => $exp[0],'order_status_name' => $exp[1]),'id_order="' . $id . '"');
                    $model=new OrderHistory();
                    $data=array();
                    //$data=$_POST['OrderHistory'];
                    $data['id_order']=$id;
                    $data['date_created']=new CDbExpression('NOW()');
                    $data['id_order_status']=$exp[0];
                    $data['order_status_name']=$exp[1];
                    $data['notified_by_customer']=$_POST['OrderHistory']['notified_by_customer'];
                    $data['message']=$_POST['OrderHistory']['message'];
                    
                    $model->attributes=$data;
                    $model->save();
                    //echo '<pre>';print_r($data);echo '</pre>';
                    $orderStatusDetails=Yii::app()->config->getData('orderStatusDetails');
                    $orderHistory="";
                    foreach(OrderHistory::getOrderHistory(array('condition'=>'id_order='.$id,'order'=>'date_created desc')) as $history):
                        $notifyCustomer=$history->notified_by_customer=='1'?Yii::t('common','text_yes'):Yii::t('common','text_no');
                        $orderHistory.='<tr>
                               <td>'.$history->date_created.'</td>
                               <td><span style="background-color:'.$orderStatusDetails[$history->id_order_status].';color:white" class="label color_field">'.$history->order_status_name.'</span></td>
                               <td>'.$history->message.'</td>
                               <td>'.$notifyCustomer.'</td>
                        </tr>';
                    endforeach;
					if($_POST['OrderHistory']['notified_by_customer'])
					{
						$orderRow=Order::model()->find('id_order='.$id);
						$rowOS=OrderStatus::model()->find('id_order_status='.$exp[0]);
						$data = array('id' => $rowOS->id_email_template, 'replace' => array('%customer_name%' =>$orderRow->firstname . " " . $orderRow->lastname,'%message%' =>$_POST['OrderHistory']['message']), 'mail' => array("to" => array($orderRow->email_address => $orderRow->firstname . " " . $orderRow->lastname)));
						//echo '<pre>';print_r($data);echo '</pre>';
						//exit;
						Mail::send($data);
					}
                    echo $orderHistory;
					
                }
        }

    public function actionIndex() {
        /*echo Yii::app()->config->getData('CONFIG_STORE_NAME');
        echo Yii::app()->config->getData('CONFIG_STORE_OWNER');
        echo Yii::app()->config->getData('CONFIG_STORE_TELEPHONE_NUMBER');
        echo Yii::app()->config->getData('CONFIG_STORE_ADDRESS');*/
        //echo Yii::app()->config->data('CONFIG_STORE_NAME');
        //echo Yii::app()->config->getName();
        //echo '<pre>';print_r(Yii::app()->config->getData('orderStatusDetails'));echo '</pre>';
        
        $model = new Order('search');
                $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Order'])) $model->attributes = $_GET['Order'];
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
    {
        $model['o']=Order::model()->find(array("condition"=>"id_order=".$id));
        $model['op']=  OrderProduct::model()->findAll(array("condition"=>"id_order=".$id));
        //$model['opo']=  OrderProductOption::model()->findAll(array("condition"=>"id_order=".$id));
        $data=array();
        $data['order']['total']=Yii::app()->currency->format($model['o']->total,$model['o']->currency,$model['o']->currency_value);
        
        foreach($model['op'] as $product)
        {   
            foreach(OrderProductOption::model()->findAll(array("condition"=>"id_order='".$id."' and id_order_product='".$product->id_order_product."'")) as $option)
            {
                $data['product'][$product->id_order_product][option][]=array(
                    "id_product_option"=>$option->id_product_option,
                    "id_product_option_value"=>$option->id_product_option_value,
                    "name"=>$option->name,
                    "value"=>$option->value,
                    "type"=>$option->type
                    );
            }
            
            $data['product'][$product->id_order_product]['unit_price']=Yii::app()->currency->format($product->unit_price,$model['o']->currency,$model['o']->currency_value);
            $data['product'][$product->id_order_product]['total']=Yii::app()->currency->format($product->total,$model['o']->currency,$model['o']->currency_value);
            
            if($product->has_download):
                $data['download'][$product->id_order_product]['download_filename']=$product->download_filename;
                $data['download'][$product->id_order_product]['download_mask']=$product->download_mask;
                $data['download'][$product->id_order_product]['download_remaining_count']=$product->download_remaining_count;
                $data['download'][$product->id_order_product]['download_expiry_date']=$product->download_expiry_date;
            endif;
            
        }
        
        /*echo '<pre>';
        print_r($data);
        exit;*/
        
        //$model['opo']= OrderProductOption::model()->findAll(array("condition"=>"id_order=".$id));
        //$model['ot']= OrderTotal::model()->findAll(array("condition"=>"id_order=".$id));
        $model['oh']= new OrderHistory;

        return array("model"=>$model,"data"=>$data);
    }
    
    protected function performAjaxValidation($model) 
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    protected function grid($data,$row,$dataColumn)
    {
         switch ($dataColumn->name)
         {
             case 'order_status_name':
                        $return='<span style="background-color:'.$data->color.';color:white" class="label color_field">'.$data->order_status_name.'</span>';
                        break;
            
            case 'total':
                        $return=Yii::app()->currency->format($data->total,$data->currency,$data->currency_value);
                        break;

			case 'invoice_no':
                        $return=$data->invoice_prefix." ".$data->invoice_no;
                        break;
         }
         return $return;
    }
}
