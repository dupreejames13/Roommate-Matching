<?php
require 'includes/init.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
    if(isset($_GET['id'])){
        $user_data = $user_obj->find_user_by_id($_GET['id']);
    }
}
else{
    header('Location: logout.php');
    exit;
}

 $db = mysqli_connect('localhost','jtd5251','tzPtmN6nKdoRlKBF','jtd5251')
 or die('Error connecting to MySQL server.');

$id = $_SESSION['user_id']; // get id through query url

$qry = mysqli_query($db,"select * from users where id=$id");

$data = mysqli_fetch_array($qry); 

if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];

    $edit = mysqli_query($db,
	"
	update users 
	set username='$name',
	user_email='$email'
	where id='$id'
	");
    if($edit)
    {
        mysqli_close($db); // Close connection
        header("location:self_profile.php"); // redirects to homepage
        exit;
    }
    else
    {
	echo '<p class="errorMsg">'.$result['errorMessage'].'</p>';
        echo mysqli_error();
    }   

}



// CHECK FRIENDS
$is_already_friends = $frnd_obj->is_already_friends($_SESSION['user_id'], $user_data->id);
//  IF I AM THE REQUEST SENDER
$check_req_sender = $frnd_obj->am_i_the_req_sender($_SESSION['user_id'], $user_data->id);
// IF I AM THE REQUEST RECEIVER
$check_req_receiver = $frnd_obj->am_i_the_req_receiver($_SESSION['user_id'], $user_data->id);
// TOTAL REQUESTS
$get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);
// TOTAL FRIENDS
$get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo  $user_data->username;?></title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body>
    <div class="profile_container">
        
        <div class="inner_profile">
            <div class="img">
                <img src="profile_images/<?php echo $data['user_image']; ?>" alt="Profile image">
            </div>
            <h1><?php echo  $data['username'];?></h1>
            <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer">Home</a></li>
                <li><a href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                if($get_req_num > 0){
                    echo 'redBadge';
                }
                ?>"><?php echo $get_req_num;?></span></a></li>
                <li><a href="friends.php" rel="noopener noreferrer">Roommates<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
		<li><a href="self_profile.php" rel="noopener noreferrer">Your Profile<span class="badge"></span></a></li>
                <li><a href="logout.php" rel="noopener noreferrer">Logout</a></li>
            </ul>
        </nav>
    <tbody>
<div class="main_container login_signup_container">
    <h1>Edit Information</h1>
    <form method="POST">
      <label for="name">Full Name</label>
      <input type="text" name="name" value="<?php echo $data['name'] ?>" placeholder="Enter your full name" Required>
      <label for="email">Email</label>
      <input type="email" name="email" value="<?php echo $data['email'] ?>" placeholder="Enter your email address" Required>

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
      <input type="submit" name="update" value="update">
      <a href="self_profile.php" class="form_link">Go back</a>
    </form>




</div>

                          
</body>
</html>            <div class="actions">
                <?php
                if($is_already_friends){
                    echo '<a href="functions.php?action=unfriend_req&id='.$user_data->id.'" class="req_actionBtn unfriend">Unfriend</a>';
                }
                elseif($check_req_sender){
                    echo '<a href="functions.php?action=cancel_req&id='.$user_data->id.'" class="req_actionBtn cancleRequest">Cancel Request</a>';
                }
                elseif($check_req_receiver){
                    echo '<a href="functions.php?action=ignore_req&id='.$user_data->id.'" class="req_actionBtn ignoreRequest">Ignore</a> 
                    <a href="functions.php?action=accept_req&id='.$user_data->id.'" class="req_actionBtn acceptRequest">Accept</a>';
                }
                ?>       
            </div>
        </div>
    </div>
</body>
</html>
