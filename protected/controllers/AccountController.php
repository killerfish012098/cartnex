<?php

class AccountController extends BaseController {

    public $position;
    public $data;

    public function filters() {
        return array('accessControl', 'ajaxOnly + Addtowishlist');
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'actions' => array('index', 'profile', 'address', 'setdefaultaddress', 'deleteaddress', 'orderHistory', 'orderDetails', 'wishlist', 'wishlistajax', 'removewishlist', 'logout','orderdownload'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated users to access all actions
                'actions' => array('Login', 'Forgotpassword', 'Addtowishlist', 'Register', 'Getstatedependencylist'),
                'users' => array('*'),
            ),
            /* array('deny',  // deny all users
              'actions'=>array('login','register','forgotpassword'),
              'users'=>array('@'),
              ),
              array('deny',  // deny all users
              'actions'=>array('Login','Forgotpassword','Addtowishlist','Register'),
              'users'=>array('@'),
              ), */
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function ActionAddtowishlist() {
        $json = array();

        if (!isset($_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = array();
        }

        if (isset($_POST['product_id'])) {
            $product_info = Yii::app()->product->getProduct((int) $_POST['product_id']);
        } else {
            $product_info = 0;
        }

        if ($product_info) {
            if (!in_array($_POST['product_id'], $_SESSION['wishlist'])) {
                $_SESSION['wishlist'][] = $_POST['product_id'];
            }

            if (isset($_SESSION['user_id'])) {
                $json['success'] = "Successfully added to wishlist";
            } else {
                $json['success'] = "You must <a href='" . $this->createUrl("account/login") . "'>login</a> or <a href='" . $this->createUrl("account/register") . "'>create an account</a> to save <a href='" . $this->createUrl("product/productdetails", array("product_id=" . (int) $_POST['product_id'])) . "'>click here</a> to your <a href='" . $this->createUrl("account/whishlist") . "'>wish list</a>!";
            }
        }
        //echo '<pre>';print_r($_SESSION['wishlist']);exit;
        echo json_encode($json);
    }

    /* public function ActionAddtowishlist() {
      $app=Yii::app();

      if (!empty(Yii::app()->session['whishlist'])) {
      $app->session['whishlist'][] = array_unique(array_merge(Yii::app()->session['whishlist'],(array) $_POST['product_id']));
      } else {
      $app->session['whishlist'] = array();
      $app->session['whishlist'] = (array) $_POST['product_id'];
      }

      if (!empty(Yii::app()->session['user_id'])) {
      $app->session['whishlist'] = array_unique(array_merge(Yii::app()->session['whishlist'],(array) $_POST['product_id']));
      $addwishlist = Customer::model()->findByPk($app->session['user_id']);
      $addwishlist->wishlist = serialize($app->session['whishlist']);
      $addwishlist->update(array('wishlist'));
      $customerWhishlist = Customer::model()->findByPk($app->session['user_id']);
      $whishlist = unserialize($customerWhishlist['wishlist']);
      $app->session['whishlist'] = $whishlist;
      }

      if (!empty($app->session['whishlist'])) {
      if (!empty($app->session['user_id'])) {
      echo json_encode(array("success" => "successfully add to wishlist"));
      } else {
      echo json_encode(array("success" => "You must <a href='" . $this->createUrl("account/login") . "'>login</a> or <a href='" . $this->createUrl("account/register") . "'>create an account</a> to save <a href='" . $this->createUrl("product/productdetails",
      array("product_id=" . (int) $_POST['product_id'])) . "'>click here</a> to your <a href='" . $this->createUrl("account/whishlist") . "'>wish list</a>!"));
      }
      } else {
      echo json_encode(array("success" => Yii::t('account','text_wrong_warning')));
      }
      } */

    public function beforerender() {
        $this->position = Yii::app()->module->prepare('account');
        return parent::beforerender();
    }

    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('account/index'));
        }
        $model = new LoginForm;
        $this->breadcrumbs = array(Yii::t('account', 'text_breadcrumb_login') => Yii::app()->request->requestUri);
        // collect user input data
        if (isset($_POST['LoginForm']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(array('account/index'));
            }
        }
        // display the login form
        $this->render('account/login', array('model' => $model));
    }

    /* public function actionLogin() {
      $request = Yii::app()->request;

      $this->breadcrumbs = array(Yii::t('account','text_breadcrumb_login') => Yii::app()->request->requestUri);
      $customer=new Customer;
      if (!empty($_POST['Customer']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {

      if($customer->login(array('email'=>$_POST['Customer']['email'],'password'=> $_POST['Customer']['password']))){
      $addwishlist = Customer::model()->findByPk(Yii::app()->session['user_id']);
      $addwishlist->wishlist = serialize(Yii::app()->session['whishlist']);
      $addwishlist->cart = serialize($_SESSION['products']);
      $addwishlist->update(array('wishlist', 'cart'));
      $this->redirect($this->createUrl("account/index"));
      } else {
      Yii::app()->flash->setFlash('error',Yii::t('account','text_incorrect_username_password'));
      }
      }
      $this->render('account/login', array('model' => $customer, 'data' => $data));
      } */

    public function actionIndex() {
        //echo Yii::app()->session['user_first_name'].'<pre>';print_r($_SESSION);echo '</pre>';exit;    
        //echo "value of ".Yii::app()->user->id;
        //exit;
        $this->breadcrumbs = array(Yii::t('account', 'text_breadcrumb_account') => Yii::app()->request->requestUri);
        //$model = new Customer;
        //$data['account'] = $model->accountsDetails();
        $data['account'] =Yii::app()->customer->getDefaultAddress();
		//echo "value of ".$model->newsletter;
        $data['text_newsletter_subscribe'] = $data['account']['newsletter'] ? Yii::t('account', 'text_newsletter_subscribe') : Yii::t('account', 'text_newsletter_unsubscribe');
        $this->render('account/index', array('data' => $data));
    }

    public function actionProfile() {
        $this->breadcrumbs = array(Yii::t('account', 'text_breadcrumb_account') => $this->createUrl('account/index'),
            Yii::t('account', 'text_breadcrumb_profile') => Yii::app()->request->requestUri);
        //$model = Customer::model()->find(array("condition" => "id_customer=" . Yii::app()->session['user_id']));
		$model=new ProfileForm;
		
        if (isset($_POST['ProfileForm'])) {
            $model->attributes=$_POST['ProfileForm'];
			
			
           if (!empty($_POST['ProfileForm']['password'])) {
                $model->password = $_POST['ProfileForm']['password'];//Yii::app()->customer->hashPassword($_POST['ProfileForm']['password']);
			}
			
            if ($model->validate()) {
				$input=$model->attributes;	
				unset($input['email']);
				unset($input['confirm']);
				
				
				if (!empty($_POST['ProfileForm']['password'])) {
                $input['password']= Yii::app()->customer->hashPassword($_POST['ProfileForm']['password']);
				}else
				{
					unset($input['password']);
				}
				Yii::app()->customer->updateCustomer(array('data'=>$input,'id_customer'=>$_SESSION['user_id']));
				//exit('yes');
                Yii::app()->flash->setFlash('success_profile', 'Update Successfull!!');
            } else {
                Yii::app()->flash->setFlash('error_profile', 'Update Failed!!');
            }
        }
		$model->attributes=Yii::app()->customer->getCustomer((int)$_SESSION['user_id']);
        $this->render('account/profile', array('model' => $model, 'data' => $data));
    }

    public function actionLogout() {

        Yii::app()->db->createCommand()->update('{{customer}}', array('ip' => $_SERVER['REMOTE_ADDR'], 'cart' => isset($_SESSION['cart']) ? serialize($_SESSION['cart']) : '', 'wishlist' => isset($_SESSION['wishlist']) ? serialize($_SESSION['wishlist']) : ''), 'id_customer=:id', array(':id' => (int) $_SESSION['user_id']));



        /* $addwishlist =Customer::model()->findByPk(Yii::app()->session['user_id']);
          $addwishlist->wishlist = serialize(Yii::app()->session['whishlist']);
          $addwishlist->cart = serialize($_SESSION['products']);
          $addwishlist->update(array('wishlist', 'cart')); */


        session_destroy();
        /* unset($_SESSION['products']);
          unset($_SESSION['cart']);
          unset(Yii::app()->session['user_first_name']);
          unset(Yii::app()->session['user_id']);
          unset(Yii::app()->session['user_last_name']);
          unset(Yii::app()->session['user_customer_group_id']);
          unset(Yii::app()->session['user_id_customer_address_default']); */
        Yii::app()->flash->setFlash('success', Yii::t('account', 'text_logged_out_success'));
        $this->redirect($this->createUrl('account/login'));
    }

    public function actionRegister() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('account/index'));
        }
        //$model = new Customer;
		$model = new RegistrationForm;
        //$data['page'] = Yii::app()->getContent(Yii::app()->config->getData('CONFIG_STORE_ACCOUNT_TERMS'));
        
        if (!empty($_POST['RegistrationForm']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $model->attributes = $_POST['RegistrationForm'];

            if ($model->validate()) {
				
                $model->password = CPasswordHelper::hashPassword($_POST['RegistrationForm']['password']);
				$input=$model->attributes;
                if (Yii::app()->config->getData('CONFIG_STORE_APPROVE_NEW_CUSTOMER')) {
                    $data = array('id' => '3', 'replace' => array('%customer_name%' => $_POST['RegistrationForm']['firstname'] . " " . $_POST['RegistrationForm']['lastname']), 'mail' => array("to" => array($_POST['RegistrationForm']['email'] => $_POST['RegistrationForm']['firstname'] . " " . $_POST['RegistrationForm']['lastname'],)));
                    Yii::app()->flash->setFlash('success', Yii::t('account', 'text_registration_success_pending_approval'));
                    $input['approved'] = 0;
					$input['status'] = 0;
                } else {
                    $data = array('id' => '2', 'replace' => array('%customer_name%' => $_POST['RegistrationForm']['firstname'] . " " . $_POST['RegistrationForm']['lastname'], '%username%' => $_POST['RegistrationForm']['email'], '%password%' => $_POST['RegistrationForm']['password']), 'mail' => array("to" => array($_POST['RegistrationForm']['email'] => $_POST['RegistrationForm']['firstname'] . " " . $_POST['RegistrationForm']['lastname'],)));
                    Yii::app()->flash->setFlash('success', Yii::t('account', 'text_registration_success'));
                    $input['approved'] = 1;
					$input['status'] = 1;
				}
				$input['date_created']=date('Y-m-d H:i:s');
				$input['id_customer_group']=Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_CUSTOMER_GROUP');
				$input['ip']=$_SERVER['REMOTE_ADDR'];
				unset($input['confirm']);
				unset($input['acknowledgement']);
				//echo '<pre>';print_r($input);exit;
                //$model->save(false);
				Yii::app()->customer->addCustomer($input);
                Mail::send($data);
                $this->redirect($this->createUrl("account/login"));
            }
        }

		$welcome = Yii::app()->page->getContent(10);
        $data['welcome']['title'] = $welcome['title'];
        $data['welcome']['description'] = $welcome['description'];
        $terms = Yii::app()->page->getContent(Yii::app()->config->getData('CONFIG_STORE_ACCOUNT_TERMS'));
        //echo '<pre>';print_r($terms);exit;
        $this->global['content'] = $terms['description'];
        $data['text_agree'] = Yii::t('account', 'text_agree', array('{page}' => $terms['title']));
        $data['acknowledgement'] = Yii::app()->config->getData('CONFIG_STORE_ACCOUNT_TERMS');
        $this->breadcrumbs = array("Account" => $this->createUrl('account/index'),"Register" => Yii::app()->request->requestUri);

        $this->render('account/register', array('model' => $model, 'data' => $data));
    }

    /* public function actionRegister() {
      $model = new Customer;
      $page = new page;
      $data['page'] = $page->getContent(Yii::app()->config->getData('CONFIG_STORE_ACCOUNT_TERMS'));

      $this->breadcrumbs = array(Yii::t('account','text_breadcrumb_account') => $this->createUrl('account/index'),
      Yii::t('account','text_breadcrumb_register') => Yii::app()->request->requestUri);

      if (!empty($_POST['Customer']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
      $model->attributes = $_POST['Customer'];
      if($model->validate()){
      $model->save(false);
      if(Yii::app()->config->getData('CONFIG_STORE_APPROVE_NEW_CUSTOMER')==1)
      $emailtemplate='3';
      else
      $emailtemplate='2';

      $data = array('id'=>$emailtemplate,'replace'=>array('%username%'=>$_POST['Customer']['firstname'].$_POST['Customer']['lastname'],'%email%'=>$_POST['Customer']['email'],'%password%'=>$_POST['Customer']['password']),'mail'=>array("to"=>array($_POST['Customer']['email']=>$_POST['Customer']['firstname'].$_POST['Customer']['lastname'],),"from"=>array(Yii::app()->config->getData('CONFIG_STORE_SUPPORT_EMAIL_ADDRESS')=>Yii::app()->config->getData('CONFIG_STORE_NAME')), "reply"=>array(Yii::app()->config->getData('CONFIG_STORE_REPLY_EMAIL')=>Yii::app()->config->getData('CONFIG_STORE_NAME'),)));

      if(Mail::send($data))
      Yii::app()->flash->setFlash('success', Yii::t('account','text_registration_success'));
      else
      Yii::app()->flash->setFlash('success', Yii::t('account','text_wrong_warning'));

      $this->redirect($this->createUrl("account/register"));
      }
      }
      $this->render('account/register', array('model' => $model, 'data' => $data));
      } */

    /*public function actionCheckemail() {
        //$user = Customer::model()->find(array("condition" => "email=:email", "params" => array(":email" => $_POST['email'])));
        $customer = Yii::app()->db->createCommand()->select('id_customer')->from('{{customer}}')->where('email=:email')->bindValue(":email", $_POST['email'])->queryRow();
		if ($customer['id_customer']) {
            echo "1";
        } else {
            echo "0";
        }
    }*/

    public function ActionForgotpassword() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('account/index'));
        }

        $this->breadcrumbs = array(Yii::t('account', 'text_breadcrumb_account') => $this->createUrl('account/index'),Yii::t('account', 'text_breadcrumb_forgot') => Yii::app()->request->requestUri);

		$model=new ForgotpasswordForm;
        if (!empty($_POST["ForgotpasswordForm"]) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
			//$customer = Customer::model()->find(array("condition" => "email=:email", "params" => array(":email" => $_POST['Customer']['email'])));
			$customer = Yii::app()->db->createCommand()->select('id_customer')->from('{{customer}}')->where('email=:email')->bindValue(":email", $_POST['ForgotpasswordForm']['email'])->queryRow();

            if ($customer['id_customer']) {

                $password = Yii::app()->customer->randomPassword();

                //$result = Customer::model()->updateAll(array("password" => Customer::hashPassword($password)), "id_customer='" . (int) $customer['id_customer'] . "' and email='" . $_POST['Customer']['email'] . "'");
				$result=Yii::app()->customer->updateCustomer(array('data'=>array("password" => Yii::app()->customer->hashPassword($password)),'id_customer'=>$customer['id_customer']));	
				
                //$customer=Customer::model()->find(array("condition" => "id_customer=" . $id_customer['id_customer']));


                $data = array('id' => '7', 'replace' => array('%username%' => $customer['firstname'] . " " . $customer['lastname'], '%password%' => $password),
                    'mail' => array("to" => array($customer['email'] => $customer['firstname'] . " " . $customer['lastname'],)));

                Mail::send($data);
                //echo '<pre>';print_r($data);
                //exit;
                if ($result) {
                    Yii::app()->user->setFlash('success', Yii::t('account', 'text_forgot_success'));
                    $this->redirect($this->createUrl('account/login'));
                } else {
                    Yii::app()->user->setFlash('danger_forgot_password', Yii::t('account', 'text_forgot_warning'));
                }
            } else {
                Yii::app()->flash->setFlash('danger_forgot_password', Yii::t('account', 'text_forgot_invalid'));
            }
        }
        //$model = new Customer;
        $this->render('account/forgotpassword', array('model' => $model, 'data' => $data));
    }

    public function ActionAddress() {

        //$model = new CustomerAddress;
		$model=new AddressForm;
        
        //$data['address_list'] = CustomerAddress::getAddressesByCustomer();
		$data['address_list'] = Yii::app()->customer->getAddresses();
        if (!empty($_POST["AddressForm"]) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
            $model->attributes = $_POST['AddressForm'];
            if ($model->validate()) {
                //echo '<pre>';print_r($model->attributes);exit;
				//$model->save(false);
				Yii::app()->customer->addAddress($model->attributes);
                Yii::app()->flash->setFlash('success_address', 'New address added successfully!!');
                $this->redirect($this->createUrl('account/address'));
            }
        }
		$data['state'] = Library::getStates($model->id_country);
        $data['country'] = Library::getCountries();
		$this->breadcrumbs = array(Yii::t('account', 'text_breadcrumb_account') => $this->createUrl('account/index'),
            Yii::t('account', 'text_breadcrumb_address') => Yii::app()->request->requestUri);
        $this->render('account/address', array('model' => $model, 'data' => $data));
    }

    public function ActionSetdefaultaddress() {
        //$address = Customer::model()->findByPk(Yii::app()->session['user_id']);
		//$address = Yii::app()->customer->getCustomer($id);
        //$address['id_customer_address_default'] = (int) $_POST['id_customer_address'];
        if(Yii::app()->customer->updateCustomer(array('data'=>array('id_customer_address_default'=>(int)$_POST['id_customer_address']),'id_customer'=>Yii::app()->session['user_id']))) {
            Yii::app()->session['user_id_customer_address_default'] = (int)$_POST['id_customer_address'];
            echo "1";
        } else {
            echo "0";
        }
    }

    public function ActionDeleteaddress() {
        if (Yii::app()->session['user_id_customer_address_default'] == $_POST['id_customer_address']) {
            echo "2";
        } //elseif (CustomerAddress::model()->deleteAll("id_customer_address='" . (int) $_POST['id_customer_address'] . "'")) {
			elseif (Yii::app()->customer->deleteAddress((int) $_POST['id_customer_address'])) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function actionOrderHistory() {

        $this->breadcrumbs = array(Yii::t('account', 'text_breadcrumb_account') => $this->createUrl('account/index'),
            Yii::t('account', 'text_breadcrumb_orderhistory') => Yii::app()->request->requestUri);
        $arrayDataProvide = Yii::app()->order->getCustomerOrders((int) $_SESSION['user_id']);
        $this->render('account/orderhistory', array('dataProvider' => $arrayDataProvide, 'data' => $data));
    }

    public function actionOrderDetails() {

        $this->breadcrumbs = array(Yii::t('account', 'text_breadcrumb_account') => $this->createUrl('account/index'),
            Yii::t('account', 'text_breadcrumb_orderdetails') => Yii::app()->request->requestUri);
        $id = (int) $_GET['id'];
        $model['o'] = Yii::app()->order->getOrderByCustomer($id); //Order::model()->find(array("condition" => "id_order=" . $id . " and id_customer=" . Yii::app()->session['user_id']));
        $model['op'] = Yii::app()->order->getOrderProducts($id); //OrderProduct::model()->findAll(array("condition" => "id_order=" . $id));
        $model['ot'] = Yii::app()->order->getOrderTotals($id);
//OrderTotal::getOrderTotal(array('condition' => 'id_order=' . $id,'order' => 'sort_order asc'));
        /* foreach ($model['op'] as $product) {
          foreach (OrderProductOption::model()->findAll(array("condition" => "id_order='" . $id . "' and id_order_product='" . $product->id_order_product . "'")) as $option) {
          $data['product'][$product->id_order_product][option][] = array(
          "id_product_option" => $option->id_product_option,
          "id_product_option_value" => $option->id_product_option_value,
          "name" => $option->name,
          "value" => $option->value,
          "type" => $option->type
          );
          }

          $data['product'][$product->id_order_product]['unit_price'] = $product->unit_price;
          $data['product'][$product->id_order_product]['total'] = $product->total;

          if ($product->has_download):
          $data['download'][$product->id_order_product]['download_filename'] = $product->download_filename;
          $data['download'][$product->id_order_product]['download_mask'] = $product->download_mask;
          $data['download'][$product->id_order_product]['download_remaining_count'] = $product->download_remaining_count;
          $data['download'][$product->id_order_product]['download_expiry_date'] = $product->download_expiry_date;
          endif;
          } */
          // var_dump($model['o']);exit;
        $data['order_history'] = Yii::app()->order->getCustomerOrderHistory($id);

        $this->render('account/order-details', array('model' => $model, 'data' => $data));
    }
    
    public function ActionOrderdownload()
    {
        //exit("inside");
        $opid=(int)$_GET['opid'];
        if($opid)
        {

            $product=Yii::app()->order->getOrderedProductById($opid);
            $allowDownload=(strtotime(date('Y').'-'.date('m').'-'.date('d'))<strtotime($product['download_expiry_date'])) && ($product['id_order_status']==Yii::app()->config->getData('CONFIG_WEBSITE_COMPLETE_ORDER_STATUS')) && ($product['download_remaining_count']>0)?1:0;
        
            if($allowDownload)
            {
                $file = Library::getCatalogUploadPath().$product['download_filename'];	
                $mask = basename($product['download_mask']);
                $mime = 'application/octet-stream';
                $encoding = 'binary';
                if (!headers_sent()) {
                    if (file_exists($file)) {
                        header('Pragma: public');
                        header('Expires: 0');
                        header('Content-Description: File Transfer');
                        header('Content-Type: ' . $mime);
                        header('Content-Transfer-Encoding: ' . $encoding);
                        header('Content-Disposition: attachment; filename='.($mask ? $mask : basename($file)));
                        header('Content-Length: ' . filesize($file));
                        $file = readfile($file);
                        print($file);
                    } else {
                        exit('Error: Could not find file ' . $file . '!');
                    }
                } else {
                    exit('Error: Headers already sent out!');
                }

                Yii::app()->order->updateProductDownloadRemaining($opid);
                exit;
            }
        }
    }

    //getState Dependency list
    /* public function ActionGetstatedependencylist() {
      $data['state'] = State::model()->findAll(array("condition" => "id_country=:country_id",
      "params" => array(":country_id" => (int) $_POST['country_id'])));
      $options.="<option value=''>".Yii::t('common','text_select')."</option>";
      foreach ($data['state'] as $state) {
      $options.="<option value='" . $state['id_state'] . "'>" . $state['name'] . "</option>";
      }
      echo $options;
      } */

    public function ActionGetstatedependencylist() {
        $id_country = !isset($_POST['id_country']) ? $_GET['id_country'] : $_POST['id_country'];
        $id_state = !isset($_POST['id_state']) ? $_GET['id_state'] : $_POST['id_state'];
        $states = Library::getStates((int) $id_country);
        $options.="<option value=''>" . Yii::t('common', 'text_select') . "</option>";
        foreach ($states as $state) {
            $selected = $id_state == $state['id_state'] ? "selected" : "";
            $options.="<option value='" . $state['id_state'] . "' " . $selected . " >" . $state['name'] . "</option>";
        }
        echo $options;
    }

    /* public function ActionWishlist() {
      $this->getAuthenticate();
      $product = new Product;
      $this->breadcrumbs = array(Yii::t('account','text_breadcrumb_account') => $this->createUrl('account/index'),
      Yii::t('account','text_breadcrumb_wishList') => Yii::app()->request->requestUri);
      $customerWhishlist = Customer::model()->findByPk(Yii::app()->session['user_id']);
      $whishlist = unserialize($customerWhishlist['wishlist']);
      foreach ($whishlist as $product_id) {
      $data['products'][$product_id] = $product->getProduct($product_id);
      }
      $this->render('account/wishlist', array('data' => $data));
      } */

    public function ActionWishlist() {
        if (isset($_GET['product_id'])) {
            Yii::app()->session['wishlist'] = array_diff(Yii::app()->session['wishlist'], (array) $_GET['product_id']);
            $this->redirect($this->createUrl('account/wishlist'));
        }
        $app = Yii::app();
        $this->breadcrumbs = array("Account" => $this->createUrl('account/index'), "My Whishlist" => $app->request->requestUri);

        $whishlist = $_SESSION['wishlist'];
        //echo '<pre>';print_r($whishlist);exit;
        $displayPrice = ($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE')) ? true : false;
        foreach ($whishlist as $product_id) {
            $product_info = $app->product->getProduct($product_id);
            $price = "";
            $special = "";
            if ($displayPrice) {
                $price = ($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE')) ? $app->currency->format($product_info['price']) : false;
                $special = isset($product_info['special']) ? $app->currency->format($product_info['special']) : 0;
            }
            //echo (bool)$special." aa <br/>";

            if ($product_info) {


                $data['products'][] = array(
                    'product_id' => $product_info['product_id'],
                    'image' => $app->easyImage->thumbSrcOf(Library::getCatalogUploadPath() . $product_info['image'], array('resize' => array('width' => $app->imageSize->productWishlist['w'], 'height' => $app->imageSize->productWishlist['h']))),
                    'name' => $product_info['name'],
                    'model' => $product_info['model'],
                    'price' => $price,
                    'special' => $special,
                    'deleteLink' => $this->createUrl('account/wishlist', array('product_id' => $product_info['product_id'])),
                    'productDetailsLink' => $this->createUrl('product/productdetails', array('product_id' => $product_info['product_id'])),
                );
            }
        }
        //echo '<pre>';print_r($data);exit;
        $this->render('account/wishlist', array('data' => $data));
    }

    /* public function ActionWishlistajax() {

      if (empty(Yii::app()->session['user_id'])) {
      if (!empty(Yii::app()->session['whishlist'])) {
      Yii::app()->session['whishlist'] = array_unique(array_merge(Yii::app()->session['whishlist'],
      (array) $_POST['product_id']));
      } else {
      Yii::app()->session['whishlist'] = array();
      Yii::app()->session['whishlist'] = (array) $_POST['product_id'];
      }
      } else {
      if (!empty(Yii::app()->session['whishlist'])) {
      Yii::app()->session['whishlist'] = array_unique(array_merge(Yii::app()->session['whishlist'],
      (array) $_POST['product_id']));
      } else {
      Yii::app()->session['whishlist'] = array();
      Yii::app()->session['whishlist'] = (array) $_POST['product_id'];
      }
      Yii::app()->session['whishlist'] = array_unique(array_merge(Yii::app()->session['whishlist'],
      (array) $_POST['product_id']));
      $addwishlist = Customer::model()->findByPk(Yii::app()->session['user_id']);
      $addwishlist->wishlist = serialize(Yii::app()->session['whishlist']);
      $addwishlist->update(array('wishlist'));
      $customerWhishlist = Customer::model()->findByPk(Yii::app()->session['user_id']);
      $whishlist = unserialize($customerWhishlist['wishlist']);
      Yii::app()->session['whishlist'] = $whishlist;
      }
      $product = new Product;
      $product = $product->getProduct($_POST['product_id']);
      if (!empty(Yii::app()->session['whishlist'])) {
      if (!empty(Yii::app()->session['user_id'])) {
      echo json_encode(array("success" => "successfully add to wishlist"));
      } else {
      echo json_encode(array("success" => "You must <a href='" . $this->createUrl("account/login") . "'>login</a> or <a href='" . $this->createUrl("account/register") . "'>create an account</a> to save <a href='" . $this->createUrl("product/productdetails",
      array("product_id=" . (int) $_POST['product_id'])) . "'>" . $product['name'] . "</a> to your <a href='" . $this->createUrl("account/whishlist") . "'>wish list</a>!"));
      }
      } else {
      echo json_encode(array("success" => Yii::t('account','text_wrong_warning')));
      }
      }

      public function ActionRemovewishlist() {
      Yii::app()->session['whishlist'] = array_diff(Yii::app()->session['whishlist'],
      (array) $_POST['product_id']);
      $addwishlist = Customer::model()->findByPk(Yii::app()->session['user_id']);
      $addwishlist->wishlist = serialize(Yii::app()->session['whishlist']);
      if ($addwishlist->update(array('wishlist'))) {
      $json['success'] = Yii::t('account','text_removed_from_wishlist_success');
      $json['total'] = count(Yii::app()->session['whishlist']);
      echo json_encode($json);
      } else {
      echo json_encode(array("success" => Yii::t('account','text_wrong_warning')));
      }
      } */
}
