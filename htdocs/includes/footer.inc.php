	<?php if(!$isHome) : ?>
		<footer class="footer cf">
			<div class="container">
				<div class="grid">
					<ul class="grid__cell unit-1-2--bp1 footer__links">
						<li><a href="<?= BASE_URL; ?>page.php?p=about">About</a></li>
						<li><a href="<?= BASE_URL; ?>page.php?p=sitemap">Sitemap</a></li>
						<li><a href="<?= BASE_URL; ?>page.php?p=terms">Terms</a></li>
					</ul>
					<h2 class="grid__cell unit-1-2--bp1 footer__section footer__section--logo">
						<a href="index.php">connectd <small><i>beta</i></small></a>
					</h2>
				</div>
			</div>
		</footer>
	</div>
	<?php endif;?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= BASE_URL; ?>assets/js/libs/jquery-1.7.2.min.js"><\/script>')</script>
	<script src="<?= BASE_URL; ?>assets/js/scripts.min.js"></script>
</body>
</html>