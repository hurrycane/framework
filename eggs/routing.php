<?php
class Routing{
}

class NestedRoutes{
	private $routing;
	public $controller;

	function __construct($ref){
		$this->routing=$ref;
	}

	function __call($method,$opt){
		switch($method){
			case "resources":
				$this->routing->resources($opt[0],$this->controller."/:id/");
			break;
			default:
				trigger_error("No method with the name: $method",E_USER_ERROR);
			break;
		}
	}
}


class Routes extends Routing{
	public $routing_tree = array();

	public function connect($path){
		$opt = $this->where_to(func_get_args());
		$this->add_to_tree($path,$opt);
	}

	public function resources($controller,$header=false){
		# index
		$this->connect($header.$controller,
		               ":controller=>$controller",
			       ":action=>index",
			       ":method=>GET");
		# new
		$this->connect($header.$controller."/new",
		               ":controller=>$controller",
			       ":action=>new",
			       ":method=>GET");

		# show
		$this->connect($header.$controller."/:id",
		               ":controller=>$controller",
			       ":action=>show",
			       ":method=>GET");
		# edit
		$this->connect($header.$controller."/:id/edit",
		               ":controller=>$controller",
			       ":action=>edit",
			       ":method=>GET");
		# create
		$this->connect($header.$controller,
		               ":controller=>$controller",
			       ":action=>create",
			       ":method=>POST");
		# update
		$this->connect($header.$controller."/:id",
		               ":controller=>$controller",
			       ":action=>update",
			       ":method=>POST");
		# delete
		$this->connect($header.$controller."/:id/delete",
		               ":controller=>$controller",
			       ":action=>delete",
			       ":method=>POST");

		$nested = new NestedRoutes($this);
		$nested->controller=$controller;
		return $nested;
	}

	public function dump_to_file($file_name){
		if(strpbrk($file_name, ".")){
			trigger_error("Extension is not needed",E_USER_ERROR);
		}else{
			$handle = fopen(SITE_PATH."config/".$file_name.".tmp.php","w");
			$this->build_output($handle);
		}

	}

	private function where_to($pieces){
		$opt = array();
		for($i=1;$i<count($pieces);$i++){
			$s = explode("=>",$pieces[$i]);
			$opt[substr($s[0],1)]=$s[1];
		}
		return $opt;
	}

	private function add_to_tree($path,$opt){
		$parts=explode("/",$path);
		$nr_parts=count($parts);
		$obj = &$this->routing_tree;
		for($i=0;$i<$nr_parts;$i++){
			$a = substr_count($parts[$i],":");
			if(empty($obj)) {
				$obj[0]=$this->create_elem($parts[$i]);
				$obj["count"]++;
				$current = &$obj[0];
			}else{
				$b=$this->check_for_part($parts[$i],$obj);
				if($b!=-1){
					if($b[0]==1&&empty($b[2])){
						$obj[$b[1]]["name"][]=substr($parts[$i],1);
					}
					$current=&$obj[$b[1]];
				}else{
					$obj[]=$this->create_elem($parts[$i]);
					$current = &$obj[$obj["count"]];
					$obj["count"]++;
				}
			}
			$obj = &$current;
		}
		if(!empty($opt["method"])){
			$obj[strtolower($opt["method"])]=$opt;
			unset($obj[strtolower($opt["method"])]["method"]);
		}else{
			$obj["both"]=$opt;
		}
	}

	private function create_elem($part){
		$a = substr_count($part,":");
		$elem = array();
		if($a){
			$elem["type"]="any";
			# FIXME needs work for more anonymous parts
			$elem["name"]=array(substr($part,1));
		}else{
			$elem["type"]="normal";
			$elem["name"]=$part;
		}
		$elem["count"]=0;
		return $elem;
	}

	private function check_for_part($part,$obj){
		$a = substr_count($part,":");
		$found = 0;
		$type = 0;
		$place = 0;
		$any_exists=FALSE;

		for($i=0;$i<$obj["count"];$i++){
			if($obj[$i]["type"]=="any"&&$a!=0){
				$w = substr($part,1);
				$biz = -1;
				for($j=0;$j<count($obj[$i]["name"]);$j++){
					if($obj[$i]["name"][$j]==$w){
						$biz = $j;
						break;
					}
				}
				$type=1;
				$place=$i;
				$found=1;
				if($biz!=-1) $any_exists=TRUE;
				break;
			}elseif($obj[$i]["type"]=="normal"&&$a==0){
				if($obj[$i]["name"]==$part){
					$found = 1;
					$type=2;
					$place=$i;
					break;
				}
			}
		}
		if($found==0) {
			return -1;
		}else{
			$ar = array($type,$place);
			if($any_exists!=FALSE) array_push($ar,$any_exists);
			return $ar;
		}
	}

	private function build_output($handle){
		$h=$handle;
		$root = &$this->routing_tree;
		$output = "<?php\n";
		$output .= '$root = array();'."\n";
		$output .= $this->dfs($root,'$root');
		$output .= "?>";
		fwrite($h,$output);
		fclose($h);
	}

	private function dfs($root,$header){
		$output = $header .'["count"]='.$root["count"].";\n";
		for($i=0;$i<$root["count"];$i++){
			$x = &$root[$i];
			$hd = $header."[".$i."]";
			$output .= $hd ."=array();\n";
			$output .= $hd . "[".'"type"'."]=".'"'.$x["type"].'"'.";\n";

			if($x["type"]=="any"){
				$output .= $hd . '["name"]=array();'."\n";
				for($j=0;$j<count($x["name"]);$j++){
					$output .= $hd . '["name"]['.$j.']='.'"'.$x["name"][$j].'"'.";\n";
				}
			}else{
				$output .= $hd . "[".'"name"'."]=".'"'.$x["name"].'"'.";\n";
			}

			$methods=array("both","get","post");
			$intersect = array_intersect(array_keys($x),$methods);
			if(!empty($intersect)){
				foreach($intersect as $v){
					foreach($x[$v] as $key=>$value){
						$output.=$hd . '["'.$v.'"]'.'["'.$key.'"]='.'"'.$value.'";'."\n";
					}
				}

			}

			$output .= $this->dfs($x,$hd);
		}
		return $output;
	}

}

?>
