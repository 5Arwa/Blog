<!DOCTYPE html>
<?php
session_start();

require_once 'connection.php';

if(isset($_SESSION['lang'])){
    $lang=$_SESSION['lang'];
}else{
    $lang="en";
}
if($lang == 'en'){
    require_once 'inc/message-en.php';

}else{
    require_once 'inc/message-ar.php';

}




?>
<html lang="<?php echo $lang; ?>" dir="<?php echo $message['dir']; ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>