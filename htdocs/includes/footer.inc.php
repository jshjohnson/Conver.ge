	<?php if(!$isHome) : ?>
		<?php
			if($pageType == "Page") {
				$footerClass = "footer--alt";
			}
		?>
			<footer class="footer <?= $footerClass; ?> cf">
				<div class="container">
					<div class="grid">
						<ul class="grid__cell unit-1-2--bp1 footer__links">
							<li><a href="<?= BASE_URL; ?>about/">About</a></li>
							<li><a href="<?= BASE_URL; ?>sitemap/">Sitemap</a></li>
							<li><a href="<?= BASE_URL; ?>terms-and-conditions/">Terms</a></li>
						</ul>
						<h2 class="grid__cell unit-1-2--bp1 footer__section footer__section--logo">
							<a href="index.php">connectd <small><i>beta</i></small></a>
						</h2>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<?php endif;?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= BASE_URL; ?>assets/js/libs/jquery-1.7.2.min.js"><\/script>')</script>
	<script src="<?= BASE_URL; ?>assets/js/scripts.min.js"></script>
	<!-- <script src="<?= BASE_URL; ?>assets/js/libs/mootools-1.2.1-core-yc.js" type="text/javascript" charset="utf-8"></script>		 -->
	<!-- required for TextboxList -->
<!-- 	<script src="<?= BASE_URL; ?>assets/js/libs/GrowingInput.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?= BASE_URL; ?>assets/js/libs/TextboxList.js" type="text/javascript" charset="utf-8"></script>		
	<script src="<?= BASE_URL; ?>assets/js/libs/TextboxList.Autocomplete.js" type="text/javascript" charset="utf-8"></script> -->
	<!-- required for TextboxList.Autocomplete if method set to 'binary' -->
<!-- 	<script src="<?= BASE_URL; ?>assets/js/libs/TextboxList.Autocomplete.Binary.js" type="text/javascript" charset="utf-8"></script>		
	<script>
		window.addEvent('load', function(){
			// With custom adding keys 
			var t2 = new TextboxList('form_tags_input_2', {
				unique: true,
				maxLength: 6,
				bitsOptions:{
					editable:{addKeys: 188}
				}
			});
			t2.add('HTML5').add('CSS3');
		});
	</script> -->
</body>
</html>