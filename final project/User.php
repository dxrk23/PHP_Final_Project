<?php

class User
{
    private $username;
    private $email;
    private $password;
    private $id;
    private $isAdmin = false;
    private $role = 0;

    public function __construct($a , $b , $c , $d){
        $this->username = $a;
        $this->email = $b;
        $this->password = $c;
        $this->id = $d;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getId(){
        return $this->id;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setIsAdmin(): void{
        $this->isAdmin = true;
    }
    public function IsNotAdmin(): void{
        $this->isAdmin = true;
    }

    public function isAdmin(): bool{
        return $this->isAdmin;
    }

    public function getRole()
    {
        return $this->role;
    }
    function setRole($role): void
    {
        $this->role = $role;
    }




    public function __destruct(){

    }


}