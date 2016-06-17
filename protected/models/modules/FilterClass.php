<?php

class FilterClass {

    public $data;
	public $id_language;

    public function __construct($input = null) {
        //0->price,1->brands,2->discounts
        //$catId='8';
        //echo "action name ".Yii::app()->controller->action->id;
		//exit;
		$languages=Yii::app()->config->getData('languages');
		$this->id_language=$languages[Yii::app()->session['language']]['id_language'];
		if(Yii::app()->controller->action->id=='category')
        {
            $catId = (int) end(explode("_", $_GET['category_id']));
            $filterRows = Yii::app()->db->createCommand()
                ->select('id, type, sort_order')
                ->from('{{category_filter}}')
                ->where('id_category=:id', array(':id' => $catId))
                ->queryAll();
        }else if(Yii::app()->controller->action->id=='search')
        {
            $filterRows=array(array('id' => 0,'type' => 'general','sort_order' => 1),array('id' => 1,'type' => 'general','sort_order' => 2));
        }else
        {
            $filterRows=array(array('id' => 0,'type' => 'general','sort_order' => 1));
        }
        /*echo '<pre>';
        print_r($filterRows);
        echo '</pre>';
        exit;*/
        //echo "value of".$cat;
        //print($_GET['category_id']);

        if (sizeof($filterRows)) {
            $sort = array();
            foreach ($filterRows as $rows) {
                $sort['sort_order'][] = $rows['sort_order'];
                $sort['data'][] = $rows['id'] . '-' . $rows['type'];
            }

            array_multisort($sort['sort_order'], SORT_ASC, $sort['data']);
            $filters = array();
            foreach ($sort['data'] as $data) {
                $info = explode("-", $data);
                $type = $info[1];
                $id = $info[0];
                //echo $type." ".$id." <br/>";

                switch ($type) {
                    case 'general':
                        if ($id == 0) {
                            //echo "in o <br/>";
                            $filters[] = array("type" => "general", "filter" => "price");
                        } else if ($id == 1) {
                            //echo "in 1 <br/>";
                            /* select m.id_manufacturer,md.name from r_manfuacturer,r_manufacturer_description where m.id_manufacturer=md.id_manufacturer 
                              and md.id_language=1 and m.status=1 order by m.sort_order asc */
                            $brands=array();
							$getCatId=Yii::app()->request->getparam('category_id');
							$searchKey=trim(Yii::app()->request->getparam('q'));
							if(Yii::app()->controller->action->id=='category' && $getCatId!="")
							{
								$getCatIdExp=explode("_",$getCatId);
								$catId=end($getCatIdExp);
								$brands = Yii::app()->db->createCommand()
                                    ->select('m.id_manufacturer,md.name')
                                    ->from('{{manufacturer}} m')
                                    ->join('{{manufacturer_description}} md', 'm.id_manufacturer=md.id_manufacturer')
                                    ->where('m.id_manufacturer in (select distinct p.id_manufacturer from {{product_category}} pc , {{product}} p where pc.id_category="0'.$catId.'" and p.id_product=pc.id_product and p.status=1 and date_product_available <= NOW()) and md.id_language=:langId and m.status=1', array(':langId' => $this->id_language))
									->order('m.sort_order asc')
                                    ->queryAll();
								/*$brands = Yii::app()->db->createCommand()
                                    ->select('m.id_manufacturer,md.name')
                                    ->from('{{manufacturer}} m')
                                    ->join('{{manufacturer_description}} md', 'm.id_manufacturer=md.id_manufacturer')
                                    ->where('md.id_language=:langId and m.status=1', array(':langId' => $this->id_language))
                                    ->order('m.sort_order asc')
                                    ->queryAll();*/
							}else if(Yii::app()->controller->action->id=='search' && $searchKey!="")
							{
								$brands = Yii::app()->db->createCommand()
                                    ->select('m.id_manufacturer,md.name')
                                    ->from('{{manufacturer}} m')
                                    ->join('{{manufacturer_description}} md', 'm.id_manufacturer=md.id_manufacturer')
                                    ->where('m.id_manufacturer in (select distinct id_manufacturer from {{product}} p,{{product_description}} pd where pd.name like "%'.$searchKey.'%" and pd.id_language="'.$this->id_language.'" and p.id_product=pd.id_product) and md.id_language=:langId and m.status=1', array(':langId' => $this->id_language))
                                    ->order('m.sort_order asc')
                                    ->queryAll();
							}
							//echo '<pre>';print_r($brands);exit;
							if(sizeof($brands))
							{
								$brandValuesData = array();
								foreach ($brands as $brand) {
									$brandValuesData[$brand['id_manufacturer']] = $brand['name'];
								}
								$filters[] = array("type" => "brands", "filter" => "brands", "data" => array('values' => $brandValuesData));
							}

                        } else if ($id == 2) {
                            //echo "in 2 <br/>";
                            $filters[] = array("type" => "discount", "filter" => "discount", "data" => array('values' => array('-1' => 'Discount', '-2' => 'Non Discount')));
                        }
                        break;

                    case 'option':
                        /*           select o.id_option,o.name from r_option o,r_option_description od where o.id_option=od.id_option and o.id_option=1 and od.id_language=1 order by o.sort_order asc
                          select ovd.id_option_value,ovd.name from r_option_value ov r_option_value_description ovd where  ov.id_option=ovd.id_option ov.id_option=1 order by ov.sort_order asc */

                        $optionName = Yii::app()->db->createCommand()
                                ->select('o.id_option,od.name')
                                ->from('{{option}} o')
                                ->join('{{option_description}} od', 'o.id_option=od.id_option')
                                ->where('od.id_language=:langId and o.id_option=:id_option', array(':langId' => $this->id_language, ':id_option' => $id))
                                ->order('o.sort_order asc')
                                ->queryRow();

                        $optionNameData = array($optionName['id_option'] => $optionName['name']);

                        $optionValues = Yii::app()->db->createCommand()
                                ->select('ovd.id_option_value,ovd.name')
                                ->from('{{option_value}} ov')
                                ->join('{{option_value_description}} ovd', 'ov.id_option=ovd.id_option')
                                ->where('ovd.id_language=:langId and ov.id_option=:id_option', array(':langId' => $this->id_language, ':id_option' => $id))
                                ->order('ov.sort_order asc')
                                ->queryAll();

                        $optionValuesData = array();
                        foreach ($optionValues as $optionValue) {
                            $optionValuesData[$optionValue['id_option_value']] = $optionValue['name'];
                        }

                        $filters[] = array("type" => "option", "filter" => $optionName['name'], "data" => array('name' => $optionNameData, 'values' => $optionValuesData));
                        break;

                    case 'attribute':

                        $attributeName = Yii::app()->db->createCommand()
                                ->select('agd.id_attribute_group,agd.name')
                                ->from('{{attribute_group_description}} agd')
                                ->join('{{attribute_group}} ag', 'ag.id_attribute_group=agd.id_attribute_group')
                                ->where('agd.id_language=:langId and ag.id_attribute_group=:id', array(':langId' => $this->id_language, ':id' => $id))
                                ->order('ag.sort_order asc')
                                ->queryRow();
                        $attributeNameData = array($attributeName['id_attribute_group'] => $attributeName['name']);
                        $attributeValues = Yii::app()->db->createCommand()
                                ->select('a.id_attribute,ad.name')
                                ->from('{{attribute_description}} ad')
                                ->join('{{attribute}} a', 'a.id_attribute=ad.id_attribute')
                                ->where('ad.id_language=:langId and a.id_attribute_group=:id', array(':langId' => $this->id_language, ':id' => $id))
                                ->order('a.sort_order asc')
                                ->queryAll();

                        $attributeValuesData = array();
                        foreach ($attributeValues as $attributeValue) {
                            $attributeValuesData[$attributeValue['id_attribute']] = $attributeValue['name'];
                        }

                        $filters[] = array("type" => "attribute", "filter" => $attributeName['name'], "data" => array('name' => $attributeNameData, 'values' => $attributeValuesData));
                        break;
                }
            }
        }
          /*echo '<pre>';
          //print_r($filterRows);
          //print_r($sort);
          print_r($filters);
          echo '</pre>';*/
          //exit;  
        //exit($_REQUEST['category_id']);
        $this->data = $filters;
    }

}
