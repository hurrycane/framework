<?php
class View{
	public $no_layout;
	private $view_name;
	private $data=array();

	function load($view_name){
		$this->view_name = $view_name;
	}

	function is_view_set(){
		if(empty($this->view_name)){
			return false;
		}else{
			return true;
		}
	}

	function data($data_name,$data_content){
		$this->data[$data_name]=$data_content;
	}

	function dump($request_info){
		$controller = $request_info["controller"];
		$action = $request_info["action"];
		if($this->no_layout==false){
			if($this->layout){
				$layout_path=APP_FOLDER."views/layouts/".$this->layout.".php";
			}else{
				$layout_path=APP_FOLDER."views/layouts/$controller.php";
			}

			if(!file_exists($layout_path)){
				trigger_error("No layout defined by the user",E_USER_ERROR);
				exit("No layout defined by the user");
			}
		}

		if(empty($this->view_name)){
			$view_path = APP_FOLDER."views/$controller/$action.php";
		}else{
			$view_path = APP_FOLDER."views/$controller/".$this->view_name.".php";
		}

		if(!file_exists($view_path)){
			trigger_error("No view defined by the user",E_USER_ERROR);
			exit("No view defined by the user");
		}

		foreach($this->data as $key=>$value){
			$$key=$value;
		}

	
		ob_start();
		include_once($view_path);
		$output=ob_get_contents();
		ob_end_clean();

		if($this->no_layout==false){
			include_once($layout_path);
		}else{
			echo $output;
		}

	}
}
?>
