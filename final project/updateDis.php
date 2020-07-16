<?php
require "Database.php";
require "User.php";
require "Topic.php";
session_start();
$db = new Database();
$conn = $db->connect();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if ($_GET['type'] == 'add'){
        $stmt = $conn->prepare("INSERT INTO discussions (Discussion_title) VALUES(?)");
        $stmt->bind_param("s",$_GET['dis_name']);
        $stmt->execute();
        header("location: discussion.php");
    } else {
        $stmt = $conn->prepare("SELECT * FROM discussions WHERE Discussion_id = ?");
        $stmt->bind_param('d' , $_GET['id']);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $dis = new Topic($res['Discussion_id'] , $res['Discussion_title']);
        $dis->setType("dis");
        $dis->delete($conn);
        header("location: discussion.php");
    }
}