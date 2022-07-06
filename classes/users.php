<?php
require_once "Db-connection.php";

class User {
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $password;
    private $phone_number;
    private $company_name;
    private $company_site;
    private $company_description;
    private $company_image;
    private $is_admin;


    function sanitize($data){
        foreach($data as $d){
            $d = htmlspecialchars($d);
            $d = stripslashes($d);
            $d = trim($d);
        }
       return $data;
    }

    function __construct($data)
    {
        $data = $this->sanitize($data);
        
        $this->email = $data["email"];
        $this->first_name   = $data["first_name"];
        $this->last_name    = $data["last_name"];
        $this->password     = $data["password"];
        $this->phone_number = $data["phone"];
        $this->company_name = $data["company_name"];
        $this->company_site = $data["company_site"];
        $this->company_description = $data["description"];
        $this->company_image = $data["company_image"];
        if(strpos($data["email"], "@devrix.com") !== false){
            $this->is_admin = true;
        }else{
            $this->is_admin = false;
        }
    }


    function insert($conn){
        mysqli_query($conn,"
        INSERT INTO 
        users(email, 
            first_name, 
            last_name, 
            password, 
            phone_number, 
            company_name, 
            company_site, 
            company_description, 
            company_image, 
            is_admin)
        values(
            '".$this->email."', 
            '".$this->first_name."', 
            '".$this->last_name."', 
            '".$this->password."', 
            '".$this->phone_number."', 
            '".$this->company_name."', 
            '".$this->company_site."', 
            '".$this->company_description."', 
            '".$this->company_image."', 
            '".$this->is_admin."')
        ");
    }

    function getid(){
        return $this->id;
    }
    function getemail(){
        return $this->email;
    }
    function getfirst_name(){
        return $this->first_name;
    }
    function getlast_name(){
        return $this->last_name;
    }
    function getpassword(){
        return $this->password;
    }
    function getphone_number(){
        return $this->phone_number;
    }
    function getcompany_name(){
        return $this->company_name;
    }
    function getcompany_site(){
        return $this->company_site;
    }
    function getcompany_description(){
        return $this->company_description;
    }
    function getcompany_image(){
        return $this->company_image;
    }
    function getis_admin(){
        return $this->is_admin;
    }
    function setid($id){
        $this->id = $id;
    }
    function setemail($email){
        $this->email = $email;
    }
    function setfirst_name($first_name){
        $this->first_name = $first_name;
    }
    function setlast_name($last_name){
        $this->last_name = $last_name;
    }
    function setpassword($password){
        $this->password = $password;
    }
    function setphone_number($phone_number){
        $this->phone_number = $phone_number;
    }
    function setcompany_name($company_name){
        $this->company_name = $company_name;
    }
    function setcompany_site($company_site){
        $this->company_site = $company_site;
    }
    function setcompany_description($company_description){
        $this->company_description = $company_description;
    }
    function setcompany_image($company_image){
        $this->company_image = $company_image;
    }
    function setis_admin($is_admin){
        $this->is_admin = $is_admin;
    }
}

?>