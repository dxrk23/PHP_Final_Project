<?php
require "Database.php";
require "User.php";
session_start();
$db = new Database();
$conn = $db->connect();

if (isset($_POST['userid'])){
    $id = $_POST['userid'];
    $pass = $_POST['pass'];

    $sql = "UPDATE users SET password = ? WHERE user_id=? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd" , $pass , $id);
    if($stmt->execute()) {
        $res = array("mes"=>"Your password is changed");
        $_SESSION['user']->setPassword($pass);
    }
    else $res = array("mes"=>"Your password is not changed");

    echo json_encode($res);

}