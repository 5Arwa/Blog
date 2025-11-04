<?php

require_once '../inc/connection.php';


if(isset($_POST['submit'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $body = htmlspecialchars(trim($_POST['body']));

    $errors = [];

    if(empty($title)) {
        $errors[] = "title is required";
    }elseif(is_numeric($title)) {
        $errors[] = "title must be string";
    }

    if(empty($body)) {
        $errors[] = "body is required";
    }elseif(is_numeric($body)) {
        $errors[] = "body must be string";
    }


    if($_FILES && $_FILES['image']['name']){

        $image = $_FILES['image'];
        $name = $image['name'];
        $tmp_name = $image['tmp_name'];
        $size = $image['size'];//
        $sizeMB = $image['size']/(1024*1024);//mb
        $ext = strtolower(pathinfo($name , PATHINFO_EXTENSION));

            $newName = uniqid().".".$ext;

            $arr = ['jpg','png','jpeg','pdf'];
            if($sizeMB>1){
                $errors[] = "large size";
            }elseif(! in_array($ext,$arr)){
                $errors[] = "upload valid image";

            }
    }else {
            $newName = "";
        }

        if(empty($errors)){
            
            $query  = "insert into posts(`title`,`body`,`image`,`user_id`)
                values('$title','$body','$newName',1)
            ";
            $result =  mysqli_query($conn , $query);

            if($result){
                if($_FILES&& $_FILES['image']['name']){
                    move_uploaded_file($tmp_name , "../uploads/$newName");
                }
                $_SESSION['success'] = "post added successfuly";
                header("location:../index.php");
            }else {
                $_SESSION['errors'] = ["error while add post"];
                header('location:../create-post.php');
            }
        }else{
            $_SESSION['errors'] = $errors;
            $_SESSION['title'] = $title;
            $_SESSION['body'] = $body;
            header('location:../create-post.php');
        }

}else {
    header('location:../index.php');
}