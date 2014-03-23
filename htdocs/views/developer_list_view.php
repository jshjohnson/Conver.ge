			<div class='media'>
				<a href="<?= BASE_URL . "developers/" . $developer['user_id']; ?>/"><img src="<?= BASE_URL ?>assets/avatars/default_avatar.png" alt='' class='media__img media__img--avatar'></a>
				<div class='media__body'>
					<div class='float-left user-info'>
						<a href='#'><i class='icon--star'></i></a>	
						<a href="<?= BASE_URL . "developers/" . $developer['user_id']; ?>/"><h4><?= $developer['firstname'] . ' ' . $developer['lastname']; ?></h4></a>
						<p><?= $developer['jobtitle']; ?></p>
					</div>
					<div class='float-right badge--price-per-hour'>
						<h5>£<?= $developer['priceperhour']; ?></h5>
						<span>per hour</span>
					</div>
				</div>
			</div>