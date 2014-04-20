<?php

	$headerClasses = array();
	
	if($section == "Designer") {
		$headerClasses[] = "header--blue";
	}else if($section == "Employer" || $section == "Job") {
		$headerClasses[] = "header--green";
	}else if($pageType == "Page" && $section == "Blue") {
		$headerClasses[] = "header-blue--alt";
	} else if($pageType == "Page" && $section == "Green") {
		$headerClasses[] = "header-green--alt";
	} else {
		$headerClasses[] = "header-navy--alt";
	}
	
	$headerClassesAll = implode(" ", $headerClasses);
?>

	<header class="header cf <?= $headerClassesAll; ?> <?php if($pageType == "Page") { ?>zero-bottom<?php } ?>">
			<div class="container">
			<?php if (!isset($_SESSION['logged'])) : ?>
				<?php if ($pageTitle == "Sign Up") : ?>
				<a class="nav-toggle nav-toggle--divide login-trigger icon--lock">Log in</a>
				<!-- Revisit this -->
				<?php else : ?>
				<a href="<?= BASE_URL; ?>#register" class="nav-toggle nav-toggle--divide icon--users">Register</a>
				<?php endif;?>
				<div class="header-section header-section--left">	
					<h1 class="header-section__title"><?php if(isset($pageTitle)) { echo $pageTitle; } ?></h1>
				</div>

				<div class="header-section header-section--right">
					<h2 class="header-section__title">
						<a href="<?= BASE_URL; ?>">connectd</a>
					</h2>
				</div>

			<?php else : ?>
				<?php include_once(ROOT_PATH . "includes/page-nav.inc.php"); ?>
				<div class="header-section header-section--left">
					<?php if($section == "Job" || $section == "Developer" || $section == "Designer" || $section == "Employer") : ?>	
					<h1 class="header-section__title"><?= $section; ?>
					<?php else : ?>
					<h1 class="header-section__title"><?= $pageTitle; ?>
					<?php endif; ?>
					</h1>
				</div>

				<div class="header-section header-section--right">
					<a href="<?= BASE_URL . $sessionUserType . "/profile/" . $sessionUser['user_id'] . "/"?>">
						<div style="background-image: url('<?= BASE_URL . $sessionAvatar; ?>');" class="header-section__avatar"></div>
					</a>
					<h2 class="header-section__title header-section__title--username">
						<a href="<?= BASE_URL . $sessionUserType . "/profile/" . $sessionUser['user_id'] . "/"?>"><?= $sessionUsername; ?></a>
					</h2>
					<a href="<?= BASE_URL . "dashboard/" ?>" class="header-section__home"></a>
				</div>

			<?php endif; ?>

			</div>
		</header>