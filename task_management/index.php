<?php
$db['db_host']="localhost";
$db['db_user']="planatir_task_management";
$db['db_pass']="Bishan@1919";
$db['db_name']="planatir_task_management";
foreach($db as $key => $value)
{
    define(strtoupper($key),$value);
}
//$connection =mysqli_connect('localhost','planatir_task_management','','global_touch');
$connection =mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
//    if($connection)
//    {
//        echo "we are connected";
//    }
session_start();
$chck_Active_User = '';

if (isset($_POST['login'])) {
    $uemail = mysqli_real_escape_string($connection, $_POST['User_nm']);
    $pass = $_POST['Paswd']; // Don't escape the password, you'll hash it
    $sql = "SELECT * FROM emp_login WHERE user_id = '$uemail'";
    $q = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($q);
    $count = mysqli_num_rows($q);

    if ($count > 0) {
        // Verify the entered password against the hashed password from the database
        if (password_verify($pass, $row['pswd'])) {
            $_SESSION['user'] = $row['id'];
            $_SESSION['emp_name'] = $row['emp_name'];
            $_SESSION['emp_pro'] = $row['emp_pro'];
            $_SESSION['User_type'] = $row['user_role'];

            $chck_Active_User = $row['status'];
            if ($chck_Active_User == '0') {
                echo "<script>alert('Your account is currently deactivated.'); window.location.href='../login.php';</script>";
            } else {
                echo "<script>alert('Login Successful'); window.location.href='dashboard.php';</script>";
            }
        } else {
            ?>
            <script>
                alert('Incorrect password');
                window.location.href = "<?php echo $_SERVER['HTTP_REFERER'] ?>";
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert('User not found');
            window.location.href = "<?php echo $_SERVER['HTTP_REFERER'] ?>";
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-image: url('atire2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #000000;
            color: #000000;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-box-w {
            background: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            max-width: 1000px;
            width: 100%;
            text-align: center;
        }

        .auth-box-w .auth-header {
            color: #F28018;
            font-size: 24px;
        }

        .form-group label {
            color: #000000;
            font-size: 16px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group-addon {
            background-color: #F28018;
            color: #ffffff;
            border: 1px solid #F28018;
            border-radius: 5px;
            padding: 10px 15px;
        }

        .form-control {
            border: 1px solid #F28018;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #F28018;
            border: 1px solid #F28018;
            color: #ffffff;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #000000;
        }

        .auth-header {
            color: #F28018;
        }

        .row {
            background-color: #000000;
            color: #F28018;
            padding: 10px;
            text-align: center;
        }

        .row a {
            color: #F28018;
            text-decoration: none;
        }

        .row a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="all-wrapper menu-side with-pattern">
        <div class="auth-box-w">
            <div class="logo-w">
                <a href="#">
                    <img style="width: auto; height: auto;" alt="" src="atire.png">
                </a>
            </div>
            <h4 class="auth-header">Login</h4>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="User_nm">Username</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input class="form-control" name="User_nm" id="User_nm" placeholder="Enter your username" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Paswd">Password</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input class="form-control" name="Paswd" id="Paswd" placeholder="Enter your password" type="password">
                    </div>
                </div>
                <div class="buttons-w">
                    <input name="login" type="submit" value="Log me in" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
   
</body>

</html>
