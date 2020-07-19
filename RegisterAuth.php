<?php

session_start();

include "databases/Encryptor.php";

$database = new SQLite3('databases/LoginData.db');
$database->exec("CREATE TABLE IF NOT EXISTS userData(username STRING PRIMARY KEY, password STRING);");
if(!isset($_POST['username'], $_POST['password'])){
    session_regenerate_id();
    $_SESSION['error'] = "noInfo";
    header("Location: RegisterPage.php");
    return;
}
$username = $_POST['username'];
$password = $_POST['password'];

if(strlen($username) === 0){
    session_regenerate_id();
    $_SESSION['error'] = "noUsername";
    header("Location: RegisterPage.php");
    return;
}

if(strlen($password) < 8){
    session_regenerate_id();
    $_SESSION['error'] = "shortPassword";
    header("Location: RegisterPage.php");
    return;
}

$query = $database->query("SELECT * FROM userData WHERE username = '$username'");
$result = $query->fetchArray(SQLITE3_ASSOC);
if(empty($result)){
    $newUserData = $database->prepare("INSERT OR REPLACE INTO userData (username, password) VALUES (:username, :password)");
    $newUserData->bindValue(":username", $username);
    $newUserData->bindValue(":password", Encryptor::encryptPassword($password));
    $newUserData->execute();
    session_regenerate_id();
    $_SESSION['error'] = "newAccount";
    header("Location: LoginPage.php");
    return;
} else {
    session_regenerate_id();
    $_SESSION['error'] = "userAlreadyExists";
    header("Location: RegisterPage.php");
    return;
}