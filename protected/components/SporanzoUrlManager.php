<?php
/**
 * SporanzoUrlManager is used to change the urls to seo friendly
 */
class SporanzoUrlManager extends CBaseUrlRule{
	
	public $connectionID = 'db';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='product/category')
        {
        	if(isset($params['category_id']) && ($params['category_id'] > 0)){
        		$parts=explode("_",$params['category_id']);
        		$data['category_count']=count($parts);
        		$category_id=(int) array_pop($parts);
        		$details = CustomUrl::model()->findByAttributes(array('id'=>$category_id));
        		
        		if($details->string != ''){
        			unset($params['category_id']);
        			$url = $details->string;
        		} else {
        			$url = $route;
        		}
        		
        		if(empty($params)){
        			return $url!=='' ? $url.$suffix : $url;
        		}
        		else
        		{
        			return $url.='?'.$manager->createPathInfo($params,'=',$ampersand);
        		}
        		
        	} else {
        		return $route.'/category_id/'.$params['category_id'];	
        	}
        }
        if($route === 'product/productdetails'){
        	if(isset($params['product_id']) && ($params['product_id'] > 0)){
        		$details = CustomUrl::model()->findByAttributes(array('id'=>$params['product_id']));
        		if($details->string != ''){
        			unset($params['product_id']);
        			$url = $details->string;
        		} else {
        			$url = $route;
        		}
        		
        		if(empty($params)){
        			return $url!=='' ? $url.$suffix : $url;
        		}
        		else
        		{
        			return $url.='?'.$manager->createPathInfo($params,'=',$ampersand);
        		}
        	} else {
        		return $route.'/product_id/'.$params['product_id'];
        	}
        }
        
        if((strpos($route,'page') !== false) || (strpos($route,'account') !== false) || (strpos($route,'site') !== false)){
        	$parts=explode("/",$route);
        	$pageName = array_pop($parts);
        	return $pageName;
        }
        
        return false;  // this rule does not apply
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if ($pathInfo)
        {
        	$details = CustomUrl::model()->findByAttributes(array('string'=>$pathInfo));
        	$cat_id = $details->id;
        	$parentCatId = Category::model()->findByPk($details['id'])->id_parent;
        	if($parentCatId > 0){
        		$categoryId = $parentCatId.'_'.$cat_id;
        	} else {
        		$categoryId = $cat_id;
        	}
        	if($details->type == "category"){
        		return 'product/category/category_id/'.$categoryId;
        	}
        	 
        	if($details->type == "product"){
        		return 'product/productdetails/product_id/'.$categoryId;
        	}
        	
        	switch ($pathInfo){
        		case 'home':
        		case 'aboutus':
        		case 'contactus':
        		case 'content':
        		case 'pages':
        		case 'sitemap':
        		case 'termsandconditions':
        		case 'privacypolicy':
        			return 'page/'.$pathInfo;
        			break;
        		case 'login':
        		case 'profile':
        		case 'logout':
        		case 'register':
        		case 'forgotpassword':
        		case 'address':
        		case 'address':
        		case 'wishlistajax':
        		case 'removewishlist':
        		case 'wishlist':
        		case 'getstatedependencylist':
        		case 'orderhistory':
        		case 'orderdetails':
        			return 'account/'.$pathInfo;
        			break;
        		case 'index':
        			return 'site/'.$pathInfo;
        		default:
        			break;
        	}
        }
        
        return false;  // this rule does not apply
    }
	
	
}
