<?php
	require_once("../inc/config.php"); 
	include_once(ROOT_PATH . "inc/header.php");
	include_once(ROOT_PATH . "inc/functions.php");
	include_once(ROOT_PATH . "inc/errors.php");

	// Grab the form data
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatpassword = trim($_POST['repeatpassword']);
	$age = trim($_POST['age']);
	$jobtitle = $_POST['jobtitle'];
	$experience = trim($_POST['experience']);
	$bio = trim($_POST['bio']);
	$speciality = trim($_POST['speciality']);
	$submit = trim($_POST['submit']);

	// Create some variables to hold output data
	$message = '';
	$s_username = '';

	if(isset($speciality)) {
		$speciality = implode(", ", $_POST['speciality']);   
	} else {
		$speciality = "";
	}

	// Start to use PHP session
	session_start();
	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		$s_username = $_SESSION['email'];
		$message = "You are already logged in as $s_username. Please <a href='logout.php'>logout</a> before trying to register.";
	}else{
		if ($submit=='Apply for your place'){

		    if($firstname == ""){
		        $message="Please enter your first name"; 
		    }else if($lastname == ""){
		        $message="Please enter your last name"; 
		    }else if($email == ""){
		        $message="Please enter your email"; 
		    }else if($password == ""){
		        $message="Please enter a password"; 
		    }else if ($password!=$repeatpassword){ 
				$message = "Both password fields must match";
			}else if (strlen($password)>25||strlen($password)<6) {
				$message = "Password must be 6-25 characters long";
			}else if($experience == ""){
		        $message="Please enter your experience"; 
		    }else if($jobtitle == ""){
		    	$message= "Please enter your current job title";
		    }else if($bio == ""){
		        $message="Please write about yourself"; 
		    }else if(strlen($bio)<25) {
				$message = "You're not going to sell yourself without a decent bio!";
			}else{
				// Process details here
				require_once(ROOT_PATH . "inc/db_connect.php"); 
				if($db_server){

					//clean the input now that we have a db connection
					$firstname = clean_string($db_server, $firstname);
					$lastname = clean_string($db_server, $lastname);
					$email = clean_string($db_server, $email);
					$password = clean_string($db_server, $password);
					$repeatpassword = clean_string($db_server, $repeatpassword);
					$age = clean_string($db_server, $age);
					$bio = clean_string($db_server, $bio);
					$experience = clean_string($db_server, $experience);

					mysqli_select_db($db_server, $db_database);

					// check whether email has been used before
					$query="SELECT designers.email FROM connectdDB.designers WHERE designers.email='$email' UNION SELECT developers.email FROM connectdDB.developers WHERE developers.email='$email' UNION SELECT employers.email FROM connectdDB.employers WHERE employers.email='$email'";
					$result = mysqli_query($db_server, $query);
					if ($row = mysqli_fetch_array($result)){
						$message = "Email already taken. Please try again.";
					}else{
						// Encrypt password
						$password = salt($password);
						$query = "INSERT INTO connectdDB.designers (firstname, lastname, email, password, jobtitle, speciality, age, experience, bio) VALUES ('$firstname', '$lastname', '$email', '$password', '$jobtitle', '$speciality', '$age', '$experience', '$bio')";
						mysqli_query($db_server, $query) or die("Insert failed. ". mysqli_error($db_server));
						header('Location: /Connectd/sign-in.php');				
					}
					mysqli_free_result($result);
				}else{
					$message = "Error: could not connect to the database.";
				}
				require_once(ROOT_PATH . "inc/db_close.php"); 
			}

		}
	}

?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
			<h1 class="page-title">
				Sign Up<a href="" class="login-trigger page-title__link"> : Log In</a>
			</h1>
			<h2 class="page-logo header-logo">
				<a href="<?php echo BASE_URL; ?>">connectd</a>
			</h2>
		</div>
	</header>
	<section>
		<div class="section-heading color-blue">
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
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 form-overlay">
				<?php if (strlen($message)>1) : ?>
					<p class="error"><?php echo $message; ?></p>
				<?php endif; ?>
				<form method="post" action="<?php echo BASE_URL; ?>designer/signup.php" autocomplete="off">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>">
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<input type='password' name='password' placeholder="Password" class="field-1-2">
					<input type='password' name='repeatpassword' placeholder="Repeat Password" class="field-1-2 float-right" /> 
					<input type="number" name="age" placeholder="Age"  value="<?php if (isset($age)) { echo htmlspecialchars($age); } ?>" min="18" max="80" class="field-1-2" />
					<input type="number" name="experience" placeholder="Years Experience" value="<?php if (isset($experience)) { echo htmlspecialchars($experience); } ?>" min="1" max="50" class="field-1-2 float-right"/>
					<div class="select-container">
						<select name="jobtitle">
							<option value="">Job title..</option>
							<option value="Designer">Designer</option>
							<option value="Illustrator">Illustrator</option>
							<option value="Illustrator">Animator</option>
						</select>
					</div>
					<fieldset>
						<label class="field-heading">What do you specialise in?</label>
						<div class="checkbox">
					   		<label><input type="checkbox" name="speciality[]" value="Graphic Design">Graphic Design</label>
					    </div>
					   	<div class="checkbox">
					   		<label><input type="checkbox" name="speciality[]" value="Web Design">Web Design</label>
					    </div>
					   	<div class="checkbox">
					   		<label><input type="checkbox" name="speciality[]" value="App Design">App Design</label>
					    </div>
						<div class="checkbox">
					   		<label><input type="checkbox" name="speciality[]" value="UX Design">UX Design</label>
						</div>
					   	<div class="checkbox">
					   		<label><input type="checkbox" name="speciality[]" value="UI Design">UI Design</label>
					    </div>
					   	<div class="checkbox">
					   		<label><input type="checkbox" name="speciality[]" value="UI Design">Motion/Animation</label>
					    </div>
					    <div class="checkbox">
					   		<label><input type="checkbox" name="speciality[]" value="UI Design">Illustration</label>
					    </div>
					</fieldset>
					<textarea name="bio" cols="30" rows="10" placeholder="A little about you..."><?php if (isset($bio)) { echo htmlspecialchars($bio); } ?></textarea>
					<div class="button-container">
		            	<input id="submit" class="submit" name="submit" type="submit" value='Apply for your place'>					
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>