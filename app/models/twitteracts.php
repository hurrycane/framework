<?php
class TwitteractsModel extends ModelBase{
	function get_auth_url($user_id){
		$this->query("SELECT * FROM twitteracts WHERE `user_id` ='?'",$user_id);
		$a=$this->fetch_assoc();
		return $a["url"];
		
	}

	function put_tw_tokens($tokena,$secreta,$user_id){
		$this->query("UPDATE twitteracts SET tokena='?', secreta='?' WHERE user_id='?'",$tokena,$secreta,$user_id);
	}
}

?>
