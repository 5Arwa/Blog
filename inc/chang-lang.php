<?php
session_start();

if(isset($_GET['lang'])){
    if($_GET['lang']=="en"){
        $_SESSION['lang']='en';
    }else{
         $_SESSION['lang']='ar';
    }
}else{
     $_SESSION['lang']="en";

}

header("location:".$_SERVER['HTTP_REFERER']);