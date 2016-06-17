<?php 
class Rating extends CWidget{
	public $output;
	public function run($rating){
		$total=5;
		$i=1;
		$this->output='';
		while($i<=$total){
			if($i<=$rating){
				 $this->output .='<img src="/front_end/themes/default/img/star-c.png" width="12" height="12" alt=""  />';
			}else{
				$this->output .='<img src="/front_end/themes/default/img/star-b.png" width="12" height="12" alt=""  />';
			}
		$i++;}
      return $this->output;
	}
}
?>