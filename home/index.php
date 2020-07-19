<?php
    session_start();
    include '../vendor/autoload.php';
    use Parsedown as PSMD;
    if(!isset($_SESSION['username'], $_SESSION['password'])){
        exit("Fatal Error: No username or password given.");
    } else {
        $userDatabase = new SQLite3('../databases/LoginData.db');
        $username = $_SESSION['username'];
        $query = $userDatabase->query("SELECT * FROM userData WHERE username = '$username'");
        $result = $query->fetchArray(SQLITE3_ASSOC);
        if($result === false){
            exit("Fatal Error: Invalid information passed.");
        }
        $postDatabase = new SQLite3('../databases/PostData.db');
        $postDatabase->exec("CREATE TABLE IF NOT EXISTS posts(author STRING NOT NULL, postText TEXT NOT NULL);");
        $replyDatabase = new SQLite3('../databases/ReplyData.db');
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>HomePage</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alatsi">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/button-materialize-1.css">
    <link rel="stylesheet" href="assets/css/button-materialize.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar-1.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar-2.css">
    <link rel="stylesheet" href="assets/css/Dark-NavBar.css">
    <link rel="stylesheet" href="assets/css/Navigation-Menu.css">
    <link rel="stylesheet" href="assets/css/Rounded-Button.css">
    <link rel="stylesheet" href="assets/css/Social-Icons.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="github.css">
</head>

<body>
    <div>
        <nav class="navbar navbar-light navbar-expand-md sticky-top navigation-clean-button" style="height:80px;background-color:#37434d;color:#ffffff;">
            <div class="container-fluid"><img src="assets/img/IdotHub.png" style="width: 50px;"><a class="navbar-brand" href="#">IdotHub</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div
                    class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation"></li>
                        <li class="nav-item" role="presentation"></li>
                        <li class="nav-item" role="presentation"></li>
                        <li class="nav-item" role="presentation"></li>
                        <li class="nav-item" role="presentation"><a class="nav-link active" style="color: #ffffff;margin: -8px;" href="#"><i class="fa fa-sign-in"></i>&nbsp;Sign out</a></li>
                    </ul>
            </div>
    </div>
    </nav>
    </div>
    <h1 style="font-size: 25px;font-family: Alatsi, sans-serif;"><strong>Create New Post</strong></h1>
    <header></header>
    <form method="post" action="../PostAction.php">
        <textarea style="position: relative; left: 15px;width: 600px;height: 100px;" name="postText" placeholder="Post text"></textarea>
        <textarea style="width: 0px;height: 0px;display: none;" name="username"><?php echo $_SESSION['username']?></textarea>
        <textarea style="width: 0px;height: 0px;display: none;" name="password"><?php echo $_SESSION['password']?></textarea>
        <div></div><button style="position: relative; left: 15px" type="submit" class="waves-effect waves-light btn">Post</button>
    </form>
    <?php
        if(isset($_SESSION['error'])){
            echo "<p style='position: relative; left: 15px;'>";
            switch($_SESSION['error']){
                case "invalidPostSpace":
                    echo "Invalid post - post contained only spaces!";
                    break;
                case "invalidPostNum":
                    echo "Invalid post - post contained only numeric characters!";
                    break;
            }
            echo "</p>";
            unset($_SESSION['error']);
        }
    ?>
    <h1 style="font-size: 30px;font-family: Alatsi, sans-serif;"><strong><u>Recent Posts</u></strong></h1>
    <div></div>
    <?php
        $currentId = 1;
        $posts = [];
        while(!empty($postData = $postDatabase->query("SELECT * FROM posts WHERE rowid = '$currentId'")->fetchArray(SQLITE3_ASSOC))){
            $posts[$currentId] = ["Author" => $postData['author'], "Text" => $postData['postText']];
            $currentId++;
        }
        krsort($posts);
        foreach($posts as $post){
            $author = $post["Author"];
            $text = $post["Text"];
            //$text = str_replace("\n", "<br>", $text);
            echo "<p style='position: relative;left: 15px' size='15px'><b>$author</b></p>";
            echo '<div class="markdown-body" style="position:relative;left:30px;height:220px;width:995px;border:1px solid #ccc;overflow:auto;">';
            $markdownParse = new PSMD();
            echo $markdownParse->text($text);
            echo "</div>";
        }
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/button-materialize.js"></script>
</body>

</html>