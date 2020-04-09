<?php 
	session_start(); 
	$email    = " ";

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		$_SESSION['email'] = $email;
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		//session_destroy();
		unset($_SESSION['username']);
		$_SESSION['email'] = $email;
		header("location: login.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Home Page</h2>
	</div>
	<div class="content">

		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
			<?php endif ?>
		<!-- logged in user information -->
		<?php  if (isset($_SESSION['username']) AND $_SESSION['olduser'] == 0) {?>
			<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
			<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
		<?php } elseif ($_SESSION['olduser'] == 1) { ?>
			<p align ='center'>You have already registered with us on <br> 
			 Email: <strong><?php echo $_SESSION['email'];  ?></strong><br>
			 Just enter the password to login</p>
			<p align ='right'> <a href="login.php" style="color: green;">Login</a> </p>
		<?php } else {
			unset($_SESSION['username']);
			header('location: login.php');
		} ?>
	</div>
		
</body>
</html>