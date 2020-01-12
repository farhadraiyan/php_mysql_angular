<?php
include_once('dbcon.php');

$error=false;

if(isset($_POST['btn-register'])){
    $username = $_POST['username'];
    //to make username palin text
    $username = strip_tags($username);
    $username = htmlspecialchars($username);

    $email = $_POST['email'];
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = $_POST['password'];
    $password = strip_tags($password);
    $password = htmlspecialchars($password);
}

//validate
if(empty($username)){
    $error=true;
    $erroUsername="User name cannot be empty";
}

if(empty($email)){
    $error=true;
    $errorEmail= "Email cannot be empty";
}
else{
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error=true;
        $errorEmail= "Please enter a valid email";

    }
}

if(empty($password)){
    $error=true;
    $errorPassword= "password cannot be empty";
}elseif (strlen($password)<6){
    $error=true;
    $errorPassword= "password must be more than 6 char";
}

//encrypt password
 $password = md5($password);

//insert data if no error

if(!$error){
    $sql= "insert into tbl_users(username, email, password)
                    values('$username', '$email', '$password')";

    if(mysqli_query($conn, $sql)){
        $successMsg="Register Successfully <a href='index.php'>click here to login</a> ";
    }
    else{
        echo 'connection error'.mysqli_error($conn);
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/bootstrap4/css/bootstrap.css">
    <link rel="stylesheet" href="assets/custom.css">
    <title>PHP Login and Registration</title>
</head>
<body>


<div class="container">
    <div class="form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" >
            <div class="text-center"><h2>Login</h2></div>
            <hr/>

            <?php
            if(isset($successMsg)){ ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    <?php echo $successMsg; ?>

                </div>

            <?php } ?>

            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" name="username" class="form-control" autocomplete="off">
                <span class="text-danger"><?php if (isset($erroUsername)) echo $erroUsername;?></span>
            </div>

            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="text" name="email" class="form-control" autocomplete="off">
                <span class="text-danger"><?php if(isset($errorEmail)) echo $errorEmail?></span>
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" class="form-control">
                <span class="text-danger"><?php if(isset($errorPassword)) echo $errorPassword ?></span>

            </div>

            <div class="form-group text-center">
                <input type="submit" value="Register" name="btn-register" class="btn btn-primary mr-5"/>
                <a href="index.php">Login?</a>
            </div>


        </form>
    </div>
</div>
</body>
</html>