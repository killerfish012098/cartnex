<?php

class Navigation extends CWidget {

    public $menu = array();
    public $more = array();
    private $top_category;
    private $more_category;
    private $children_catetory;
    private $product_count;
    public $id_language;

    public function init() {
        $this->id_language = Yii::app()->config->getData('languages')[Yii::app()->session['language']]['id_language'];
        return parent::init();
    }

    public function run() {
        $this->top_category = $this->getTopCategory();
        //top categories
        foreach ($this->top_category as $topcategory) {
            $this->children_catetory = $this->getChildCategory($topcategory['id_category']);
            $children = array();
            if (Yii::app()->config->getData('CONFIG_STORE_SHOW_CATEGORY_PRODUCT_COUNT') == '1') {
                foreach ($this->children_catetory as $childrencatetory) {
                    $product_count = $this->productCount($childrencatetory['id_category']);
                    $children[] = array(
                        'name' => $childrencatetory['name'] . "(" . $product_count . ")",
                        'href' => Yii::app()->controller->createUrl('product/category', array("category_id" => $topcategory['id_category'] . "_" . $childrencatetory['id_category'])),
                    );
                }
            } else {
                foreach ($this->children_catetory as $childrencatetory) {
                    $children[] = array(
                        'name' => $childrencatetory['name'],
                        'href' => Yii::app()->controller->createUrl('product/category', array("category_id" => $topcategory['id_category'] . "_" . $childrencatetory['id_category'])),
                    );
                }
            }

            $this->menu[] = array(
                'name' => $topcategory['name'],
                'children' => $children,
                'category_id' => $topcategory['id_category'],
                'column' => $topcategory['column'] ? $topcategory['column'] : 1,
                'href' => Yii::app()->controller->createUrl('product/category', array("category_id" => $topcategory['id_category'])),
            );
        }
        $this->more_category = $this->getMoreCategory();

        foreach ($this->more_category as $morecategory) {
            $this->children_catetory = $this->getChildCategory($morecategory['id_category']);
            $children = array();
            if (Yii::app()->config->getData('CONFIG_STORE_SHOW_CATEGORY_PRODUCT_COUNT') == '1') {
                foreach ($this->children_catetory as $childrencatetory) {
                    $product_count = $this->productCount($childrencatetory['id_category']);
                    $children[] = array(
                        'name' => $childrencatetory['name'] . "(" . $product_count . ")",
                        'href' => Yii::app()->controller->createUrl('product/category', array("category_id" => $childrencatetory['id_category'] . "_" . $childrencatetory['id_category'])),
                    );
                }
            } else {
                foreach ($this->children_catetory as $childrencatetory) {
                    $children[] = array(
                        'name' => $childrencatetory['name'],
                        'href' => Yii::app()->controller->createUrl('product/category', array("category_id" => $childrencatetory['id_category'] . "_" . $childrencatetory['id_category'])),
                    );
                }
            }

            $this->more[] = array(
                'name' => $morecategory['name'],
                'children' => $children,
                'category_id' => $morecategory['id_category'],
                'column' => $topcategory['column'] ? $topcategory['column'] : 1,
                'href' => Yii::app()->controller->createUrl('product/category', array("category_id" => $morecategory['id_category'])),
            );
        }
        //more categories

        $this->render("navigation");
    }

    public function getTopCategory() {

        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT c.id_category,cd.name,c.image,c.column FROM {{category_description}} cd , {{category}} c WHERE c.id_category=cd.id_category and cd.id_language="' . $this->id_language . '" and c.id_parent=0 and c.top=1 and c.status=1 order by c.sort_order asc');
        return $command->queryAll();
    }

    public function getMoreCategory() {

        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT c.id_category,cd.name,c.image,c.column FROM {{category_description}} cd , {{category}} c WHERE c.id_category=cd.id_category and cd.id_language="' . $this->id_language . '" and c.id_parent=0 and c.top=0 and c.status=1 order by c.sort_order asc');
        return $command->queryAll();
    }

    public function getChildCategory($topcategory_id) {

        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT c.id_category,cd.name FROM {{category_description}} cd , {{category}} c WHERE c.id_category=cd.id_category and cd.id_language="' . $this->id_language . '" and c.id_parent="' . $topcategory_id . '" order by c.sort_order asc');
        return $command->queryAll();
    }

    public function productCount($category_id) {
        $connection = Yii::app()->db;
        $product = $connection->createCommand('SELECT count(*) as count FROM {{product_category}} pc, {{product}} p WHERE p.id_product=pc.id_product and p.status=1 and pc.id_category=' . $category_id . ' and p.date_product_available <= NOW()')->queryScalar();
        return $product['count'];
    }
}