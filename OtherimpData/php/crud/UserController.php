<?php
include_once 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$user = new User();
	if (isset($_POST['create'])) {

		//set the member values of user instance
		$user->setUserName($_POST["name"]);
		$user->setEmail($_POST["email"]);
		$user->setMobileNo($_POST["mobile"]);
		$user->setDisability($_POST["disable"]);
		//echo $user->getDisability();
		//die;
		$user->setGender($_POST["gender"]);
		$hobbies = $_POST["hobby"];

		//setting hobby array
		foreach ($hobbies as $hobby) {
			$user->setHobby($hobby);
		}
		$user->setDescription($_POST["description"]);

		$user->create();

	} else if (isset($_POST['edit'])) {
		//First Create Conenction instance then pass to it to User instance
		if (!isset($_SESSION)) {
			session_start();
		}
		$_SESSION["user_id"] = $_POST['user_id'];
		header("Location: edit.php");
	} else if (isset($_POST["update"])) {

		//set the member values of user instance
		$user->setUserId($_POST['user_id']);
		$user->setUserName($_POST["name"]);
		$user->setEmail($_POST["email"]);
		$user->setMobileNo($_POST["mobile"]);
		$user->setDisability($_POST["disable"]);
		//echo $user->getDisability();
		//die;
		$user->setGender($_POST["gender"]);
		$hobbies = $_POST["hobby"];

		//setting hobby array
		foreach ($hobbies as $hobby) {
			$user->setHobby($hobby);
		}
		$user->setDescription($_POST["description"]);

		$user->update();
	} else if (isset($_POST["delete"])) {

		$user->delete($_POST['user_id']);

	} else {
		echo "Please Fill the Form. ";
	}
}

?>