<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>IdotHub</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alfa+Slab+One">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allerta">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="assets/css/Advanced-NavBar---Multi-dropdown.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar-1.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar-2.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar.css">
    <link rel="stylesheet" href="assets/css/dh-header-non-rectangular.css">
    <link rel="stylesheet" href="assets/css/Navbar---Apple-1.css">
    <link rel="stylesheet" href="assets/css/Navbar---Apple.css">
    <link rel="stylesheet" href="assets/css/Navigation-Menu.css">
    <link rel="stylesheet" href="assets/css/OcOrato---Login-form-1.css">
    <link rel="stylesheet" href="assets/css/OcOrato---Login-form.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="background: url(assets/img/minimal-sunset-landscape-4k-w5.jpg);background-color: rgb(0,0,0);">
    <form action="LoginAuth.php" method="post" id="form" style="font-family:Quicksand, sans-serif;background-color:rgba(44,40,52,0.73);width:320px;padding:40px;">
        <h1 id="head" style="color:rgb(193,166,83);">Login</h1>
        <div></div>
        <div class="form-group"><input class="form-control" type="username" id="username" placeholder="Username" name="username"></div>
        <div class="form-group"><input class="form-control" type="password" id="password" placeholder="Password" name="password"></div>
        <?php
            if(isset($_SESSION['error'])){
                echo '<div align="center">';
                switch($_SESSION['error']){
                    case "newAccount":
                        echo "<p>Account created! Login!</p>";
                        break;
                    case "noInfo":
                        echo "<p>Something went wrong!</p>";
                        break;
                    case "noUsername":
                        echo "<p>No username given!</p>";
                        break;
                    case "userNotRegistered":
                        echo "<p>You are not registered!</p>";
                        break;
                    case "invalidPassword":
                        echo "<p>Incorrect password!</p>";
                        break;
                }
                echo "</div>";
                unset($_SESSION['error']);
            }
        ?>
        <button class="btn btn-light" id="butonas" style="width:100%;height:100%;margin-bottom:10px;background-color:rgb(106,176,209);" type="submit">Submit</button>
    </form>
    <script
        src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/Advanced-NavBar---Multi-dropdown.js"></script>
        <script src="assets/js/Navbar---Apple.js"></script>
</body>

</html>