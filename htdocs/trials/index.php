<?php 	
	require_once("../config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();
	$general->loggedOutProtect();
	$votes->userVotedForProtect();
	$votedBy        = $_SESSION['user_id'];

	$pageTitle      = "Trials";
	$section        = "Trials";

	$status         = $_GET["status"];

	$trial_users 	= $trials->getTrialUsers();

	include_once(ROOT_PATH . "includes/header.inc.php");
?>
		<?php if ($status == "added") : ?>
		<section class="call-to-action call-to-action--top">
			<div class="container">
				<h4 class="call-to-action__title zero-top">
					Thanks for voting - Have a<i class="icon--star-alt"></i>on us!
				</h4>
			</div>
		</section>
		<?php elseif ($status == "removed") : ?>
		<section class="call-to-action call-to-action--top">
			<div class="container">
				<h4 class="call-to-action__title zero-top">
					Vote removed
				</h4>
			</div>
		</section>
		<?php endif;?>
		<section class="container">
			<div class="grid grid--center cf">
			<?php foreach ($trial_users as $trial_user) : ?>
				<?php $vote_id == $trial_user["firstname"]; ?>
				<aside class="grid__cell module-1-4 push-bottom">
					<article class="user-sidebar module--no-pad">
						<?php 
							$vote_id         = $trial_user["user_id"]; 
							$trialUserVotes  = $votes->getUserVotes($vote_id);
						 	if(strtotime(date('F j, Y', $trial_user['time_joined']))>strtotime('-3 days')) : 
						 ?>
						<div class="ribbon"><h5>New</h5></div>
						<?php endif ?>
						<div class="user-sidebar__price--small">
							<span class="currency currency--small">
								<h5><?= $trialUserVotes['CountOfvote_id']; ?></h5>
								<small>votes</small>
							</span>
						</div>
						<div class="user-sidebar__info">
							<h3 class="user-sidebar__title user-sidebar__title--alt"><?= $trial_user["firstname"] . "\n" . $trial_user["lastname"]; ?></h3>
							<h4 class="user-sidebar__label icon--attach icon--marg"><?= $trial_user["jobtitle"]; ?></h4>
							<h4 class="user-sidebar__label icon--location icon--marg"><?= $trial_user["location"]; ?>, UK</h4>
							<h4 class="user-sidebar__label icon--briefcase icon--marg"><?php $url = preg_replace("(Between)", "", $trial_user["experience"] ); echo $url ?> experience</h4>
							<h4 class="user-sidebar__label icon--globe icon--marg"><a href="<?= $trial_user["portfolio"]; ?>"><?php $url = preg_replace("(https?://)", "", $trial_user["portfolio"] ); echo $url ?></a></h4>
							<div class="button-wrapper">
							<?php if($votes->sessionUserVoted($vote_id, $votedBy) == false) : ?>
								<a href="add-vote.php?user_id=<?= $trial_user["user_id"]; ?>" class="btn btn--green btn--small">
									 <span class="icon--check">Add vote</span>
								</a>
							<?php else : ?>
								<a href="remove-vote.php?user_id=<?= $trial_user["user_id"]; ?>" class="btn btn--red btn--small">
									 <span class="icon--cross">Remove vote</span>
								</a>
							<?php endif;?>
							</div>
						</div>
					</article>
				</aside>
			<?php endforeach; ?>
			</div>
		</section>
		<section class="call-to-action footer-push">
			<div class="container">
				<h4 class="as-h1 call-to-action__title">
					Looking for freelance work?
				</h4>
				<a class="btn btn--green" href="<?= BASE_URL; ?>jobs/list/">See our jobs list</a>
			</div>
		</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>