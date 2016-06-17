<?php
class BestSellerClass
{
	public $data;
	public function __construct($info=null) {
		
		$products= array();
		$app=Yii::app();
		$results = $app->product->getBestSellerProducts($info['limit']);
		$login_show_price=($app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE') && isset($app->session['user_id'])) || 
                (!$app->config->getData('CONFIG_STORE_LOGIN_SHOW_PRICE'))?true:false;
		foreach ($results as $result) {
			$image=$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$result['image'],array('resize' => array('width' => $app->imageSize->productThumb['w'],'height' => $app->imageSize->productThumb['h'])));
			
			$tax=$app->tax->calculate($result['price'],$result['id_tax_class'],true);
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
            $price=$login_show_price?$app->currency->format($result['price']+$tax['amount']):false;
            $rating=$app->config->getData('CONFIG_STORE_ALLOW_REVIEWS')==1?$result['rating']:false;
            $price_special=$login_show_price && isset($result['special'])?$app->currency->format($result['special']+$tax['amount']):false;
			
			//special_prices
            $special_price="";
            $special_prices=array();
            if(sizeof($result['special_prices'])>0)
            {
                foreach($result['special_prices'] as $special)
                {
                    $special_price=$login_show_price?$app->currency->format($special['price']):false;
                    $special_prices[]=array('price'=>$special_price,
                                            'quantity'=>$special['quantity'],
                                            'label'=>Yii::t('product','text_product_special',array('price'=>$special_price,'quantity'=>$special['quantity'])));
                }
            }

			$products[] = array('id_product'=>$result['product_id'],
                                    'image'=>$image,
                                    'name'=>$result['name'],
                                    'full_name'=>$result['full_name'],
                                    'taxInfo'=>$taxInfo,        
                                    'quantity'=>$result['quantity'],
                                    'stock_status'=>$result['stock_status'],
                                    'manufacturer'=>$result['manufacturer'],
                                    'price'=>$price,
                                    'special'=>$price_special,
                                    'special_prices'=>$special_prices,
                                    'rating'=>$rating,
                                    'group'=>$group,
                                    'minimum'=>$result['minimum'],
                                    'model'=>$result['model'],
                            ); 
		}
		$this->data=array("products"=>$products,'info'=>$info);	
	}
}