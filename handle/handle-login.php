<?php
// connection - submit - filter -validation - empty (check ) - redirect index
require_once '../inc/connection.php';
require_once '../inc/header.php';


if(isset($_POST['submit'])){
    $email=htmlspecialchars(trim($_POST['email']));
    $password=htmlspecialchars(trim($_POST['password']));


     $errors=[];
     if(empty($email)){
        $errors[] = "email is required";
     }elseif(! filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = "email is not valid";
     }
     

     if(empty($password)){
        $errors[] = "password is required";
     }elseif(strlen($password)<6){
        $errors[] = "password must be more than 5 chars";
     }

     if(empty($errors)){
        $query= "SELECT * from users where `email`='$email'";
        $result=mysqli_query($conn,$query);
         
        if(mysqli_num_rows($result)==1){
            $user=mysqli_fetch_assoc($result);
            $oldPassword=$user['password'];
            $is_valid=password_verify($password,$oldPassword);
            
            if($is_valid){
             $_SESSION['user_id']=$user['id'];

             $_SESSION['success']='welcome user';
             header("location:../index.php");
           
            }else{
              
              $_SESSION['errors']=['credintials not correct'];
              $_SESSION['email']=$email;
              header("location:../login.php");
             
            }

        }else{
            $_SESSION['errors']=['this account not found'];
            header("location:../login.php");
           
 
        }
           


     }else{

        $_SESSION['errors']=$errors;
        $_SESSION['email']=$email;

        header("location:../login.php");

     }

}else{
    header("location:../login.php");
}
