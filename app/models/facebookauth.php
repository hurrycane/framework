<?php
class FacebookauthModel extends ModelBase{
	function get_auth_url($user_id){
		$this->query("SELECT * FROM facebookauth WHERE `user_id` ='?'",$user_id);
		$a=$this->fetch_assoc();
		return $a["url"];
		
	}
}

?>
