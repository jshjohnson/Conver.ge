<?php
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle    = "About Us";
	$pageType     = "Page";
	$section      = "Blue";

	include_once(ROOT_PATH . "includes/header.inc.php");
?>
	<section class="section color-blue">
		<div class="container__inner">
			<div class="grid text-center">
				<div class="grid__cell unit-2-3--bp4">
					<blockquote class="intro-quote">
						“Quality is never an accident. It is always the result of intelligent effort.”
						<footer class="source">John Ruskin</footer>
					</blockquote>
				</div>
			</div>
		</div>
	</section>
	<section class="section color-navy">
		<div class="container__inner">
			<div class="grid">
				<div class="section__content grid__cell unit-1-2--bp2">
					<h2>We care about your work</h2>
					<p>
						Connectd is an entirely new community-based service, targetted towards the high quality niche freelance market, aiming to align high quality freelancers seeking work, with fair paying employers searching for high quality, reliable freelancers.
					</p>
					<p>
						Connectd works by individually handpicking freelancers through the community to ensure only the best are granted access to the service. Not only does this assure employers that the freelancer they hire is of a sought-after callibre, it also shifts the focus from that of price, to that of <i>quality</i>.
					</p>
				</div>
				<div class="grid__cell unit-1-2--bp2">
					<img src="<?= BASE_URL; ?>assets/img/iphone.png" alt="" class="iphone-img">
				</div>
			</div>
		</div>
	</section>
	<section class="section color-white cf">
	<div class="container__inner">
			<div class="grid">
				<div class="section__content grid__cell unit-1-2--bp2 float-right">
					<h2>How are we different</h2>
					<p>
						Connectd works by individually handpicking freelancers through the community to ensure only the best are granted access to the service. Not only does this assure employers that the freelancer they hire is of a sought-after callibre, it also shifts the focus from that of price, to that of <i>quality</i>.
					</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, libero, eveniet, odit, dignissimos natus reprehenderit inventore qui laudantium iure corporis voluptatibus ut quae doloremque reiciendis perferendis numquam minima. Blanditiis, quasi.</p>
				</div>
				<div class="grid__cell unit-1-2--bp2 float-left">
					<img src="<?= BASE_URL; ?>assets/img/bubbles.png" alt="" class="section__img">
				</div>
			</div>
		</div>
	</section>
	<section class="section color-green section--mission">
		<div class="container footer--push">
			<div class="grid">
				<div class="section__content grid__cell unit-1-2--bp2">
					<h2>Help us achieve our life mission</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, libero, eveniet, odit, dignissimos natus reprehenderit inventore qui laudantium iure corporis voluptatibus ut quae doloremque reiciendis perferendis numquam minima. Blanditiis, quasi.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, libero, eveniet, odit, dignissimos natus reprehenderit inventore qui laudantium iure corporis voluptatibus ut quae doloremque reiciendis perferendis numquam minima. Blanditiis, quasi.</p>
				</div>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>