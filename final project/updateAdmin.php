<?php
require "Database.php";
require "User.php";
session_start();
$db = new Database();
$conn = $db->connect();

if (!isset($_COOKIE['logged'])) exit(json_encode(array()));
if ($_SERVER['REQUEST_METHOD'] = 'POST'){
    if (isset($_POST['search'])){
        $ad = $_SESSION['user']->getRole();
        $req = $_POST['search'];
        $sql = "SELECT user_id , user_name , email , isAdmin FROM users WHERE user_name LIKE ? OR email LIKE ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss" , $req ,$req);
        $stmt->execute();
        $res = $stmt->get_result();

        $result = array();
        while($row = $res->fetch_assoc()){
            if ($row['isAdmin'] != 0 && $row['isAdmin'] < $ad) continue;
            if ($row['isAdmin'] == 0) $kk = 1;
            else $kk = 0;
            $row += array("role"=>$kk );
            array_push($result,$row);
        }

        echo json_encode($result);
    } else {
        $id = ($_POST['id'] - ($_POST['id']%10) )/10;
        $sql = 'UPDATE users SET users.isAdmin = ? WHERE user_id = ?';
        $stmt = $conn->prepare($sql);
        if ($_POST['id']%10 == 1) $var1 = $_SESSION['user']->getRole()+1;
        else $var1 = 0;
        echo $id;
        $stmt->bind_param("dd", $var1,$id);
        if($stmt->execute()) header("location: index.php");
        else echo "Something went wrong";

    }

}