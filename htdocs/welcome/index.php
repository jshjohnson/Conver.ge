<?php 	
	require("../config.php"); 
	require(ROOT_PATH . "core/init.php");

	$users->loggedOutProtect();

	$trial_user = $trials->getTrialUser($sessionUserID);

	$vote_id = $trial_user["user_id"]; 
	$trialUserVotes = $votes->getUserVotes($vote_id);

	$votes = $trialUserVotes['CountOfvote_id'];

	$pageTitle = "Welcome";
	$pageType = "Welcome";
	$section = "Welcome";

	include_once(ROOT_PATH . "includes/header.inc.php");
	include_once(ROOT_PATH . "views/welcome/welcome.html");
	include_once(ROOT_PATH . "includes/footer.inc.php");
?>