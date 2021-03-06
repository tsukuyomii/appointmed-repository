<?php

SESSION_start();
include 'connectdatabase.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $account_type = '';
    $date = date('Y-m-d');

    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $password = hash('sha256', $password);

    $result = mysqli_query($con, "SELECT * FROM account WHERE BINARY username = '$username' AND  password = '$password' AND account_status = 'active'");
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if (!($count == 1)) {
        if ($username == "" && $password == "") {
            echo "<script> alert('Enter a username and password');</script>";
            echo "<script> location.replace('authenticate.php') </script>";
        }
        if($row['username'] == $username && $row['password'] == $password  && $row['account_status'] == 'inactive'){
            echo "<script> alert('Please wait for your account to be activated');</script>";
            echo "<script> location.replace('authenticate.php') </script>";
        }
        echo "<script> alert('Incorrect Username/Password'); </script>";
        echo "<script> location.replace('authenticate.php') </script>";
        $_SESSION['can_access'] = true;
        $_SESSION['loggedIn'] = false;
    } else {

        $_SESSION['username'] = $username;
        $_SESSION['account_type'] = $row['account_type'];
        if ($row['account_type'] == 'Admin') {
            $_SESSION['loggedIn'] = false;
            header("location: admin/index.php");
        } else if ($row['account_type'] == 'Patient') {
            $_SESSION['loggedIn'] = true;
           
            $sql = "UPDATE account SET last_logged_in = '$date' WHERE username LIKE '$username'";
            if (!(mysqli_query($con, $sql))) {
                die('Error: ' . mysqli_error($con));
            }
            header("location: appointment.php");
        } else {
            $_SESSION['loggedIn'] = false;
            header("location: admin/index.php");
        }
    }
    if (!(mysqli_query($con, $result))) {
        die('Error: ' . mysqli_error($con));
    }
} else {
    echo "<script> alert('Error!'); </script>";
    echo "<script> location.replace('authenticate.php') </script>";
}

mysqli_close($con);
?>