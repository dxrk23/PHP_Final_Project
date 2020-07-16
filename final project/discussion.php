<?php
require "Database.php";
require "User.php";
session_start();
$db = new Database();
$conn = $db->connect();

if (isset($_COOKIE['logged'])) {
    $admin = $_SESSION['user']->isAdmin();
} else {
    $admin = false;
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

        if( <?php if (isset($_COOKIE['logged'])) {
    if ($_SESSION['user']->isAdmin()) {
        echo 'true';
    } else {
        echo 'false';
    }
} else {
    echo 'false';
} ?> ){
            $(".addTopic").show();
        }

        $("#login").click(function () {
            location.href("login.php");
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

<!-- Content part -->
<main>
    <?php
    $result = $conn->query("SELECT * FROM discussions");
    while ($row = $result->fetch_assoc()) {
        ?>
    <div class="branch">
        <p><?php echo $row['Discussion_title']; ?><?php
            if ($admin) {
                echo '<a href="updateDis.php?type=delete&id='.$row['Discussion_id'].'" class="del"><img src="img/del.png"></a>';
            } ?></p>

        <div>
            <?php

            $join = "SELECT Topic_name , td.Topic_id FROM (discussions d INNER JOIN td ON d.Discussion_id = td.Discussion_id INNER JOIN topics t ON td.Topic_id = t.topic_id) WHERE d.Discussion_id = ?";
        $st = $conn->prepare($join);
        $st->bind_param("d", $row['Discussion_id']);
        $st->execute();
        $res = $st->get_result();
        while ($rw = $res->fetch_assoc()) {
            ?>
            <div class="comment">
                <form action="seeComments.php" method="get">
                    <img src="img/com.png" alt="img">
                    <input hidden type="number" name="topic_id" value="<?php echo $rw['Topic_id']; ?>">
                    <input hidden type="text" name="topic_name" value="<?php echo $rw['Topic_name']; ?>">
                    <button class="link_btn"><?php echo $rw['Topic_name']; ?></button>
                    <?php if ($admin) {
                echo  '<a href="updateCom.php?type=delete&id='.$rw['Topic_id'].'" class="del"><img src="img/del.png"></a>';
            } ?>
                </form>
            </div>
            <?php
        } ?>
            <div class="comment addTopic">
                <form class="form-inline" method="get" action="updateCom.php" >
                    <img src="img/com.png" alt="img">
                    <input hidden type="number" name="dis_id" value="<?php echo $row['Discussion_id']; ?>">
                    <input hidden type="text" name="type" value="add">
                    <input type="text" name="topic_name">
                    <input  type="submit" class="btn-sm btn-outline-info" value="Add topic">
                </form>
            </div>
        </div>
    </div>
    <?php
    } ?>
    <?php
        if ($admin) {
            echo '<div class="branch">
                    <p>Add discussion</p>
                    <div class="comment addTopic">
                <form class="form-inline " method="get" action="updateDis.php">
                    <img src="img/com.png" alt="img">
                    <input type="text" name="dis_name">
                    <input type="text" name="type" value="add" hidden>
                    <input  type="submit" class="btn-sm btn-outline-info addDisbtn" value="add">
                </form>
            </div>
                  </div>';
        }
    ?>
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
                    <a href="#">Olzhas</a>
                </li>
                <li>
                    <a href="#">DImsh</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<!-- Footer -->
</body>
</html>
