<?php
Class Request{
	public $request_method;
	public $format;
	public $remote_ip;
	public $proxy_ip;
	public $url;
	public $host;
	public $port;
	public $host_with_port;
	public $domain;
	public $subdomain;
	public $query_string;
	public $path;
	public $params;
	public $refferer;
	# FIXME session and cookie are not parsed and/or espaced at this level
	public $session;
	public $cookie;
	public $uri_parts;
	public $request_info;

	function __construct(){
		$this->request_method();
		$this->format();
		$this->remote_ip();
		$this->host_port_url();
		$this->domain();
		$this->query_string_path_refferer();
	}

	private function request_method(){
		$this->request_method=strtolower($_SERVER["REQUEST_METHOD"]);
	}

	private function format(){
		if(@$_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest"){
			$this->format = "xhr";
		}elseif(strpos($_SERVER["HTTP_ACCEPT"],"text/html")!==FALSE){
			$this->format = "html";
		}elseif(strpos($_SERVER["HTTP_ACCEPT"],"application/xml")!==FALSE){
			$this->format = "xml";
		}
	}

	private function remote_ip(){
		if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) {
			if ($_SERVER["HTTP_CLIENT_IP"]) {
				$this->proxy_ip = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$this->proxy_ip = $_SERVER["REMOTE_ADDR"];
			}
	         	$this->remote_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else {
			if (@$_SERVER["HTTP_CLIENT_IP"]) {
				$this->remote_ip = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$this->remote_ip = $_SERVER["REMOTE_ADDR"];
			}
		}

	}

	private function host_port_url(){
		$this->host = $_SERVER["SERVER_NAME"];
		$this->port = $_SERVER["SERVER_PORT"];
		$protocol=explode("/",$_SERVER["SERVER_PROTOCOL"]);
		$protocol=strtolower($protocol[0]);
		$this->url = $protocol . "://" .$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		$this->host_with_port = $_SERVER["HTTP_HOST"];
	}

	private function domain(){
		$domain = explode(".",$_SERVER["SERVER_NAME"]);
		if($domain[0] == "www"){
			if(count($domain)>3){
				$this->domain=$domain[3];
				$this->subdomain=$domain[2];
			}else{
				$this->domain=$domain[2];
			}
		}else{
			if(count($domain)>2){
				$this->subdomain=$domain[0];
				$this->domain=$domain[1];
			}else{
				$this->domain=$domain[0];
			}
		}
	}

	private function query_string_path_refferer(){
		$this->query_string = $_SERVER["QUERY_STRING"];
		$this->path=$_SERVER["REQUEST_URI"];
		$this->referer=@$_SERVER["HTTP_REFERER"];
		
		$p=$this->path;
		$pos = strpos($p,"?");
		if($pos!==false) $p =  substr($p,0,$pos);
		if($p{0}=="/") $p=substr($p,1);
		if($p{strlen($p)-1}=="/") $p=substr($p,0,strlen($p)-1);
		$this->uri_parts=explode("/",$p);
	}

	private function params(){
		$this->params=array();
		if(!empty($_GET)){
			foreach($_GET as $key=>$value){
				$this->params[$key]=strip_tags($value);
			}
		}

		if(!empty($_POST)){
			foreach($_POST as $key=>$value){
				$this->params[$key]=strip_tags($value);
			}

		}

	}

}
?>
