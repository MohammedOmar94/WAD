<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function register_user($username, $password, $email_address) {
    $conn = sql_connection();
    $verification_code = substr(sha1(uniqid(rand())), 1, 5);
    $pass_hash = PassHash::hash($password);
    $stmt = $conn->prepare("INSERT INTO reg_users VALUES ('DEFAULT' ,?,?,?,?)");
    $stmt->bind_param('ssss', $username, $pass_hash, $email_address, $verification_code);
    if ($stmt->execute()) {
        send_email($verification_code, $username);
        login_user($username, $password);
        echo "New record created successfully";
    } else {
        echo "Error: <br>" . $conn->error;
    }
}

function login_user($username, $password) {
    $conn = sql_connection();
    $stmt = $conn->prepare("Select * from reg_users where Username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $assoc = $result->fetch_assoc();
//    while ($assoc = $result->fetch_assoc()) {
//    var_dump($assoc);
//    }
//    $row = mysqli_fetch_assoc($result);
    if ((PassHash::check_password($assoc['Password_'], $password))) {
        $_SESSION['user'] = $assoc['Username'];
        $_SESSION['userid'] = $assoc['id'];
        $_SESSION['verificationCode'] = $assoc['vCode'];
        setcookie('username', $username, time() + (86400 * 30), "/"); // 86400 = 1 day
        if ($assoc['vCode'] !== '0') {
            header("Location: verification.php");
            exit;
        } else {
            header("Location: index.php");
            mysqli_close($conn);
            exit;
        }
    } else {
        echo "Incorrect Username or Password entered.";
        mysqli_close($conn);
    }
}

function logout_user() {
    session_unset();
    session_destroy();
    header("Location: login.php");
}

function new_username($username) {
    $conn = sql_connection();
    $stmt = $conn->prepare("Select * from reg_users where Username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Username already exists!";
        mysqli_close($conn);
        return false;
    } else {
        echo "Username is unique!<br/>";
        mysqli_close($conn);
        return true;
    }
}

function new_email($email) {
    $conn = sql_connection();
    $stmt = $conn->prepare("Select * from reg_users where Email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Email already in use.";
        mysqli_close($conn);
        return false;
    } else {
        echo "Email has been created!";
        mysqli_close($conn);
        return true;
    }
}

function captcha() {
    if (isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"]) {
        echo "Correct Code Entered <br/>";
        return true;
//Do you stuff
    } else {
        die("Wrong Code Entered");
        return false;
    }
}

/* Unused */
function update_details($userid, $verification_code) {//return array, use array for values in accom_update.
    $stmt = $conn->prepare("Update reg_users set Username = ?, Password_ = ?, Email = ? where id = ?;");
    $stmt->bind_param('ssi', $username, $verification_code);
    $stmt->execute();
}

?>