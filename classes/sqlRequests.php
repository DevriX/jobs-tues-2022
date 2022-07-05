<?php
include "users.php";


class Requests{
    private $object;

    function connectDB(){
        $conn = mysqli_connect("localhost", "fustuk", "123456", "jobs_devrix");
        if($conn){
            echo("Connected successfully");
        }else{
            echo("Error connecting");
        }
        
        mysqli_select_db($conn, "jobs_devrix") or die(mysqli_error($conn));
        return $conn;
    }
    
    function Insert($object){
        $conn = connectDB();
        if($object.get_class() == "users"){
            $sql = 'INSERT INTO  users  values()';
        }
        else if($object.get_class() == "jobs"){
            $sql = 'INSERT INTO  jobs  values()';
        }
        else if($object.get_class() == "categories"){
            $sql = 'INSERT INTO  categories  values()';
        }
        else if($object.get_class() == "applications"){
            $sql = 'INSERT INTO  applications  values()';
        }
        
        mysqli_querry($conn, $sql);
    }

}



?>