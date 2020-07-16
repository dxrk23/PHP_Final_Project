<?php
require "Database.php";
require "User.php";
require "Topic.php";
session_start();
$db = new Database();
$conn = $db->connect();
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if ($_GET['type'] == 'add'){
        $disid = $_GET['dis_id'];

        $topid = 1;
        $th = $conn->query("SELECT Topic_id AS id FROM topics");
        while($tt = $th->fetch_assoc()){
            $topid = $tt['id'];
        }
        $topid++;

        $stmt = $conn->prepare("INSERT INTO topics (Topic_id , Topic_name) VALUES(?,?)");
        $stmt->bind_param("ds",$topid, $_GET['topic_name']);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO td(Discussion_id , Topic_id) VALUES(?,?)");
        $stmt->bind_param("dd",$disid , $topid);
        $stmt->execute();
        header("location: discussion.php");
    } else {

        $st = $conn->prepare("DELETE FROM td WHERE Topic_id = ?");
        $st->bind_param("d" , $_GET['id']);
        $st->execute();

        $stmt = $conn->prepare("SELECT * FROM topics WHERE Topic_id = ?");
        $stmt->bind_param('d' , $_GET['id']);
        $stmt->execute();

        $res = $stmt->get_result()->fetch_assoc();
        $dis = new Topic($res['Topic_id'] , $res['Topic_name']);
        $dis->setType("top");
        $dis->delete($conn);
        header("location: discussion.php");
    }
}