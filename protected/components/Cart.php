<?php

class Cart {

    public $weight;
    private $id_language;
    private $db;

    public function init() {
		$languages=Yii::app()->config->getData('languages');
        $this->id_language = $languages[Yii::app()->session['language']]['id_language'];
        $this->db = Yii::app()->db;
    }

    public function calculateWeight() {
        
    }

    public function hasShipping() {
        $shipping = false;
        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $shipping = true;

                break;
            }
        }

        return $shipping;
		//return true;
		//return false;
    }

    public function getCartVolume() { //total items in cart
        $productTotal = 0;

        $products = $this->getProducts();

        foreach ($products as $product) {
            $productTotal += $product['quantity'];
        }

        return $productTotal;
    }

    function addProduct($id_product, $qty = 1, $option) {
        if (!$option) {
            $key = $id_product;
        } else {
            $key = $id_product . ':' . base64_encode(serialize($option));
        }

        if ((int) $qty && ((int) $qty > 0)) {
            if (!isset($_SESSION['cart'][$key])) {
                $_SESSION['cart'][$key] = (int) $qty;
            } else {
                $_SESSION['cart'][$key] += (int) $qty;
            }
        }
    }

    public function calculateBasePrice($qty, $descSplQty) {
        $amt = 0;
        foreach ($descSplQty as $k => $v) {
            if ($k <= $qty) {
                while ($k <= $qty) {
                    $qty = $qty - $k;
                    $amt+=(float) $descSplQty[$k];
                }
            } else {
                if (in_array($qty, array_keys($descSplQty))) {
                    continue;
                } else {
                    break;
                }
            }
        }
        return array('price' => $amt, 'qty' => $qty);
    }

    public function getProducts() {
        $product_data = array();
		//echo '<pre>';print_r($_SESSION);echo '</pre>';
        foreach ($_SESSION['cart'] as $key => $quantity) {
            $product = explode(':', $key);
            $id_product = $product[0];
            $stock = true;

            // Options
            if (isset($product[1])) {
                $options = unserialize(base64_decode($product[1]));
            } else {
                $options = array();
            }
            //echo '<pre>';print_r($options);exit;
            $productRow = $this->db->createCommand("SELECT * FROM {{product}} p LEFT JOIN {{product_description}} pd ON (p.id_product = pd.id_product)  WHERE p.id_product = '" . (int) $id_product . "' AND pd.id_language = '" . (int) $this->id_language . "'  AND p.date_product_available <= '" . date('Y-m-d H:i:s') . "' AND p.status = '1'")->queryRow();

            if ($productRow) {
                $option_price = 0;
                $option_points = 0;
                $option_weight = 0;

                $option_data = array();
                $assign = false;
                foreach ($options as $id_product_option => $option_value) {
                    $optionRow = $this->db->createCommand("SELECT po.id_product_option, po.id_option, od.name, o.type FROM {{product_option}} po LEFT JOIN {{option}} o ON (po.id_option = o.id_option) LEFT JOIN {{option_description}} od ON (o.id_option = od.id_option) WHERE po.id_product_option = '" . (int) $id_product_option . "' AND po.id_product = '" . (int) $id_product . "' AND od.id_language = '" . (int) $this->id_language . "'")->queryRow();

                    if (count($optionRow)) {

                        if ($optionRow['type'] == 'select' || $optionRow['type'] == 'radio') {
                            $optionValueRow = $this->db->createCommand("SELECT pov.id_option_value, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix,  pov.weight, pov.weight_prefix FROM {{product_option_value}} pov LEFT JOIN {{option_value}} ov ON (pov.id_option_value = ov.id_option_value) LEFT JOIN {{option_value_description}} ovd ON (ov.id_option_value = ovd.id_option_value) WHERE pov.id_product_option_value = '" . (int) $option_value . "' AND pov.id_product_option = '" . (int) $id_product_option . "' AND ovd.id_language = '" . (int) $this->id_language . "'")->queryRow();


                            if ($optionValueRow) {
                                if ($optionValueRow['price_prefix'] == '+') {
                                    $option_price += $optionValueRow['price'];
                                } elseif ($optionValueRow['price_prefix'] == '-') {
                                    $option_price -= $optionValueRow['price'];
                                } elseif ($optionValueRow['price_prefix'] == '=') {
                                    $option_price = $optionValueRow['price'];
                                    $assign = true;
                                }


                                if ($optionValueRow['weight_prefix'] == '+') {
                                    $option_weight += $optionValueRow['weight'];
                                } elseif ($optionValueRow['weight_prefix'] == '-') {
                                    $option_weight -= $optionValueRow['weight'];
                                }

                                if ($optionValueRow['subtract'] && (!$optionValueRow['quantity'] || ($optionValueRow['quantity'] < $quantity))) {
                                    $stock = false;
                                }

                                $option_data[] = array(
                                    'id_product_option' => $id_product_option,
                                    'id_product_option_value' => $option_value,
                                    'id_option' => $optionRow['id_option'],
                                    'id_option_value' => $optionValueRow['id_option_value'],
                                    'name' => $optionRow['name'],
                                    'option_value' => $optionValueRow['name'],
                                    'type' => $optionRow['type'],
                                    'quantity' => $optionValueRow['quantity'],
                                    'subtract' => $optionValueRow['subtract'],
                                    'price' => $optionValueRow['price'],
                                    'price_prefix' => $optionValueRow['price_prefix'],
                                    'weight' => $optionValueRow['weight'],
                                    'weight_prefix' => $optionValueRow['weight_prefix']
                                );
                            }
                        } elseif ($optionRow['type'] == 'checkbox' && is_array($option_value)) {

                            foreach ($option_value as $id_product_option_value) {
                                $optionValueRow = $this->db->createCommand("SELECT pov.id_option_value, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.weight, pov.weight_prefix FROM {{product_option_value}} pov LEFT JOIN {{option_value}} ov ON (pov.id_option_value = ov.id_option_value) LEFT JOIN {{option_value_description}} ovd ON (ov.id_option_value = ovd.id_option_value) WHERE pov.id_product_option_value = '" . (int) $id_product_option_value . "' AND pov.id_product_option = '" . (int) $id_product_option . "' AND ovd.id_language = '" . (int) $this->id_language . "'")->queryRow();

                                //echo '<pre>';print_r($optionValueRow);print_r($option_value);exit('in check box');
                                if ($optionValueRow) {
                                    if ($optionValueRow['price_prefix'] == '+') {
                                        $option_price += $optionValueRow['price'];
                                    } elseif ($optionValueRow['price_prefix'] == '-') {
                                        $option_price -= $optionValueRow['price'];
                                    } elseif ($optionValueRow['price_prefix'] == '=') {
                                        $option_price = $optionValueRow['price'];
                                        $assign = true;
                                    }


                                    if ($optionValueRow['weight_prefix'] == '+') {
                                        $option_weight += $optionValueRow['weight'];
                                    } elseif ($optionValueRow['weight_prefix'] == '-') {
                                        $option_weight -= $optionValueRow['weight'];
                                    }

                                    if ($optionValueRow['subtract'] && (!$optionValueRow['quantity'] || ($optionValueRow['quantity'] < $quantity))) {
                                        $stock = false;
                                    }

                                    $option_data[] = array(
                                        'id_product_option' => $id_product_option,
                                        'id_product_option_value' => $id_product_option_value,
                                        'id_option' => $optionRow['id_option'],
                                        'id_option_value' => $optionValueRow['id_option_value'],
                                        'name' => $optionRow['name'],
                                        'option_value' => $optionValueRow['name'],
                                        'type' => $optionRow['type'],
                                        'quantity' => $optionValueRow['quantity'],
                                        'subtract' => $optionValueRow['subtract'],
                                        'price' => $optionValueRow['price'],
                                        'price_prefix' => $optionValueRow['price_prefix'],
                                        'weight' => $optionValueRow['weight'],
                                        'weight_prefix' => $optionValueRow['weight_prefix']
                                    );
                                }
                            }
                        } elseif ($optionRow['type'] == 'text' || $optionRow['type'] == 'textarea' || $optionRow['type'] == 'file' || $optionRow['type'] == 'date' || $optionRow['type'] == 'datetime' || $optionRow['type'] == 'time') {
                            $option_data[] = array(
                                'id_product_option' => $id_product_option,
                                'product_option_value_id' => '',
                                'id_option' => $optionRow['id_option'],
                                'id_option_value' => '',
                                'name' => $optionRow['name'],
                                'option_value' => $option_value,
                                'type' => $optionRow['type'],
                                'quantity' => '',
                                'subtract' => '',
                                'price' => '',
                                'price_prefix' => '',
                                'weight' => '',
                                'weight_prefix' => ''
                            );
                        }
                    }
                }

                $id_customer_group = isset(Yii::app()->session['user_id']) ? Yii::app()->session['user_customer_group_id'] : Yii::app()->config->getData('CONFIG_WEBSITE_DEFAULT_CUSTOMER_GROUP');


                if (!$assign) {
                    // Product Specials
                    $productSpecialRow = $this->db->createCommand("SELECT quantity,price FROM {{product_special}} WHERE id_product = '" . (int) $id_product . "' AND id_customer_group = '" . (int) $id_customer_group . "' AND ((start_date = '0000-00-00' OR start_date < '" . date('Y-m-d H:i:s') . "') AND (end_date = '0000-00-00' OR end_date > '" . date('Y-m-d H:i:s') . "')) ORDER BY quantity desc")->queryAll();
                    if (sizeof($productSpecialRow)) {
                        $prodSpecQty = array();
                        foreach ($productSpecialRow as $ps) {
                            $prodSpecQty[$ps['quantity']] = $ps['price'];
                        }

                        $calculateBasePrice = $this->calculateBasePrice($quantity, $prodSpecQty);
                        $remPrice = 0;
                        if ($calculateBasePrice['qty'] != 0) {
                            $remPrice = $productRow['price'] * $calculateBasePrice['qty'];
                        }
                        $price = $calculateBasePrice['price'] + $remPrice;
                        $price_unit = $price / $quantity;
                        //echo '<pre>';print_r($calculateBasePrice);print_r($prodSpecQty);
                        //exit($quantity." qty ".$price);
                    } else {
                        $price = $productRow['price'] * $quantity;
                        $price_unit = $productRow['price'];
                    }
                } else {
                    $price = 0;
                    $price_unit = 0;
                }
                //exit('unit price'.$price_unit." price ".$price);
                //echo 'customer group id '.$id_customer_group.'<pre>';print_r($productRow);print_r($productSpecialRow);
                // Stock
                if (!$productRow['quantity'] || ($productRow['quantity'] < $quantity)) {
                    $stock = false;
                    //echo "wow".$stock;
                }
                //exit("value of ".$stock);
                //exit($option_price);
				/*if (strlen($productRow['name']) > Yii::app()->config->getData('CONFIG_WEBSITE_PRODUCT_NAME_LIMIT')) {
                $product_name = substr($productRow['name'], 0,
									Yii::app()->config->getData('CONFIG_WEBSITE_PRODUCT_NAME_LIMIT')) . "...";
				} else {
					$product_name = $productRow['name'];
				}*/

				if($productRow['id_tax_class'])
				{
					$tax_price_final=Yii::app()->tax->calculate($price_unit + $option_price,$productRow['id_tax_class'],true);
					$price_final=$price_unit + $option_price+$tax_price_final['amount'];

					$tax_total_final=Yii::app()->tax->calculate(($price + ($option_price * $quantity)),$productRow['id_tax_class'],true);
					$total_final=($price + ($option_price * $quantity))+$tax_total_final['amount'];
		
				}else
				{
					$price_final =($price_unit + $option_price);
					$total_final = ($price + ($option_price * $quantity));
				}

                $product_data[$key] = array(
                    'key' => $key,
                    'id_product' => $productRow['id_product'],
                    'full_name'=>$productRow['name'],
					'name' =>Library::shortString(array('str'=> $productRow['name'],'len'=>Yii::app()->config->getData('CONFIG_WEBSITE_PRODUCT_NAME_LIMIT'))),
                    'model' => $productRow['model'],
                    'shipping' => $productRow['shipping_required'],
                    'image' => $productRow['image'],
                    'option' => $option_data,
                    'download_status' => $productRow['download_status'],
                    'download_filename' => $productRow['download_filename'],
                    'download_mask' => $productRow['download_mask'],
                    'download_allowed_count' => $productRow['download_allowed_count'],
                    'download_allowed_days' => $productRow['download_allowed_days'],
                    'quantity' => $quantity,
                    'minimum' => $productRow['minimum_quantity'],
                    'subtract' => $productRow['subtract_stock'],
                    'stock' => $stock,
                    'price' => $price_final,
                    'total' => $total_final,
					//'price' => ($price_unit + $option_price),
                    //'total' => ($price + ($option_price * $quantity)),
                    'id_tax_class' => $productRow['id_tax_class'],
                    'weight' => ($productRow['weight'] + $option_weight) * $quantity,
                    'length' => $productRow['length'],
                    'width' => $productRow['width'],
                    'height' => $productRow['height'],
                );
            } else {
                $this->remove($key);
            }
        }
       // echo '<pre>';print_r($product_data);echo '</pre>';exit;
        return $product_data;
    }

    public function remove($key) {
        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }
    }

	 public function hasDownload() {
		$download = false;

		foreach ($this->getProducts() as $product) {
	  		if ($product['download_status']) {
	    		$download = true;

				break;
	  		}
		}

		return $download;
	}

    public function getSubTotal() {
        $total = 0;

        foreach ($this->getProducts() as $product) {
            $total += $product['total'];
        }

        return $total;
    }

	public function hasStock() {
		$stock = true;

		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				$stock = false;
			}
		}

		return $stock;
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
		}		

		return $product_total;
	}

	public function hasProducts() {
		if(count($_SESSION['cart']))
		{
			return true;
		}else
		{
			return false;
		}
	}
 
}