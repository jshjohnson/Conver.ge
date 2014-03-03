<?php
	require_once("../config.php");
	require_once(ROOT_PATH . "core/init.php");

	$general->loggedInProtect();
	$general->errors();
	$counties = $general->getCounties();

	$userType = "Developer";
	$jobTitles = $general->getJobTitles($userType);

	$pageTitle = "Sign Up";
	$section = "Developer";

	include_once(ROOT_PATH . "inc/header.php");

	// Grab the form data
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatpassword = trim($_POST['repeatpassword']);
	$age = trim($_POST['age']);
	$jobtitle = trim($_POST['jobtitle']);
	$experience = trim($_POST['experience']);
	$priceperhour = trim($_POST['priceperhour']);
	$bio = trim($_POST['bio']);
	$portfolio = trim($_POST['portfolio']);
	$location = trim($_POST['location']);
	$submit = trim($_POST['submit']);

	$status = $_GET["status"];

	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header('Location: dashboard/');
	}else if (isset($_POST['submit'])) {

		// Form hijack prevention
		foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $errors[] = "Hmmmm. Are you a robot? Try again.";
            }
        }
	 		        
		$r1='/[A-Z]/';  // Test for an uppercase character
		$r2='/[a-z]/';  // Test for a lowercase character
		$r3='/[0-9]/';  // Test for a number

		if($firstname == ""){
		    $errors[] ="Please enter your first name"; 
		}else if($lastname == ""){
		    $errors[] ="Please enter your last name"; 
		}else if($email == ""){
		    $errors[] ="Please enter your email"; 
		}else if (!$mail->ValidateAddress($email)){
				$errors[] = "You must specify a valid email address.";
		}else if ($users->emailExists($email) === true) {
		    $errors[] = "Email already taken. Please try again.";
		}else if($password == ""){
		    $errors[] ="Please enter a password"; 
		}else if ($password!=$repeatpassword){ 
			$errors[] = "Both password fields must match";
		} else if(preg_match_all($r1,$password)<1) {
			$errors[] = "Your password needs to contain at least one uppercase character";
		} else if(preg_match_all($r2,$password)<1) {
			$errors[] = "Your password needs to contain at least one lowercase character";
		} else if(preg_match_all($r3,$password)<1) {
			$errors[] = "Your password needs to contain at least one number";
		} else if (strlen($password)>25||strlen($password)<6) {
			$errors[] = "Password must be 6-25 characters long";
		} else if($portfolio == ""){
		    $errors[] ="You must have an active portfolio to join Connectd"; 
		} else if($jobtitle == ""){
		    $errors[] ="Please select your current job title"; 
		}else if($experience == ""){
		    $errors[] ="Please enter your experience"; 
		}else if($bio == ""){
		    $errors[] ="Please write about yourself"; 
		}else if(strlen($bio)<25) {
			$errors[] = "You're not going to sell yourself without a decent bio!";
		}

	 
		if(empty($errors) === true){

			$firstname = $general->cleanString($db, $firstname);
			$lastname = $general->cleanString($db, $lastname);
			$email = $general->cleanString($db, $email);
			$password = $general->cleanString($db, $password);
			$repeatpassword = $general->cleanString($db, $repeatpassword);
			$age = $general->cleanString($db, $age);
			$location = $general->cleanString($db, $location);
			$jobtitle = $general->cleanString($db, $jobtitle);
			$priceperhour = $general->cleanString($db, $priceperhour);
			$bio = $general->cleanString($db, $bio);
			$portfolio = $general->cleanString($db, $portfolio);
			$experience = $general->cleanString($db, $experience);
			$votes = '0';
			$user_type = 'developer';
	 
			$users->registerUser($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $age, $priceperhour, $experience, $bio, $user_type, $votes);
			header("Location:" . BASE_URL . "developers/signup.php?status=success");
			exit();
		}
	}
?>
	<header class="header header-navy--alt zero-bottom cf">
		<div class="container">
				<?php if (!isset($_SESSION['logged'])) :?>
				<h1 class="header__section header__section--title"><?= $pageTitle ?>
					<a href="" class="login-trigger header__section--title__link">: Log In</a>
				</h1>
				<?php else : ?>
				<h1 class="header__section header__section--title"><?= $pageTitle ?>
					<a href="" class="menu-trigger header__section--title__link">: Menu</a>
				</h1>
					<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
				<?php endif; ?>
			<h2 class="header__section header__section--logo">
				<a href="<?php echo BASE_URL; ?>">connectd</a>
			</h2>
		</div>
	</header>
		<div class="section-heading color-navy">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							The beginning of something special...
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-grey">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp4 unit-2-3--bp1 content-overlay">
				<?php 
					if(empty($errors) === false){
						echo '<p class="message message--error">' . implode('</p><p>', $errors) . '</p>';
					}
				?>
				<?php if ($status == "success") : ?>
				<p class="message message--success">Thank you for registering. Please check your emails to activate your account.</p>
				<?php endif; ?>
				<form method="post" action="<?php echo BASE_URL; ?>developers/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2 float-left" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" autofocus>
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<p class="message message--hint">Psst. Passwords must contain at least one uppercase character and at least one number.</p>
					<input type='password' name='password' placeholder="Password" class="field-1-2"  value="<?php if (isset($password)) { echo htmlspecialchars($password); } ?>">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right"  value="<?php if (isset($repeatpassword)) { echo htmlspecialchars($repeatpassword); } ?>">
					<label for="jobtitle">Where do you work from?</label>
					<div class="select-container">
						<select name="location">
							<option value="">Location...</option>
						<?php foreach ($counties as $county) : ?>
							<option <?php if ($_POST['location'] == $county['county']) { ?>selected="true" <?php }; ?>value="<?php echo $county['county']; ?>"><?php echo $county['county']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<p class="message message--hint">Psst. Prospective users need an online portfolio to prove themselves in the Connectd community.</p>
					<input type="url" name="portfolio" placeholder="Portfolio URL" value="<?php if (isset($portfolio)) { echo htmlspecialchars($portfolio); } ?>" >
					<label for="jobtitle">What best describes what you do?</label>
					<div class="select-container">
						<select name="jobtitle">
							<option value="">Pick one..</option>
							<?php foreach ($jobTitles as $jobTitle) : ?>
								<option <?php if ($_POST['jobtitle'] == $jobTitle['job_title']) { ?>selected="true" <?php }; ?>value="<?php echo $jobTitle['job_title']; ?>"><?php echo $jobTitle['job_title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<input type="number" name="age" placeholder="Age" min="18" max="80" class="field-1-2 float-left" value="<?php if (isset($age)) { echo htmlspecialchars($age); } ?>">
					<input type="number" name="priceperhour" placeholder="Price per hour" min="1" max="200" class="field-1-2 float-right"  value="<?php if (isset($priceperhour)) { echo htmlspecialchars($priceperhour); } ?>">
					<div class="select-container">
						<select name="experience">
							<option value="">Years experience...</option>
							<option <?php if ($_POST['experience'] == 'Less than 1 year') { ?>selected="true" <?php }; ?>value="Less than 1 year">Less than 1 year</option>
							<option <?php if ($_POST['experience'] == 'Between 1-2 years') { ?>selected="true" <?php }; ?>value="Between 1-2 years">Between 1-2 years</option>
							<option <?php if ($_POST['experience'] == 'Between 3-5 years') { ?>selected="true" <?php }; ?>value="Between 3-5 years">Between 3-5 years</option>
							<option <?php if ($_POST['experience'] == 'Between 5-10 years') { ?>selected="true" <?php }; ?>value="Between 5-10 years">Between 5-10 years</option>
							<option <?php if ($_POST['experience'] == 'Over 10 years') { ?>selected="true" <?php }; ?>value="Over 10 years">Over 10 years</option>
						</select>
					</div>
					<textarea name="bio" cols="30" rows="8" placeholder="A little about you..."><?php if (isset($bio)) { echo htmlspecialchars($bio); } ?></textarea>
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Apply for your place'>				
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>