<?php

class ProductController extends BaseController {

    public $position;
    public $data;
    public $url;

	public function filters()
    {
      return array('ajaxOnly + Addtocompare,Uploadfile');
    }

	public function ActionbrandProducts() {
        $app=Yii::app();
        $request=$app->request;
        $route='product/brandproducts';
        
        $data['sort']=Yii::app()->request->getParam('sort','p.sort_order');
        $data['order']=Yii::app()->request->getParam('order','ASC');
        
        $sort_data['page']=Yii::app()->request->getParam('page');
        if (isset($_GET['sort'])) {
            $sort_data['sort'] = $_GET['sort'];
        } else {
            $sort_data['sort'] = 'p.sort_order';
        }

        if (isset($_GET['order'])) {
            $sort_data['order'] = $_GET['order'];
        } else {
            $sort_data['order'] = 'ASC';
        }

        if (isset($_GET['brands'])) {
            $sort_data['manufacturer_ids'] = $_GET['brands'];
        }

        if (isset($_GET['discount'])) {
            $sort_data['discount'] = $_GET['discount'];
        }

        if (isset($_GET['attribute'])) {
            $sort_data['attribute'] = $_GET['attribute'];
        }
        
        if (isset($_GET['option'])) {
            $sort_data['option'] = $_GET['option'];
        }
        
        if (isset($_GET['priceranga'])) {
            $sort_data['priceranga'] = $_GET['priceranga'];
        }
        
        $data['sorts'] = array();
        $data['sorts'][] = array(
            'text' => "Default",
            'value' => 'p.sort_order-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.sort_order','order' => 'ASC')))
        );

        $data['sorts'][] = array(
            'text' => "Price (Low > High)",
            'value' => 'p.price-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.price','order' => 'ASC')))
        );

        $data['sorts'][] = array(
            'text' => "Price (High > Low)",
            'value' => 'p.price-DESC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.price','order' => 'DESC')))
        );
        
        if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS'))
        {
            $data['sorts'][] = array(
                'text' => "Rating (High > Low)",
                'value' => 'rating-DESC',
                'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'rating','order' => 'DESC')))
            );

            $data['sorts'][] = array(
                'text' => "Rating (Low > High)",
                'value' => 'rating-ASC',
                'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'rating','order' => 'ASC')))
            );
        }
        
        $data['sorts'][] = array(
            'text' => "Popular",
            'value' => 'p.viewed-DESC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.viewed','order' => 'DESC')))
        );
        
        $data['sorts'][] = array(
            'text' => "Whats New",
            'value' => 'p.date_product_available-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.date_product_available','order' => 'ASC')))
        );
	
        $manufacturer_id=isset($_GET['manufacturer_id'])?(int)$_GET['manufacturer_id']:0;
        //$sort_data['category_lists']='';
        $sort_data['manufacturer_ids']=$manufacturer_id;
        $data['total']=$app->product->getTotalProducts($sort_data);
        
        $pages = new CPagination((int)$data['total']);
        $pages->pageSize = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        
        $pages->route = $route;
        $page=$request->getParam('page');
        if (!empty($page)) {
                $from = (Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE') * ($page - 1)) + 1;
        } else {
                $from =  1;
        }

        if (($page) > 1) {
                $to = (Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE') * ($page));
        } else {
                $to = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        }

        if ($data['total'] < $to) {
                $to = $data['total'];
        }

        $data['pagination_desc']="Displaying ".$from."-".$to." of ".$data['total']." Results";;
        $sort_data['limit']=Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        $products=$app->product->getProducts($sort_data);
        //echo '<pre>';print_r($products);echo '</pre>';
        //exit("value of ".sizeof($products)." products and total ".$data['total']);
        //print_r($products);
        
        $login_show_price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || 
                (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?true:false;
        foreach($products as $product)
        {
            $image=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h'])));
            //CONFIG_STORE_SHOW_PRICE_WITH_TAX
            $tax=$app->tax->calculate($product['price'],$product['id_tax_class'],true);
            if($tax['amount'])
            {
                $taxInfo="";
                foreach($tax['details'] as $details)
                {
                        $taxInfo.=$plus.$details['name'].' : '.$app->currency->format($details['amount']);
                        $plus='+';        
                }
                $taxInfo="Including (".$taxInfo.")";
            }
            
            $price=$login_show_price?$app->currency->format($product['price']+$tax['amount']):false;
            
            //$price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?$app->currency->format($product['price']):false;
            
            $rating=$app->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1?$product['rating']:false;
            
            //$special=isset($product['special'])?$app->currency->format($product['special']):false;
            $price_special=$login_show_price && isset($product['special'])?$app->currency->format($product['special']+$tax['amount']):false;
            $group=array();
            foreach($product['group_products'] as $group_product)
            {
                $group[]=array('product_id'=>$group_product['id_product'],'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$group_product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))));
            }
            
                        //special_prices
            $special_price="";
            $special_prices=array();
            if(sizeof($product['special_prices'])>0)
            {
                foreach($product['special_prices'] as $special)
                {
                    $special_price=$login_show_price?$app->currency->format($special['price']):false;
                    $special_prices[]=array('price'=>$special_price,
                                            'quantity'=>$special['quantity'],
                                            'label'=>Yii::t('product','text_product_special',array('price'=>$special_price,'quantity'=>$special['quantity'])));
                }
            }
            
            $data['products'][]=array('product_id'=>$product['product_id'],
                'image'=>$image,
                'name'=>$product['name'],
                'full_name'=>$product['full_name'],
                'taxInfo'=>$taxInfo,
                'quantity'=>$product['quantity'],
                'stock_status'=>$product['stock_status'],
                'manufacturer'=>$product['manufacturer'],
                'price'=>$price,
                //'special'=>$special,
                'special'=>$price_special,
                'special_prices'=>$special_prices,
                'rating'=>$rating,
                'group'=>$group,
                'minimum'=>$product['minimum'],
                'model'=>$product['model'],
                );
           
        }
        $brand=$app->brand->getBrand($manufacturer_id);    
        
        $data['brand']['name']=$brand['name'];
        $data['brand']['href']=$this->createUrl('product/brandproducts',array('manufacturer_id'=>$manufacturer_id));
        $data['brand']['description']=$brand['description'];
        $data['brand']['image']=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$brand['image'],array('resize' => 
            array('width' => $app->imageSize->brandThumb['w'],'height' => $app->imageSize->brandThumb['h'])));
        $this->position = Yii::app()->module->prepare('productlisting');
        $this->breadcrumbs = $this->data['breadcrumbs'];
        $this->metatitle=$brand['meta_title'];
        $this->metakeywords=$brand['meta_keywords'];
        $this->metadescription=$brand['meta_description'];
        //echo '<pre>';print_r($app->imageSize->brandThumb);echo '</pre>';
        $this->render("product/brandproducts", array('data' => $data, 'pages' => $pages));
    }

	    public function ActionCategory() {
        
        //echo '<pre>';print_r($_GET);echo '</pre>';exit;
        $app=Yii::app();
        $request=$app->request;
        $route='product/category';
        $data['sort']=Yii::app()->request->getParam('sort','p.sort_order');
        $data['order']=Yii::app()->request->getParam('order','ASC');
        //$request->getParam('sort','p.sort_order')
        $sort_data['page']=Yii::app()->request->getParam('page');
        if (isset($_GET['sort'])) {
            $sort_data['sort'] = $_GET['sort'];
        } else {
            $sort_data['sort'] = 'p.sort_order';
        }

        if (isset($_GET['order'])) {
            $sort_data['order'] = $_GET['order'];
        } else {
            $sort_data['order'] = 'ASC';
        }

        if (isset($_GET['brands'])) {
            $sort_data['manufacturer_ids'] = $_GET['brands'];
        }

        if (isset($_GET['discount'])) {
            $sort_data['discount'] = $_GET['discount'];
        }

        if (isset($_GET['attribute'])) {
            $sort_data['attribute'] = $_GET['attribute'];
        }
        
        if (isset($_GET['option'])) {
            $sort_data['option'] = $_GET['option'];
        }
        
        if (isset($_GET['priceranga'])) {
            $sort_data['priceranga'] = $_GET['priceranga'];
        }
        
        $data['sorts'] = array();
        $data['sorts'][] = array(
            'text' => "Default",
            'value' => 'p.sort_order-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.sort_order','order' => 'ASC')))
        );

        $data['sorts'][] = array(
            'text' => "Price (Low > High)",
            'value' => 'p.price-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.price','order' => 'ASC')))
        );

        $data['sorts'][] = array(
            'text' => "Price (High > Low)",
            'value' => 'p.price-DESC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.price','order' => 'DESC')))
        );
        if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS'))
        {
            $data['sorts'][] = array(
                'text' => "Rating (High > Low)",
                'value' => 'rating-DESC',
                'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'rating','order' => 'DESC')))
            );

            $data['sorts'][] = array(
                'text' => "Rating (Low > High)",
                'value' => 'rating-ASC',
                'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'rating','order' => 'ASC')))
            );
        }
        
        $data['sorts'][] = array(
            'text' => "Popular",
            'value' => 'p.viewed-DESC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.viewed','order' => 'DESC')))
        );
        
        $data['sorts'][] = array(
            'text' => "Whats New",
            'value' => 'p.date_product_available-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.date_product_available','order' => 'ASC')))
        );

        //$_GET['category_id']='11_37_51_52';
        $parts = explode("_", $_GET['category_id']);
        $composeid="";
        foreach(explode("_", $_GET['category_id']) as $cid)
        {
            $composeid.=$pre.$cid;
            $pre='_';
            $categoryDetails=$app->category->getCategory(array('id_category'=>(int)$cid));
            //echo $cid."<br/>";
            $this->data['breadcrumbs'][$categoryDetails['name']] = $this->createUrl($route,array('category_id'=>$composeid));
        
            $category_id=$cid;
        }
        $sort_data['category_lists']=$category_id;
        
        $data['total']=$app->product->getTotalProducts($sort_data);
                
        $pages = new CPagination($data['total']);
        $pages->pageSize = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        
        $pages->route = $route;
        $page=$request->getParam('page');
        if (!empty($page)) {
                $from = (Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE') * ($page - 1)) + 1;
        } else {
                $from =  1;
        }

        if (($page) > 1) {
                $to = (Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE') * ($page));
        } else {
                $to = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        }

        if ($data['total'] < $to) {
                $to = $data['total'];
        }

        $data['pagination_desc']="Displaying ".$from."-".$to." of ".$data['total']." Results";;
        
		$sort_data['limit']=Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        $products=$app->product->getProducts($sort_data);
        
        $login_show_price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || 
                (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?true:false;
        foreach($products as $product)
        {
            $image=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h'])));
            //CONFIG_STORE_SHOW_PRICE_WITH_TAX
            $tax=$app->tax->calculate($product['price'],$product['id_tax_class'],true);
            if($tax['amount'])
            {
                $taxInfo="";
                foreach($tax['details'] as $details)
                {
                        $taxInfo.=$plus.$details['name'].' : '.$app->currency->format($details['amount']);
                        $plus='+';        
                }
                $taxInfo="Including (".$taxInfo.")";
            }
            
            $price=$login_show_price?$app->currency->format($product['price']+$tax['amount']):false;
            
            $rating=$app->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1?$product['rating']:false;
            
            $price_special=$login_show_price && isset($product['special'])?$app->currency->format($product['special']+$tax['amount']):false;
            
            $group=array();

            foreach($product['group_products'] as $group_product)
            {
                $group[]=array('product_id'=>$group_product['id_product'],'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$group_product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))));
            }
            
            //special_prices
            $special_price="";
            $special_prices=array();
            if(sizeof($product['special_prices'])>0)
            {
                foreach($product['special_prices'] as $special)
                {
                    $special_price=$login_show_price?$app->currency->format($special['price']):false;
                    $special_prices[]=array('price'=>$special_price,
                                            'quantity'=>$special['quantity'],
                                            'label'=>Yii::t('product','text_product_special',array('price'=>$special_price,'quantity'=>$special['quantity'])));
                }
            }
            
            $data['products'][]=array('product_id'=>$product['product_id'],
                                    'image'=>$image,
                                    'name'=>$product['name'],
                                    'full_name'=>$product['full_name'],
                                    'taxInfo'=>$taxInfo,        
                                    'quantity'=>$product['quantity'],
                                    'stock_status'=>$product['stock_status'],
                                    'manufacturer'=>$product['manufacturer'],
                                    'price'=>$price,
                                    'special'=>$price_special,
                                    'special_prices'=>$special_prices,
                                    'rating'=>$rating,
                                    'group'=>$group,
                                    'minimum'=>$product['minimum'],
                                    'model'=>$product['model'],
                            );
           
        }
        //echo '<pre>';print_r($categoryDetails);echo '</pre>';
        $data['catagorydetails']['name'] = $categoryDetails['name'];
        $data['catagorydetails']['description'] = html_entity_decode($categoryDetails['description'],ENT_QUOTES, 'UTF-8');
        $data['catagorydetails']['image'] = $app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$categoryDetails['image'],array('resize' => array('width' => $app->imageSize->categoryThumb['w'],'height' => $app->imageSize->categoryThumb['h'])));
        
        $this->position = Yii::app()->module->prepare('productlisting');
        $this->breadcrumbs = $this->data['breadcrumbs'];
        $this->metatitle=$categoryDetails['meta_title'];
        $this->metakeywords=$categoryDetails['meta_keyword'];
        $this->metadescription=$categoryDetails['meta_description'];
        $data['sub_categories']=array();
        //$category_id=0;
        foreach( $app->category->getChildCategories($category_id) as  $category){
            $data['sub_categories'][] =array('id'=>$category['id_category'],
                                             'name'=>$category['name'],
                                             'href'=>$this->createUrl($route,array('category_id'=>$request->getParam('category_id').'_'.$category['id_category'])),
                                             'description'=>$category['description'],
                                             'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$category['image'],array('resize' => array('width' => $app->imageSize->categoryThumb['w'],'height' => $app->imageSize->categoryThumb['h'])))
                                            );
        }
        //echo '<pre>';print_r($data['products']);echo '</pre>';exit;
        $this->render("product/category", array('data' => $data, 'pages' => $pages));
    }
    /*public function ActionCategory() {
        $parts = explode("_", $_GET['category_id']);
        $data['category_count'] = count($parts);
        $category_id = (int) array_pop($parts);
        $data['sorts'] = array();
        $url = '';

        if (isset($_GET['sort'])) {
            $sort_data['sort'] = $_GET['sort'];
        } else {
            $sort_data['sort'] = 'p.sort_order';
        }

        if (isset($_GET['order'])) {
            $sort_data['order'] = $_GET['order'];
        } else {
            $sort_data['order'] = 'ASC';
        }

        if (isset($_GET['brands'])) {
            $sort_data['manufacturer_ids'] = $_GET['brands'];
        } else {
            $sort_data['manufacturer_ids'] = '';
        }

        if (isset($_GET['discount'])) {
            $sort_data['discount'] = $_GET['discount'];
        } else {
            $sort_data['discount'] = '';
        }

        if (isset($_GET['attribute'])) {
            $sort_data['attribute'] = $_GET['attribute'];
        } else {
            $sort_data['attribute'] = '';
        }
        if (isset($_GET['option'])) {
            $sort_data['option'] = $_GET['option'];
        } else {
            $sort_data['option'] = '';
        }
        if (isset($_GET['priceranga'])) {
            $sort_data['priceranga'] = $_GET['priceranga'];
        } else {
            $sort_data['priceranga'] = '';
        }
        if (isset($_GET['sort'])) {
            $data['sort'] = $_GET['sort'];
        } else {
            $data['sort'] = 'p.sort_order';
        }

        if (isset($_GET['order'])) {
            $data['order'] = $_GET['order'];
        } else {
            $data['order'] = 'ASC';
        }
        $data['sorts'][] = array(
            'text' => "Default",
            'value' => 'p.sort_order-ASC',
            'href' => $this->createUrl('product/category',
                    array('category_id' => $category_id, 'sort' => 'p.sort_order',
                'order' => 'ASC', "brands" => $_GET['brands'], "discount" => $_GET['discount'],
                "attribute" => $_GET['attribute'], "option" => $_GET['option'], "priceranga" => $_GET['priceranga']))
        );

        $data['sorts'][] = array(
            'text' => "Price (Low > High)",
            'value' => 'p.price-ASC',
            'href' => $this->createUrl('product/category',
                    array('category_id' => $category_id, 'sort' => 'p.price', 'order' => 'ASC',
                "brands" => $_GET['brands'], "discount" => $_GET['discount'], "attribute" => $_GET['attribute'],
                "option" => $_GET['option'], "priceranga" => $_GET['priceranga']))
        );

        $data['sorts'][] = array(
            'text' => "Price (High > Low)",
            'value' => 'p.price-DESC',
            'href' => $this->createUrl('product/category',
                    array('category_id' => $category_id, 'sort' => 'p.price', 'order' => 'DESC',
                "brands" => $_GET['brands'], "discount" => $_GET['discount'], "attribute" => $_GET['attribute'],
                "option" => $_GET['option'], "priceranga" => $_GET['priceranga']))
        );
        $data['sorts'][] = array(
            'text' => "Rating (High > Low)",
            'value' => 'rating-DESC',
            'href' => $this->createUrl('product/category',
                    array('category_id' => $category_id, 'sort' => 'rating', 'order' => 'DESC',
                "brands" => $_GET['brands'], "discount" => $_GET['discount'], "attribute" => $_GET['attribute'],
                "option" => $_GET['option'], "priceranga" => $_GET['priceranga']))
        );

        $data['sorts'][] = array(
            'text' => "Rating (Low > High)",
            'value' => 'rating-ASC',
            'href' => $this->createUrl('product/category',
                    array('category_id' => $category_id, 'sort' => 'rating', 'order' => 'ASC',
                "brands" => $_GET['brands'], "discount" => $_GET['discount'], "attribute" => $_GET['attribute'],
                "option" => $_GET['option'], "priceranga" => $_GET['priceranga']))
        );
        $data['sorts'][] = array(
            'text' => "Popular",
            'value' => 'p.viewed-DESC',
            'href' => $this->createUrl('product/category',
                    array('category_id' => $category_id, 'sort' => 'p.viewed', 'order' => 'DESC',
                "brands" => $_GET['brands'], "discount" => $_GET['discount'], "attribute" => $_GET['attribute'],
                "option" => $_GET['option'], "priceranga" => $_GET['priceranga']))
        );
        $data['sorts'][] = array(
            'text' => "Whats New",
            'value' => 'p.date_product_available-ASC',
            'href' => $this->createUrl('product/category',
                    array('category_id' => $category_id, 'sort' => 'p.date_product_available',
                'order' => 'ASC', "brands" => $_GET['brands'], "discount" => $_GET['discount'],
                "attribute" => $_GET['attribute'], "option" => $_GET['option'], "priceranga" => $_GET['priceranga']))
        );


        $category = new Category;
        $sort_data['category_lists'] = $category->getCategoryArrayList($category_id);
        $data['category_sub_lists'] = $category->getSubCategoryList($category_id);
        $getCategoryDetails = $category->getCategoryDetails($category_id);
         
        if (count(explode("_", $_GET['category_id'])) == 1) {
            $this->data['breadcrumbs'] = array($getCategoryDetails['name'] => Yii::app()->request->requestUri);
        } else {
            $getTopCategory = $category->getCategoryDetails($parts[0]);
            $this->data['breadcrumbs'] = array($getTopCategory['name'] => $this->createUrl('/product/category',
                        array('category_id' => $parts[0])), $getCategoryDetails['name'] => Yii::app()->request->requestUri);
            //$this->data['breadcrumbs'][]=array();
        }
        $data['pagination_data']['url'] = Yii::app()->params['config']['site_url'] . "index.php/product/category?category_id=" . $_GET['category_id'];
        $product = new Product;
        $sort_data['pagination'] = false;
        $data['pagination_data']['count'] = count($product->getProducts($sort_data));
        $pages = new CPagination($data['pagination_data']['count']);
        $pages->pageSize = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        $pages->route = 'product/category';

        $data['dispaly_pagination'] = $this->displayPaginationStatus($_GET['page'],
                $data['pagination_data']['count']);
        $sort_data['pagination'] = true;
        $data['products'] = $product->getProducts($sort_data);
        $data['catagorydetails']['name'] = $getCategoryDetails['name'];
        $data['catagorydetails']['meta_title'] = $getCategoryDetails['meta_title'];
        $data['catagorydetails']['meta_keyword'] = $getCategoryDetails['meta_keyword'];
        $data['catagorydetails']['meta_description'] = $getCategoryDetails['meta_description'];
        $data['catagorydetails']['description'] = html_entity_decode($getCategoryDetails['description'],ENT_QUOTES, 'UTF-8');
        $data['catagorydetails']['image'] = $getCategoryDetails['image'];
        $this->position = Yii::app()->module->prepare('productlisting');
        $this->breadcrumbs = $this->data['breadcrumbs'];

        $this->render("product/category", array('data' => $data, 'pages' => $pages));
    }*/

    //display pagination
    public function displayPaginationStatus($page, $total_list) {
        $pages = $page;
        if (!empty($page)) {
            $start_count = (Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE') * ($page - 1)) + 1;
        } else {
            $start_count = $page + 1;
        }
        if (($pages) > 1) {
            $ranga_count = (Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE') * ($pages));
        } else {
            $ranga_count = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        }
        if ($total_list < $ranga_count) {
            $ranga_count = $total_list;
        }
        return "Displaying $start_count-$ranga_count of $total_list Results";
    }

	public function ActionProductdetails() {
        $app=Yii::app();
        $product_id = (int)$_GET['product_id'];
        $categoryBreadCrumb=array();
        $categoryId=$app->category->getCategoryByProduct($product_id);
        if((int)$categoryId!=0)
        {
            $categories=$app->category->getCategoryTree($categoryId);
            if($categories)
            {
                $categories=array_reverse($categories,true);
                foreach($categories as $id=>$name)
                {
                    $cid.=$pre.$id;
                    $pre='_';
                    $categoryBreadCrumb[$name]=$this->createUrl('product/category',array('category_id'=>$cid));
                }
            }
        }
        if($app->config->getData('CONFIG_STORE_ALLOW_REVIEWS'))
        {
            $data['reviews'] = true;
            $data['reviews_data'] =$app->product->getReviews($product_id);
            //$data['reviews']=array();
        }else
        {
            $data['reviews']=false;
        }
        
        $groupData=$app->product->getGroupProducts(array('product_id'=>$product_id,'displayInListing'=>1));
        foreach($groupData['products'] as $product)
        {
            $data['group']['products'][]=array('name'=>$product['name'],
                        'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))),
                        'id_product'=>$product['id_product'],
                        );
        }
        $data['group']['lable']=$groupData['group']['lable'];
        
        //start other group
        $data['product']['otherGroup']=$app->product->getOtherGroupProducts(array('product_id'=>$product_id));
        
        //end other group
        
        $product = $app->product->getProduct($product_id);
        
        //echo '<pre>';print_r($otherGroupData);print_r($data['group']);print_r($product);echo '</pre>';exit;
        $this->breadcrumbs=array_merge($categoryBreadCrumb,array($product['name']=>$product['id_product']));
        
        foreach($app->product->getProductImages($product_id) as $image)
        {
             $data['product']['images'][]=array('icon'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$image['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))),
                     'thumb'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$image['image'],array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h']))),
                    'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$image['image'],array('resize' => array('width' => $app->imageSize->productPopup['w'],'height' => $app->imageSize->productPopup['h']))));   
        }
        $data['attributes'] = $app->product->getProductAttributes($product_id);
       
        foreach ($app->product->getProductOptions($product_id) as $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox') {
                $option_value_data = array();

                foreach ($option['option_value'] as $option_value) {
                    $option_name="";
                    if ((float)$option_value['price']) 
                    {
                            if($option_value['price_prefix']=='+')
                            {
                                    $option_name=Yii::t('product','text_option_name_plus',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));
                            }else if($option_value['price_prefix']=='-')
                            {
                                    $option_name=Yii::t('product','text_option_name_minus',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));

                            }else //if($option_value['price_prefix']=='=')
                            {
                                    $option_name=Yii::t('product','text_option_name_assign',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));
                            }
                }else
                {
                    
                    $option_name=Yii::t('product','text_option_name',array('name'=>$option_value['name']));   
                     
                }
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        $option_value_data[] = array(
                            'id_product_option_value' => $option_value['id_product_option_value'],
                            'id_option_value' => $option_value['id_option_value'],
                            'name' => $option_name,//$option_value['name'],
                            'image' => $option_value['image'],
                            'price' => (float)$option_value['price']?$app->currency->format($option_value['price']):false,
                            'price_prefix' => $option_value['price_prefix']
                        );
                    }
                }
                
                $data['product']['options'][] = array(
                    'id_product_option' => $option['id_product_option'],
                    'id_option' => $option['id_option'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option_value_data,
                    'required' => $option['required']
                );
            } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                $data['product']['options'][] = array(
                    'id_product_option' => $option['id_product_option'],
                    'id_option' => $option['id_option'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option['option_value'],
                    'required' => $option['required']
                );
            }
        }
        
        $data['product']['name']=$product['name'];
        $data['product']['full_name']=$product['full_name'];
        $data['product']['id_product']=$product['product_id'];
        $data['product']['description']=$product['description'];
        $data['product']['model']=$product['model'];
        $data['product']['sku']=$product['sku'];
        $data['product']['upc']=$product['upc'];
        $data['product']['quantity']=$product['quantity'];
        $data['product']['stock_status']=$product['stock_status'];
        $data['product']['image']=array('icon'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],
                array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))),'thumb'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],
                array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h']))),
            'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],
                array('resize' => array('width' => $app->imageSize->productPopup['w'],'height' => $app->imageSize->productPopup['h']))));
        $data['product']['images'][]=$data['product']['image'];
                //array('image'=>$data['product']['image'],'thumb'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],                array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))));
        $data['product']['manufacturer']=$product['manufacturer'];
        $data['product']['manufacturer_image']=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['manufacturer_image'],
                array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h'])));
        $login_show_price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || 
                (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?true:false;
        $tax=$app->tax->calculate($product['price'],$product['id_tax_class'],true);
        //echo '<pre>';print_r($tax);echo '</pre>';exit;
        if($tax['amount'])
        {
            $taxInfo="";
            foreach($tax['details'] as $details)
            {
                $taxInfo.=$plus.$details['name'].' : '.$app->currency->format($details['amount']);
                $plus='+';        
            }
            $data['product']['taxInfo']="Including (".$taxInfo.")";
        }
        $data['product']['price']=$login_show_price?$app->currency->format($product['price']+$tax['amount']):false;
        $data['product']['special']=$login_show_price && isset($product['special'])?$app->currency->format($product['special']+$tax['amount']):false;
        //$data['product']['special_quantity']=$product['special_quantity'];
        if(sizeof($product['special_prices'])>0)
        {
            
            foreach($product['special_prices'] as $special)
            {
                $special_price=$login_show_price?$app->currency->format($special['price']):false;
                $special_prices[]=array('price'=>$special_price,
                                        'quantity'=>$special['quantity'],
                                        'label'=>Yii::t('product','text_product_special',array('price'=>$special_price,'quantity'=>$special['quantity'])));
            }
        }
        $data['product']['special_prices']=$special_prices;
        $data['product']['minimum']=$product['minimum'];
        if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS')){
            $data['product']['reviews']=$product['reviews'];
            $data['product']['rating']=$product['rating'];
        }else
        {
            $data['product']['reviews']=false;
            $data['product']['rating']=false;
        }
        $this->metatitle=$product['full_name'];
        $this->metakeywords=$product['meta_keywords'];
        $this->metadescription=$product['meta_description'];
        $data['product']['href']=$this->createUrl('product/category',array('product_id'=>$product['product_id']));
        //echo '<pre>';print_r($product);echo '</pre>';//exit;
        $app->product->updateProductViews($product['product_id']);
        $_SESSION['rvp'][$product['product_id']]=$product['product_id'];
		$this->render("product/product-details", array('data' => $data));
    }
    //product details
    /*public function ActionProductdetails() {
        $product = new Product;
        $category = new Category;
        $catalog = new Catalog;
        $product_id = (int) $_GET['product_id'];
        $data['product_reviews'] = $catalog->getReviewsList($product_id);
        $data['product_groups'] = $product->getGroupedProducts($product_id);
        $data['product'] = $product->getProduct($product_id);
        $data['attribute'] = $catalog->getProductAttributes($product_id);
        $data['product_images'] = $product->getProductImages($product_id);
//		echo "<pre>";print_r($data['product_images']);echo "</pre>";exit;
        $parent_id = $category->getParentCategoryDetails($data['product']['category_id']);
        $category_list = array_merge($parent_id,
                (array) $data['product']['category_id']);
        foreach ($product->getProductOptions($product_id) as $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                $option_value_data = array();

                foreach ($option['option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        $option_value_data[] = array(
                            'product_option_value_id' => $option_value['product_option_value_id'],
                            'option_value_id' => $option_value['option_value_id'],
                            'name' => $option_value['name'],
                            'image' => $option_value['image'],
                            'price' => $price,
                            'price_prefix' => $option_value['price_prefix']
                        );
                    }
                }

                $data['product']['options'][] = array(
                    'product_option_id' => $option['product_option_id'],
                    'option_id' => $option['option_id'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option_value_data,
                    'required' => $option['required']
                );
            } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                $data['product']['options'][] = array(
                    'product_option_id' => $option['product_option_id'],
                    'option_id' => $option['option_id'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option['option_value'],
                    'required' => $option['required']
                );
            }
        }
        //echo "<pre>";print_r($data);exit;
        foreach ($category_list as $clist) {
            $category_details = $category->getCategoryDetails($clist);
            $this->breadcrumbs[$category_details['name']] = $this->createUrl('product/category',
                    array('category_id' => $category_details['id_category']));
        }
        $this->breadcrumbs[$data['product']['name']] = $this->createUrl('product/productdetails',
                array('product_id' => $data['product']['product_id']));
        $this->render("product/product-details", array('data' => $data));
    }*/

    public function ActionCaptcha() {
        Yii::app()->captcha->showImage();
    }

    public function ActionReview() {

        $json = array();
        if (empty($_POST['review_title'])) {
            $json['error'] = 'Please enter your name';
        } elseif (empty($_POST['review_description']) || strlen($_POST['review_description']) < 25 && strlen($_POST['review_description']) > 1000) {
            $json['error'] = 'Review Text must be between 25 and 1000 characters!';
        } elseif (empty($_POST['rating'])) {
            $json['error'] = 'Please give a rating!!';
        } elseif (empty($_POST['review_code']) || Yii::app()->session['captcha_code'] != $_POST['review_code']) {
            $json['error'] = 'Verification code failed.Please try again!!';
        }

        if (empty($json['error'])) {
            Yii::app()->product->addReview();
            $json['success'] = 'Thanks for your review!!';
        }
        echo json_encode($json);
    }

	 public function ActionAddproducttocompare() {
        $app=Yii::app();
        $product_id=(int)$_POST['product_id'];
        //print("value of ".$product_id);
        if (count($app->session['user_compare']) <= 4) {
            if (!empty($app->session['user_compare'])) {
                $app->session['user_compare'] = array_unique(array_merge(Yii::app()->session['user_compare'],
                                (array) $product_id));
            } else {
                $app->session['user_compare'] = array();
                $app->session['user_compare'] = (array) $product_id;
            }
        }
        if (!empty($app->session['user_compare'])) {
            echo json_encode(array("success" => "You have added to your <a href='" . $this->createUrl('product/compare') . "'>Product comparison</a>!"));
        } else {
            echo json_encode(array("success" => "some-thing wrong try again"));
        }
    }

    public function ActionAddtocompare() {
        if (count(Yii::app()->session['user_compare']) <= 4) {
            if (!empty(Yii::app()->session['user_compare'])) {
                Yii::app()->session['user_compare'] = array_unique(array_merge(Yii::app()->session['user_compare'],
                                (array) $_POST['product_id']));
            } else {
                Yii::app()->session['user_compare'] = array();
                Yii::app()->session['user_compare'] = (array) $_POST['product_id'];
            }
        }
        if (!empty(Yii::app()->session['user_compare'])) {
            echo json_encode(array("success" => "You have added to your <a href='" . $this->createUrl('product/compare') . "'>Product comparison</a>!"));
        } else {
            echo json_encode(array("success" => "some-thing wrong try again"));
        }
    }

     public function ActionCompare() {
        $app=Yii::app();
        $this->breadcrumbs = array("Compare" => $this->createUrl('product/compare'));
        $compare_product = Yii::app()->session['user_compare'];
        //echo '<pre>';
        //remove
        if(isset($_GET['product_id']))
        {
            if (($key = array_search($_GET['product_id'], $compare_product)) !== false) {
                unset($compare_product[$key]);
            }
            $app->session['user_compare'] = $compare_product;
            $this->redirect($this->createUrl('product/compare'));
        }
        
        $displayPrice=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?true:false;
        $displayRating=$app->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1?true:false;
        $data['displayPrice']=$displayPrice;
        $data['displayRating']=$displayRating;

        foreach ($app->session['user_compare'] as $key => $product_id) {
            $product_info = $app->product->getProduct($product_id);
            //echo '<pre>';print_r($product_info);echo '</pre>';
            if ($product_info) {
                $attribute_data = array();

                $attribute_groups = $app->product->getProductAttributes($product_id);

                foreach ($attribute_groups['General'] as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }
                
                foreach ($attribute_groups['Attribute'] as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }
               // print_r($attribute_groups);
              //exit;  
                $group=array();
                foreach($product_info['group_products'] as $group_product)
                {
                    if($product_info['product_id']==$group_product['id_product']){ continue;}
                    $group[]=array('product_id'=>$group_product['id_product'],'productDetailsLink'=>$this->createUrl('product/productdetails',
                    array('product_id'=>$group_product['id_product'])),'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$group_product['image'],
                    array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))));
                }
                
                if($displayPrice)
                {
                    $price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?
                        $app->currency->format($product_info['price']):false;
                    $special=isset($product['special'])?$app->currency->format($product['special']):false;
                }
                
                if($displayRating){
                    $rating=$app->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1?$product_info['rating']:false;
                }
            

                $data['products'][$product_id] = array(
                    'product_id' => $product_info['product_id'],
                    'name' => $product_info['name'],
                    'full_name' => $product_info['full_name'],
                    'image' => $app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product_info['image'],
                            array('resize' => array('width' => $app->imageSize->productCompare['w'],'height' => $app->imageSize->productCompare['h']))),
                    'price' => $price,
                    'special' =>$special ,
                    'description' => substr(strip_tags(html_entity_decode($product_info['description'],
                                            ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
                    'model' => $product_info['model'],
                    'manufacturer' => $product_info['manufacturer'],
                    //'availability' => $availability,
                    'rating' => $rating,
                    'reviews' => $product_info['reviews'],
                    'weight' => $product_info['weight'],
                    'length' => $product_info['length'],
                    'width' => $product_info['width'],
                    'height' => $product_info['height'],
                    'manufacturer' => $product_info['manufacturer'],
                    'group'=>$group,
                    'model' => $product_info['model'],
                    'quantity' => $product_info['quantity'],
                    'stock_status'=>$product_info['stock_status'],
                    'attribute' => $attribute_data,
                    'deleteLink' => $this->createUrl('product/compare',array('product_id'=>$product_info['product_id'])),
                    'productDetailsLink' => $this->createUrl('product/productdetails',array('product_id'=>$product_info['product_id'])),
                );
                
                foreach ($attribute_groups['General'] as $attribute_group) {
                    $data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];

                    foreach ($attribute_group['attribute'] as $attribute) {
                        $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
                    }
                }
                
                foreach ($attribute_groups['Attribute'] as $attribute_group) {
                    $data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];

                    foreach ($attribute_group['attribute'] as $attribute) {
                        $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
                    }
                }
            }
        }
        //echo "<pre>";print_r($product_info);print_r($data);exit;
        $this->render("product/compare", array('data' => $data));
    }
	
	/*public function ActionCompare() {
        $this->data['breadcrumbs'][] = array(
            'text' => Yii::t('product','text_breadcrumb_productcompare'),
            'href' => $this->createUrl('product/compare'),
        );
        $product = new Product;
        foreach (Yii::app()->session['user_compare'] as $key => $product_id) {
            $product_info = $product->getProduct($product_id);
            if ($product_info) {
                $attribute_data = array();

                $attribute_groups = $product->getProductAttributes($product_id);

                foreach ($attribute_groups as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }

                $data['products'][$product_id] = array(
                    'product_id' => $product_info['product_id'],
                    'name' => $product_info['name'],
                    'image' => $product_info['image'],
                    'price' => ($product_info['discount'] ? $product_info['discount'] : $product_info['price']),
                    'special' => $product_info['special'],
                    'description' => substr(strip_tags(html_entity_decode($product_info['description'],
                                            ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
                    'model' => $product_info['model'],
                    'manufacturer' => $product_info['manufacturer'],
                    'availability' => $availability,
                    'rating' => (int) $product_info['rating'],
                    'reviews' => $product_info['reviews'],
                    'weight' => $product_info['weight'],
                    'length' => $product_info['length'],
                    'width' => $product_info['width'],
                    'height' => $product_info['height'],
                    'manufacturer' => $product_info['manufacturer'],
                    'model' => $product_info['model'],
                    'quantity' => $product_info['quantity'],
                    'attribute' => $attribute_data,
                );

                foreach ($attribute_groups as $attribute_group) {
                    $data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];

                    foreach ($attribute_group['attribute'] as $attribute) {
                        $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
                    }
                }
            }
        }
        echo "<pre>";print_r($data);exit;
        $this->render("product/compare", array('data' => $data));
    }*/

	public function ActionGetproduct()
    {
        $app=Yii::app();
        $product=$app->product->getProduct((int) $_POST['product_id']);
        $login_show_price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || 
                (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?true:false;
        $image=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h'])));

        //CONFIG_STORE_SHOW_PRICE_WITH_TAX
        //$price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?$app->currency->format($product['price']):false;
        $tax=$app->tax->calculate($product['price'],$product['id_tax_class'],true);
        if($tax['amount'])
        {
            $taxInfo="";
            foreach($tax['details'] as $details)
            {
                    $taxInfo.=$plus.$details['name'].' : '.$app->currency->format($details['amount']);
                    $plus='+';        
            }
            $taxInfo="Including (".$taxInfo.")";
        }

        $price=$login_show_price?$app->currency->format($product['price']+$tax['amount']):false;

        $rating=$app->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1?$product['rating']:false;
        $price_special=$login_show_price && isset($product['special'])?$app->currency->format($product['special']+$tax['amount']):false;
        
        //$special=isset($product['special'])?$app->currency->format($product['special']):false;
        //$price_special=$login_show_price && isset($product['special'])?$app->currency->format($product['special']+$tax['amount']):false;
                    //special_prices
            $special_price="";
            $special_prices=array();
            if(sizeof($product['special_prices'])>0)
            {
                foreach($product['special_prices'] as $special)
                {
                    $special_price=$login_show_price?$app->currency->format($special['price']):false;
                    $special_prices[]=array('price'=>$special_price,
                                            'quantity'=>$special['quantity'],
                                            'label'=>Yii::t('product','text_product_special',array('price'=>$special_price,'quantity'=>$special['quantity'])));
                }
            }
        $data['product']=array('product_id'=>$product['product_id'],
                                                        'image'=>$image,
                                                        'name'=>$product['name'],
                                                        'full_name'=>$product['full_name'],
                                                        'quantity'=>$product['quantity'],
                                                        'stock_status'=>$product['stock_status'],
                                                        'manufacturer'=>$product['manufacturer'],
                                                        'price'=>$price,
                                                        //'special'=>$special,
                                                        'special'=>$price_special,
                                                        'special_prices'=>$special_prices,
                                                        'rating'=>$rating,
                                                        'minimum'=>$product['minimum'],
                                                        'model'=>$product['model'],
                                                        );
        //echo '<pre>';print_r($data);exit;
        $this->renderPartial("product/getproduct", array('data' => $data));
    }
    /*public function ActionGetproduct() {
        $product = new Product;
        $product_id = (int) $_POST['product_id'];
        $data['products'] = $product->getProduct($product_id);
        $this->renderPartial("product/getproduct", array('data' => $data));
    }*/

    public function ActionRemovecompare() {
        $compare_product = Yii::app()->session['user_compare'];
        if (($key = array_search($_GET['product_id'], $compare_product)) !== false) {
            unset($compare_product[$key]);
        }
        Yii::app()->session['user_compare'] = $compare_product;
        $this->redirect($this->createUrl('/product/compare'));
    }
public function ActionQuickview() {
        $app=Yii::app();
        $product_id = (int) $_POST['product_id'];
        //$data['product_groups'] = $product->getGroupedProducts($product_id);
        $groupData=  $app->product->getGroupProducts(array('product_id'=>$product_id));
        foreach($groupData['products'] as $product)
        {
            $data['group']['products'][]=array('name'=>$product['name'],
                        'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))),
                        'id_product'=>$product['id_product'],
                        );
        }
        $data['group']['lable']=$groupData['group']['lable'];
        
        $product = $app->product->getProduct($product_id);
        //$data['product']['attributes'] = $app->product->getProductAttributes($product_id);
        //echo '<pre>';        print_r($product);exit;
        //$data['product_images'] = $app->product->getProductImages($product_id);
        foreach($app->product->getProductImages($product_id) as $image)
        {
             $data['product']['images'][]=array('thumb'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$image['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))),
                     'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$image['image'],array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h']))));   
        }
	//echo "<pre>";print_r($app->product->getProductImages($product_id));print_r($data['product']['images']);echo "</pre>";exit;
        
        foreach ($app->product->getProductOptions($product_id) as $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox') {
                $option_value_data = array();
                foreach ($option['option_value'] as $option_value) {
                    $option_name="";
                if ((float)$option_value['price']) 
                {
                    if($option_value['price_prefix']=='+')
                    {
                        $option_name=Yii::t('product','text_option_name_plus',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));
                    }else if($option_value['price_prefix']=='-')
                    {
                        $option_name=Yii::t('product','text_option_name_minus',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));

                    }else //if($option_value['price_prefix']=='=')
                    {
                        $option_name=Yii::t('product','text_option_name_assign',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));
                    }
                }else
                {
                    $option_name=Yii::t('product','text_option_name',array('name'=>$option_value['name']));   
                }
                
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        $option_value_data[] = array(
                            'id_product_option_value' => $option_value['id_product_option_value'],
                            'id_option_value' => $option_value['id_option_value'],
                            'name' => $option_name,
                            'image' => $option_value['image'],
                            'price' => (float)$option_value['price']?$app->currency->format($option_value['price']):false,
                            'price_prefix' => $option_value['price_prefix']
                        );
                    }
                }

                $data['product']['options'][] = array(
                    'id_product_option' => $option['id_product_option'],
                    'id_option' => $option['id_option'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option_value_data,
                    'required' => $option['required']
                );
            } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                $data['product']['options'][] = array(
                    'id_product_option' => $option['id_product_option'],
                    'id_option' => $option['id_option'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option['option_value'],
                    'required' => $option['required']
                );
            }
        }
        $data['product']['name']=$product['full_name'];
        $data['product']['id_product']=$product['product_id'];
        $data['product']['description']=$product['description'];
        $data['product']['model']=$product['model'];
        $data['product']['sku']=$product['sku'];
        $data['product']['upc']=$product['upc'];
        $data['product']['quantity']=$product['quantity'];
        $data['product']['stock_status']=$product['stock_status'];
        $data['product']['image']=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],
                array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h'])));
        $data['product']['images'][]=array('image'=>$data['product']['image'],'thumb'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))));
        $data['product']['manufacturer']=$product['manufacturer'];
        $data['product']['manufacturer_image']=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['manufacturer_image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h'])));
        
		/*$data['product']['price']=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?$app->currency->format($product['price']):false;
        $data['product']['special']=$app->currency->format($product['special']);
        $data['product']['special_quantity']=$product['special_quantity'];*/
        
		$login_show_price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || 
                (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?true:false;
        $tax=$app->tax->calculate($product['price'],$product['id_tax_class'],true);
        //echo '<pre>';print_r($tax);echo '</pre>';exit;
        if($tax['amount'])
        {
            $taxInfo="";
            foreach($tax['details'] as $details)
            {
                $taxInfo.=$plus.$details['name'].' : '.$app->currency->format($details['amount']);
                $plus='+';        
            }
            $data['product']['taxInfo']="Including (".$taxInfo.")";
        }
        $data['product']['price']=$login_show_price?$app->currency->format($product['price']+$tax['amount']):false;
        $data['product']['special']=$login_show_price && isset($product['special'])?$app->currency->format($product['special']+$tax['amount']):false;
        //$data['product']['special_quantity']=$product['special_quantity'];
        if(sizeof($product['special_prices'])>0)
        {
            
            foreach($product['special_prices'] as $special)
            {
                $special_price=$login_show_price?$app->currency->format($special['price']):false;
                $special_prices[]=array('price'=>$special_price,
                                        'quantity'=>$special['quantity'],
                                        'label'=>Yii::t('product','text_product_special',array('price'=>$special_price,'quantity'=>$special['quantity'])));
            }
        }
        $data['product']['special_prices']=$special_prices;
        
		
		
		$data['product']['minimum']=$product['minimum'];
        if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS')){
            $data['product']['reviews']=$product['reviews'];
            $data['product']['rating']=$product['rating'];
        }else
        {
            $data['product']['reviews']=false;
            $data['product']['rating']=false;
        }
        $data['product']['href']=$this->createUrl('product/category',array('product_id'=>$product['product_id']));
        $_SESSION['rvp'][$product['product_id']]=$product['product_id'];
        Yii::app()->product->updateProductViews($product['product_id']);
        //echo '<pre>';print_r($data['product']);print_r($product);exit;
        //echo '<pre>';print_r($data['product']);exit;
        $this->renderPartial('product/quickview', array('data' => $data));
    }
    /*public function ActionQuickview() {
        $app=Yii::app();
        $product_id = (int) $_POST['product_id'];
        //$data['product_groups'] = $product->getGroupedProducts($product_id);
        $groupData=  $app->product->getGroupProducts(array('product_id'=>$product_id));
        foreach($groupData['products'] as $product)
        {
            $data['group']['products'][]=array('name'=>$product['name'],
                        'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))),
                        'id_product'=>$product['id_product'],
                        );
        }
        $data['group']['lable']=$groupData['group']['lable'];
        
        $product = $app->product->getProduct($product_id);
        //$data['product']['attributes'] = $app->product->getProductAttributes($product_id);
        //echo '<pre>';        print_r($product);exit;
        //$data['product_images'] = $app->product->getProductImages($product_id);
        foreach($app->product->getProductImages($product_id) as $image)
        {
             $data['product']['images'][]=array('thumb'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$image['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))),
                     'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$image['image'],array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h']))));   
        }
	//echo "<pre>";print_r($app->product->getProductImages($product_id));print_r($data['product']['images']);echo "</pre>";exit;
        
        foreach ($app->product->getProductOptions($product_id) as $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox') {
                $option_value_data = array();
                foreach ($option['option_value'] as $option_value) {
                    $option_name="";
                if ((float)$option_value['price']) 
                {
                    if($option_value['price_prefix']=='+')
                    {
                        $option_name=Yii::t('product','text_option_name_plus',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));
                    }else if($option_value['price_prefix']=='-')
                    {
                        $option_name=Yii::t('product','text_option_name_minus',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));

                    }else //if($option_value['price_prefix']=='=')
                    {
                        $option_name=Yii::t('product','text_option_name_assign',array('name'=>$option_value['name'],'price'=>$app->currency->format($option_value['price'])));
                    }
                }else
                {
                    $option_name=Yii::t('product','text_option_name',array('name'=>$option_value['name']));   
                }
                
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        $option_value_data[] = array(
                            'id_product_option_value' => $option_value['id_product_option_value'],
                            'id_option_value' => $option_value['id_option_value'],
                            'name' => $option_name,
                            'image' => $option_value['image'],
                            'price' => (float)$option_value['price']?$app->currency->format($option_value['price']):false,
                            'price_prefix' => $option_value['price_prefix']
                        );
                    }
                }

                $data['product']['options'][] = array(
                    'id_product_option' => $option['id_product_option'],
                    'id_option' => $option['id_option'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option_value_data,
                    'required' => $option['required']
                );
            } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                $data['product']['options'][] = array(
                    'id_product_option' => $option['id_product_option'],
                    'id_option' => $option['id_option'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option['option_value'],
                    'required' => $option['required']
                );
            }
        }
        $data['product']['name']=$product['full_name'];
        $data['product']['id_product']=$product['product_id'];
        $data['product']['description']=$product['description'];
        $data['product']['model']=$product['model'];
        $data['product']['sku']=$product['sku'];
        $data['product']['upc']=$product['upc'];
        $data['product']['quantity']=$product['quantity'];
        $data['product']['stock_status']=$product['stock_status'];
        $data['product']['image']=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],
                array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h'])));
        $data['product']['images'][]=array('image'=>$data['product']['image'],'thumb'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))));
        $data['product']['manufacturer']=$product['manufacturer'];
        $data['product']['manufacturer_image']=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['manufacturer_image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h'])));
        $data['product']['price']=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?$app->currency->format($product['price']):false;
        $data['product']['special']=$app->currency->format($product['special']);
        $data['product']['special_quantity']=$product['special_quantity'];
        $data['product']['minimum']=$product['minimum'];
        if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS')){
            $data['product']['reviews']=$product['reviews'];
            $data['product']['rating']=$product['rating'];
        }else
        {
            $data['product']['reviews']=false;
            $data['product']['rating']=false;
        }
        $data['product']['href']=$this->createUrl('product/category',array('product_id'=>$product['product_id']));
        //echo '<pre>';print_r($data['product']);print_r($product);exit;
        //echo '<pre>';print_r($data['product']);exit;
        $this->renderPartial('product/quickview', array('data' => $data));
    }*/
    
    public function ActionSearch() {
        $app=Yii::app();
        $request=$app->request;
        $route='product/search';
        $data['sort']=Yii::app()->request->getParam('sort','p.sort_order');
        $data['order']=Yii::app()->request->getParam('order','ASC');
        
        $sort_data['page']=Yii::app()->request->getParam('page');
        if (isset($_GET['sort'])) {
            $sort_data['sort'] = $_GET['sort'];
        } else {
            $sort_data['sort'] = 'p.sort_order';
        }

        if (isset($_GET['order'])) {
            $sort_data['order'] = $_GET['order'];
        } else {
            $sort_data['order'] = 'ASC';
        }

        if (isset($_GET['brands'])) {
            $sort_data['manufacturer_ids'] = $_GET['brands'];
        }

        if (isset($_GET['discount'])) {
            $sort_data['discount'] = $_GET['discount'];
        }

        if (isset($_GET['attribute'])) {
            $sort_data['attribute'] = $_GET['attribute'];
        }
        
        if (isset($_GET['option'])) {
            $sort_data['option'] = $_GET['option'];
        }
        
        if (isset($_GET['priceranga'])) {
            $sort_data['priceranga'] = $_GET['priceranga'];
        }
        
        $data['sorts'] = array();
        $data['sorts'][] = array(
            'text' => "Default",
            'value' => 'p.sort_order-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.sort_order','order' => 'ASC')))
        );

        $data['sorts'][] = array(
            'text' => "Price (Low > High)",
            'value' => 'p.price-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.price','order' => 'ASC')))
        );

        $data['sorts'][] = array(
            'text' => "Price (High > Low)",
            'value' => 'p.price-DESC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.price','order' => 'DESC')))
        );
        if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS'))
        {
           $data['sorts'][] = array(
               'text' => "Rating (High > Low)",
               'value' => 'rating-DESC',
               'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'rating','order' => 'DESC')))
           );

           $data['sorts'][] = array(
               'text' => "Rating (Low > High)",
               'value' => 'rating-ASC',
               'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'rating','order' => 'ASC')))
           );
       }
        
        $data['sorts'][] = array(
            'text' => "Popular",
            'value' => 'p.viewed-DESC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.viewed','order' => 'DESC')))
        );
        
        $data['sorts'][] = array(
            'text' => "Whats New",
            'value' => 'p.date_product_available-ASC',
            'href' => $this->createUrl($route,array_merge($_GET,array('sort'=>'p.date_product_available','order' => 'ASC')))
        );
	$query=$_GET['q'];
        $data['query']=$query;
        $sort_data['q']=strtolower($query);
        //$sort_data['category_lists']='';
        $data['total']=$app->product->getTotalProducts($sort_data);
        //exit('total'.$data['total']);
        $pages = new CPagination((int)$data['total']);
        $pages->pageSize = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        
        $pages->route = $route;
        $page=$request->getParam('page');
        if (!empty($page)) {
                $from = (Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE') * ($page - 1)) + 1;
        } else {
            $from =  1;
			Library::setSearchKeyword($query);
		}

        if (($page) > 1) {
                $to = (Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE') * ($page));
        } else {
                $to = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        }

        if ($data['total'] < $to) {
                $to = $data['total'];
        }

        $data['pagination_desc']="Displaying ".$from."-".$to." of ".$data['total']." Results";;
        
		$sort_data['limit']=Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        $products=$app->product->getProducts($sort_data);
        //echo '<pre>';print_r($products);echo '</pre>';
        //exit("value of ".sizeof($products)." products and total ".$data['total']);
        //print_r($products);
        $login_show_price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || 
                (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?true:false;
        foreach($products as $product)
        {
            $image=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h'])));
            //CONFIG_STORE_SHOW_PRICE_WITH_TAX
            $tax=$app->tax->calculate($product['price'],$product['id_tax_class'],true);
            if($tax['amount'])
            {
                $taxInfo="";
                foreach($tax['details'] as $details)
                {
                        $taxInfo.=$plus.$details['name'].' : '.$app->currency->format($details['amount']);
                        $plus='+';        
                }
                $taxInfo="Including (".$taxInfo.")";
            }
            
            $price=$login_show_price?$app->currency->format($product['price']+$tax['amount']):false;
            
            $rating=$app->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1?$product['rating']:false;
            
            //$special=isset($product['special'])?$app->currency->format($product['special']):false;
            $price_special=$login_show_price && isset($product['special'])?$app->currency->format($product['special']+$tax['amount']):false;
            $group=array();
            foreach($product['group_products'] as $group_product)
            {
                $group[]=array('product_id'=>$group_product['id_product'],'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$group_product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h']))));
            }
            
            //special_prices
            $special_price="";
            $special_prices=array();
            if(sizeof($product['special_prices'])>0)
            {
                foreach($product['special_prices'] as $special)
                {
                    $special_price=$login_show_price?$app->currency->format($special['price']):false;
                    $special_prices[]=array('price'=>$special_price,
                                            'quantity'=>$special['quantity'],
                                            'label'=>Yii::t('product','text_product_special',array('price'=>$special_price,'quantity'=>$special['quantity'])));
                }
            }
            
            $data['products'][]=array('product_id'=>$product['product_id'],
                                       'image'=>$image,
                                        'name'=>$product['name'],
                'full_name'=>$product['full_name'],
                'taxInfo'=>$taxInfo,        
                'quantity'=>$product['quantity'],
                'stock_status'=>$product['stock_status'],
                'manufacturer'=>$product['manufacturer'],
                'price'=>$price,
                //'special'=>$special,
                'special'=>$price_special,
                'special_prices'=>$special_prices,
                'rating'=>$rating,
                'group'=>$group,
                'minimum'=>$product['minimum'],
                'model'=>$product['model'],
                );
           
        }
        $this->position = Yii::app()->module->prepare('productlisting');
        $this->breadcrumbs = array($query=>$this->createUrl($route,array('q'=>$query)));
        $this->metatitle=$query;
        $this->render("product/search", array('data' => $data, 'pages' => $pages));
    }
    
    
    public function ActionBrands() {
        $app=Yii::app();
        $this->breadcrumbs = array("Brands" => Yii::app()->request->requestUri);
        $brands=$app->product->getProductBrands();
        foreach ($brands as $brand) {
            if (is_numeric(substr($brand['name'], 0, 1))) {
                $key = '0 - 9';
            } else {
                $key = substr(strtoupper($brand['name']), 0, 1);
            }

            if (!isset($data['manufacturers'][$key])) {
                $data['categories'][$key]['name'] = $key;
            }

            $data['categories'][$key]['manufacturer'][] = array(
                'name' => $brand['name'],
                'href' => $this->createUrl('product/brandproducts',
                        array('manufacturer_id' => $brand['id_manufacturer']))
            );
        }
        $data['total_brands']=count($brands);
        //echo '<pre>';print_r($brands);print_r($data);echo '</pre>';exit;        
        $this->render('product/brands', array('data' => $data));
    }
	
	/*public function ActionBrands() {
        $product = new Product;
        $this->breadcrumbs = array(Yii::t('product','text_breadcrumb_brand') => Yii::app()->request->requestUri);
        $product_brands = $product->getBrands();
        foreach ($product_brands as $result) {
            if (is_numeric(substr($result['name'], 0, 1))) {
                $key = '0 - 9';
            } else {
                $key = substr(strtoupper($result['name']), 0, 1);
            }

            if (!isset($data['manufacturers'][$key])) {
                $data['categories'][$key]['name'] = $key;
            }

            $data['categories'][$key]['manufacturer'][] = array(
                'name' => $result['name'],
                'href' => $this->createUrl('product/brandproduct',
                        array('manufacturer_id' => $result['id_manufacturer']))
            );
        }
        $this->render('product/brands', array('data' => $data));
    }*/

    /*public function ActionBrandproduct() {
        $product = new Product;
        $manufacturer_id = (int) $_GET['manufacturer_id'];

        $this->data['breadcrumbs'][] = array(
            'text' => "Brand",
            'href' => $this->createUrl("product/brands"),
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $product->getManufacturer($manufacturer_id),
            'href' => Yii::app()->request->requestUri,
        );
        $sort_data['pagination'] = false;
        $data['brand_name'] = $product->getManufacturer($manufacturer_id);
        $data['pagination_data']['count'] = count($product->getBrandsProducts($manufacturer_id,
                        $sort_data));
        $pages = new CPagination($data['pagination_data']['count']);
        $pages->pageSize = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
        $pages->route = 'product/brandproduct';
        $data['dispaly_pagination'] = $this->displayPaginationStatus($_GET['page'],
                $data['pagination_data']['count']);
        $sort_data['pagination'] = true;
        $data['products'] = $product->getBrandsProducts($manufacturer_id,
                $sort_data);
        $this->position = Yii::app()->module->prepare('productlisting');
        $this->render('product/brandproduct',
                array('data' => $data, 'position' => Yii::app()->module->prepare('productlisting')));
    }*/

    public function ActionAutosuggest() {
        $search_query = $_GET['term'];
        $search_results = Library::getSearchKeys($search_query);
        foreach ($search_results as $results) {
            $result[] = $results['keyword'];
        }
        echo json_encode($result);
    }

	public function ActionUploadfile() {
        $file=$_POST['file_id'];
        $id_product_option=key($file);
        $field="FileInput_".$id_product_option;
        $json=array();
        $fileExt=substr(strrchr($_FILES[$field]['name'], '.'), 1);
        //echo $fileExt." ".trim($_FILES[$field]['type'])."<pre>";
        //print_r(Yii::app()->config->getData('CONFIG_WEBSITE_ALLOWED_FILE_TYPES'));exit;
        
        if (isset($_FILES[$field]) && (in_array($fileExt,Yii::app()->config->getData('CONFIG_WEBSITE_ALLOWED_FILE_TYPES'))) && $_FILES[$field]["error"] == UPLOAD_ERR_OK) {
            $UploadDirectory = Library::getMiscUploadPath();
            $File_Name = strtolower($_FILES[$field]['name']);
            $File_Ext = substr($File_Name, strrpos($File_Name, '.')); //get file extention
            $Random_Number = strtotime("now"); //Random number to be added to name.
            $NewFileName = $Random_Number . $File_Ext; //new file name

            if (move_uploaded_file($_FILES[$field]['tmp_name'], $UploadDirectory . $NewFileName)) {

                $json=array('id_product_option'=>$id_product_option,'message'=>'file upload successfull!!','value'=>$Random_Number . $File_Ext);
                //die('Success! File Uploaded.');
            } else {
                $json=array('id_product_option'=>$id_product_option,'message'=>'file upload failed!!','value'=>'');
                //die('error uploading File!');
            }
        }else
            {
                 $json=array('id_product_option'=>$id_product_option,'message'=>'File upload failed.Upload valid file!!','value'=>'');
            }
            echo json_encode($json);
    }
    
	/*public function ActionUploadfile() {
        if (isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"] == UPLOAD_ERR_OK) {
            $UploadDirectory = Library::getMiscUploadPath();

            //check if this is an ajax request
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                die();
            }
            //Is file size is less than allowed size.
            if ($_FILES["FileInput"]["size"] > 5242880) {
                die("File size is too big!");
            }
            //allowed file type Server side check
            switch (strtolower($_FILES['FileInput']['type'])) {
                //allowed file types
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                case 'text/plain':
                case 'text/html': //html file
                case 'application/x-zip-compressed':
                case 'application/pdf':
                case 'application/msword':
                case 'application/vnd.ms-excel':
                case 'video/mp4':
                    break;
                default:
                    die('Unsupported File!'); //output error
            }

            $File_Name = strtolower($_FILES['FileInput']['name']);
            $File_Ext = substr($File_Name, strrpos($File_Name, '.')); //get file extention
            $Random_Number = rand(0, 9999999999); //Random number to be added to name.
            $NewFileName = $Random_Number . $File_Ext; //new file name

            if (move_uploaded_file($_FILES['FileInput']['tmp_name'],
                            $UploadDirectory . $NewFileName)) {
                Yii::app()->session['image_upload'] = $Random_Number . $File_Ext;
                die('Success! File Uploaded.');
            } else {
                die('error uploading File!');
            }
        }
    }*/

    public function ActionImageupload() {
        echo Yii::app()->session['image_upload'];
    }

}
