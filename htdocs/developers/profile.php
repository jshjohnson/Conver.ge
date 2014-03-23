<?php 
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$general->loggedOutProtect();

	if (isset($_GET["id"])) {
		$developer_id = $_GET["id"];
		$developer = $developers->get_developers_single($developer_id);
	}

	if (empty($developer)) {
		header("Location: " . BASE_URL);
		exit();
	}
	
	$pageTitle  = $developer['firstname'] . ' ' . $developer['lastname'] . ' :: ' . $developer['jobtitle'];
	$section    = "Developers";

	include_once(ROOT_PATH . "includes/header.inc.php");

?>
		<section class="container">
			<div class="grid--no-marg cf">
				<aside class="user-module grid__cell unit-1-3--bp2 module module-1-3 module--no-pad float-left">
					<div class="badge badge--right color-red">
						<span class="badge__inner">
							<h5>£<?= $developer['priceperhour']; ?></h5>
							<small>per hour</small>
						</span>
					</div>
					<div class="user-module__header">
						<div class="user-module__avatar">
							<img src="http://placehold.it/400x400" alt="">
						</div>
						<div class="button-wrapper">
							<a class="button--left btn btn--green cf hire-trigger" href="mailto:<?= $developer['email']; ?>?subject=I would like to hire you! -- Connectd&body=Hey <?= $developer['firstname']; ?>...">Hire <?= $developer['firstname']; ?></a>
							<a class="button--right btn btn--blue cf hire-trigger" href="mailto:<?= $developer['email']; ?>?subject=I would like to collaborate with you! -- Connectd&body=Hey <?= $developer['firstname']; ?>..."?>Collaborate</a>
						</div>
					</div>
					<div class="user-module__info">
						<h3 class="user-module__title"><?= $developer['firstname'] . " " . $developer['lastname']; ?></h3>
						<h4 class="user-module__label icon--attach icon--marg"><?= $developer['jobtitle']; ?></h4>
						<h4 class="user-module__label icon--location icon--marg"><?= $developer['location']; ?></h4>
						<h4 class="user-module__label icon--globe icon--marg"><a href="http://<?= $developer['portfolio']; ?>"><?php $url = preg_replace("(https?://)", "", $developer["portfolio"] ); echo $url ?></a></h4>
						<p><?= $developer['bio']; ?></p>
					</div>
				</aside>
				<article class="portfolio grid__cell module-2-3 module--no-pad float-right">
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings">
							<li class="active active--navy">Skills</li>
							<li class="float-right help"><a href="" class="dev-skills-trigger">What are these skills?</a></li>
						</ul>
					</nav>
					<div class="container__inner">
						<ul class="grid--no-marg">
							<li class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="5">HTML5</div>
								</div>
							</li>
							<li class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="3">CSS3</div>
								</div>
							</li>
							<li class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="3">WordPress</div>
								</div>
							</li>
							<li class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="4">jQuery</div>
								</div>
							</li>
							<li class="grid__cell--no-pad skills--developer">
								<div class="skills__bar">
									<div class="skill__name" data-skill="2">Git</div>
								</div>
							</li>
						</ul>
					</div>
					<nav class="portfolio__headings-bg zero-bottom">
						<ul class="portfolio__headings portfolio__headings">
							<li class="active active--navy"><a href="">Responsive websites</a></li>
							<li><a href="">WordPress</a></li>
						</ul>
					</nav>
					<div class="container__inner">
						<ul class="grid grid__developer">
							<li class="grid__cell grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/developer-1.jpg" alt="">
							</li>
							<li class="grid__cell grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/developer-2.jpg" alt="">
							</li>
							<li class="grid__cell grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/developer-3.png" alt="">
							</li>
							<li class="grid__cell grid__cell--img">
								<img src="<?= BASE_URL; ?>assets/img/developer-4.jpg" alt="">
							</li>
						</ul>
					</div>
					<nav class="portfolio__headings-bg">
						<ul class="portfolio__headings portfolio__headings">
							<li class="active active--navy">Testimonial</li>
						</ul>
					</nav>
					<div class="container__inner push-bottom">
					<blockquote>
						<p>"I have found Josh to be a very hard-working colleague. He is highly organised, has great communication skills and I have always been very impressed with the way that he has approached work. As such, we have been very happy to ask Josh to support our development team with on-going client work."</p>
						<b class="source">Phil Shackleton, Mixd</b>
					</blockquote>
					</div>
				</article>
			</div>
		</section>
		<section class="call-to-action">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for someone else?
				</h4>
				<a class="btn btn--red" href="<?= BASE_URL; ?>developers/list/">See our talented bunch</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>