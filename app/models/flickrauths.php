<?php
class FlickrauthsModel extends ModelBase{
	function get_auth_url($user_id){
		$this->query("SELECT * FROM flickrauths WHERE `user_id` ='?'",$user_id);
		$a=$this->fetch_assoc();
		return $a["url"];
	}


	function put_fl_tokens($frob,$user_id){
		$this->query("UPDATE flickrauths SET frob='?' WHERE user_id='?'",$frob,$user_id);
	}
}

?>
