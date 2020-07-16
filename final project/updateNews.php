<?php
require "Database.php";
require "User.php";
require "Word.php";
session_start();
$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $word = new word($conn , $_GET['id']);
    if ($_GET['type'] == 'update'){
        ?>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <style type="text/css">
            textarea{
                min-height: 400px;
            }
            form > *{
                width: 400px;
            }
            form{
               display: grid;
                justify-content: center;
            }
        </style>
        <div class="news-card-info someNewNews form-group">
        <form class="form-group" method="post" action="updateNews.php">
            <input type="text" hidden name="type" value="update">
            <input type="number" hidden value="<?php echo $word->getId();?>" name="id"><br>
            <input type="text" name="title" value="<?php echo $word->getTitle();?>"><br>
            <textarea type="text" name="text"><?php echo $word->getText();?></textarea><br>
            <input type="text" name="url" value="<?php echo $word->getUrl();?>"><br>
            <input type="date" name="date" value="<?php echo $word->getDate();?>"><br>
            <input  class="btn btn-primary" type="submit" value="Submit">
        </form>
        </div>
    <?php

    } else {
        $word->delete($conn);
        header("location: news.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $text = $_POST['text'];
    $url = $_POST['url'];
    if ($url == "") $url = word::$standrtURL;
    $date = $_POST['date'];

    if($_POST['type'] == 'update'){
        $stmt = $conn->prepare("UPDATE news SET title=?,text=?,url=?,date=? WHERE id = ?");
        $id = $_POST['id'];
        $stmt->bind_param('ssssd' ,$title , $text , $url , $date , $id);
        $stmt->execute();
        header("location: news.php");
    } else {
        $stmt = $conn->prepare("INSERT INTO news(title, text, url,date ) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss' ,$title , $text , $url , $date );
        $stmt->execute();
        $return = array("mes"=>"Inserted");
        echo json_encode($return);
    }
}

