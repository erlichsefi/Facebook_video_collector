<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
	session_start();
	ob_start();
	$debug =false;

	require_once $local_path_to_dir."/crawler/facebook-php-sdk/src/Facebook/autoload.php";

	$fb = new Facebook\Facebook([
	  'app_id' => $app_id,
	  'app_secret' =>  $app_secret,
	  'default_graph_version' => $version,
	  ]);
	  
	$helper = $fb->getRedirectLoginHelper();

	if (isset($_GET['state'])) {
    		$helper->getPersistentDataHandler()->set('state', $_GET['state']);
	}
	if(!isset($DO_NOT_CLOSE_SESSION)){
		session_write_close();
	}
