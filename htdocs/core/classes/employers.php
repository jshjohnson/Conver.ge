<?php 
	class Employers {

		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}

		//***************************** Employer *****************************//

		// Register en employer on sign up
		public function registerEmployer($firstname, $lastname, $email, $password, $businessname, $location, $businesstype, $businesswebsite, $businessbio){
			
			$time 		= time();
			$ip 		= $_SERVER['REMOTE_ADDR'];
			$email_code = sha1($email + microtime());
			$password = sha1($password);
		 
			$query 	= $this->db->prepare("INSERT INTO " . DB_NAME . ".employers
				(firstname, lastname, email, email_code, time, password, businessname, location, businesstype, businesswebsite, businessbio, ip) 
				VALUES 
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		 
			$query->bindValue(1, $firstname);
			$query->bindValue(2, $lastname);
			$query->bindValue(3, $email);
			$query->bindValue(4, $email_code);
			$query->bindValue(5, $time);
			$query->bindValue(6, $password);
			$query->bindValue(7, $businessname);
			$query->bindValue(8, $location);
			$query->bindValue(9, $businesstype);
			$query->bindValue(10, $businesswebsite);
			$query->bindValue(11, $businessbio);
			$query->bindValue(12, $ip);
		 
			try{
				$query->execute();
		 
				mail($email, 'Please activate your account', "Hello " . $firstname. ",\r\n\r\nThank you for registering with Connectd. Please visit the link below so we can activate your account:\r\n\r\n" . BASE_URL . "sign-in.php?email=" . $email . "&email_code=" . $email_code . "&user=employer\r\n\r\n-- Connectd team");
			
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function activateEmployer($email, $email_code) {
		
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `employers` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");
	 
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
	}