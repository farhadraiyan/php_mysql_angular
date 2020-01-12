<?php
session_start();
//check if session set if session found then don't do anything redirect the user to home
if(isset($_SESSION['username'])){
    header('location: home.php');
}
include_once('dbcon.php');
//get and convert all data from front end to palin text

$error=false;
if(isset($_POST['btn-login'])){
    $email=$_POST['email'];
    $email = htmlspecialchars(strip_tags($email));

    $password = $_POST['password'];
    $password = htmlspecialchars(strip_tags($password));

    //validation

    if(empty($email)){
        $error = true;
        $errorUsername = "User name cannot be empty";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $errorUsername = "Must be a valid email address";
    }
    if(empty($password)){
        $error = true;
        $errorPassword = "Password cannot be empty";
    }elseif (strlen($password)<6){
        $error = true;
        $errorPassword = "Password must be at least 6 char";
    }

    if(!$error){
        //hash password from user input
        $password=md5($password);
        $sql= "SELECT * FROM tbl_users WHERE email='".$email."'";
        $result = mysqli_query($conn, $sql);
        //this will return num of rows found
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);

        if($count==1 && $row['password'] == $password){
            $_SESSION['username'] = $row['username'];
            header('location: home.php');
        }else{
            $errLoginMsg= 'Invalid username or password';
        }

//        if(mysqli_query($conn, $sql)){
//            $succesmsg='data get'.var_dump($rows);
//
//        }else{
//            echo 'Error'.mysqli_error($conn);
//        }
    }

}





//connect to database


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/bootstrap4/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/custom.css">
    <title>PHP Login and Registration</title>
</head>
<body>


<div class="container">
    <div class="form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" >
            <div class="text-center"><h2>Login</h2></div>
            <hr/>
            <?php if(isset($errLoginMsg)) { ?>

                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    <?php echo $errLoginMsg; ?>

                </div>

            <?php } ?>
            <hr/>
            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="text" name="email" class="form-control" autocomplete="off">
                <span class="text-danger"><?php if (isset($errorUsername)) echo $errorUsername;?></span>
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" class="form-control">
                <span class="text-danger"><?php if (isset($errorPassword)) echo $errorPassword;?></span>
            </div>

            <div class="form-group text-center">
                <input type="submit" value="Login" name="btn-login" class="btn btn-primary mr-5"/>
            </div>
            Don't have an account? <a href="register.php">Register</a>


        </form>
    </div>
</div>
</body>
</html>