<?php
require ("Topic.php");
class word extends Topic
{
    private $text = "No text";
    private $date = "2012-12-12";
    private $url = 'https://thumbs.dreamstime.com/b/newsletter-concept-email-news-message-pink-background-184204805.jpg';
    public static $standrtURL = 'https://thumbs.dreamstime.com/b/newsletter-concept-email-news-message-pink-background-184204805.jpg';

    public function __construct( $conn , $id){


        try{
            $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
            $stmt->bind_param("d" , $id);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();
            $this->text = $res['text'];
            $this->date = $res['date'];
            $this->url = $res['url'];
            parent::__construct($res['id'] , $res['title']);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function getText(){
        return $this->text;
    }

    public function getDate(){
        return $this->date;
    }

    public function getUrl(){
        return $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function delete($conn){
        try{
            $stmt = $conn->prepare('DELETE FROM news WHERE id = ?');
            $stmt->bind_param("d" , $this->id);
            $stmt->execute();
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

}