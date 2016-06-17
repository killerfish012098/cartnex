<?php

class CheckoutController extends BaseController {

    public $url;
    public $position;
    public $data;

    public function ActionCart() {
        $app = Yii::app();
        $json = array();

        $productDetails = isset($_POST['product_id']) ? $app->product->getProduct((int) $_POST['product_id']) : 0;
        if ($productDetails) {
            $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;

            $option = isset($_POST['option']) ? $_POST['option'] : array();

            $productOptions = $app->product->getProductOptions($productDetails['product_id']);
            foreach ($productOptions as $productOption) {
                if ($productOption['required'] && empty($option[$productOption['id_product_option']])) {
                    $json['error']['option'][$productOption['id_product_option']] = $productOption['name'] . " Required";
                }
            }


            if (!$json) {
                $app->cart->addProduct($productDetails['product_id'], $quantity, $option);
                $json['success'] = Yii::t('checkout', 'text_add_to_cart_success');
                if (Yii::app()->config->getData('CONFIG_WEBSITE_ADDTOCART_REDIRECT')) {
                    //$json['redirect'] = $this->createUrl('product/productdetails', array('product_id' => $productDetails['product_id']));
                    $json['redirect'] = $this->createUrl('checkout/carts');
                }
                $json['total_price']=Yii::app()->currency->format(Yii::app()->cart->getSubTotal());
                $json['total_qty']=Yii::app()->cart->countProducts();
            }
        }
        //echo '<pre>';print_r($json);exit;
        echo json_encode($json);
    }

    public function actionLogin() {
        $app = Yii::app();
        $json = array();
        if ((!$app->cart->hasProducts()) || (!$app->cart->hasStock() && !$app->config->getData('CONFIG_STORE_ALLOW_CHECKOUT'))) {
            $this->redirect($this->createUrl('checkout/carts'));
        }
        $model = new LoginForm;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['acountType'])) {
                $_SESSION['acountType'] = $_POST['acountType'];
            }

            if (isset($_POST['email']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $model->username = $_POST['email'];
                $model->password = $_POST['password'];
                // validate user input and redirect to the previous page if valid
                if ($model->validate() && $model->login()) {
                    /* $addwishlist = Customer::model()->findByPk(Yii::app()->session['user_id']);
                      $addwishlist->wishlist = serialize(Yii::app()->session['user_whishlist']);
                      $addwishlist->cart = serialize($_SESSION['products']);
                      $addwishlist->update(array('wishlist', 'cart')); */
                } else {
                    $json['error']['warning'] = Yii::t('account', 'text_incorrect_username_password'); // $_SESSION['OBJ']['tr']->translate('error_login_checkout_checkout');
                }
            }
            /* if (isset($_POST['email']) && isset($_POST['password'])) {
              $customer=new Customer;
              if ($customer->login(array('email'=>$_POST['email'],'password'=> $_POST['password']))) {
              unset($_SESSION['guest']);
              } else {
              $json['error']['warning'] =Yii::t('account','text_incorrect_username_password');// $_SESSION['OBJ']['tr']->translate('error_login_checkout_checkout');
              }
              } */
        } else {

            $data['guestCheckout'] = ($app->config->getData('CONFIG_STORE_ALLOW_GUEST_CHECKOUT') && !$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && !$app->cart->hasDownload());

            /* if (isset($_SESSION['accountType'])) {
              $data['accountType'] = $_SESSION['accountType'];
              } else {
              $data['accountType'] = 'register';
              } */
            //$model = new Customer;
            $data['forgotten'] = $this->createUrl('account/forgotpassword');
            $json['output'] = $this->renderPartial('checkout/login', array('data' => $data, 'model' => $model), true);
        }
        //echo '<pre>';print_r($json);echo '</pre>';exit;
        echo json_encode($json);
    }

    public function actionGuest() {
        $json = array();
        $app = Yii::app();
        $data['shipping_required'] = $app->cart->hasShipping();
        // $data['shipping_required'] = true;
        if ((int) Yii::app()->session['user_id']) {
			$json['redirect'] = $this->createUrl('checkout/checkout');
        }

        if ((!$app->cart->hasProducts()) || (!$app->cart->hasStock() && !$app->config->getData('CONFIG_STORE_ALLOW_CHECKOUT'))) {
            $json['redirect'] = $this->createUrl('checkout/carts');
        }

        if (!$app->config->getData('CONFIG_STORE_ALLOW_GUEST_CHECKOUT') || $app->cart->hasDownload()) {
            $json['redirect'] = $this->createUrl('checkout/checkout');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            unset($_SESSION['billing']);
            unset($_SESSION['shipping']);
            if (!$json) {
                if ((strlen(utf8_decode($_POST['billing']['firstname'])) < 1) || (strlen(utf8_decode($_POST['billing']['firstname'])) > 32)) {
                    $json['error']['billing']['firstname'] = Yii::t('checkout', 'error_firstname');
                }

                if ((strlen(utf8_decode($_POST['billing']['lastname'])) < 1) || (strlen(utf8_decode($_POST['billing']['lastname'])) > 32)) {
                    $json['error']['billing']['lastname'] = Yii::t('checkout', 'error_lastname');
                }

                if ((strlen(utf8_decode($_POST['billing']['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $_POST['billing']['email'])) {
                    $json['error']['billing']['email'] = Yii::t('checkout', 'error_email');
                }

                if ((strlen(utf8_decode($_POST['billing']['telephone'])) < 3) || (strlen(utf8_decode($_POST['billing']['telephone'])) > 32)) {

                    $json['error']['billing']['telephone'] = Yii::t('checkout', 'error_telephone');
                }

                if ((strlen(utf8_decode($_POST['billing']['address_1'])) < 3) || (strlen(utf8_decode($_POST['billing']['address_1'])) > 128)) {
                    $json['error']['billing']['address_1'] = Yii::t('checkout', 'error_address_1');
                }

                if ((strlen(utf8_decode($_POST['billing']['city'])) < 2) || (strlen(utf8_decode($_POST['billing']['city'])) > 128)) {
                    $json['error']['billing']['city'] = Yii::t('checkout', 'error_city');
                }

                if ((strlen(utf8_decode($_POST['billing']['postcode'])) < 2) || (strlen(utf8_decode($_POST['billing']['postcode'])) > 10)) {
                    $json['error']['billing']['postcode'] = Yii::t('checkout', 'error_postcode');
                }

                if ($_POST['billing']['id_country'] == '') {
                    $json['error']['billing']['id_country'] = Yii::t('checkout', 'error_country');
                }

                if ($_POST['billing']['id_state'] == '') {
                    $json['error']['billing']['id_state'] = Yii::t('checkout', 'error_state');
                }
            }

            if (!$json) {
                $_SESSION['billing']['firstname'] = $_POST['billing']['firstname'];
                $_SESSION['billing']['lastname'] = $_POST['billing']['lastname'];
                $_SESSION['billing']['email'] = $_POST['billing']['email'];
                $_SESSION['billing']['telephone'] = $_POST['billing']['telephone'];
                $_SESSION['billing']['company'] = $_POST['billing']['company'];
                $_SESSION['billing']['address_1'] = $_POST['billing']['address_1'];
                $_SESSION['billing']['address_2'] = $_POST['billing']['address_2'];
                $_SESSION['billing']['postcode'] = $_POST['billing']['postcode'];
                $_SESSION['billing']['city'] = $_POST['billing']['city'];
                $_SESSION['billing']['id_country'] = $_POST['billing']['id_country'];
                $_SESSION['billing']['id_state'] = $_POST['billing']['id_state'];


                $country_info = Library::getCountry($_POST['billing']['id_country']);
                if ($country_info) {
                    $_SESSION['billing']['country'] = $country_info['name'];
                    $_SESSION['billing']['iso_code_2'] = $country_info['iso_code_2'];
                    $_SESSION['billing']['iso_code_3'] = $country_info['iso_code_3'];
                    $_SESSION['billing']['address_format'] = $country_info['address_format'];
                    $_SESSION['billing']['call_prefix'] = $country_info['call_prefix'];
                }

                $state_info = Library::getState($_POST['billing']['id_state']);

                if ($state_info) {
                    $_SESSION['billing']['state'] = $state_info['name'];
                    $_SESSION['billing']['state_code'] = $state_info['code'];
                }

                unset($_SESSION['payment_methods']);
                unset($_SESSION['payment_method']);
            }

            //start guest shipping
            if (!$json && $data['shipping_required']) {
                if ((strlen(utf8_decode($_POST['shipping']['firstname'])) < 1) || (strlen(utf8_decode($_POST['shipping']['firstname'])) > 32)) {
                    $json['error']['shipping']['firstname'] = Yii::t('checkout', 'error_firstname');
                }

                if ((strlen(utf8_decode($_POST['shipping']['lastname'])) < 1) || (strlen(utf8_decode($_POST['shipping']['lastname'])) > 32)) {
                    $json['error']['shipping']['lastname'] = Yii::t('checkout', 'error_lastname');
                }

                if ((strlen(utf8_decode($_POST['shipping']['telephone'])) < 3) || (strlen(utf8_decode($_POST['shipping']['telephone'])) > 32)) {

                    $json['error']['shipping']['telephone'] = Yii::t('checkout', 'error_telephone');
                }

                if ((strlen(utf8_decode($_POST['shipping']['address_1'])) < 3) || (strlen(utf8_decode($_POST['shipping']['address_1'])) > 128)) {
                    $json['error']['shipping']['address_1'] = Yii::t('checkout', 'error_address_1');
                }

                if ((strlen(utf8_decode($_POST['shipping']['city'])) < 2) || (strlen(utf8_decode($_POST['shipping']['city'])) > 128)) {
                    $json['error']['shipping']['city'] = Yii::t('checkout', 'error_city');
                }

                if ((strlen(utf8_decode($_POST['shipping']['postcode'])) < 2) || (strlen(utf8_decode($_POST['shipping']['postcode'])) > 10)) {
                    $json['error']['shipping']['postcode'] = Yii::t('checkout', 'error_postcode');
                }

                if ($_POST['shipping']['id_country'] == '') {
                    $json['error']['shipping']['id_country'] = Yii::t('checkout', 'error_country');
                }

                if ($_POST['shipping']['id_state'] == '') {
                    $json['error']['shipping']['id_state'] = Yii::t('checkout', 'error_state');
                }

                if (!$json) {
                    $_SESSION['shipping']['firstname'] = $_POST['shipping']['firstname'];
                    $_SESSION['shipping']['lastname'] = $_POST['shipping']['lastname'];
                    $_SESSION['shipping']['telephone'] = $_POST['shipping']['telephone'];
                    $_SESSION['shipping']['company'] = $_POST['shipping']['company'];
                    $_SESSION['shipping']['address_1'] = $_POST['shipping']['address_1'];
                    $_SESSION['shipping']['address_2'] = $_POST['shipping']['address_2'];
                    $_SESSION['shipping']['postcode'] = $_POST['shipping']['postcode'];
                    $_SESSION['shipping']['city'] = $_POST['shipping']['city'];
                    $_SESSION['shipping']['id_country'] = $_POST['shipping']['id_country'];
                    $_SESSION['shipping']['id_state'] = $_POST['shipping']['id_state'];


                    $country_info = Library::getCountry($_POST['shipping']['id_country']);
                    if ($country_info) {
                        $_SESSION['shipping']['country'] = $country_info['name'];
                        $_SESSION['shipping']['iso_code_2'] = $country_info['iso_code_2'];
                        $_SESSION['shipping']['iso_code_3'] = $country_info['iso_code_3'];
                        $_SESSION['shipping']['address_format'] = $country_info['address_format'];
                        $_SESSION['shipping']['call_prefix'] = $country_info['call_prefix'];
                    }

                    $state_info = Library::getState($_POST['shipping']['id_state']);

                    if ($state_info) {
                        $_SESSION['shipping']['state'] = $state_info['name'];
                        $_SESSION['shipping']['state_code'] = $state_info['code'];
                    }
                }
                unset($_SESSION['shipping_methods']);
                unset($_SESSION['shipping_method']);
            }
        } else {
            if (isset($_SESSION['billing']['firstname'])) {
                $data['billing']['firstname'] = $_SESSION['billing']['firstname'];
            } else {
                $data['billing']['firstname'] = '';
            }

            if (isset($_SESSION['billing']['lastname'])) {
                $data['billing']['lastname'] = $_SESSION['billing']['lastname'];
            } else {
                $data['billing']['lastname'] = '';
            }

            if (isset($_SESSION['billing']['email'])) {
                $data['billing']['email'] = $_SESSION['billing']['email'];
            } else {
                $data['billing']['email'] = '';
            }

            if (isset($_SESSION['billing']['telephone'])) {
                $data['billing']['telephone'] = $_SESSION['billing']['telephone'];
            } else {
                $data['billing']['telephone'] = '';
            }

            if (isset($_SESSION['billing']['fax'])) {
                $data['billing']['fax'] = $_SESSION['billing']['fax'];
            } else {
                $data['billing']['fax'] = '';
            }

            if (isset($_SESSION['billing']['company'])) {
                $data['billing']['company'] = $_SESSION['billing']['company'];
            } else {
                $data['billing']['company'] = '';
            }

            if (isset($_SESSION['billing']['address_1'])) {
                $data['billing']['address_1'] = $_SESSION['billing']['address_1'];
            } else {
                $data['billing']['address_1'] = '';
            }

            if (isset($_SESSION['billing']['address_2'])) {
                $data['billing']['address_2'] = $_SESSION['billing']['address_2'];
            } else {
                $data['billing']['address_2'] = '';
            }

            if (isset($_SESSION['billing']['postcode'])) {
                $data['billing']['postcode'] = $_SESSION['billing']['postcode'];
            } else {
                $data['billing']['postcode'] = '';
            }

            if (isset($_SESSION['billing']['city'])) {
                $data['billing']['city'] = $_SESSION['billing']['city'];
            } else {
                $data['billing']['city'] = '';
            }

            if (isset($_SESSION['billing']['id_country'])) {
                $data['billing']['id_country'] = $_SESSION['billing']['id_country'];
            } else {
                $data['billing']['id_country'] = '';
            }

            if (isset($_SESSION['billing']['id_state'])) {
                $data['billing']['id_state'] = $_SESSION['billing']['id_state'];
            } else {
                $data['billing']['id_state'] = '';
            }

            $data['countries'] = Library::getCountries();
            if ($data['shipping_required']) {

                //start shipping guest
                if (isset($_SESSION['shipping']['firstname'])) {
                    $data['shipping']['firstname'] = $_SESSION['shipping']['firstname'];
                } else {
                    $data['shipping']['firstname'] = '';
                }

                if (isset($_SESSION['shipping']['lastname'])) {
                    $data['shipping']['lastname'] = $_SESSION['shipping']['lastname'];
                } else {
                    $data['shipping']['lastname'] = '';
                }

                if (isset($_SESSION['shipping']['telephone'])) {
                    $data['shipping']['telephone'] = $_SESSION['shipping']['telephone'];
                } else {
                    $data['shipping']['telephone'] = '';
                }

                if (isset($_SESSION['shipping']['company'])) {
                    $data['shipping']['company'] = $_SESSION['shipping']['company'];
                } else {
                    $data['shipping']['company'] = '';
                }

                if (isset($_SESSION['shipping']['address_1'])) {
                    $data['shipping']['address_1'] = $_SESSION['shipping']['address_1'];
                } else {
                    $data['shipping']['address_1'] = '';
                }

                if (isset($_SESSION['shipping']['address_2'])) {
                    $data['shipping']['address_2'] = $_SESSION['shipping']['address_2'];
                } else {
                    $data['shipping']['address_2'] = '';
                }

                if (isset($_SESSION['shipping']['postcode'])) {
                    $data['shipping']['postcode'] = $_SESSION['shipping']['postcode'];
                } else {
                    $data['shipping']['postcode'] = '';
                }

                if (isset($_SESSION['shipping']['city'])) {
                    $data['shipping']['city'] = $_SESSION['shipping']['city'];
                } else {
                    $data['shipping']['city'] = '';
                }

                if (isset($_SESSION['shipping']['id_country'])) {
                    $data['shipping']['id_country'] = $_SESSION['shipping']['id_country'];
                } else {
                    $data['shipping']['id_country'] = '';
                }

                if (isset($_SESSION['shipping']['id_state'])) {
                    $data['shipping']['id_state'] = $_SESSION['shipping']['id_state'];
                } else {
                    $data['shipping']['id_state'] = '';
                }

                $data['countries'] = Library::getCountries();
                //end shipping guest
            }

            $json['output'] = $this->renderPartial('checkout/checkout-guest', array('data' => $data), true);
        }
        //echo '<pre>';print_r($data); echo '</pre>';exit;
        echo json_encode($json);
    }

    public function actionshowcart() {
        //echo '<pre>';
        $json = array();
        $app = Yii::app();
        if (isset($_POST['product_id'])) {
            $app->cart->remove($_POST['product_id']);
        }

        $data['products'] = array();
        $total_quantity = 0;
        $products = $app->cart->getProducts();
        if (sizeof($products)) {

            foreach ($products as $product) {
                $total_quantity += $product['quantity'];
                $option_data = array();
                foreach ($product['option'] as $option) {
                    $file = $option['option_value'];
                    $option_data[] = array(
                        'name' => $option['name'],
                        'value' => (strlen($file) > 20 ? substr($file, 0, 20) . '..' : $file)
                    );
                }

                $price = ($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE')) ? $app->currency->format($product['price']) : false;

                $total = ($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE')) ? $app->currency->format($product['total']) : false;

                $data['products'][] = array(
                    'key' => $product['key'],
                    'image' => $app->easyImage->thumbSrcOf(Library::getCatalogUploadPath() . $product['image'], array('resize' => array('width' => $app->imageSize->productCart['w'], 'height' => $app->imageSize->productCart['h']))),
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $option_data,
                    'quantity' => $product['quantity'],
                    'stock' => $product['stock'],
                    'price' => $price,
                    'total' => $total,
                    'href' => $this->createUrl('product/productdetails', array('product_id' => $product['id_product']))
                );
            }

            $json = $data;
            $json['cart_rules'] = $app->cartRules->loadRules();


            $json['total_qty'] = $total_quantity;
            $json['total_amount'] = Yii::app()->currency->format(Yii::app()->cart->getSubTotal());
            $show_cart = $this->renderPartial("checkout/showcart", array('data' => $json), true);
            $output = array('show_cart' => $show_cart, 'total_qty' => $json['total_qty'], 'total_amount' => $json['total_amount']);
        } else {
            $json['total_qty'] = 0;
            $show_cart = $this->renderPartial("checkout/showcart", array('data' => $json), true);
            $output = array('show_cart' => $show_cart, 'total_qty' => 0, 'total_amount' => $app->currency->format(0));
        }
        echo json_encode($output);
    }

    
    public function ActionCarts() {
        $app = Yii::app();

        //remove
        if (isset($_GET['remove'])) {
            unset($_SESSION['cart'][$_GET['remove']]);
            $this->redirect($this->createUrl("checkout/carts"));
        }

        //update
        if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['quantity'])) {
            //echo '<pre>';print_r($_POST);exit;
            foreach ($_POST['quantity'] as $key => $value) {
                if (isset($_SESSION['cart'][$key]) && !is_nan($value)) {
                    $_SESSION['cart'][$key] = (int) $value;
                }
            }
            $this->redirect($this->createUrl("checkout/carts"));
        }

        if (count($_SESSION['cart'])) {
            $flag = true;
            $prodQty = array();
            foreach ($_SESSION['cart'] as $k => $v) {
                $details = explode(':', $k);
                if (in_array($details[0], array_keys($prodQty))) {
                    $prodQty[$details[0]] = $prodQty[$details[0]] + $v;
                } else {
                    $prodQty[$details[0]] = $v;
                }
            }

            $products = $app->cart->getProducts();
            foreach ($products as $product) {
                if ($prodQty[$product['id_product']] < $product['minimum']) {
                    $flag = false;
                    Yii::app()->flash->setFlash('danger_minimum_quantity', 'Minimum order quantity for ' . $product['name'] . ' is ' . $product['minimum']);
                }

                if ($flag) {
                    $data['checkout']['href'] = $this->createUrl("checkout/checkout");
                } else {
                    $data['checkout']['href'] = $this->createUrl("checkout/carts");
                }


                $stock = 'instock';
                //echo '<pre>';print_r($product);exit;
                //echo "value of ".Yii::app()->config->getData('CONFIG_STORE_ALLOW_CHECKOUT');
                if (!Yii::app()->config->getData('CONFIG_STORE_ALLOW_CHECKOUT') && !$product['stock']) {
                    Yii::app()->user->setFlash('danger_no_stock', 'Highlighted products where not in stock!!');
                    $stock = 'nostock';
                    $data['checkout']['href'] = $this->createUrl("index/index");

                    //exit('inside');
                }
                //exit($stock);
                //echo '<pre>';print_r($product);echo '</pre>';exit;
                $data['product'][] = array('id_product' => $product['id_product'],
                    'image' => $app->easyImage->thumbSrcOf(Library::getCatalogUploadPath() . $product['image'], array('resize' => array('width' => $app->imageSize->productCart['w'], 'height' => $app->imageSize->productCart['h']))),
                    'name' => $product['name'],
                    'full_name' => $product['full_name'],
                    'model' => $product['model'],
                    'option' => $product['option'],
                    'stock' => $stock,
                    'quantity' => $product['quantity'],
                    'key' => $product['key'],
                    'price' => $app->currency->format($product['price']),
                    'total' => $app->currency->format($product['total'])
                );
            }
            //Coupons

            Yii::import('application.models.cartrules.Coupon_Class');
            $data['coupon_status'] = Coupon_Class::getStatus();
            /* exit("value of ".$data['coupon_status']);
              //exit("value of ".$coupon->getStatus()); */
            //echo $_POST['Apply_Discount_Code'].empty($_POST['Apply_Discount_Code'])." && ". strtoupper($_SERVER['REQUEST_METHOD']) .'== POST &&'.$this->validateCoupon();
            //exit;
            //$this->validateCoupon();
            $data['coupon'] = $_POST['Apply_Discount_Code'];

            if (!empty($_POST['Apply_Discount_Code']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' && $this->validateCoupon()) {
                Yii::app()->session['coupon_code'] = $_POST['Apply_Discount_Code'];
                Yii::app()->user->setFlash('success', 'Coupon discount applied successfully!!');
            }
            $data['cart_rules'] = Yii::app()->cartRules->loadRules();
        } else {
            $data['checkout']['href'] = $this->createUrl("index/index");
        }
        $this->breadcrumbs = array("Shopping Cart" => Yii::app()->request->requestUri);

        $this->render("checkout/cart", array('data' => $data));
    }

    public function validateCoupon($coupon) {
        if (!Coupon_Class::getCoupon($_POST['Apply_Discount_Code'])) {
            //Yii::app()->flash->setFlash('error', 'Minimum order quantity for ' . $product['name'] . ' is ' . $product['minimum']);
            Yii::app()->user->setFlash('danger_invalid_coupon', 'Invalid Coupon.coupon may be expired or already used!!');
            return false;
        } else {
            return true;
        }
    }

    public function actionCheckoutprocess() {
        $app = Yii::app();

        if ((!$app->cart->hasProducts()) || (!$app->cart->hasStock() && !$app->config->getData('CONFIG_STORE_ALLOW_CHECKOUT'))) {
            $this->redirect($this->createUrl('checkout/carts'));
        }

        if ($app->cart->hasShipping()) {
            if (isset($_SESSION['shipping_method']) && $_SESSION['shipping_method']['id'] != "") {
                list($shippingModule, $shippingMethod) = explode('-', $_SESSION['shipping_method']['id']);
                $shippingMethods = $app->shipping->getMethods();
                if (!is_array($shippingMethods) || !is_array($shippingMethods[$shippingModule]['methods'][$shippingMethod])) {
                    $this->redirect($this->createUrl('checkout/carts'));
                }
            } else {
                $this->redirect($this->createUrl('checkout/carts'));
            }
        }

        if (!isset($_SESSION['payment_method']) || !in_array($_SESSION['payment_method']['id'], array_keys($app->payment->getMethods()))) {
            $this->redirect($this->createUrl('checkout/carts'));
        }

        $app->payment->beforeOrderProcess();

        /* start datebase insertiona and mail */
        $app->order->confirm(array('id_order' => $_SESSION['id_order']));
        /* end datebase insertion and mail */

        $app->payment->afterOrderProcess();

        $this->redirect($this->createUrl('checkout/success'));
    }

    public function actionSuccess() {
        // echo '<pre>';print_r($_SESSION);
        //echo "value of ".Yii::app()->cart->hasShipping();
        //exit;
        $this->metatitle = "Order Successfull.Thank You!!";
        if (isset($_SESSION['id_order'])) {
            $_SESSION['cart'] = array();
            unset($_SESSION['coupon_id']);
            unset($_SESSION['coupon_amount']);
            unset($_SESSION['coupon_code']);
            unset($_SESSION['shipping_method']);
            unset($_SESSION['shipping_methods']);
            unset($_SESSION['payment_method']);
            unset($_SESSION['payment_methods']);
            unset($_SESSION['guest']);
            unset($_SESSION['id_order']);
            unset($_SESSION['payment']);
            unset($_SESSION['shipping']);
        } else {
            $this->redirect($this->createUrl('site/index'));
        }


        $this->breadcrumbs = array("checkout" => $this->createUrl('checkout/checkout'), 'success' => Yii::app()->request->requestUri);

        if (isset($_SESSION['user_id'])) {
            $data['text_message'] = '<p>Your order has been successfully processed!</p><p>You can view your order history by going to the <a href="%s">my account</a> page and by clicking on <a href="%s">history</a>.</p><p>If your purchase has an associated download, you can go to the account <a href="%s">downloads</a> page to view them.</p><p>Please direct any questions you have to the <a href="%s">store owner</a>.</p><p>Thanks for shopping with us online!</p>';
        } else {
            $data['text_message'] = '<p>Your order has been successfully processed!</p><p>Please direct any questions you have to the <a href="%s">store owner</a>.</p><p>Thanks for shopping with us online!</p>';
        }
        $data['title'] = "Order Successfull!!";
        $this->render("checkout/success", array('data' => $data));
    }

    public function ActionCheckout() {
        /* Library::prepareMailTemplate(array('id_language'=>1,'language_code'=>'es'));exit;
          $customer_id=1;
          ob_start();
          include 'order.tpl';
          $html = ob_get_contents();
          ob_end_clean();
          echo $html;exit; */
        /* $row=Yii::app()->db->createCommand('select description from {{email_template_description}} where id_email_template="1"')->queryRow();

          $text_greeting="hello";
          ob_start();

          echo $row['description'];
          $html = ob_get_contents();

          ob_end_clean();
          echo $html;
          exit; */
        //ob_start();
        //echo $row['description'];
        //$order=ob_get_clean();
        //$text="hello ".$store_name;
        /* $text=$row['description'];
          $store_name="suresh ";
          //extract(array("store_name"=>"hello"));
          //var_dump($order);

          //eval($text);
          eval("\$text = \"$text\";");
          echo "wow ".$text;
          exit; */
        //Yii::app()->payment->getMethod('MT');
        //echo '<pre>';print_r(Yii::app()->config->getData('languages'));print_r($_SESSION);exit;
        $app = Yii::app();

        $this->breadcrumbs = array("Cart" => $this->createUrl('checkout/cart'), 'Checkout' => Yii::app()->request->requestUri);

        if ((!$app->cart->hasProducts()) || (!$app->cart->hasStock() && !$app->config->getData('CONFIG_STORE_ALLOW_CHECKOUT'))) {
            $this->redirect($this->createUrl('checkout/carts'));
        }
		
		// Validate minimum quantity requirments.			
        $products = $app->cart->getProducts();
        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['id_product'] == $product['id_product']) {
                    $product_total += $product_2['quantity'];
                }
            }
            if (!$app->config->getData('CONFIG_STORE_ALLOW_CHECKOUT') && !$product['stock']) {
                $this->redirect($this->createUrl('checkout/carts'));
            }

            if ($product['minimum'] > $product_total) {
                $this->redirect($this->createUrl('checkout/carts'));
            }

            $data['product'][] = array('id_product' => $product['id_product'],
                'image' => $app->easyImage->thumbSrcOf(Library::getCatalogUploadPath() . $product['image'], array('resize' => array('width' => $app->imageSize->productCart['w'], 'height' => $app->imageSize->productCart['h']))),
                'name' => $product['name'],
                'model' => $product['model'],
                'option' => $product['option'],
                'quantity' => $product['quantity'],
                'key' => $product['key'],
                'price' => $app->currency->format($product['price']),
                'total' => $app->currency->format($product['total'])
            );
        }
        $data['cart_rules'] = Yii::app()->cartRules->loadRules();
        $data['logged'] = (int) $_SESSION['user_id'];
        $data['shipping_required'] = $app->cart->hasShipping();
        $terms = Yii::app()->page->getContent(Yii::app()->config->getData('CONFIG_STORE_CHECKOUT_TERMS'));
        $this->global['content']=$terms['description'];
        //$model = new Customer;
        $this->render("checkout/checkout", array('model' => $model, 'data' => $data));
    }

    public function ActionCustomeraddress() {
        $json = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (Yii::app()->cart->hasShipping()) {
                if (isset($_POST['shipping_address'])) {
                    unset($_SESSION['shipping']);
                    //$_SESSION['shipping'] = Customer::getAddress((int) $_POST['shipping_address']);
					$_SESSION['shipping'] = Yii::app()->customer->getAddress((int)$_POST['shipping_address']);
                    $_SESSION['shipping']['id_address'] = (int) $_POST['shipping_address'];

                    $country_info = Library::getCountry($_SESSION['shipping']['id_country']);
                    $_SESSION['shipping']['country'] = $country_info['name'];
                    $_SESSION['shipping']['iso_code_2'] = $country_info['iso_code_2'];
                    $_SESSION['shipping']['iso_code_3'] = $country_info['iso_code_3'];
                    $_SESSION['shipping']['address_format'] = $country_info['address_format'];
                    $_SESSION['shipping']['call_prefix'] = $country_info['call_prefix'];

                    $state_info = Library::getState($_SESSION['shipping']['id_state']);
                    $_SESSION['shipping']['state'] = $state_info['name'];
                    $_SESSION['shipping']['state_code'] = $state_info['code'];
                } else {
                    $json['error'] = 'Please select address!!';
                }
            }

            if (isset($_POST['billing_address'])) {
                unset($_SESSION['billing']);
				
                $_SESSION['billing'] = Yii::app()->customer->getAddress((int) $_POST['billing_address']);
				//$_SESSION['billing'] = Customer::getAddress((int) $_POST['billing_address']);
                $_SESSION['billing']['id_address'] = (int) $_POST['billing_address'];

                $country_info = Library::getCountry($_SESSION['billing']['id_country']);
                $_SESSION['billing']['country'] = $country_info['name'];
                $_SESSION['billing']['iso_code_2'] = $country_info['iso_code_2'];
                $_SESSION['billing']['iso_code_3'] = $country_info['iso_code_3'];
                $_SESSION['billing']['address_format'] = $country_info['address_format'];
                $_SESSION['billing']['call_prefix'] = $country_info['call_prefix'];

                $state_info = Library::getState($_SESSION['billing']['id_state']);
                $_SESSION['billing']['state'] = $state_info['name'];
                $_SESSION['billing']['state_code'] = $state_info['code'];
            } else {
                $json['error'] = 'Please select address!!';
            }
        } else {
            $json['error'] = 'Invalid request!!';
        }
        //echo '<pre>';print_r($_SESSION['billing']);print_r($_SESSION['shipping']);exit;
        echo json_encode($json);
    }

    public function ActionCustomer() {
        $json = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['address'])) {
            if ((strlen(utf8_decode($_POST['address']['firstname'])) < 1) || (strlen(utf8_decode($_POST['address']['firstname'])) > 32)) {
                $json['error']['address']['firstname'] = Yii::t('checkout', 'error_firstname_checkout_checkout');
            }

            if ((strlen(utf8_decode($_POST['address']['lastname'])) < 1) || (strlen(utf8_decode($_POST['address']['lastname'])) > 32)) {
                $json['error']['address']['lastname'] = Yii::t('checkout', 'error_lastname_checkout_checkout');
            }

            if ((strlen(utf8_decode($_POST['address']['telephone'])) < 3) || (strlen(utf8_decode($_POST['address']['telephone'])) > 32)) {

                $json['error']['address']['telephone'] = Yii::t('checkout', 'error_telephone_checkout_checkout');
            }

            if ((strlen(utf8_decode($_POST['address']['address_1'])) < 3) || (strlen(utf8_decode($_POST['address']['address_1'])) > 128)) {
                $json['error']['address']['address_1'] = Yii::t('checkout', 'error_address_1_checkout_checkout');
            }

            if ((strlen(utf8_decode($_POST['address']['city'])) < 2) || (strlen(utf8_decode($_POST['address']['city'])) > 128)) {
                $json['error']['address']['city'] = Yii::t('checkout', 'error_city_checkout_checkout');
            }

            if ((strlen(utf8_decode($_POST['address']['postcode'])) < 2) || (strlen(utf8_decode($_POST['address']['postcode'])) > 10)) {
                $json['error']['address']['postcode'] = Yii::t('checkout', 'error_postcode_checkout_checkout');
            }

            if ($_POST['address']['id_country'] == '') {
                $json['error']['address']['id_country'] = Yii::t('checkout', 'error_id_country_checkout_checkout');
            }

            if ($_POST['address']['id_state'] == '') {
                $json['error']['address']['id_state'] = Yii::t('checkout', 'error_id_state_checkout_checkout');
            }

            if (!$json) {
                /*$address = new CustomerAddress;
                $address->attributes = $_POST['address'];
                $address->id_customer = $_SESSION['user_id'];
                $address->save(false);*/
				$addrData=array();
				$addrData=$_POST['address'];
				$addrData['id_customer']=$_SESSION['user_id'];
				Yii::app()->customer->addAddress($addrData);
			}
        }

        //$data['address'] = Customer::getAddresses();
		$data['address'] = Yii::app()->customer->getAddresses();
        foreach ($_SESSION['cart'] as $key => $value) {
            $product_split = explode(":", $key);
            $data['product'][$i] = Yii::app()->product->getProduct($product_split[0]);
            $data['product_key'][$i] = $key;
            $i++;
        }
        $data['shipping'] = Yii::app()->cartRules->loadRules();
        $data['countries'] = Library::getCountries();
        $data['shipping_required'] = Yii::app()->cart->hasShipping();
        if (!$json['error']) {
            $json['output'] = $this->renderPartial("checkout/customer", array('data' => $data), true);
        }
        echo json_encode($json);
    }

    public function sessionAddress($input) {
        if ($_SESSION['user_id'] != "") { //user
            if ($input['data']['billing_address'] != "") {
                //$billingRow = CustomerAddress::model()->find('id_customer_address=' . $input['data']['billing_address']);
                unset($_SESSION['address']['billing']);
                //$_SESSION['address']['billing'] = $billingRow->attributes;
				$_SESSION['address']['billing'] = Yii::app()->customer->getAddress($input['data']['billing_address']);
            }

            if ($input['data']['shipping_address'] != "") {
                //$shippingRow = CustomerAddress::model()->find('id_customer_address=' . $input['data']['shipping_address']);
                unset($_SESSION['address']['shipping']);
                //$_SESSION['address']['shipping'] = $shippingRow->attributes;
				$_SESSION['address']['shipping'] = Yii::app()->customer->getAddress($input['data']['shipping_address']);
            }
        } else { //guest
        }
    }

    public function actionOrdermethod() {
        $json = array();
        $app = Yii::app();
        $data['confirmButton'] = 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($app->cart->hasShipping()) {
                unset($_SESSION['shipping_method']);
                if (isset($_POST['shipping_method'])) {
                    $_SESSION['shipping_method'] = $app->shipping->getMethod($_POST['shipping_method']);
                } else {
                    $json['error']['shipping'] = 'Please select shipping method!!';
                }
                //echo '<pre>';print_r($_SESSION['shipping_method']);echo '</pre>';//exit;

                if (!isset($_SESSION['shipping'])) {
                    $json['error']['shipping_address'] = 'Shipping address not available!!';
                    $json['redirect'] = $this->createUrl('checkout/checkout');
                }
            }

            unset($_SESSION['payment_method']);
            if (isset($_POST['payment_method'])) {
                $_SESSION['payment_method'] = $app->payment->getMethod($_POST['payment_method']);
            } else {
                $json['error']['payment'] = 'Please select payment method!!';
            }

            if (!isset($_SESSION['billing'])) {
                $json['error']['billing_address'] = 'Payment address not available!!';
                $json['redirect'] = $this->createUrl('checkout/checkout');
            }

            if ($app->config->getData('CONFIG_STORE_CHECKOUT_TERMS') && !isset($_POST['agree'])) {
                $json['error']['agree'] = 'Please agree to terms and conditions!!';
            }


            $products = $app->cart->getProducts();
            foreach ($products as $product) {
                $product_total = 0;

                foreach ($products as $product_2) {
                    if ($product_2['id_product'] == $product['id_product']) {
                        $product_total += $product_2['quantity'];
                    }
                }
                if (!$app->config->getData('CONFIG_STORE_ALLOW_CHECKOUT') && !$product['stock']) {
                    $json['redirect'] = $this->createUrl('checkout/carts');
                }

                if ($product['minimum'] > $product_total) {
                    $json['redirect'] = $this->createUrl('checkout/carts');
                }

                $data['product'][] = array('id_product' => $product['id_product'],
                    'image' => $app->easyImage->thumbSrcOf(Library::getCatalogUploadPath() . $product['image'], array('resize' => array('width' => $app->imageSize->productCart['w'], 'height' => $app->imageSize->productCart['h']))),
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $product['option'],
                    'quantity' => $product['quantity'],
                    'key' => $product['key'],
                    'price' => $app->currency->format($product['price']),
                    'total' => $app->currency->format($product['total'])
                );
            }
            $data['cart_rules'] = $app->cartRules->loadRules();
            //echo '<pre>';print_r($data['cart_rules']);echo '</pre>';
            //echo "value of ".$app->cartRules->total." no result ".$cartRule['total'];
            //echo "value of ".$app->cartRules->total;
            //exit;
            //$data['confirmButton']=!count($json['error'])?'1':'0';
            if (!count($json['error'])) { //no errors,can proceed with order
                //echo '<pre>';print_r($_SESSION['payment_method']);echo '</pre>';exit;

                $order = array();
                $order['id_customer'] = (int) $_SESSION['user_id'];
                $order['id_customer_group'] = isset($_SESSION['user_id']) ? $_SESSION['user_customer_group_id'] : Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_CUSTOMER_GROUP');
                //$cgRow = Customer::getCustomerGroup($order['id_customer_group']);
				$cgRow = Yii::app()->customer->getCustomerGroup($order['id_customer_group']);
                //echo '<pre>';print_r($cgRow);exit;
                $order['customer_group'] = $cgRow['name'];
                $order['firstname'] = isset($_SESSION['user_id']) ? $_SESSION['user_first_name'] : $_SESSION['billing']['firstname'];
                $order['lastname'] = isset($_SESSION['user_id']) ? $_SESSION['user_last_name'] : $_SESSION['billing']['lastname'];
                $order['email_address'] = isset($_SESSION['user_id']) ? $_SESSION['user_email'] : $_SESSION['billing']['email'];
                $order['telephone'] = isset($_SESSION['user_id']) ? $_SESSION['user_telephone'] : $_SESSION['billing']['telephone'];
                $order['delivery_firstname'] = $_SESSION['shipping']['firstname'];
                $order['delivery_lastname'] = $_SESSION['shipping']['lastname'];
                $order['delivery_company'] = $_SESSION['shipping']['company'];
                $order['delivery_address_1'] = $_SESSION['shipping']['address_1'];
                $order['delivery_address_2'] = $_SESSION['shipping']['address_2'];
                $order['delivery_city'] = $_SESSION['shipping']['city'];
                $order['delivery_postcode'] = $_SESSION['shipping']['postcode'];
                $order['delivery_state'] = $_SESSION['shipping']['state'];
                $order['id_state_delivery'] = $_SESSION['shipping']['id_state'];
                $order['delivery_country'] = $_SESSION['shipping']['country'];
                $order['id_country_delivery'] = $_SESSION['shipping']['id_country'];
                $order['shipping_method'] = empty($_SESSION['shipping_method']['title']) ? '' : $_SESSION['shipping_method']['title'];
                $order['shipping_method_code'] = empty($_SESSION['shipping_method']['id']) ? '' : $_SESSION['shipping_method']['id'];
                $order['billing_firstname'] = $_SESSION['billing']['firstname'];
                $order['billing_lastname'] = $_SESSION['billing']['lastname'];
                $order['billing_company'] = $_SESSION['billing']['company'];
                $order['billing_address_1'] = $_SESSION['billing']['address_1'];
                $order['billing_address_2'] = $_SESSION['billing']['address_2'];
                $order['billing_city'] = $_SESSION['billing']['city'];
                $order['billing_postcode'] = $_SESSION['billing']['postcode'];
                $order['billing_state'] = $_SESSION['billing']['state'];
                $order['billing_country'] = $_SESSION['billing']['country'];
                $order['id_state_billing'] = $_SESSION['billing']['id_state'];
                $order['id_country_billing'] = $_SESSION['billing']['id_country'];
                $order['payment_method'] = $_SESSION['payment_method']['module'];
                $order['payment_method_code'] = $_SESSION['payment_method']['id'];
                $order['id_order_status'] = 0;
                $order['order_status_name'] = '';
                $order['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $order['total'] = $app->cartRules->total;
                $order['language_code'] = $_SESSION['language'];
                $languages = Yii::app()->config->getData('languages');
                $order['id_language'] = $languages[$_SESSION['language']]['id_language'];
                $order['currency'] = $_SESSION['currency'];

                $currencies = Yii::app()->config->getData('currencies');
                $order['currency_value'] = $currencies[$_SESSION['currency']]['value'];
                $order['message'] = '';
                $product_data = array();

                foreach (Yii::app()->cart->getProducts() as $product) {
                    $option_data = array();

                    foreach ($product['option'] as $option) {
                        $option_data[] = array(
                            'id_product_option' => $option['id_product_option'],
                            'id_product_option_value' => $option['id_product_option_value'],
                            'id_product_option' => $option['id_product_option'],
                            'id_product_option_value' => $option['id_product_option_value'],
                            'id_option' => $option['id_option'],
                            'id_option_value' => $option['id_option_value'],
                            'name' => $option['name'],
                            'value' => $option['option_value'],
                            'type' => $option['type']
                        );
                    }

                    $product_data[] = array(
                        'id_product' => $product['id_product'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'has_download' => $product['download_status'],
                        'download_filename' => $product['download_filename'],
                        'download_mask' => $product['download_mask'],
                        'download_remaining_count' => $product['download_allowed_count'],
                        'download_expiry_date' => date('Y-m-d H:i:s', strtotime($Date . ' + ' . (int) $product['download_allowed_days'] . ' days')),
                        'quantity' => $product['quantity'],
                        'subtract' => $product['subtract'],
                        'unit_price' => $product['price'],
                        'total' => $product['total'],
                        'tax' => ''//$this->tax->getRate($product['tax_class_id'])
                    );
                }
                $order['cartrules'] = $data['cart_rules']['cartRule'];
                $order['products'] = $product_data;
                //echo '<pre>';print_r($order);echo '</pre>';exit;
                $_SESSION['id_order'] = Yii::app()->order->create($order);
                //exit;
                $data['addParams'] = $app->payment->getAdditionalParams();
                $json['confirmButton'] = $this->renderPartial('checkout/confirmbutton', array("data" => $data), true);
                ;
            } else {
                $json['confirmButton'] = "";
            }

            $json['checkoutOrder'] = $this->renderPartial('checkout/checkoutorder', array("data" => $data), true);
        } else {
            $hasShipping = Yii::app()->cart->hasShipping(); //1 if yes,0 if no
            //Yii::app()->cart->calculateWeight();

            $data['shipping_required'] = $hasShipping;
            $data['shipping_methods'] = $hasShipping ? $app->shipping->getMethods() : '';
            $data['payment_methods'] = $app->payment->getMethods();
            $_SESSION['shipping_methods'] = $data['shipping_methods'];
            $_SESSION['payment_methods'] = $data['payment_methods'];

            $data['terms'] = $app->config->getData['CONFIG_STORE_CHECKOUT_TERMS'] != 0 ? 'i have read and agree to the terms & conditions' : "";

            if (Yii::app()->config->getData('CONFIG_STORE_CHECKOUT_TERMS')) {
                $data['terms'] = $app->page->getContent(Yii::app()->config->getData('CONFIG_STORE_CHECKOUT_TERMS'));
            }

            $json['output'] = $this->renderPartial('checkout/checkoutmethod', array('data' => $data, 'cofirm' => $confirm), true);
        }
        echo json_encode($json);
    }
}