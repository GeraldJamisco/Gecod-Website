<?php
session_start();
include 'config.php';
// include 'sessionizr.php';

?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin | SignIn</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../img/GECOD LOGO NO BACKGROUND.fw.png">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="css/style.css" rel="stylesheet">
    
</head>

<body class="h-100">
    
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="index.html"> <h4>GECOD INITIATIVE BACK DOOR LOGIN</h4></a>
                                       
                                <form class="mt-5 mb-5 login-input" action="" method="POST">
                                    <div class="text-center">.
                                    <img src="../img/GECOD LOGO NO BACKGROUND.fw.png" alt="" width="80">.
                                    </div>
                                
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                                    </div>
                                    <button class="btn login-form__btn submit w-100" name="submit">Login</button>
                                </form>
                            </div>
                            
<?php


if (isset($_POST['submit'])) {
    $mmails = $conn->real_escape_string(trim(isset($_POST['email'])    ? $_POST['email']    : ''));
    $pwd    = trim(isset($_POST['password']) ? $_POST['password'] : '');

    if (empty($mmails) || empty($pwd)) {
        echo '<div class="container"><div class="alert alert-danger mt-3">Please enter your email and password.</div></div>';
    } else {
        // Fetch by email only so we can do proper password comparison
        $send = $conn->query("SELECT * FROM gecodusers WHERE gecodUname='$mmails'");

        if ($send && mysqli_num_rows($send) > 0) {
            $user        = $send->fetch_assoc();
            $storedHash  = $user['gecodUpassword'];
            $authenticated = false;

            // 1. Try modern bcrypt first
            if (password_verify($pwd, $storedHash)) {
                $authenticated = true;
            }
            // 2. Legacy MD5 fallback — auto-upgrade to bcrypt on success
            elseif ($storedHash === md5($pwd)) {
                $authenticated = true;
                $newHash = $conn->real_escape_string(password_hash($pwd, PASSWORD_BCRYPT));
                $conn->query("UPDATE gecodusers SET gecodUpassword='$newHash' WHERE gecodUname='$mmails'");
                $storedHash = $newHash;
            }

            if ($authenticated) {
                session_regenerate_id(true);
                $_SESSION['gecodmail']     = $mmails;
                $_SESSION['gecodpassword'] = $storedHash;
                echo "<script>window.location.href='dashboard.php';</script>";
            } else {
                echo '<div class="container"><div class="alert alert-danger mt-3">Wrong credentials. Please try again.</div></div>';
            }
        } else {
            echo '<div class="container"><div class="alert alert-danger mt-3">Wrong credentials. Please try again.</div></div>';
        }
    }
}

?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    
<?php
include 'includes/footer.php';

?>