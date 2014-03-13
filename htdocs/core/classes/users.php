<?php
	class Users {
	 
		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
	  
		// Test if email already exists in database
		public function emailExists($email) {
		 
			$query = $this->db->prepare("SELECT `email`
						FROM " . DB_NAME . ".users
						WHERE `email` = ? 
					");
			$query->bindParam(1, $email);

			try{
		 
				$query->execute();
				$rows = $query->rowCount();
		 
				if($rows > 0){
					return true;
				}else{
					return false;
				}
		 
			} catch (PDOException $e){
				die($e->getMessage());
			}
		 
		}

		// Test if user has confirmed their email
		public function emailConfirmed($email) {
 
			$query = $this->db->prepare("SELECT COUNT(*) FROM (
				(SELECT 1 FROM " . DB_NAME . ".users AS a WHERE a.email = ? AND a.confirmed = ?)) z
			");

			$query->bindValue(1, $email);
			$query->bindValue(2, 1);
			
			try{
				
				$query->execute();
				$rows = $query->fetchColumn();
		 
				if($rows == 1){
					return true;
				}else{
					return false;
				}
		 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function login($email, $password) {

			global $bcrypt;  // Make the bcrypt variable global, which is defined in init.php, which is included in login.php where this function is called
 
			$query = $this->db->prepare("SELECT 
					`user_id`, `email`, `password`
					FROM " . DB_NAME . ".users
					WHERE `email` = ? 
				");
			$query->bindValue(1, $email);
			
			try{
				
				$query->execute();
				$data 				= $query->fetch();
				$stored_password 	= $data['password'];
				$id 				= $data['user_id'];
				
				// hashing the supplied password and comparing it with the stored hashed password.
				if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
					return $id;	
				}else{
					return false;	
				}
		 
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function getTrialUsers() {

			$query = $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, u.location, u.portfolio, u.experience, u.time_joined
				FROM " . DB_NAME . ".users u
				JOIN " . DB_NAME . ".user_votes v ON u.user_id = v.user_id
				HAVING COUNT(u.user_id)< ?;
				GROUP BY u.user_id
				WHERE u.user_type != ?  
				AND u.confirmed = ? 
				AND u.user_id = f.user_id
				ORDER BY u.time_joined DESC
			");

			$query->bindValue(1, 10);
			$query->bindValue(2, 'employer');
			$query->bindValue(3, 2);	
			

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		// Get user data
		public function userData($id) {
 
			$query = $this->db->prepare("
				SELECT firstname, lastname, user_type FROM " . DB_NAME . ".users WHERE `user_id`= ?
				");
			$query->bindValue(1, $id);

			try{
				$query->execute();
				return $query->fetch();
			} catch(PDOException $e){
		 
				die($e->getMessage());
			}
		}
		
		public function activateUser($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("UPDATE `users` SET `confirmed` = ? WHERE `email` = ?");
	 
					$query_2->bindValue(1, 1);
					$query_2->bindValue(2, $email);							
	 
					$query_2->execute();
					return true;
				} else {
					return false;
				}
	 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		// Register a developer on sign up
		public function registerFreelancer($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $priceperhour, $experience, $bio, $user_type){

			global $bcrypt; // making the $bcrypt variable global so we can use here
			global $mail;
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);// generating a hash using the $bcrypt object

			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, experience, portfolio, bio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			");
			
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $password);
			$query->bindValue(6, $time);
			$query->bindValue(7, $location);
			$query->bindValue(8, $experience);
			$query->bindValue(9, $portfolio);
			$query->bindValue(10, $bio);
			$query->bindValue(11, $ip);
		 
			try{
				$query->execute();
		 
				$to = $email;

				$mail->Host               = DB_EMAIL;  // specify main and backup server
				$mail->Username           = "josh@joshuajohnson.co.uk";  // SMTP username
				$mail->Password           = "cheeseball27"; // SMTP password
				$mail->SMTPAuth           = true;               // enable SMTP authentication
				$mail->SMTPSecure         = "tls"; 
				$mail->addAddress($to);  // Add a recipient=
                
                $mail->From               = 'robot@connectd.io';
				$mail->FromName           = 'Connectd.io';
                // Set word wrap to 50 characters
				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject            = 'Activate your new Connectd account';

				$mail->Body               = "<p>Hey " . $firstname . "!</p>";
				$mail->Body              .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				$mail->Body              .= "<p>" . BASE_URL . "login.php?email=" . $email . "&email_code=" . $email_code . "</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";
				$mail->AltBody            = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
				   echo 'Message could not be sent.';
				   echo 'Mailer Error: ' . $mail->ErrorInfo;
				   exit;
				}


				$rows = $query->rowCount();
	 
				if($rows > 0 && $user_type != 'employer'){

					$last_user_id =  $this->db->lastInsertId('user_id');
					
					$query_2 = $this->db->prepare("INSERT INTO " . DB_NAME . ".freelancers (user_id, jobtitle, priceperhour) VALUE (?,?,?)");
	 
	 				$query_2->bindValue(1, $last_user_id);
					$query_2->bindValue(2, $jobtitle);
					$query_2->bindValue(3, $priceperhour);						
	 
					$query_2->execute();

					$query_3 = $this->db->prepare("INSERT INTO " . DB_NAME . ".user_types (user_id, user_type) VALUE (?,?)");
	 
	 				$query_3->bindValue(1, $last_user_id);
					$query_3->bindValue(2, $user_type);				
	 
					$query_3->execute();
					
					return true;

				}
							
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function registerEmployer($firstname, $lastname, $email, $password, $location, $portfolio, $employerName, $employerType, $experience, $bio, $user_type) {

			global $bcrypt; // making the $bcrypt variable global so we can use here
			global $mail;
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password   = $bcrypt->genHash($password);// generating a hash using the $bcrypt object

			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".users
				(firstname, lastname, email, email_code, password, time_joined, location, experience, portfolio, bio, ip, user_type) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			");
			
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $password);
			$query->bindValue(6, $time);
			$query->bindValue(7, $location);
			$query->bindValue(8, $experience);
			$query->bindValue(9, $portfolio);
			$query->bindValue(10, $bio);
			$query->bindValue(11, $ip);
			$query->bindValue(12, $user_type);
		 
			try{
				$query->execute();
		 
				$to = $email;

				$mail->Host               = DB_EMAIL;  // specify main and backup server
				$mail->Username           = "josh@joshuajohnson.co.uk";  // SMTP username
				$mail->Password           = "cheeseball27"; // SMTP password
				$mail->SMTPAuth           = true;               // enable SMTP authentication
				$mail->SMTPSecure         = "tls"; 
				$mail->addAddress($to);  // Add a recipient
                
                $mail->From               = 'robot@connectd.io';
				$mail->FromName           = 'Connectd.io';
                // Set word wrap to 50 characters
				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject            = 'Activate your new Connectd account';

				$mail->Body               = "<p>Hey " . $firstname . "!</p>";
				$mail->Body              .= "<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>";
				$mail->Body              .= "<p>" . BASE_URL . "login.php?email=" . $email . "&email_code=" . $email_code . "</p>";
				$mail->Body              .= "<p>-- Connectd team</p>";
				$mail->Body              .= "<p><a href='http://connectd.io'>www.connectd.io</a></p>";
				$mail->Body              .= "<img width='180' src='" . BASE_URL . "assets/img/logo-email.jpg' alt='Connectd.io logo'><br>";
				$mail->AltBody            = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
				   echo 'Message could not be sent.';
				   echo 'Mailer Error: ' . $mail->ErrorInfo;
				   exit;
				}


				$rows = $query->rowCount();
	 
				if($rows > 0 && $user_type = 'employer'){

					$last_user_id =  $this->db->lastInsertId('user_id');
					
					$query_2 = $this->db->prepare("INSERT INTO " . DB_NAME . ".employers (user_id, employer_name, employer_type) VALUE (?,?,?)");
	 
	 				$query_2->bindValue(1, $last_user_id);
					$query_2->bindValue(2, $employerName);
					$query_2->bindValue(3, $employerType);						
	 
					$query_2->execute();
					
					return true;

				}
							
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
	}