<?php 
class Resize extends CWidget{
    
    public function init(){
	    return parent::init();
    }//init
   
	//image resize fucntion comes here..
	public function resize($filename, $width, $height) {
	    define("DIR_IMAGE", Library::imageRootPath());
		//echo DIR_IMAGE . $filename;
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		$info = pathinfo($filename);
		
		$extension = $info['extension'];
		
		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		
		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}
            require_once "classes/image.php";
			$image = new Image(DIR_IMAGE . $old_image);
			$image->resize($width, $height);
			$saveimage=$image->save(DIR_IMAGE . $new_image);
			return  Library::getCatalogUploadLink().$new_image;
		}else {
			return  Library::getCatalogUploadLink().$new_image;
		}
	
		
			
			
	}
}//class
?>