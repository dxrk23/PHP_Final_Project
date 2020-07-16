<?php
require "Database.php";
require "User.php";
session_start();
$db = new Database();
$conn = $db->connect();

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

    <!-- Page css-->
    <link rel="stylesheet" href="style/style5.css">

    <!-- Google Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap js -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Mainscript -->
    <script src="js/main.js"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Purple+Purse&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300&display=swap" rel="stylesheet">

</head>
<body>

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
            </form>
        </div>
    </nav>
</div>
<!-- End of navigation-->
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
            location.href = "index.php";
            $("#login").show();
            $(".dropp").hide();
        }

        $(".confirm-2").slideToggle(0);

        $("#check").click(function () {
            if ("<?php echo $_SESSION['user']->getPassword();?>" !== $("#lpassword").val()){
                $("#mes-1").text("Wrong password");
            } else {
                $("#mes-1").text("");
                $(".confirm-2").slideToggle();
                $(".confirm-1").slideToggle();

            }
        });

        $("#check1").click(function () {
            if ( $("#password1").val() !== $("#password2").val()){
                $("#mes-2").text("Passwords are not equal");
            } else {
                $("#mes-2").text("");
                $.ajax("updatePass.php",{
                   type: "POST",
                   data: {
                       "pass": $("#password1").val(),
                       "userid": "<?php echo $_SESSION['user']->getId(); ?>"
                   },
                    success: function (data) {
                       x = JSON.parse(data);
                        $("#mes-2").text(x.mes);
                        $("#check1").hide();
                        $("#goHome").show();
                    }
                });
            }
        });
        $("#goHome").click(function () {
            location.href = "index.php";
        });
    });
</script>
<br>
<br>
<br>
<main>

        <div class="user">
            <div class="email">
                <h2><?php echo $_SESSION['user']->getEmail();?></h2>
            </div>

            <div class="user confirm-2">
                <h3>Enter new password</h3>
                <span class="text-danger" id="mes-2"></span>
                <input type="password" id="password1" placeholder="Password">
                <input type="password" id="password2" placeholder="Confirm password">
                <input id="check1" type="submit" value="change">
                <input id="goHome" type="submit" value="Home page">
            </div>

            <div class="user confirm-1">
                <h3>Confirm password</h3>
                <span class="text-danger" id="mes-1"></span>
                <input type="password" id="lpassword" placeholder="Password">
                <input id="check" type="submit" value="confirm">
            </div>
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
