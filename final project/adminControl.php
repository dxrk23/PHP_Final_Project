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

    <!-- Google Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap js -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!--mainscript-->
    <script src="js/main.js"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Purple+Purse&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300&display=swap" rel="stylesheet">

</head>
<body>
<!-- Page preloader -->
<div class="meaningless">
    <div></div>
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

        if (<?php if (!$admin) {
    echo 'true';
} else {
    echo 'false';
} ?>) {
            location.href = 'index.php';
        }

        $("#login").click(function () {
            location.href = "login.php";
        });

        $("#src").click(function () {
            $.ajax("updateAdmin.php",{
                type: "POST",
                data:{
                    "search": $("#tetx").val()
                },
                success: function (data) {
                    console.log(data);
                    if (data == "[]"){
                        $(".result").html("<span class='text-danger'> Can not find anyone </span>");
                        return;
                    }
                    var ans = JSON.parse(data);
                    $(".result").html(function () {
                       let x = "<form action=\"updateAdmin.php\" method=\"post\">";
                        for(let i = 0; i < ans.length; ++i) {
                            let mes;
                            if (ans[i].role == 1) mes = "add new admin";
                            else mes = "delete admin";
                            x += "<div><input type='radio' name='id' value=\"" + ans[i].user_id + ans[i].role + "\"><span> name: " + ans[i].user_name + " email: " + ans[i].email + "</span><span style=\"margin-left: 10px;\" class=\"text-danger\">" + mes + "</span></div>";
                        }
                        return x+"<input type='submit' class='btn btn-primary'></form>";
                    });
                }
            })
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

<style type="text/css">
    main{
        height: 100vh;
    }
    .search , .result form{
        height: 80%;
        margin-top: 100px;
        display: flex;
        flex-direction: column;
        align-content: center;
        background-color: white;
    }
    .ses{
        display: flex;
        flex-direction: row;
    }
    .ses *{
        margin: 10px 5px;
    }

    .result form{
        margin-top: 20px;
    }

    .result form > *{
        margin: 10px 5px;
    }

</style>

<!-- Content part -->
<main>
    <div class="container search">
        <div class="container-fluid ses">
            <input id="tetx" class="form-control" type="text" placeholder="Email or name" aria-label="Search">
            <button class="btn btn-primary" id="src">Search</button>
        </div>
        <div class="container-fluid result">

        </div>
    </div>
</main>
<!-- End of content part -->

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
