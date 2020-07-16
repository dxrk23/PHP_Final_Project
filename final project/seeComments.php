<?php
require "Database.php";
require "User.php";
session_start();
$db = new Database();
$conn = $db->connect();


$title = $_GET['topic_name'];
$actual_link = ('seeComments.php'.'?topic_id='.$_GET['topic_id'].'&'.'topic_name='.$_GET['topic_name']);
setcookie("urlComments", $actual_link, time() + 3600);
setcookie("topicID", $_GET['topic_id'], time() -1);
setcookie("topicID", $_GET['topic_id'], time() + 3600);
$sql = "SELECT c.Comment_id AS cidw ,Comment_text AS text , u.user_name AS username , u.email AS email FROM comments c INNER JOIN ctu ON c.Comment_id = ctu.Comment_id INNER JOIN users u ON ctu.User_id = u.user_id WHERE ctu.Topic_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("d", $_GET['topic_id']);
$stmt->execute();
$res = $stmt->get_result();

if (isset($_COOKIE['logged'])) {
    $admin = $_SESSION['user']->isAdmin();
    $email = $_SESSION['user']->getEmail();
} else {
    $admin = false;
    $email = "";
}



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
    <link rel="stylesheet" href="style/style3.css">

    <!-- Google Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--mainscript-->
    <script src="js/main.js"></script>

    <!-- Bootstrap js -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Purple+Purse&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300&display=swap" rel="stylesheet">

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

        $("#login").click(function () {
            location.href("login.php");
        });

        $("#addComment").click(function(){
            $("#addCom").slideToggle();
            $(".adForm").slideToggle();
        });

        $("#addCombtn").click(function() {
            $("#addCom").slideToggle();
            $(".adForm").slideToggle();
            if ($("#comm").val() != "") {
                $.ajax("updateComments.php", {
                    type: "POST",
                    data: {"text": $("#comm").val()},
                    success: function (data) {
                        let x = JSON.parse(data);
                        if (x.id === 1) alert(x.mes);
                        else location.reload();
                    }
                });
            }
        });

    });
</script>
<!-- Navigation bar-->
<div class="container navigation">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top ">
        <a href="#" class="navbar-brand ml-3">
            <img src="img/rogp.png" id="logo" alt="logo">
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
                    if (isset($_COOKIE['logged']) && $_SESSION['user']->isAdmin()) {
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
<style type="text/css">
    main{
        min-height: 62vh;
    }
    .username{
        text-align: left;
    }
    .branch p{
        padding-left: 10px;
    }
    #addComment:hover{
        text-decoration: underline;
        cursor: pointer;
    }

    .adForm textarea{
        min-height: 100px;
    }


</style>
<!-- Content part -->
<main>
    <div class="branch">
        <p><?php echo $title;?></p>
        <div>
            <?php
            while ($row = $res->fetch_assoc()) {
                ?>
            <div class="comment">
                <img src="img/com.png" alt="img">

                <span class="text-info"><?php echo $row['text']?></span>

                <span class="username text-danger"><?php echo $row['username']?></span>
                <?php
                    if ($email == $row['email'] || $admin) {
                        echo '<a href="updateComments.php?delcomID='.$row['cidw'].'" class="del"><img src="img/del.png"></a>';
                    } ?>
            </div>
            <?php
            } ?>
            <div class="comment" id="addCom">
                <img src="img/com.png" alt="img">
                <span class="text-info" id="addComment">Add comment</span>
            </div>
            <div style="display: none" class="adForm">
                <textarea id="comm"></textarea>
                <button class="btn btn-light" id="addCombtn">Add comment</button>
            </div>
        </div>
        <p>.</p>
    </div>
</main>
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
