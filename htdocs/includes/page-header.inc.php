	<header class="header cf 
		<?php if($section == "Designer") { ?>
			header--designer 
		<?php } else if($section == "Employer") { ?> 
			header--employer 
		<?php } ?>

		<?php if($pageType == "Page") { ?>
			zero-bottom
		<?php } ?>
		
		<?php if($pageType == "Page" && $section == "Designer") { ?>
			header-blue--alt
		<?php } else if($pageType == "Page" && $section == "Developer") { ?>
			header-navy--alt
		<?php } else if($pageType == "Page" && $section == "Employer") { ?>
			header-green--alt
		<?php } ?>
		">
			<div class="container">
				<?php if (!isset($_SESSION['logged'])) : ?>
				<h1 class="header__section header__section--title"><?= $pageTitle; ?>
					<?php if ($pageTitle == "Sign Up") : ?>
					<a href="" class="login-trigger header__section--title__link">: Log In</a>
					<!-- Revisit this -->
					<?php else : ?>
					<a href="" class="login-trigger header__section--title__link">: Register</a>
					<?php endif;?>
				</h1>
				<?php include_once(ROOT_PATH . "includes/page-nav.inc.php"); ?>
				<h2 class="header__section header__section--logo">
					<a href="<?= BASE_URL; ?>">connectd</a>
				</h2>
				<?php else : ?>
				<h1 class="header__section header__section--title"><?= $pageTitle; ?>
					<a href="" class="menu-trigger header__section--title__link">: Menu</a>
				</h1>
				<?php include_once(ROOT_PATH . "includes/page-nav.inc.php"); ?>
				<h2 class="header__section header__section--username">
					<a href="<?= BASE_URL . "dashboard/" ?>" class="header-username"><?= $username; ?></a>
				</h2>
				<?php endif; ?>
			</div>
		</header>