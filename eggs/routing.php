<?php
class Routing{
	private $url;
	private $method;
	private $count;
	private $param;

	function __construct($request,$routes_file="routes"){
		$this->load_tree($routes_file);
		$this->url=$request->uri_parts;
		$this->method=$request->request_method;
	}

	public function climb(){
		$result=$this->mount($this->routing_tree,0);
		if(!empty($result["error"])) {
			trigger_error($result["error"],E_USER_ERROR);
			exit($result["error"]);
		}
		if(!empty($this->param)){
			$result["param"]=$this->param;
		}
		return $result;
	}

	private function mount($root,$part){
		$found=-1;
		$type=1;

		for($i=0;$i<$root["count"];$i++){
			if($root[$i]["type"]=="normal"){
				if($root[$i]["name"]==$this->url[$part]){
					$found = $i;
					break;
				}
			}else{
				$found=$i;
				$type=2;
				break;
			}
		}
		if($found!=-1){
			if($root["type"]=="any"){
				$this->param[$root["name"][$found]]=$this->url[$part-1];
			}

			if($part<count($this->url)-1){
				return $this->mount($root[$i],$part+1);
			}else{
				if(!empty($root[$found][$this->method])){
					return $root[$found][$this->method];	
				}elseif(!empty($root[$found]["both"])){
					return $root[$found]["both"];
				}else{
					return array("error"=>"No route found");
				}
			}
		}else{
			return array("error"=>"No route found");
		}

	}

	private function load_tree($file){
		if(file_exists(SITE_PATH."config/$file.tmp.php")){
			include_once(SITE_PATH."config/$file.tmp.php");
			$this->routing_tree=&$root;
		}else{
			if(empty($root)){
				$this->load_routes($file);
			}
		}
	}
	
	private function load_routes($file){
		$routes = new Routes;
		include_once(SITE_PATH."config/$file.php");
		$routes->dump_to_file("$file");
		$this->routing_tree=&$routes->routing_tree;
	}

}
?>
