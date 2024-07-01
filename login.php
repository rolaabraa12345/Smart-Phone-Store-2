<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="layout/css/style.css">
    <link rel="stylesheet" href="layout/css/Login.css">
   
</head>


<?php
ob_start();
session_start();
  $pageTitle = 'Login';
  $noNavbar = '';
if (isset($_SESSION['Username'])) {

	header('Location: shooping.php');
}
include 'init.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$username = $_POST['email'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);
		$stmt = $con->prepare("SELECT 
									*
								FROM 
									users 
								WHERE 
								user_email = ? 
								AND 
								user_pass = ?
								
								LIMIT 1");

		$stmt->execute(array($username, $hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if( $count > 0){
				$_SESSION['Username']= $username;
				$_SESSION['ID']= $row['id'];
				header('Location:shooping.php');
				exit();
		}else{
			header('Location:shooping.php');
			exit();
		  }
	}

?>  <div class="login-form">
<div class="log">
 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
 <h1>Login</h1>
 <div class="content">
   <div class="input-field">
	 <input class="signin-ailem" type="email" placeholder="email" name="email" autocomplete="nope">
   </div>
   <div class="input-field">
	 <input class="signin-password" type="password" placeholder="Password"  name="pass" autocomplete="new-password">
   </div>
   <a href="#" class="link"><b> Forgot Your Password? </b></a>
 </div>
 <div class="action">
   <button><a href="register.php">Register</a></button>
   <button class="signin-btn-submit" type="submit"><a href="shooping.php">Sign in</a></button>
 </div>
</form> </div>
</div>
<?php include $tpl . 'footer.php'; 
ob_end_flush();
?>
