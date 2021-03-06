<?php 
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$users->loggedOutProtect();
	$users->grantedAccessProtect($sessionUserID);
	
	if (isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
	}
	
	$votedBy = $sessionUserID;

	if($user_id != '' && is_numeric($user_id)) {
		$votes->addVote($user_id, $votedBy);
	}
?>