<?php
class BannerClass
{
	public $data;
	public function __construct($data=null) {
		$banners= array();
		//$banObj=new Banner();
		//$results = $banObj->getSlideShow($data['banner']);
		$results = Library::getSlideShow($data['banner']);


		foreach ($results as $result)
		{
				$banners[] = array(
					'label' => $result['title'],
					'caption' => $result['title'],
					'link'  => $result['link'],
					'image' => $result['image'],
                                        'path'=>Library::getMiscUploadLink(),
				);
		}
		
		$this->data=array("banners"=>$banners,'info'=>$data);
		
	}
}
