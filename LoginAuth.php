<?php

session_start();

include "databases/Encryptor.php";

$database = new SQLite3('databases/LoginData.db');
$database->exec("CREATE TABLE IF NOT EXISTS userData(username STRING PRIMARY KEY, password STRING);");

if(!isset($_POST['username'], $_POST['password'])){
    session_regenerate_id();
    $_SESSION['error'] = "noInfo";
    header("Location: LoginPage.php");
    return;
}

$username = $_POST['username'];
$password = $_POST['password'];

if(strlen($username) === 0){
    session_regenerate_id();
    $_SESSION['error'] = "noUsername";
    header("Location: LoginPage.php");
    return;
}

$query = $database->query("SELECT * FROM userData WHERE username = '$username'");
$result = $query->fetchArray(SQLITE3_ASSOC);

if(!empty($result)){
    $realPassword = $result['password'];
    if(Encryptor::verifyPassword($password, $realPassword)){
        session_regenerate_id();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $realPassword;
        header("Location: home/index.php");
        return;
    } else {
        session_regenerate_id();
        $_SESSION['error'] = "invalidPassword";
        header("Location: LoginPage.php");
        return;
    }
} else {
    session_regenerate_id();
    $_SESSION['error'] = "userNotRegistered";
    header("Location: LoginPage.php");
    return;
}