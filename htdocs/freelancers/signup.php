<?php
	require("../config.php");
	require(ROOT_PATH . "core/init.php");
	
	$users->loggedInProtect();

	$towns = $users->getLocations();
	$experiences = $users->getExperiences();

	$userType = $_GET['usertype'];
	$jobTitles = $freelancers->getFreelancerJobTitles($userType);

	$userIP = $ipInfo->getIPAddress();
	$userLocation = json_decode($ipInfo->getCity($userIP), true);
	$userCity = $userLocation['cityName'];

	if (isset($_GET['status'])) {
		$status = $_GET["status"];
	}

	// Determine whether user is logged in - test for value in $_SESSION
	if (isset($_SESSION['logged'])){
		header("Location: " . BASE_URL . "dashboard/");
	}else if (isset($_POST['submit'])) {

		// Grab the form data
		$firstName = trim($_POST['firstname']);
		$lastName = trim($_POST['lastname']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$repeatPassword = trim($_POST['repeatpassword']);
		$jobTitle = trim($_POST['jobtitle']);
		$experience = trim($_POST['experience']);
		$pricePerHour = trim($_POST['priceperhour']);
		$bio = htmlentities(trim($_POST['bio']));
		$portfolio = trim($_POST['portfolio']);
		$location = trim($_POST['location']);

		$forms->hijackPrevention();
	 		        
		$errors = $forms->validateFreelancer($firstName, $lastName, $email, $password, $repeatPassword, $portfolio, $jobTitle, $experience, $bio, $errors);

		if(empty($errors) === true){
			$data = array(
				"firstName" => ucwords($firstName), 
				"lastName" => ucwords($lastName), 
				"email" => $email, 
				"password" => $password, 
				"location" => $location, 
				"portfolio" => $portfolio, 
				"jobTitle" => $jobTitle, 
				"pricePerHour" => $pricePerHour, 
				"experience" => $experience, 
				"bio" => $bio, 
				"userType" => $userType
			);			
			$freelancers->registerFreelancer($data);
			header("Location:" . BASE_URL . "login/success/");
			exit();
		}
	}

	$pageTitle = "Sign Up";
	$pageType = "Page";
	if($userType == "designer") {
		$section = "Blue";
	} else {
		$section = "Navy";
	}


	include(ROOT_PATH . "includes/header.inc.php");
	include(ROOT_PATH . "views/freelancer/freelancer-signup-form.html");
	include(ROOT_PATH . "includes/footer.inc.php");
?>