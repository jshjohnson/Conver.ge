<?php 	
	require_once("../config.php");  
	include_once(ROOT_PATH . "includes/header.inc.php");
	require_once(ROOT_PATH . 'inc/checklog.php');
	 

	session_start();
	//Connect to DB
	require_once(ROOT_PATH . "includes/db_connect.php");

	mysqli_select_db($db_server, DB_NAME) or die("Couldn't find db");

	// Query designers
	$designers = mysqli_query($db_server, "SELECT COUNT(1) FROM connectdDB.designers"); 
	$designerResult = mysqli_fetch_array($designers);
	$designerTotal = $designerResult[0];

	// Query developers
	$developers = mysqli_query($db_server, "SELECT COUNT(1) FROM connectdDB.developers"); 
	$developerResult = mysqli_fetch_array($developers);
	$developerTotal = $developerResult[0];

	// Query employers
	$employers = mysqli_query($db_server, "SELECT COUNT(1) FROM connectdDB.employers"); 
	$employerResult = mysqli_fetch_array($employers);
	$employerTotal = $employerResult[0];


	// Query jobs
	$jobs= mysqli_query($db_server, "SELECT COUNT(1) FROM connectdDB.jobs"); 
	$jobResult = mysqli_fetch_array($jobs);
	$jobTotal = $jobResult[0];


	$userTotal = $employerTotal + $designerTotal + $developerTotal;

?>
		<header class="header cf">
			<div class="container">
				<h1 class="header__section header__section--title">
					Admin<a href="" class="menu-trigger header__section--title__link "> : Menu</a>
				</h1>
				<nav class="header__nav">
					<ul>
						<li><a href="<?= BASE_URL; ?>settings/">Settings</a></li>
						<li><a href="<?= BASE_URL; ?>sign-out.php">Log out</a></li>
					</ul>
				</nav>
				<h2 class="header__section header__section--logo">
					<a href="<?= BASE_URL; ?>" class="icon--home">connectd</a>
				</h2>
			</div>
		</header>
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-left">
					<header class="header--panel header--designer cf">
						<h3 class="float-left">Designers</h3>
					</header>
					<div class="media-wrapper">
						<div class="media">
							<div class="media__body">
								<div class="float-left user-info">
									<h4>Number of designers:</h4>
								</div>
								<div class="float-right price-per-hour">
									<h5><?= $designerTotal; ?></h5>
								</div>
							</div>
						</div>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Developers</h3>
					</header>
					<div class="media-wrapper">
						<div class="media">
							<div class="media__body">
								<div class="float-left user-info">
									<h4>Number of developers:</h4>
								</div>
								<div class="float-right price-per-hour">
									<h5><?= $developerTotal; ?></h5>
								</div>
							</div>
						</div>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-left">
					<header class="header--panel header--employer cf">
						<h3 class="float-left">Employers</h3>
					</header>
					<div class="media-wrapper">
						<div class="media">
							<div class="media__body">
								<div class="float-left user-info">
									<h4>Number of employers:</h4>
								</div>
								<div class="float-right price-per-hour">
									<h5><?= $employerTotal; ?></h5>
								</div>
							</div>
						</div>
					</div>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-right">
					<header class="header--panel header--alt cf">
						<h3 class="float-left">Data Crunching</h3>
					</header>
					<div class="media-wrapper">
						<div class="media">
							<div class="media__body">
								<div class="float-left user-info">
									<h4>Total number of users:</h4>
								</div>
								<div class="float-right price-per-hour">
									<h5><?= $userTotal; ?></h5>
								</div>
							</div>
						</div>
						<div class="media">
							<div class="media__body">
								<div class="float-left user-info">
									<h4>Total number of jobs:</h4>
								</div>
								<div class="float-right price-per-hour">
									<h5><?= $jobTotal; ?></h5>
								</div>
							</div>
						</div>
					</div>
				</article>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>
