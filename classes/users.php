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

    function clear_data($work_data){
        $err = array(
            'first_name_err' => "",
            'last_name_err' => "",
            'password_err' => "",
            'email_err' => "",
            'repeat_err' => "",
            'phone_err' => "",
            'site_err' => ""
        );
        $clear = true;
        if(empty($work_data["first_name"])){
            $err["first_name_err"] = "First name is reqired!";
            $clear = false;
        };
        
        if(empty($work_data["last_name"])){
            $err["last_name_err"] = "Last name is reqired!";
            $clear = false;
        };
        
        if(empty($work_data["email"])){
            $err["email_err"] = "Email is reqired!";
            $clear = false;
        };
        
        
        if(empty($work_data["password"])){
            $err["password_err"] = "Password is reqired!";
            $clear = false;
        };
        
        if(empty($work_data["repeat"])){
            $err["repeat_err"] = "You have to repeat the password!";
            $clear = false;
        };
        
        
        
        $user_data = array(
            'first_name' 	=> "",
            'last_name'  	=> "",
            'email'		 	=> "",
            'password'	 	=> "",
            'phone'	     	=> "",
            'company_name'  => "",
            'company_site'  => "",
            'description'   => "",
            'company_image' => "",
            'is_admin'		=> false
        );
        
        if(isset($work_data["first_name"])){
            $user_data["first_name"] = $work_data["first_name"];
        }
        if(isset($work_data["last_name"])){
            $user_data["last_name"] = $work_data["last_name"];
        }
        if(isset($work_data["email"])){
            $user_data["email"] = $work_data["email"];
        }
        if(isset($work_data["password"])){
            $user_data["password"] = password_hash($work_data["password"], PASSWORD_DEFAULT);
        }
        if(isset($work_data["phone"])){
            $user_data["phone"] = $work_data["phone"];
        }
        if(isset($work_data["companyName"])){
            $user_data["company_name"] = $work_data["companyName"];
        }
        if(isset($work_data["companySite"])){
            $user_data["company_site"] = $work_data["companySite"];
        }
        if(isset($work_data["description"])){
            $user_data["description"] = $work_data["description"];
        }
        if(isset($work_data["company_image"])){
            $user_data["company_image"] = $work_data["company_image"];
        }
        
        if(isset($work_data["password"])){
            $uppercase = preg_match('@[A-Z]@', $work_data["password"]);
            $lowercase = preg_match('@[a-z]@', $work_data["password"]);
            $specialChars = preg_match('@[^\w]@', $work_data["password"]);

            if(!$uppercase || !$lowercase ||  !$specialChars || strlen($work_data["password"]) < 8) {
                $err["password_err"] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one lower case letter, and one special character.';
                $clear = false;
            }
            
            if($work_data["password"] != $work_data["repeat"] && !empty($work_data["password"]) && !empty($work_data["repeat"])){
                $err["password_err"] = "passwords do not match!";
                $clear = false;
            }
        }
        
        
        
        if(filter_var($user_data["email"], FILTER_VALIDATE_EMAIL) != true && !empty($work_data["email"])){
            $err["email_err"] = "email is not valid!";
            $clear = false;
        }
        
        if(!filter_var($user_data["company_site"], FILTER_VALIDATE_URL) && !empty($user_data["company_site"])){
            $err["site_err"] = "site url is not valid!";
            $clear = false;
        }
        
        if(!preg_match('/^[0-9]{10}+$/', $user_data["phone"])){
            $err['phone_err'] = "phone number is not valid!";
            $clear = false;
        }

        $output = array(
            'errors' => $err,
            'data'   => $user_data,
            'is_clear' => $clear
        );

        return $output;
    }


    function __construct($input)
    {
        $work_data = $this->clear_data($input);
        $data = $work_data["data"];
        $data = $this->sanitize($data);
        $this->email        = $data["email"];
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


    function insert($conn, $image_name){
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