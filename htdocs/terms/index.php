<?php 
	require_once("../../config.php");  
	include_once(ROOT_PATH . "inc/functions.php");

	$pageTitle = "Terms & Conditions";
	$section = "Terms & Conditions";

	checkLoggedOut();

	include_once(ROOT_PATH . "views/header.php"); ?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
				<?php if (!isset($_SESSION['logged'])) :?>
				<h1 class="header__section header__section--title"><?= $pageTitle ?>
					<a href="" class="login-trigger header__section--title__link">: Log In</a>
				</h1>
				<?php else : ?>
				<h1 class="header__section header__section--title"><?= $pageTitle ?>
					<a href="" class="menu-trigger header__section--title__link">: Menu</a>
				</h1>
					<?php include_once(ROOT_PATH . "views/page-nav.php"); ?>
				<?php endif; ?>
			<h2 class="header__section header__section--logo">
				<a href="<?= BASE_URL ?>">connectd</a>
			</h2>
		</div>
	</header>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 form-overlay">
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "views/footer.php"); ?>