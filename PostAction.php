<?php

session_start();
if(!isset($_POST['username'], $_POST['password'], $_POST['postText'])){
    exit("Fatal Error: Insufficient information given.");
}
if(ctype_space($_POST['postText'])){
    session_regenerate_id();
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['error'] = "invalidPostSpace";
    header("Location: home/index.php");
    return;
} elseif($_POST['postText'] === ""){
    session_regenerate_id();
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['error'] = "invalidPostSpace";
    header("Location: home/index.php");
} elseif(ctype_digit($_POST['postText'])){
    session_regenerate_id();
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['error'] = "invalidPostNum";
    header("Location: home/index.php");
    return;
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $text = $_POST['postText'];

    $userDatabase = new SQLite3('databases/LoginData.db');
    $query = $userDatabase->query("SELECT * FROM userData WHERE username = '$username'");
    $result = $query->fetchArray(SQLITE3_ASSOC);
    if(!empty($result)){
        $realPassword = $result['password'];
        include "databases/Encryptor.php";
        if($password === $realPassword){
            $postDatabase = new SQLite3('databases/PostData.db');
            $newPostData = $postDatabase->prepare("INSERT OR REPLACE INTO posts (author, postText) VALUES (:author, :postText)");
            $newPostData->bindValue(":author", $username);
            $newPostData->bindValue(":postText", $text);
            $newPostData->execute();
            session_regenerate_id();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header("Location: home/index.php");
        } else {
            exit("Fatal Error: Invalid user information was given.");
        }
    } else {
        exit("Fatal Error: Attempted post user is not registered in the database.");
    }
}