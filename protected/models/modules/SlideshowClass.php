<?php
class SlideshowClass
{
	public $data;
	public function __construct($data=null,$moduleData=null) {
                $banners= array();
		//$banObj=new Banner();
		//$results = $banObj->getSlideShow($data['banner']);
		$results = Library::getSlideShow($data['banner']);
		
		foreach ($results as $result)
		{
				$image=Library::getMiscUploadLink().$result['image'];
				$banners[] = array(
					//'label' => $result['title'],
					'caption' => $result['title'],
					'link'  => $result['link'],
					'linkOptions' => array(
					'title' => $result['title'],
					),
					'image' => $image,
				);
		}
		
		$this->data=array("banners"=>$banners);
		
	}
}
