<?php 
	session_start();

	// variable declaration
	$firstname = "";
	$lastname = "";
	$indosno = "";
	$dob = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('lhtestdb.ciy0mdpdswpo.ap-south-1.rds.amazonaws.com:3306', 'adminbhai', 'Kadal123', 'User');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
		$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
		$indosno = mysqli_real_escape_string($db, $_POST['indosno']);
		$dob = mysqli_real_escape_string($db, $_POST['dob']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($firstname)) { array_push($errors, "Firstname is required"); }
		if (empty($lastname)) { array_push($errors, "Lastname is required"); }
		if (empty($indosno)) { array_push($errors, "INDoSNo is required"); }
		if (empty($dob)) { array_push($errors, "DoB is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO Sign_up_entry (firstname, lastname, indosno, dob, email, password) 
					  VALUES('$firstname', '$lastname', '$indosno', '$dob', '$email', '$password')";
			mysqli_query($db, $query)or die(mysqli_error($db));
			$username = $firstname ." ". $lastname;
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}

	// ... 

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM Sign_up_entry WHERE email='$email' AND password='$password'";
			$results = mysqli_query($db, $query);
			 while ($row = $results->fetch_assoc()) {
				$field1name = $row["firstname"];
				$field2name = $row["lastname"];
			 }	
			$username = $field1name ." ". $field2name;

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

?>