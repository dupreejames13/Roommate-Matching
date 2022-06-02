<?php
require 'includes/init.php';
// IF USER MAKING SIGNUP REQUEST
	
if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){				 //&& isset($_POST['phone']) && isset($_POST['owl']) && isset($_POST['early']) && isset($_POST['smoker']) && isset($_POST['gender'])

	$result = $user_obj->signUpUser($_POST['username'],$_POST['email'],$_POST['password'],$_POST['owl'],$_POST['early'],$_POST['smoker'],$_POST['gender']);
}
// IF USER ALREADY LOGGED IN
if(isset($_SESSION['email'])){
  header('Location: profile.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body>
  <div class="main_container login_signup_container">
    <h1>Sign Up</h1>
    <form action="" method="POST" novalidate>
      <label for="username">Full Name</label>
      <input type="text" id="username" name="username" spellcheck="false" placeholder="Enter your full name" required>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" spellcheck="false" placeholder="Enter your email address" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required><br><br><br>

	<h2>Profile Information</h2>
      <label for="owl">Are you a nightowl?</label>
      <input type="checkbox" id="owl" name="owl"><br><br>
      <label for="early">Are you an early riser?</label>
      <input type="checkbox" id="early" name="early"><br><br>
      <label for="smoker">Are you a smoker?</label>
      <input type="checkbox" id="smoker" name="smoker"><br><br>
      <label for="gender">What is your gender?</label>
	<select id="gender" name="gender" required>
		<option></option>
		<option value="male">Male</option>
		<option value="female">Female</option>
	</select><br><br>

      <input type="submit" value="Sign Up">
      <a href="index.php" class="form_link">Login</a>
    </form>
    <div>  
      <?php
        if(isset($result['errorMessage'])){
          echo '<p class="errorMsg">'.$result['errorMessage'].'</p>';
        }
        if(isset($result['successMessage'])){
          echo '<p class="successMsg">'.$result['successMessage'].'</p>';
        }
      ?>    
    </div>
  </div>
</body>
</html>