
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

require 'includes/init.php';
	if (isset($_GET['h1'])) {
		$qID = $_GET['h1'];
	} else {
		$qID = 1;
	}
	$question = 'Question not set';
	$answerA = 'unchecked';
	$answerB = 'unchecked';
	$answerC = 'unchecked';
	$A = "";
	$B = "";
	$C = "";
	$database = "survey";

	$db_found = new mysqli("localhost", "jtd5251", "tzPtmN6nKdoRlKBF", "jtd5251" );
	if ($db_found) {
		$stmt = $db_found->prepare("SELECT ID, username, user_email,user_password, owl, riser, smoker, gender FROM users WHERE ID = ?");
			if ($res->num_rows > 0) {
				$A = $row['OptionA'];
				$B = $row['OptionB'];
				$C = $row['OptionC'];
			}
			else {
				print "Error - No rows";
			}
		}
		else {
			print "Error - DB ERROR";
		}
	}
	else {
		print "Error getting Survey";
	}
?>