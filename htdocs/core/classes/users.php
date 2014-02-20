<?php
	class Users {
	 
		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
	  
		// Test if email already exists in database
		public function email_exists($email) {
		 
			$query = $this->db->prepare("SELECT designers.email 
						FROM " . DB_NAME . ".designers 
						WHERE designers.email = ? 
						UNION SELECT developers.email 
						FROM " . DB_NAME . ".developers 
						WHERE developers.email = ?
						UNION SELECT employers.email 
						FROM " . DB_NAME . ".employers 
						WHERE employers.email = ?");
			$query->bindParam(1, $email);
			$query->bindParam(2, $email);
			$query->bindParam(3, $email);

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


		public function email_confirmed($email) {
 
			$query = $this->db->prepare("SELECT 
				COUNT(`id`) FROM `developers` WHERE developers.email=  ? AND confirmed = ?
				UNION SELECT 
				COUNT(`id`) FROM `designers` WHERE designers.email = ? AND confirmed = ?
				UNION SELECT 
				COUNT(`id`) FROM `employers` WHERE employers.email = ? AND confirmed = ?
				");
			$query->bindValue(1, $email);
			$query->bindValue(2, 1);
			$query->bindValue(3, $email);
			$query->bindValue(4, 1);
			$query->bindValue(5, $email);
			$query->bindValue(6, 1);
			
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
 
			$query = $this->db->prepare("SELECT 
				designers.id, designers.email, designers.password 
				FROM " . DB_NAME . ".designers 
				WHERE designers.email = ? 
				UNION SELECT developers.id, developers.email, developers.password 
				FROM " . DB_NAME . ".developers WHERE developers.email = ? 
				UNION SELECT employers.id, employers.email, employers.password 
				FROM " . DB_NAME . ".employers WHERE employers.email = ?");
			$query->bindValue(1, $email);
			$query->bindValue(2, $email);
			$query->bindValue(3, $email);
			
			try{
				
				$query->execute();
				$data 				= $query->fetch();
				$stored_password 	= $data['password'];
				$id 				= $data['id'];
				
				#hashing the supplied password and comparing it with the stored hashed password.
				if($stored_password === sha1($password)){
					return $id;	
				}else{
					return false;	
				}
		 
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}

		// Activate developer after following emailed url

		public function activateDeveloper($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `developers` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("UPDATE `developers` SET `confirmed` = ? WHERE `email` = ?");
	 
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


		public function activateDesigner($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `designers` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("UPDATE `designers` SET `confirmed` = ? WHERE `email` = ?");
	 
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

		public function activateEmployer($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `developers` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
			$query->bindValue(1, $email);
			$query->bindValue(2, $email_code);
			$query->bindValue(3, 0);
	 
			try{
	 
				$query->execute();
				$rows = $query->fetchColumn();
	 
				if($rows == 1){
					
					$query_2 = $this->db->prepare("UPDATE `employers` SET `confirmed` = ? WHERE `email` = ?");
	 
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

		//***************************** Developer *****************************//
		
		// Register a developer on sign up
		public function registerDeveloper($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $age, $priceperhour, $experience, $bio){
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password = sha1($password);
		 
			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".developers
				(firstname, lastname, email, email_code, time, password, location, portfolio, jobtitle, age, priceperhour, experience, bio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				");
		 
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $time);
			$query->bindValue(6, $password);
			$query->bindValue(7, $location);
			$query->bindValue(8, $portfolio);
			$query->bindValue(9, $jobtitle);
			$query->bindValue(10, $age);
			$query->bindValue(11, $priceperhour);
			$query->bindValue(12, $experience);
			$query->bindValue(13, $bio);
			$query->bindValue(14, $ip);
			
		 
			try{
				$query->execute();
		 
				mail($email, 'Please activate your account', "Hello " . $firstname. ",\r\n\r\nThank you for registering with Connectd. Please visit the link below so we can activate your account:\r\n\r\n" . BASE_URL . "sign-in.php?email=" . $email . "&email_code=" . $email_code . "&user=developer\r\n\r\n-- Connectd team");
			
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		//***************************** Designer *****************************//

		// Register a designer on sign up
		public function registerDesigner($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $age, $priceperhour, $experience, $bio){
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password = sha1($password);
		 
			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".designers
				(firstname, lastname, email, email_code, time, password, location, portfolio, jobtitle, age, priceperhour, experience, bio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				");
		 
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $time);
			$query->bindValue(6, $password);
			$query->bindValue(7, $location);
			$query->bindValue(8, $portfolio);
			$query->bindValue(9, $jobtitle);
			$query->bindValue(10, $age);
			$query->bindValue(11, $priceperhour);
			$query->bindValue(12, $experience);
			$query->bindValue(13, $bio);
			$query->bindValue(14, $ip);
			
		 
			try{
				$query->execute();
		 
				mail($email, 'Please activate your account', "Hello " . $firstname. ",\r\n\r\nThank you for registering with Connectd. Please visit the link below so we can activate your account:\r\n\r\n" . BASE_URL . "sign-in.php?email=" . $email . "&email_code=" . $email_code . "&user=designer\r\n\r\n-- Connectd team");
			
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}


		//***************************** Employer *****************************//

		// Register en employer on sign up
		public function registerEmployer($firstname, $lastname, $email, $password, $location, $portfolio, $jobtitle, $age, $priceperhour, $experience, $bio){
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password = sha1($password);
		 
			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".employers
				(firstname, lastname, email, email_code, time, password, location, portfolio, jobtitle, age, priceperhour, experience, bio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				");
		 
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $time);
			$query->bindValue(6, $password);
			$query->bindValue(7, $location);
			$query->bindValue(8, $portfolio);
			$query->bindValue(9, $jobtitle);
			$query->bindValue(10, $age);
			$query->bindValue(11, $priceperhour);
			$query->bindValue(12, $experience);
			$query->bindValue(13, $bio);
			$query->bindValue(14, $ip);
			
		 
			try{
				$query->execute();
		 
				mail($email, 'Please activate your account', "Hello " . $firstname. ",\r\n\r\nThank you for registering with Connectd. Please visit the link below so we can activate your account:\r\n\r\n" . BASE_URL . "sign-in.php?email=" . $email . "&email_code=" . $email_code . "&user=employer\r\n\r\n-- Connectd team");
			
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

	}