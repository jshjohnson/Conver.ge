<?php

	function get_designer_list_view($designer_id, $designer) {

		$output = "";

		$output = $output . "<div class='media'>";
		$output = $output . "<a href='" . BASE_URL . "designers/" . $designer['user_id'] . "/'><img src='" . BASE_URL . "assets/avatars/default_avatar.png' alt='' class='media__img media__img--avatar'></a>";
		$output = $output . "<div class='media__body'>";
		$output = $output . "<div class='float-left user-info'>";
		$output = $output . "<a href='#'><i class='icon--star'></i></a><a href='" . BASE_URL . "designers/" . $designer['user_id'] . "/'><h4>" . $designer['firstname'] . ' ' . $designer['lastname'] . "</h4></a>";
		$output = $output . "<p>" . $designer['jobtitle'] . "</p>";
		$output = $output . "</div>";
		$output = $output . "<div class='float-right price-per-hour'>";
		$output = $output . "<h5>£" . $designer['priceperhour'] . "</h5>";
		$output = $output . "<span>per hour</span>";
		$output = $output . "</div>";
		$output = $output . "</div>";
		$output = $output . "</div>";

		return $output;
	}

	function get_designers_recent() {

		$recent = "";
		$all = get_designers_all();

		$total_designers = count($all);
		$position = 0;
		$list_view = "";

		foreach ($all as $designer) {
			$position = $position + 1;
			// if designer is one of the 4 most recent designers
			if ($total_designers - $position < 6) {
				$recent[] = $designer;
			}
		}
		return $recent;
	}

	function get_designers_all() {

		require(ROOT_PATH . "core/connect/database.php");

		try {
			$results = $db->prepare("
				SELECT users.user_id, users.firstname, users.lastname, freelancers.jobtitle, freelancers.priceperhour
				FROM " . DB_NAME . ".users
				JOIN " . DB_NAME . ".freelancers ON users.user_id = freelancers.freelancer_id
				WHERE users.confirmed = ?
			");
			$results->bindValue(1, 1);
			// $results->bindValue(2, 'designer');

			$results->execute();
		} catch (Exception $e) {
			echo "Damn. All developer data could not be retrieved.";
			exit;
		}
		
		$designers = $results->fetchAll(PDO::FETCH_ASSOC);

		return $designers;

	}

	function get_designers_single($id) {

		require(ROOT_PATH . "core/connect/database.php");

		try {
			$results = $db->prepare("
				SELECT *
				FROM " . DB_NAME . ".users, " . DB_NAME . ".freelancers  
				WHERE users.confirmed = ? 
				AND users.user_id = ?
				AND users.user_id = freelancers.user_id
			");
			$results->bindValue(1, 1);
			$results->bindValue(2, $id);
			// $results->bindValue(3, 'designer');

			$results->execute();
		} catch (Exception $e) {
			echo "Damn. Single designer data could not be retrieved.";
			exit;
		}

		$designers= $results->fetch(PDO::FETCH_ASSOC);
		
		return $designers;
	}

?>