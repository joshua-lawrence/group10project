<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require_once("./components.php");
    require_once("./entities.php");
    session_start();

    if(isset($_REQUEST["signout"])) {
        session_destroy();
    }
    
    if(isset($_REQUEST["createaccount"])) {
        $password = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
        User::createUser($_REQUEST["firstname"], $_REQUEST["lastname"], $_REQUEST["email"], $password);
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = User::getUserId($_REQUEST["email"]);
        header('Location: index.php?newaccount=true');

    }

    if(isset($_REQUEST["signin"])) {
        if(User::getPassword($_REQUEST["email"]) != false) {
            $hashed = User::getPassword($_REQUEST["email"]);
            if(password_verify($_REQUEST["password"], $hashed)) {
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = User::getUserId($_REQUEST["email"]);
                header('Location: index.php?signedin=true');
            }
            else {
                $error = "Invalid Password";
            }
        }
        else {
            $error = "No account exists with that email";
        }
        
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
     <title>U of U Parking System - <?php echo ucfirst(basename(__FILE__, '.php')); ?></title>
     <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    </head>
<body style="background-color: #f8f9fa;">
 
<div class="container-fluid">        

    <div class="row">
        <div class="col-sm-3" style="margin: auto; background-color: white; margin-top: 100px; padding: 50px;">
        <?php     
        if (isset($_REQUEST["signup"])) {
            ob_start();
            ?>
            <h1 style="text-align: center; margin-top: 20px;"><span style="color:red; font-weight: 800">U</span> Parking System</h1>
            <h3 style="text-align: center; margin-top: 60px;">Sign Up</h3>
            <form method="post" action="login.php" class="form-signin" style="padding: 10px;">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control" placeholder="First Name" required autofocus>
                <label style="padding-top: 30px;">Last Name</label>
                <input type="text" name="lastname" class="form-control" placeholder="Last Name" required autofocus>
                <label style="padding-top: 30px;">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
                <label style="padding-top: 30px;">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 30px;">Sign Up</button>
                <input type='hidden' name="createaccount" value="true"/>
                <a href="login.php">Have an account? Sign in</a>
            </form>
            <?php
            echo ob_get_clean();
        
        }
        else {
            ob_start();
            ?>
            <h1 style="text-align: center; margin-top: 20px;"><span style="color:red; font-weight: 800">U</span> Parking System</h1>
            <h3 style="text-align: center; margin-top: 60px;">Sign In</h3>
            <?php if (isset($error)) echo '<div class="alert alert-warning" role="alert">' . $error . '<button type="button" class="close" data-dismiss="alert">x</button></div>'; ?>
            <form method="post" action="login.php" class="form-signin" style="padding: 10px;">
                <label>Email address</label>
                <input type="email"  name="email" class="form-control" placeholder="Email address" required autofocus>
                <label style="padding-top: 30px;">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 30px;">Sign in</button>
                <input type='hidden' name="signin" value="true"/>
                <a href="login.php?signup=true">Don't have an account? Sign up</a>
            </form>
            <?php
            echo ob_get_clean();
        }
        ?>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
