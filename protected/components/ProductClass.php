<?php

class ProductClass {

    private $id_language;
	private $db;
	public function init()
	{
		$languages=Yii::app()->config->getData('languages');
		$this->id_language=$languages[Yii::app()->session['language']]['id_language'];
		$this->db = Yii::app()->db;
	}

	 public function getTotalProducts($sort_data) {
		//echo '<pre>';
		//print_r($sort_data);
        //Yii::app()->session['product_sort_data'] = $sort_data;
         
		$customer_group_id=isset(Yii::app()->session['user_id'])?Yii::app()->session['user_customer_group_id']:Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_CUSTOMER_GROUP');

        $sql = "select count(distinct p.id_product) as total";
 
        if (!empty($sort_data['category_lists'])) {
			$sql .=" from {{product_category}} pc left join {{product}} p on pc.id_product = p.id_product";
            $sql .=' and pc.id_category in (' . $sort_data['category_lists'] . ')';
        }else
		{
			$sql .=" from  {{product}} p";	
		}

		$sql .= " LEFT JOIN {{product_description}} pd ON (p.id_product = pd.id_product) WHERE pd.id_language = '$this->id_language' AND p.status = '1' AND p.date_product_available <= NOW()";

        if (!empty($sort_data['manufacturer_ids'])) {
            $sql .= " AND p.id_manufacturer in (" . $sort_data['manufacturer_ids'] . ")";
        }

        $discount = explode(",", $sort_data['discount']);
        if (in_array("-2", $discount)) {
            $sql .= " AND p.id_product not in (select id_product from {{product_special}} ps where ps.id_customer_group='$customer_group_id' AND ((ps.start_date = '0000-00-00' OR ps.start_date < NOW()) AND (ps.end_date = '0000-00-00' OR ps.end_date > NOW())))";
        }

        if (!empty($sort_data['attribute'])) {
            $sql .= " AND p.id_product in (select distinct id_product from {{product_attribute}} where id_language='".$this->id_language."' and id_attribute in (" . $sort_data['attribute'] . "))";
        }
		
		if (!empty($sort_data['option'])) {
            $sql .= " AND p.id_product in (SELECT DISTINCT pov.id_product FROM  r_product_option_value pov WHERE pov.id_product = p.id_product AND pov.id_option_value IN (".$sort_data['option'].")) ";			
			//$sql .= " AND p.id_product in (select distinct po.id_product from r_option_value_description pvd,r_product_option po where pvd.id_option=po.id_option and pvd.id_option_value in (" . $sort_data['option'] . "))";
        }
		
		if (!empty($sort_data['priceranga'])) {
            $priceranga = explode(",", $sort_data['priceranga']);
            $sql .= " AND p.price>='" . $priceranga[0] . "' and p.price<='" . $priceranga[1] . "'";
        }

		if (!empty($sort_data['q'])) {
            $sql .= " AND p.id_product in (select distinct id_product from {{product_description}} where id_language='".$this->id_language."' and lower(name) like '%".$_GET['q']."%' or lower(description) like '%".$_GET['q']."%')";
        }
 
 
		
        
		
        $command = $this->db->createCommand($sql);
        $product_results = $command->queryRow();
		
        return $product_results['total'];
    }

	public function getGroupProducts($input)
	{
		if($input['product_id'])
		{
			$app=Yii::app();
			$group=$this->db->createCommand("SELECT  pgd.lable, pg.id_product_group FROM r_product_group_list pgl, r_product_group pg,r_product_group_description pgd WHERE pg.id_product_group = pgl.id_product_group AND pg.id_product_group=pgd.id_product_group and pg.display_in_listing =1 AND pgl.id_product =  '".$input['product_id']."' limit 1")->queryRow();

			$products=$this->db->createCommand("select p.id_product,pd.name,p.image from {{product}} p,{{product_description}} pd,{{product_group_list}} pgl where p.id_product=pgl.id_product and p.id_product=pd.id_product and pgl.id_product_group='".$group['id_product_group']."' and pd.id_language='".$this->id_language."' and p.date_product_available <= NOW() and p.status=1 and p.id_product!='".$input['product_id']."'")->queryAll();
		}
		return array('group'=>$group,'products'=>$products);
	}

	public function getOtherGroupProducts($input)
	{
		$data=array();
		if($input['product_id'])
		{
			$app=Yii::app();
			$groups=$this->db->createCommand("SELECT  pgd.lable, pg.id_product_group FROM r_product_group_list pgl, r_product_group pg,r_product_group_description pgd WHERE pg.id_product_group = pgl.id_product_group AND pg.id_product_group=pgd.id_product_group and pg.display_in_listing =0 AND pgl.id_product =  '".$input['product_id']."' limit 1")->queryAll();
			
			foreach($groups as $group){
				$products=$this->db->createCommand("select p.id_product,pd.name,p.image from {{product}} p,{{product_description}} pd,{{product_group_list}} pgl where p.id_product=pgl.id_product and p.id_product=pd.id_product and pgl.id_product_group='".$group['id_product_group']."' and pd.id_language='".$this->id_language."' and p.date_product_available <= NOW() and p.status=1 and p.id_product!='".$input['product_id']."'")->queryAll();
				foreach($products as $product)
				{
					$data[$group['id_product_group']."_".$group['lable']][]=array("id_product"=>$product['id_product'],
						'name'=>$product['name'],
						'image'=>$app->easyImage->thumbSrcOf(Library::getCatalogUploadPath().$product['image'],array('resize' => array('width' => $app->imageSize->productAdditional['w'],'height' => $app->imageSize->productAdditional['h'])))
						);
				}
			}
		}

		//echo '<pre>';print_r($data);exit;
		return $data;
	}

	public function getProduct($product_id) {

        $customer_group_id = isset(Yii::app()->session['user_id'])?Yii::app()->session['user_customer_group_id']:Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_CUSTOMER_GROUP');
        
        
		$sql="SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer,rm.image as manufacturer_image,(SELECT price FROM {{product_special}} ps WHERE ps.id_product = p.id_product AND ps.quantity=1 and ps.id_customer_group = '".$customer_group_id."' AND ((ps.start_date = '0000-00-00' OR ps.start_date < NOW()) AND (ps.end_date = '0000-00-00' OR ps.end_date > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special,  (SELECT ss.name FROM {{stock_status}} ss WHERE ss.id_stock_status = p.id_stock_status AND ss.id_language = '" . $this->id_language . "') AS stock_status, "; 

		if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS'))
		{
			$sql.=" (SELECT AVG(rating) AS total FROM {{product_review}} r1 WHERE r1.id_product = p.id_product AND r1.status = '1' GROUP BY r1.id_product) AS rating, (SELECT COUNT(*) AS total FROM {{product_review}} r2 WHERE r2.id_product = p.id_product AND r2.status = '1' GROUP BY r2.id_product) AS reviews ,";
		}

		$sql.=" p.sort_order FROM {{product}} p LEFT JOIN {{product_description}} pd ON (p.id_product = pd.id_product) LEFT JOIN {{manufacturer_description}} m ON (p.id_manufacturer = m. id_manufacturer) left join {{manufacturer}} rm ON (p.id_manufacturer = rm. id_manufacturer)  WHERE p.id_product = '$product_id' AND pd.id_language = '$this->id_language' AND p.status = '1' AND p.date_product_available <= NOW()";

		//echo $sql;
		//exit;

		//special prices
		$special_prices=$this->db->createCommand("SELECT price,quantity FROM {{product_special}} ps WHERE ps.id_product = '".$product_id."' and  ps.quantity>1 and ps.id_customer_group = '".$customer_group_id."' AND ((ps.start_date = '0000-00-00' OR ps.start_date < NOW()) AND (ps.end_date = '0000-00-00' OR ps.end_date > NOW())) ORDER BY ps.priority ASC, ps.price ASC")->queryAll();
		
		
		$products = $command = $this->db->createCommand($sql)->queryRow();
        
		//$getGroup = $connection->createCommand("select id_product from {{product_group_list}} where id_product_group=(select id_product_group from {{product_group_list}} where id_product='".$product_id."') and id_product!='".$product_id."'");
		
		$product_group=$this->db->createCommand("select p.id_product,p.image from r_product p,r_product_group_list pgl where p.date_product_available <= NOW() and p.status=1 and p.id_product=pgl.id_product  and pgl.id_product_group=(SELECT pg.id_product_group FROM r_product_group_list pgl, r_product_group pg WHERE pg.id_product_group = pgl.id_product_group AND pg.display_in_listing =1
AND pgl.id_product =  '".$product_id."')")->queryAll();

        /*$getCategory = $connection->createCommand("select id_category from {{product_category}} where id_product='$product_id'");
        
		$category_id = $getCategory->queryAll();

        $gproduct_ids = $getGroup->queryAll();
        
		foreach ($gproduct_ids as $gpids) {
            $pids[] = $gpids['id_product'];
        }
        
		$pids = implode(",", $pids);*/
        
        if ($products) {
            if (strlen($products['name']) > Yii::app()->config->getData('CONFIG_WEBSITE_PRODUCT_NAME_LIMIT')) {
                $product_name = substr($products['name'], 0,
                                Yii::app()->config->getData('CONFIG_WEBSITE_PRODUCT_NAME_LIMIT')) . "...";
            } else {
                $product_name = $products['name'];
            }
            if (strlen($products['description']) > 250) {
                $description = substr($products['description'], 0, 250) . "...";
            } else {
                $description = $products['description'];
            }
            return array(
                'product_id' => $products['id_product'],
                'name' => $product_name,
                'full_name' => $products['name'],
                'description' => html_entity_decode($products['description'],
                        ENT_QUOTES, 'UTF-8'),
                'description_short' => Library::shortString(array('str'=>strip_tags(html_entity_decode($description,
                        ENT_QUOTES, 'UTF-8')),'len'=>'200')),
                'meta_description' => $products['meta_description'],
                'meta_keyword' => $products['meta_keyword'],
                //'tag' => $products['tag'],
                'model' => $products['model'],
                'sku' => $products['sku'],
                'upc' => $products['upc'],
                'location' => $products['location'],
                'quantity' => $products['quantity'],
                'stock_status' => $products['stock_status'],
                'image' => $products['image'],
                'manufacturer_id' => $products['manufacturer_id'],
                'manufacturer' => $products['manufacturer'],
                'manufacturer_image' => $products['manufacturer_image'],
                //'price' => ($products['discount'] ? $products['discount'] : $products['price']),
				'price' => $products['price'],
                'special' => $products['special'],
                //'flat' => round(((($products['discount'] ? $products['discount'] : $products['price']) - $products['special'])/ ($products['discount'] ? $products['discount'] : $products['price']))*100),
                //'special_quantity' => $products['special_quantity'],
				'special_prices' => $special_prices,
                //'reward' => $products['reward'],
                //'points' => $products['points'],
                'id_tax_class' => $products['id_tax_class'],
                'date_available' => $products['date_available'],
                'weight' => $products['weight'],
                //'weight_class_id' => $products['weight_class_id'],
                'length' => $products['length'],
                'width' => $products['width'],
                'height' => $products['height'],
                //'length_class_id' => $products['length_class_id'],
                'subtract' => $products['subtract'],
                'rating' => round($products['rating']),
                'reviews' => $products['reviews'] ? $products['reviews'] : 0,
                'minimum' => $products['minimum_quantity'],
                'sort_order' => $products['sort_order'],
                'status' => $products['status'],
                'date_added' => $products['date_added'],
                'date_modified' => $products['date_modified'],
                'viewed' => $products['viewed'],
                //'category_id' => $category_id[0]['id_category'],
                'manufacturer' => $products['manufacturer'],
                'group_products' => $product_group,
                //'attribute' => $this->getProductAttributes($products['id_product'])
            );
        } else {
            return false;
        }
    }


	 public function getProductAttributes($product_id) {

        $product_attribute_group_data = array();

        $product_attribute_group_query = $this->db->createCommand("SELECT ag.filter,ag.id_attribute_group, agd.name FROM {{product_attribute}} pa LEFT JOIN {{attribute}} a ON (pa.id_attribute = a.id_attribute) LEFT JOIN {{attribute_group}} ag ON (a.id_attribute_group = ag.id_attribute_group) LEFT JOIN {{attribute_group_description}} agd ON (ag.id_attribute_group = agd.id_attribute_group) WHERE pa.id_product = '" . (int) $product_id . "' AND agd.id_language = '" . (int) $this->id_language . "' GROUP BY ag.id_attribute_group ORDER BY ag.sort_order, agd.name");

        foreach ($product_attribute_group_query->queryAll() as
            $product_attribute_group) {
            $product_attribute_data = array();

            $product_attribute_query = $this->db->createCommand("SELECT a.id_attribute, ad.name, pa.text FROM {{product_attribute}} pa LEFT JOIN {{attribute}} a ON (pa.id_attribute = a.id_attribute) LEFT JOIN {{attribute_description}} ad ON (a.id_attribute = ad.id_attribute) WHERE pa.id_product = '" . (int) $product_id . "' AND a.id_attribute_group = '" . (int) $product_attribute_group['id_attribute_group'] . "' AND ad.id_language = '" . (int) $this->id_language . "' AND pa.id_language = '" . (int) $this->id_language . "' ORDER BY a.sort_order, ad.name");

            foreach ($product_attribute_query->queryAll() as $product_attribute) {

                $product_attribute_data[] = array(
                    'attribute_id' => $product_attribute['id_attribute'],
                    'name' => $product_attribute['name'],
                    'text' => $product_attribute['text']
                );
            }

			if($product_attribute_group['filter'])
			{
				$product_attribute_group_data['General'][] = array(
					'attribute_group_id' => $product_attribute_group['id_attribute_group'],
					'name' => $product_attribute_group['name'],
					'attribute' => $product_attribute_data
				);
			}else
			{
				$product_attribute_group_data['Attribute'][] = array(
					'attribute_group_id' => $product_attribute_group['id_attribute_group'],
					'name' => $product_attribute_group['name'],
					'attribute' => $product_attribute_data
				);
			
			}
        }

		//echo '<pre>';print_r($product_attribute_group_data);exit;

        return $product_attribute_group_data;
    }

	public function getProductImages($product_id) {
        $product_images = $this->db->createCommand("select * from {{product_image}} where id_product='".(int)$product_id."' order by sort_order asc");
        return $product_images->queryAll();
    }

	public function getGroupedProducts($product_id) {

        $product_group_name = Yii::app()->db->createCommand("select * from {{product_group_description}} where id_language='".$this->id_language."' and id_product_group=(select id_product_group from {{product_group_list}} where id_product='$product_id')");
        foreach ($product_group_name->queryAll() as $group_name) {
            $product_group_products = Yii::app()->db->createCommand("select * from {{product_group_list}} where id_product_group='" . $group_name['id_product_group'] . "' and id_product!='$product_id'");
            foreach ($product_group_products->queryAll() as $group_product) {
                $group_products[] = $this->getProduct($group_product['id_product']);
            }
            $prduct_group_name[] = array(
                'group_label' => $group_name['lable'],
                'products' => $group_products,
            );
        }
        return $prduct_group_name;
    }


	 public function getProducts($sort_data) {
		//echo '<pre>';print_r($sort_data);exit;
		$customer_group_id=isset(Yii::app()->session['user_id'])?Yii::app()->session['user_customer_group_id']:Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_CUSTOMER_GROUP');

        $sql = "select distinct p.id_product, ";
		
		if(Yii::app()->config->getData('CONFIG_STORE_ALLOW_REVIEWS'))
		{
			$sql.='(select avg(rating) from {{product_review}} r where r.id_product=p.id_product and r.status=1 group by r.id_product) as rating, ';
		}

        $sql .="(select price from {{product_special}} ps where ps.id_product = p.id_product and ps.id_customer_group='".$customer_group_id."' AND ((ps.start_date = '0000-00-00' OR ps.start_date < NOW()) AND (ps.end_date = '0000-00-00' OR ps.end_date > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

        if (!empty($sort_data['category_lists'])) {
			$sql .=" from {{product_category}} pc left join {{product}} p on pc.id_product = p.id_product";
            $sql .=' and pc.id_category in (' . $sort_data['category_lists'] . ')';
        }else
		{
			$sql.=" from {{product}} p";
		}

        $sql .= " LEFT JOIN {{product_description}} pd ON (p.id_product = pd.id_product) WHERE pd.id_language = '".$this->id_language."' AND p.status = '1' AND p.date_product_available <= NOW()";


        if (!empty($sort_data['manufacturer_ids'])) {
            $sql .= " AND p.id_manufacturer in (" . $sort_data['manufacturer_ids'] . ")";
        }

        $discount = explode(",", $sort_data['discount']);
        if (in_array("-2", $discount)) {
            $sql .= " AND p.id_product not in (select id_product from {{product_special}} ps where ps.id_customer_group='".$customer_group_id."' AND ((ps.start_date = '0000-00-00' OR ps.start_date < NOW()) AND (ps.end_date = '0000-00-00' OR ps.end_date > NOW())))";
        }

        if ($sort_data['attribute']) {
            $sql .= " AND p.id_product in (select distinct id_product from {{product_attribute}} where id_language='".$this->id_language."' and id_attribute in (" . $sort_data['attribute'] . "))";
        }
		
		if ($sort_data['option']) {
            $sql .= " AND p.id_product in (SELECT DISTINCT pov.id_product FROM  r_product_option_value pov WHERE pov.id_product = p.id_product AND pov.id_option_value IN (".$sort_data['option'].")) ";
			
			//$sql .= " AND p.id_product in (select distinct po.id_product from r_option_value_description pvd,r_product_option po where pvd.id_option=po.id_option and pvd.id_option_value in (" . $sort_data['option'] . "))";
        }
		
		if ($sort_data['priceranga']) {
            $priceranga = explode(",", $sort_data['priceranga']);
            $sql .= " AND p.price>='" . $priceranga[0] . "' and p.price<='" . $priceranga[1] . "'";
        }

		if (!empty($sort_data['q'])) {
            $sql .= " AND p.id_product in (select distinct id_product from {{product_description}} where lower(name) like '%".$sort_data[q]."%' or lower(description) like '%".$sort_data[q]."%')";
        }

        if (isset($sort_data['sort']) && in_array($sort_data['sort'], $sort_data)) {
            if ($sort_data['sort'] == 'p.price') {
                $sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special ELSE p.price END)";
            } else {
                $sql .= " ORDER BY " . $sort_data['sort'];
            }
        }
		
		else 
		
		{
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($sort_data['order']) && ($sort_data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }
 
		
 

		//$limit = Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE');
		$limit = $sort_data['limit'];
		if ($sort_data['page']) {
			$start = ($sort_data['page'] - 1) * $limit;
		} else {
			$start = 0;
		}
		$sql .=" limit $start,$limit";
		//echo $sql;exit;
        $connection = Yii::app()->db;
		
        $command = $connection->createCommand($sql);
        $product_results = $command->queryAll();
		//exit;
        foreach ($product_results as $result) {
            //Yii::app()->session['last_product_id'] = $result['id_product'];
            $product_data[$result['id_product']] = $this->getProduct($result['id_product']);
        }
        return $product_data;
    }

	public function getProductOptions($product_id) {
        $product_option_data = array();
        
        $product_option_query = $this->db->createCommand("SELECT * FROM {{product_option}} po LEFT JOIN {{option}} o ON (po.id_option = o.id_option) LEFT JOIN {{option_description}} od ON (o.id_option = od.id_option) WHERE po.id_product = '" . (int) $product_id . "' AND od.id_language = '" . (int) $this->id_language . "' ORDER BY o.sort_order");
        foreach ($product_option_query->queryAll() as $product_option) {
            if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox') {
                $product_option_value_data = array();

                $product_option_value_query = $this->db->createCommand("SELECT * FROM {{product_option_value}} pov LEFT JOIN {{option_value}} ov ON (pov.id_option_value = ov.id_option_value) LEFT JOIN {{option_value_description}} ovd ON (ov.id_option_value = ovd.id_option_value) WHERE pov.id_product = '" . (int) $product_id . "' AND pov.id_product_option = '" . (int) $product_option['id_product_option'] . "' AND ovd.id_language = '" . (int) $this->id_language . "' ORDER BY ov.sort_order");

                foreach ($product_option_value_query->queryAll() as
                            $product_option_value) {
                    $product_option_value_data[] = array(
                        'id_product_option_value' => $product_option_value['id_product_option_value'],
                        'id_option_value' => $product_option_value['id_option_value'],
                        'name' => $product_option_value['name'],
                        'image' => $product_option_value['image'],
                        'quantity' => $product_option_value['quantity'],
                        'subtract' => $product_option_value['subtract'],
                        'price' => $product_option_value['price'],
                        'price_prefix' => $product_option_value['price_prefix'],
                        'weight' => $product_option_value['weight'],
                        'weight_prefix' => $product_option_value['weight_prefix']
                    );
                }

                $product_option_data[] = array(
                    'id_product_option' => $product_option['id_product_option'],
                    'id_option' => $product_option['id_option'],
                    'name' => $product_option['name'],
                    'type' => $product_option['type'],
                    'option_value' => $product_option_value_data,
                    'required' => $product_option['required']
                );
            } else {
                $product_option_data[] = array(
                    'id_product_option' => $product_option['id_product_option'],
                    'id_option' => $product_option['id_option'],
                    'name' => $product_option['name'],
                    'type' => $product_option['type'],
                    'option_value' => $product_option['option_value'],
                    'required' => $product_option['required']
                );
            }
        }
		//echo '<pre>';print_r($product_option_data);exit;
        return $product_option_data;
    }

	public function getReviews($id_product)
	{
		$reviews=$this->db->createCommand("select * from {{product_review}} where id_product='".$id_product."' and status=1 order by date_created desc");
		return $reviews->queryAll();
	}

	public function getProductBrands()
	{
		$brands=$this->db->createCommand("select md.name,md.id_manufacturer from {{manufacturer_description}} md,{{manufacturer}} m where m.id_manufacturer=md.id_manufacturer and md.id_language='".$this->id_language."' and m.status='1' and m.id_manufacturer in (select distinct id_manufacturer from {{product}} where status=1 and date_product_available<='now()') and m.status=1 order by md.name asc")->queryAll();
		return $brands;
	}

	 public function getRecentlyViewedProducts($limit) {
        $product_data = array();
        $i = 1;
        foreach (array_reverse($_SESSION['rvp']) as $k => $v) {
            if ($i > $limit) {
                continue;
            }
            $product_data[$v] = $this->getProduct($v);
            $i++;
        }
        return $product_data;
    }

	public function getFeaturedProducts($prod) {
        if ($prod != "") {
            $prod = explode(",", $prod);
            foreach ($prod as $k => $v) {
                $product_data[$k] = $this->getProduct($v);
            }
        }
        return $product_data;
    }

	public function getBestSellerProducts($limit) {
        $product_data = array();

        $getproducts = $this->db->createCommand("SELECT op.id_product, COUNT(*) AS total FROM {{order_product}} op LEFT JOIN {{order}} o ON (op.id_order = o.id_order) LEFT JOIN {{product}} p ON (op.id_product = p.id_product)  WHERE o.id_order_status > '0' AND p.status = '1' AND p.date_product_available <= '" . date(Y) . "-" . date(m) . "-" . date(d) . "'  GROUP BY op.id_product ORDER BY total DESC LIMIT " . (int) $limit);

        $results = $getproducts->queryAll();
        foreach ($results as $result) {
            $product_data[$result['id_product']] = $this->getProduct($result['id_product']);
        }
        return $product_data;
    }

	public function getCategoryProducts($categorylist) {

        $product_data = array();
        $categoryquery = Yii::app()->db->createCommand("select name,id_category from {{category_description}} where id_category in (" . $categorylist . ") and id_language=1");
        $categories = $categoryquery->queryAll();
        foreach ($categories as $category) {
            $getproducts = Yii::app()->db->createCommand("SELECT p.id_product FROM {{product}} p,{{product_category}} p2c  WHERE p.status = '1' AND p.date_product_available <= NOW() and p2c.id_product=p.id_product and p2c.id_category='" . $category['id_category'] . "' ORDER BY p.date_created DESC");
            $results = $getproducts->queryAll();

            foreach ($results as $result) {
                $product_data[$result['id_product']] = $this->getProduct($result['id_product']);
            }
        }


        return $product_data;
    }

	public function updateProductViews($id_product) {
		$this->db->createCommand("UPDATE {{product}} SET viewed = (viewed + 1) WHERE id_product = '" . (int)$id_product . "'")->query();
	}

	public function getProductSpecials($data = array()) {
		if (Yii::app()->session['user_id']) {
            $customer_group_id = Yii::app()->session['user_customer_group_id'];
        } else {
            $customer_group_id = Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_CUSTOMER_GROUP');
        }
		
        $sql = "SELECT DISTINCT ps.id_product, (SELECT AVG(rating) FROM {{product_review}} r1 WHERE r1.id_product = ps.id_product AND r1.status = '1' GROUP BY r1.id_product) AS rating FROM {{product_special}} ps LEFT JOIN {{product}} p ON (ps.id_product = p.id_product) LEFT JOIN {{product_description}} pd ON (p.id_product = pd.id_product)  WHERE p.status = '1' AND p.date_product_available <= NOW()  AND ps.id_customer_group = '" . (int) $customer_group_id . "' AND ((ps.start_date = '0000-00-00' OR ps.start_date < NOW())  AND (ps.end_date = '0000-00-00' OR ps.end_date > NOW())) GROUP BY ps.id_product";


        $sort_data = array(
            'pd.name',
            'p.model',
            'ps.price',
            'rating',
            'p.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }
		//echo $sql;exit;

        $product_data = array();
		$query = Yii::app()->db->createCommand($sql);
        $results = $query->queryAll();
        foreach ($results as $result) {
            $product_data[$result['id_product']] = $this->getProduct($result['id_product']);
        }

        return $product_data;
    }

	public function addReview()
	{
		$sql = "insert into {{product_review}} (id_product, id_customer, customer_name, text, rating, date_created, date_modified, status) values (:id_product, :id_customer, :customer_name, :text, :rating, :date_created, :date_modified, :status)";
		$parameters = array(":id_product"=>$_POST['product_id'], ":id_customer"=>Yii::app()->session['user_id'], ":customer_name"=>$_POST['review_title'], ":text"=>$_POST['review_description'], ":rating"=>$_POST['rating'], ":date_created"=>date("Y-m-d H:i:s"), ":date_modified"=>date("Y-m-d H:i:s"), ":status"=>"0");
		Yii::app()->db->createCommand($sql)->execute($parameters);
	}
}