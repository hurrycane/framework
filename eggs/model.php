<?php
# class from witch each model inherits the sql/validation/callback methods
class ModelBase{
	private $connection;
	public $result;

	function __construct($connection){
		$this->connection=$connection;
	}


	# $ceva->query("SELECT * FROM `tabel` WHERE `ceva`='?'");
	public function query($sql){
		$pieces=func_get_args();
		$offset=0;
		for($i=1;$i<count($pieces);$i++){
			$pos=strpos($sql,"?");
			$sql=substr($sql,0,$pos).mysql_real_escape_string($pieces[$i]).substr($sql,$pos+1);
		}
		$this->result = mysql_query($sql) or die(mysql_error());
	}

	public function fetch_assoc(){
		if(empty($this->result)) die("You must run query first");
		return mysql_fetch_assoc($this->result);
	}

	public function num_rows(){
		if(empty($this->result)) die("You must run query first");
		return mysql_num_rows($this->result);
	}

	public function free_result(){
		$val=mysql_free_result($this->result);
		unset($this->result);
		return $val;
	}

	public function fetch_object(){
		if(empty($this->result)) die("You must run query first");
		return mysql_fetch_object($this->result);

	}

	public function data_seek($pointer){
		if(empty($this->result)) die("You must run query first");
		return mysql_data_seek($this->result,$pointer);
	}

}

class Model{
	public $config;
	private $loaded_models;
	function __construct(){
	}

	function __destruct(){
		mysql_close($this->connection);
	}

	function load(){
		if(empty($this->config)){
			trigger_error("The config file must be loaded manually");
			exit("The config file must be loaded manually");
		}
		$config_models = $this->config["models"];
		$this->connect();
		foreach($config_models as $value){
			global $$value;
			include_once(APP_FOLDER."models/$value.php");
			$cname=ucfirst($value)."Model";
			$$value=new $cname(&$this->connection);
		}
	}

	private function connect(){
		$host=$this->config["host"];
		$db_name=$this->config["db_name"];
		$db_user=$this->config["db_user"];
		$db_pass=$this->config["db_pass"];

		$this->connection=mysql_connect($host,$db_user,$db_pass) or die("Mysql connection could not be established");
		mysql_select_db($db_name,$this->connection) or die("Mysql database selection error");
	}

	# basic mysql functions
	# -> query +
	# -> fetch_object +
	# -> fetch_array +
	# -> num_rows +
	# -> data_seek +
	# -> error - 
	# -> result +

	# basic model functions
	# -> load_model
	# -> callbacks
	# -> validations => acceptance, confirmation_of, exclusion,
	# format_of, inclusion_of, length_of, numericality_of,
	# presence_of, uniqueness_of
	# allow_nil, message, errors_on

	# callbacks => before_validation, after_validation, before_save
	# after_save, before/after update, before/after destroy
	# before/after create

	# callbacks => before_all, after_all
	# $model->load(); makes

	# exemple of usage
	# <in controller>
	# global $model_name;
	# $a = $model_name->get_account_info();
	# $a["ceva"];

	# $model_name->validate($array_of_vars,$name_of_var_to_type_of_validation);
	# $model->validate($array_of_vars, $model->login_form); # returns array of errors or just true of not
	# <in model>
	# fct ceva(){
	#    $a=$this->query("SELECT * FROM `tabel`");
	# }
	#

}

?>
