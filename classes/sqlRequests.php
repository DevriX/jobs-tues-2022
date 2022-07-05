<?php
include "users.php";


class Requests{
    private $object;

    function connectDB(){
        $conn = mysqli_connect("localhost", "fustuk", "123456", "jobs_devrix");
        if(!$conn){
            echo("Error connecting");
        }
        
        mysqli_select_db($conn, "jobs_devrix") or die(mysqli_error($conn));
        return $conn;
    }


    }

}