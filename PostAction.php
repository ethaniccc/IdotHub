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
}

if(ctype_digit($_POST['postText'])){
    session_regenerate_id();
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['error'] = "invalidPostNum";
    header("Location: home/index.php");
    return;
}