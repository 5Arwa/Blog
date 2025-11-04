<?php
// connection - submit - filter - validation (input -image(oldname))
// empty -->update (if image -->move(unlike ))

require_once '../inc/connection.php';

if(isset($_POST['submit'])){
    if(isset($_GET['id'])){
       $id = $_GET['id'];


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
    
       $query = "SELECT image from posts where id=$id";
       $result=mysqli_query($conn,$query);
         if(mysqli_num_rows($result)==1){
            $post=mysqli_fetch_assoc($result);
            $oldImage=$post['image'];
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
                $newName = $oldImage; //oldname 
            }

            if(empty($errors)){
               $query="UPDATE posts set `title`='$title',`body`='$body' , `image`='$newName' where id=$id";
               $result = mysqli_query($conn,$query);
                if($result){
                   if($_FILES && $_FILES['image']['name']){
                    move_uploaded_file($tmp_name,"../uploads/$newName");
                    unlink("../uploads/$oldImage");
                     }


                   $_SESSION['success']="post updated successfully";
                   header("location:../show-post.php?id=$id");


                }else{
                    $_SESSION['errors']=['error while update'];
                    header("location:../edit-post.php?id=$id"); 
                }  



            }else{
                 $_SESSION['errors']=$errors;
                 header("location:../edit-post.php?id=$id");
            }



        }else{
                header("location:../index.php");
             }

}else{
    header("location:../index.php");
}