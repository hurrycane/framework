<?php
class Model{
	public $config;
	private $loaded_models;
	function __construct(){
	}

	function load(){
		if(empty($this->config)){
			trigger_error("The config file must be loaded manually");
			exit("The config file must be loaded manually");
		}
		$config_models = $this->config["models"];

		foreach($config_models as $value){
			global $$value;
			include_once(APP_FOLDER."models/$value.php");
			$cname=ucfirst($value)."Model";
			$$value=new $cname;
		}

	}

	# basic mysql functions
	# -> query
	# -> fetch_object
	# -> fetch_array
	# -> num_rows
	# -> data_seek
	# -> error
	# -> result

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
