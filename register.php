<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="layout/css/register.css">
    <link rel="stylesheet" href="layout/css/style.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>

<?php
	

	$pageTitle = 'Register';

		include 'init.php';
		

		$do = isset($_GET['do']) ? $_GET['do'] : 'Add';

		if ($do == 'Add') {?>
			
  <div class="container">
  <div class="title">Registration</div>
  <div class="content">
	<form  action="?do=Insert" method="POST" enctype="multipart/form-data">
	  <div class="user-details">
		<div class="input-box">
		  <span class="details">Full Name</span>
		  <input type="text" name ="full" placeholder="Enter your name" required>
		</div>
		<div class="input-box">
		  <span class="details">Username</span>
		  <input type="text"  name ="name" placeholder="Enter your username" required>
		</div>
		<div class="input-box">
		  <span class="details">Email</span>
		  <input class="signin-email"  name ="email"type="text" placeholder="Enter your email" required>
		</div>
		<div class="input-box">
		  <span class="details">Phone Number</span>
		  <input  type="text"  name ="phone" placeholder="Enter your number" required>
		</div>
		<div class="input-box">
		  <span class="details">Password</span>
		  <input class="signin-password" type="text"   name ="password" placeholder="Enter your password" required>
		</div>
		<div class="input-box">
		  <span class="details">Confirm Password</span>
		  <input type="text"  name ="password" placeholder="Confirm your password" required>
		</div>
	  </div>
	  <div class="gender-details">
		<input type="radio" name="gender" id="dot-1" value="1">
		<input type="radio" name="gender" id="dot-2" value="2">
		<input type="radio" name="gender" id="dot-3" value="3">
		<span class="gender-title">Gender</span>
		<div class="category">
		  <label for="dot-1">
		  <span class="dot one"></span>
		  <span class="gender">Male</span>
		</label>
		<label for="dot-2">
		  <span class="dot two"></span>
		  <span class="gender">Female</span>
		</label>
		<label for="dot-3">
		  <span class="dot three"></span>
		  <span class="gender">Prefer not to say</span>
		  </label>
		</div>
	  </div>
	  <div class="button">
		<input class="signin-btn-submit" type="submit" value="Register">
	  </div>
	</form>
  </div>
</div>


			 
<?php

		} elseif ($do == 'Insert') {
           
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		
				echo "<div class='container'>";
		
				$full     = $_POST['full'];
				$name   =  $_POST['name'];
				$email    =  $_POST['email'];
				$pass =  $_POST['password'];
				$phone   =  $_POST['phone'];
				$gender   =  $_POST['gender'];
                


				$formErrors = array();

				if (strlen($name) < 4) {
					$formErrors[] = 'name Cant Be Less Than <strong>4 Characters</strong>';
				}

				if (strlen($name) > 20) {
					$formErrors[] = 'name Cant Be More Than <strong>20 Characters</strong>';
				}


				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					$check = checkItem("user_name", "users", $name);

					if ($check == 1) {

						$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

						redirectHome($theMsg, 'back');

					} else {

						// Insert Userinfo In Database

						$stmt = $con->prepare("INSERT INTO 
													users(user_name ,full_name ,user_email ,user_pass ,phone ,gender)
												VALUES(:zname  ,:zfull , :zemail , :zpassword, :zphone, :zgender )");
						$stmt->execute(array(
							'zname'  => $name,
							'zfull'  => $full,
							'zemail' => $email,
							'zpassword'  => $pass,
							'zphone' => $phone,
							'zgender'=> $gender,

						));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

						redirectHome($theMsg, 'shooping.php');

					}

				}


			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg , 'back');

				echo "</div>";

			}

			echo "</div>";


		} 
	

	include $tpl . 'footer.php';

	ob_end_flush(); // Release The Output

?>