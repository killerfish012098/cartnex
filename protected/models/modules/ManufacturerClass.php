<?php
class ManufacturerClass
{
	public $data;
	public function __construct($data=null) {
		$manufacturers=Catalog::getManufacturers();
		$this->data=array('manufacturers'=>$manufacturers);
	}
}
