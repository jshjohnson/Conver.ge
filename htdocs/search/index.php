<?php 	
	require_once("../config/config.php"); 
	include_once(ROOT_PATH . "inc/db_connect.php");
	include_once(ROOT_PATH . "inc/functions.php");
	checkLoggedOut();

	$pageTitle = "Search";
	$section = "Search";
	
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");
?>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				
			</div>
		</section>
<?php 
	require_once(ROOT_PATH . "inc/db_close.php");
	include_once(ROOT_PATH . "views/footer-page.php"); 
?>