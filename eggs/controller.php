<?php
# this class incorporates
# flash - a way to comunicate between two concurent requests
# mime - a way to handle diferent requests in terms of mime type (xhr/html/xml)
# cookies
# session
# headers
# req_forgery
# dinamic model loading
# views/layouts
# helpers
class Controller{
	public $flash;
	public $old_flash;
	public $cookie;
	public $header;
	# FIXME view can be seen only inside the controller class
	# private $view
	function __construct(){
		# FIXME give the type param to the controller
	}

	function __destruct(){
		# only in loaded controller
		if(get_class($this)=="Controller") return ;
			if($this->is_after==true) $this->after();
		if(!empty($this->flash)){
			$this->session["flash"]=array_diff($this->flash,$this->old_flash);
		}
		$_SESSION=$this->session;

		if(!isset($this->view)) return ;

		# view
		if($this->no_layout==TRUE) $this->view->no_layout=TRUE;
		$this->view->dump($this->request->request_info);
	}

	public function init(){
		# only in the loaded controller
		if(get_class($this)=="Controller") return ;
		# init session
		$this->session=$_SESSION;
		session_unset();

		# init flash
		if(!empty($this->session["flash"])){
			$this->flash=$this->session["flash"];
			$this->old_flash=$this->session["flash"];
		}else{
			$this->flash=array();
			$this->old_flash=array();
		}

		# init cookies
		if(!empty($_COOKIE)) $this->init_cookies();
		# init filters
		$this->init_filters();
		# init header
		$this->header=array();
	}

	public function load($request){
		$req_controller=$request->request_info["controller"];
		$req_action=$request->request_info["action"];

		include_once(APP_FOLDER."controllers/".$req_controller."_controller.php");
		$req_cname=ucfirst($req_controller)."zController";
		$loaded=new $req_cname;
		$this->precontroller(&$loaded,$request);
		$loaded->$req_action();
		
	}

	private function precontroller($controller,$request){
		# init view
		$controller->view=load_egg("view",1);
		# init request
		$controller->request=$request;
	}

	private function postcontroller(){
	
	}

	public function setcookie($name,$value,$expire,$path=false,$domain=false){
		# FIXME include from config
		$key = "moscraciunexista";
		# FIXME iv and iv_size can be generate just once
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$value = mcrypt_encrypt (MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB, $iv);
		setcookie($name,$value,$expire,$path,$domain);
	}


	private function init_cookies(){
		if(!empty($_COOKIE)){
			# FIXME include from config
			$mkey = "moscraciunexista";
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

			foreach($_COOKIE as $key=>$value){
				if($key=="PHPSESSID") continue;
				$text= $_COOKIE[$key];
				$value = rtrim(mcrypt_decrypt (MCRYPT_RIJNDAEL_256, $mkey, $text, MCRYPT_MODE_ECB, $iv));
				$this->cookie[$key]=$value;
			}
		}
	}

	private function init_filters(){
		$methods = get_class_methods($this);
		if(in_array("before",$methods)){
			$this->before();
		}
		if(in_array("after",$methods)){
			$this->is_after = true;
		}
	}

	public function header($header){
		array_push($this->header,$header);
	}
}
?>
