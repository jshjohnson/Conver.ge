<?php 	
	require_once("../config/config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->loggedOutProtect();

	$trial_user = $trials->getTrialUser($user_id);

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