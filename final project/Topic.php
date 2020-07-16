<?php

class Topic{
    protected $title = 'title';
    protected $id;
    private $type;

    public function __construct( $id , $title){
        $this->title = $title;
        $this->id = $id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getId(){
        return $this->id;
    }

    public function setType($type){
        $this->type = $type;
    }


    public function delete($conn){
       try{
           if ($this->type == "dis") {
               $sql1 = "DELETE FROM discussions WHERE Discussion_id = ?";
               $sql2 = "DELETE t.* , td.* , ctu.* , c.* FROM topics t INNER JOIN td ON t.Topic_id = td.Topic_id INNER JOIN ctu ON ctu.Topic_id = t.Topic_id INNER JOIN comments c ON c.Comment_id = ctu.Comment_id WHERE td.Discussion_id = ?";
           } else {
               $sql1 = "DELETE FROM topics WHERE Topic_id=?";
               $sql2 = "DELETE c.* , ctu.* FROM comments c INNER JOIN ctu ON c.Comment_id = ctu.Comment_id WHERE ctu.Topic_id = ?";
           }

           $stmt = $conn->prepare($sql1);
           $stmt->bind_param("d" , $this->id);
           $stmt->execute();

           $stmt = $conn->prepare($sql2);
           $stmt->bind_param("d" , $this->id);
           $stmt->execute();
       } catch (Exception $e){
           echo $e->getMessage();
       }
    }

}