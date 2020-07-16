<?php
require "Database.php";
require "User.php";
session_start();
$db = new Database();
$conn = $db->connect();
$return = array("mes"=>"Request is not defined");
if (isset($_POST['email'])) {

    $sql = "SELECT * FROM users WHERE email = ?";
    $st = $conn->prepare("$sql");
    $st->bind_param("s", $_POST['email']);
    $st->execute();
    $res = $st->get_result()->fetch_assoc();

    if (empty($res)) {
        if (isset($_POST['name'])) {
            $return = array("mes" => "registered");
            $rt = $conn->prepare("INSERT INTO users(user_name , email , password) VALUES (?,?,?)");
            $rt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['password']);
            if ($rt->execute()) {
                $rows = $conn->prepare('SELECT user_id FROM users WHERE email = ?');
                $rows->bind_param("s",$_POST['email']);
                $rows->execute();
                $id = $rows->get_result()->fetch_assoc();
                $us = new User($_POST['name'] , $_POST['email'] , $_POST['password'] , $id['user_id']);
                $_SESSION['user'] = $us;
                setcookie("logged" , true , time()+3600*24);
            } else $return = array("mes" => "Cannot insert");

        } else {
            $return = array("mes" => "Wrong email");
        }
    } else {
        $email = $res['email'];
        $name = $res['user_name'];
        $pass = $res['password'];
        $id = $res['user_id'];
        if (isset($_POST['name'])) {
            $return = array("mes" => "user is alredy registered");
        } else {
            if ($pass == $_POST['password']) {
                $return = array("mes" => "Logged");
                $us = new User($name , $email , $pass , $id);

                if ($res['isAdmin'] != 0) $us->setIsAdmin();
                $us->setRole($res['isAdmin']);
                $_SESSION['user'] = $us;
                setcookie("logged" , true , time()+3600*24);
            } else {
                $return = array("mes" => "wrong password");
            }
        }
    }
} else if(isset($_POST['destroy'])){
    $_SESSION['user']->__destruct();
   session_destroy();
    setcookie('logged', false , time() -1);
    $return = array("mes"=>"Logged out");
}

echo json_encode($return);

