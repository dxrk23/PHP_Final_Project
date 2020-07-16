<?php
require "Database.php";
require "User.php";
session_start();
$db = new Database();
$conn = $db->connect();

if (isset($_COOKIE['logged']) && isset($_POST['wp'])) {
    header("location: index.php");
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

    <!-- Page css-->
    <link rel="stylesheet" href="style/style4.css">

    <!-- Google Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap js -->
    <script src="bootstrap/js/bootstrap.min.js"></script>


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
                    <span class="dropdown-item" id="logout" >Logout</span>
                </div>
            </div>
            <form action="login.php" method="post">
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
                location.href = "index.php";
                $("#login").hide();
                $(".dropp").show();
            } else {
                $("#login").show();
                $(".dropp").hide();
            }


            $("#loginl").click(function () {
                if ($("#lemail").val() === "" || $("#lpassword").val() === "") {
                    alert("They can't be empty");
                    return;
                }
                $.ajax({
                    url:"loginLogic.php",
                    type: "POST",
                    data: {
                        "email" : $("#lemail").val(),
                        "password" : $("#lpassword").val()
                    },
                    success: function (data) {
                        let ans = JSON.parse(data);
                        if (ans.mes == "Logged"){
                            location.reload();
                        }
                    }
                });
            });
            $("#regr").click(function () {
                if ($("#rname").val() == "" || $("#remail").val() == "" || $("#rpassword").val() == "") {
                    alert("They can't be empty");
                    return;
                }
                $.ajax({
                    url:"loginLogic.php",
                    type: "POST",
                    data: {
                        "name": $("#rname").val(),
                        "email" : $("#remail").val(),
                        "password" : $("#rpassword").val()
                    },
                    success: function (data) {
                        let ans = JSON.parse(data);
                        if (ans.mes == "registered"){
                            location.reload();
                        }
                        alert(ans.mes);
                    }
                });
            });
            $(".signUpBox").slideToggle(0);
            $(".change").click(function () {
                $(".signUpBox").slideToggle();
                $(".signInBox").slideToggle();
            });
        });
    </script>
<main>

        <div class="container">

                <div class="user signInBox">
                    <div class="imgbox" id="img1">
                        <img src="img/carousel/first.jpg" alt="oops">
                    </div>
                    <div class="formbox">
                        <h3> Sign in</h3>
                        <input type="email" id="lemail" placeholder="Email" >
                        <input type="password" id="lpassword" placeholder="Password">
                        <input id="loginl" type="submit" value="Login">
                        <p class="dont">Dont have account ? <a class="change">Sign up.</a></p>
                    </div>
                </div>

                <div class="user signUpBox">
                    <div class="formbox">
                        <h3>Create account</h3>
                        <input type="text" id="rname" placeholder="Name">
                        <input type="email" id="remail" placeholder="Email" >
                        <input type="password" id="rpassword" placeholder="Password">
                        <input id="regr" type="submit" value="Sign up">
                        <p class="dont">Already have an account ? <a class="change">Sign in.</a></p>
                    </div>
                    <div class="imgbox" id="img2">
                        <img src="img/carousel/second.jpg" alt="oops">
                    </div>
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
