<?php
class CallbackController extends Controller{
	function __construct(){
		$this->init();
	}

	function index(){
		global $facebookauth;
		$a = $facebookauth->get_auth_url("1");
		echo $a;
	}

	function edit(){
		global $jobs;
		$jobs->add(1,"facebook_auth_create_token");
	}

	function show(){
		# twitter
		if($this->request->uri_parts[1]=="twitter"){
			global $twitteracts;
			$twitteracts->put_tw_tokens($_GET["oauth_token"],$_GET["oauth_verifier"],"1");
		}
		# flickr
		if($this->request->uri_parts[1]=="flickr"){
			global $flickrauths;
			global $jobs;
			$flickrauths->put_fl_tokens($_GET["frob"],1);
			$jobs->add(1,"flickr_frob_token");
		}

		# facebook
		if($this->request->uri_parts[1]=="facebook"){
			global $jobs;
			$jobs->add(1,"facebook_auth_get_session");
		}

	}

}
?>
