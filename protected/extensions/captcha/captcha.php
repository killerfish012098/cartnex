<?php
class Captcha extends CWidget{
	protected $code;
	protected $width = 35;
	protected $height = 150;

	function showImage() {
		$code=rand(1000,9999);
		Yii::app()->session['captcha_code']=$code;
		$im = imagecreatetruecolor(50, 24);
		$bg = imagecolorallocate($im, 22, 86, 165); //background color blue
		$fg = imagecolorallocate($im, 255, 255, 255);//text color white
		imagefill($im, 0, 0, $bg);
		imagestring($im, 5, 5, 5,  $code, $fg);
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
	}
}
?>