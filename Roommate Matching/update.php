<?php
require 'includes/init.php';


$id = $_GET['id'] ?? null;

if(!$id) {
    header('Location: self_profile.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);



$errors = [];

$username = $user['username'];
$user_email = $user['user_email'];



if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username']; //test
    $user_email = $_POST['user_email'];
    
    


    if(!$username) {
        $errors[] = 'Need to enter valid user name!';
    }
    if(!$user_email) {
        $errors[] = 'Need to enter valid email!';
    }

        

        $statement = $pdo->prepare("UPDATE users SET username = :username,
                    user_email = :user_email  WHERE id = :id");
                    
                    

        $statement->bindValue(':username', $username);
        $statement->bindValue(':user_email', $user_email);
        $statement->bindValue(':id', $id);
        

        $statement->execute();
        header('Location: self_profile.php');
    }





?>
<!doctype hmtl>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="app.css" rel="stylesheet"/>
    <title>Profile</title>
</head>
<body>

<h1>Update Profile: <b><?php echo $user['username'] ?></b></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    

    <div class="form-group">
        <label>User Name</label>
        <input type="text" name="title" class="form-control" value="<?php echo $username ?>">
    </div>
    <div class="form-group">
        <label>User Email</label>
        <textarea class="form-control" name="user_email"><?php echo $user_email ?></textarea>
    </div>
 
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>
</html>