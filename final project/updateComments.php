<?php
require "Database.php";
require "User.php";
session_start();
$db = new Database();
$conn = $db->connect();


if ($_SERVER['REQUEST_METHOD'] == "GET"){
    $id = $_GET['delcomID'];
    $stmt = $conn->prepare("DELETE FROM comments WHERE Comment_id = ?");
    $stmt->bind_param("d" , $id);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM ctu WHERE Comment_id = ?");
    $stmt->bind_param("d" , $id);
    $stmt->execute();
    header ('location: '.$_COOKIE['urlComments']);
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $comText = $_POST['text'];
    $topicID = $_COOKIE['topicID'];
    $comment_id = 0;
    $num = $conn->query("SELECT comment_id FROM comments");
    while( $row = $num->fetch_assoc() ){
        $comment_id = $row['comment_id'];
    }
    $comment_id++;

    if (!isset($_COOKIE['logged'])) {
        exit(json_encode(array("mes"=>"sign in first please" , "id"=>1)));
    }
    $userid = $_SESSION['user']->getId();

    $sql1 = 'INSERT INTO comments(comment_id , comment_text) VALUES (?,?)';
    $sql2 = 'INSERT INTO ctu(user_id , topic_id , comment_id) VALUES (?,?,?)';

    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("ds" , $comment_id , $comText);
    if(!$stmt->execute()) {
        exit(json_encode(array("mes"=>"Cannot add to comments" , "id"=>1)));
    }
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("ddd" ,$userid, $topicID , $comment_id );

    if(!$stmt->execute()) {
        exit(json_encode(array("mes"=>"Cannot add to comments" , "id"=>1)));
   }
    exit(json_encode(array("id"=>2 , "mes"=>"Added")));
}


