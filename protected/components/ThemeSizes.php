<?php
class ThemeSizes 
{
    public $categoryList;
    public $categoryThumb;
    public $productList;
    public $productThumb;
    public $productPopup;
    public $productAdditional;
    public $productCompare;
    public $productWishlist;
    public $productCart;
    public $brandList; //not required
    public $brandThumb;

    public function init() {
        $theme = Yii::app()->config->getData('CONFIG_WEBSITE_TEMPLATE');
		
        $params = array('%category_details_image_size%' => 'categoryThumb',
            '%category_list_image_size%' => 'categoryList',
            '%product_details_image_size%' => 'productThumb',
            '%product_list_image_size%' => 'productList',
            '%product_popup_image_size%' => 'productPopup',
            '%product_additional_image_size%' => 'productAdditional',
            '%product_compare_image_size%' => 'productCompare',
            '%product_wishlist_image_size%' => 'productWishlist',
            '%product_cart_image_size%' => 'productCart',
            '%brand_list_image_size%' => 'brandList',
            '%brand_details_image_size%' => 'brandThumb'
        );
        
        $sizes = array('%category_details_image_size%', '%category_list_image_size%',
            '%product_details_image_size%', '%product_list_image_size%', '%product_popup_image_size%',
            '%product_additional_image_size%', '%product_compare_image_size%', '%product_wishlist_image_size%',
            '%product_cart_image_size%', '%brand_list_image_size%',
            '%brand_details_image_size%'
        );
        
        $data = file(Yii::getpathofalias('webroot.themes.' . $theme . '.css') . '/custom-template-params.txt');
        /*echo '<pre>';
         print_r($data); 
        exit;////*/
        foreach ($data as $element) {
            $info = explode("==", $element);
            if (in_array($info[0], $sizes)) {
                //echo $info[0]."<br>";
                $exp = explode("*", trim($info[1]));
                $this->$params[$info[0]] = array('w' => $exp[0], 'h' => $exp[1]);
            }
        }
        //echo "brand thumb ".$this->brandThumb['w']." & ".$this->brandThumb['h']."<br/>";
        $missing = array();
        foreach ($params as $const => $attr) {
            //echo $attr . " attr <br/>";
            if ($this->$attr == "") {
                $missing[] = $const;
            }
        }
        ///$missing[]='%brand_details_image_size%';// for testing missing
        //print_r($missing);

        if (sizeof($missing)) 
        {
            $defaultData=file(Yii::getpathofalias('webroot.themes.default.css').'/default-template-params.txt');
            foreach($defaultData as $defaultEle)
            {
                $defaultInfo = explode("==", $defaultEle);
                if (in_array($defaultInfo[0], $missing)) 
                {
                    $defaultExp = explode("*", trim($defaultInfo[1]));
                    $this->$params[$defaultInfo[0]] = array('w' => $defaultExp[0], 'h' => $defaultExp[1]);
                }
            }
        }
        //echo "brand thumb ".$this->brandThumb['w']." & ".$this->brandThumb['h']."<br/>";
        //exit;
        /* echo  "<br/>".$this->productAdditional." pro add<br/>".$this->brandList." brand list<br/>".$this->brandThumb." brand thumb<br/>".$this->categoryList."cat list<br/>".
         * $this->categoryThumb."cat thumb<br/>".$this->productCart."pro cart<br/>".$this->productCompare."pro comp<br/>".$this->productList."pro list<br/>".$this->productPopup.
         * "pro pop<br/>".$this->productThumb."pro thum<br/>".$this->productWishlist."pro wish<br/>";           print_r($this->productAdditional);            exit; */
    }
}
