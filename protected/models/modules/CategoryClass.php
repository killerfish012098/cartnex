<?php

class CategoryClass {

     public $data;

    public function __construct($input = null) {
        $ifpath = $_GET['category_id'];
        $app = Yii::app();
        if (isset($ifpath)) {
            $parts = explode('_', (string) $ifpath);
        } else {
            $parts = array();
        }

        if (isset($parts[0])) {
            $this->data['categories_id'] = $parts[0];
        } else {
            $this->data['categories_id'] = 0;
        }

        if (isset($parts[1])) {
            $this->data['child_id'] = $parts[1];
        } else {
            $this->data['child_id'] = 0;
        }


        $this->data['categories'] = array();

        $categories = $app->category->getChildCategories(0);
        /* echo "<pre>";
          print_r($categories);
          echo "</pre>"; */
        foreach ($categories as $category) {
            $children_data = array();

            $children = $app->category->getChildCategories($category['id_category']);

            foreach ($children as $child) {
                $data = array(
                    'filter_category_id' => $child['id_category'],
                    'filter_sub_category' => true
                );

                //$product_total = $prodObj->getTotalProducts($data); //commented on july 5 to remove count
                $href = $app->createUrl("product/category",array('category_id'=>$category['id_category'] . '_' . $child['id_category']));
                /* start subchilder */
                $sub_children_data = array();
                $sub_children = $app->category->getChildCategories($child['id_category']);
                /* echo "<pre>here";
                  print_r($sub_children);
                  echo "</pre>"; */
//echo "size of ".sizeof($sub_children)."<br/>";
                $limit = 6;  //wiil show one less then the value
                if (sizeof($sub_children) >= $limit) {
                    $view_more = "1";
                } else {
                    $view_more = "0";
                }
                $limit_count = 1;
                foreach ($sub_children as $sub_child) {
                    if ($limit_count >= $limit) {
                        break;
                    }
                    /* $data = array(
                      'filter_category_id'  => $sub_child['categories_id'],
                      'filter_sub_category' => true
                      ); */

                    //$product_total = $prodObj->getTotalProducts($data); //commented on july 5 to remove count
                    $href_sub =$app->createUrl("product/category",array('category_id'=>$category['id_category'] . '_' . $child['id_category']));
                    $sub_children_data[] = array(
                        'id_category' => $sub_child['id_category'],
                        'name' => $sub_child['name'], //commented on july 5 to remove count
                        'href' => $href_sub);
                    $limit_count++;
                }
                /* end subchilder */

                $children_data[] = array(
                    'id_category' => $child['id_category'],
                    'name' => $child['name'], //commented on july 5 to remove count
                    'href' =>$href,
                    'view_more' => $view_more,
                    'sub_child' => $sub_children_data);
            }

            $data = array(
                'filter_category_id' => $category['id_category'],
                'filter_sub_category' => true
            );

            //$product_total = $prodObj->getTotalProducts($data); //commented on july 5 to remove count

            $href1 = $app->createUrl("product/category",array('category_id'=>$category['id_category']));

            $this->data['categories'][] = array(
                'category_id' => $category['id_category'],
                //	'name'        => $category['categories_name'] . ' (' . $product_total . ')', //commented on july 5 to remove count
                'name' => $category['name'],
                'children' => $children_data,
                'href' => $href1);
        }
    }

}
