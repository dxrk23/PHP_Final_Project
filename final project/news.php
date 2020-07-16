<?php
require "Database.php";
require "User.php";
require "Word.php";

session_start();
$db = new Database();
$conn = $db->connect();
$result = $conn->query("SELECT * FROM news ORDER BY date DESC ");
$admin = isset($_COOKIE['logged']) && $_SESSION['user']->isAdmin();
?>
<!DOCTYPE html>
<html>

<head>
    <title>OD Tanki</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap css-->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">

    <!-- Main css-->
    <link rel="stylesheet" href="style/style.css">

    <!-- Page style-->
    <link rel="stylesheet" href="style/style2.css">

    <!-- Google Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- mainscript -->
    <script src="js/main.js"></script>

    <!-- Bootstrap js -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Purple+Purse&display=swap" rel="stylesheet">

</head>
<body>
<!-- Page preloader -->
<div class="meaningless">
    <div class="hello"></div>
</div>
<script>
    $(document).ready(function () {
        if (<?php if (isset($_COOKIE['logged'])) {
    echo 'true';
} else {
    echo 'false';
} ?>){
            $("#login").hide();
            $(".dropp").show();
        } else {
            $("#login").show();
            $(".dropp").hide();
        }

        if( <?php if ($admin) {
    echo 'true';
} else {
    echo 'false';
} ?> ){
            $(".news-card-info .btn").show();
        } else {
            $(".news-card-info .btn").hide();
        }

        $("#login").click(function () {
            location.href("login.php");
        });

        $("#insert").click(function () {
            $.ajax("updateNews.php", {
                type: "POST",
                data:{
                    'type' : 'insert',
                    'title' : $("#title ").val(),
                    'text' : $("#text").val(),
                    'url' : $("#url").val(),
                    'date' : $("#date").val()
                },
                success: function (data) {
                    console.log(data);
                    location.reload();
                }
            });
        });

    });
</script>
<!-- Navigation bar-->
<div class="container navigation">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top ">
        <a href="#" class="navbar-brand ml-3">
            <img src="img/rogp.png" alt="logo" id="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#MyNavbar" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="MyNavbar">
            <ul class="navbar-nav nav-tabs  pl-lg-3  mt-0 ml-md-5 mr-auto" >
                <li class="nav-item ml-3 mr-3">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item ml-3 mr-3">
                    <a class="nav-link" href="news.php">News</a>
                </li>
                <li class="nav-item ml-3 mr-3">
                    <a class="nav-link" href="discussion.php">Discussions</a>
                </li>
            </ul>
            <button class="btn btn-outline-light ml-3 mr-3 open-game" id="login">Sign in</button>
            <div class="btn-group dropp">
                <button class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown"><?php
                    if (isset($_COOKIE['logged'])) {
                        echo $_SESSION['user']->getUsername();
                    }
                    ?></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="update.php" >Change password</a>
                    <?php
                    if ($admin) {
                        echo '<a class="dropdown-item" href="adminControl.php">Control admins</a>';
                    }
                    ?>
                    <span class="dropdown-item" id="logout" >Logout</span>
                </div>
            </div>
            <form action="game.php" method="post">
                <input hidden type="text" name="wp" value="play">
                <button class="btn btn-outline-light ml-3 mr-3 open-game">Play</button>
            </form>        </div>
    </nav>
</div>
<!-- End of navigation-->

<!-- Beginnig of news section -->
<main>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <div class="news-container container">
        <div class="news-card">
            <div class="news-card-img">
                <img src="<?php echo $row['url'];?>" alt="">
            </div>
            <div class="news-card-info">
                <span class="info-date"><?php echo $row['date'];?></span>
                <h1 class="info-title"><?php echo $row['title'];?></h1>
                <p class="info-text"> <?php echo $row['text'];?></p>
                <a class="btn btn-info" href="updateNews.php?id=<?php echo $row['id'];?>&type=update">Edit</a>
                <a class="btn btn-danger" href="updateNews.php?id=<?php echo $row['id'];?>&type=delete">Delete</a>
            </div>
        </div>
    </div>
    <?php }

    if ($admin) {
        echo ' <div class="news-container container">
        <div class="news-card">
            <div class="news-card-img">
                <img src="https://thumbs.dreamstime.com/b/newsletter-concept-email-news-message-pink-background-184204805.jpg" alt="logo">
            </div>
            <div class="news-card-info someNewNews form-group">
                <input class="form-control-lg mt-3 mb-3" type="text" name="title" id="title" placeholder="Title">
                <textarea class="form-control-plaintext border-dark mt-3 mb-3" name="content" id="text" placeholder="Type some text"></textarea>
                <input class="form-control-sm mt-3 mb-3" type="text" name="url" id="url" placeholder="url">
                <input class="form-control-sm mt-3 mb-3" type="date" name="date" id="date" placeholder="yyyy-mm-dd">
                <button class="btn btn-primary mt-3 mb-3" id="insert">Add news</button>
            </div>
        </div>
    </div>';
    }
    ?>
</main>
<!-- End of news section -->
<!-- Footer -->
<footer class="page-footer font-small bg-dark pt-4">
    <div class="container footer">
        <div class="info">
            <h5 class="text">OD Tanki</h5>
            <p>There you can play tanki with your friend</p>
        </div>

        <div class="links">
            <h5 class="">There is some useful links for you:</h5>
            <ul class="list-unstyled">
                <li>
                    <a href="https://github.com/ChpOlzhik" target="_blank">Olzhas</a>
                </li>
                <li>
                    <a href="https://github.com/dxrk23" target="_blank">Dimash</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<!-- Footer -->
</body>

</html>
