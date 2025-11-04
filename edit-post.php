<?php require('inc/header.php'); ?>
<?php require('inc/navbar.php'); ?>
<?php require('inc/connection.php'); ?>

<?php
if(! isset($_SESSION['user_id'])){
    header("location:login.php");

}
if(isset($_GET['id'])){
    $id=$_GET['id'];

    $query = "SELECT * from posts where id=$id";
    $result=mysqli_query($conn,$query);

    if(mysqli_num_rows($result)==1){
  $post = mysqli_fetch_assoc($result);
    }else{
    $_SESSION['errors']="no data founded";
    header("location:index.php");

    }
}else{

    header("location:index.php");
}
    session_abort();

?>


<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3><?php echo $message['Edit post']?></h3>
                </div>
                <div>
                    <a href="index.php" class="text-decoration-none"><?php echo $message['Back']?></a>
                </div>
          
            </div>
           
            <?php require_once 'inc/errors.php' ?>


            <form method="POST" action="handle/update-post.php?id=<?php echo $id?>" enctype="multipart/form-data">
    
                <div class="mb-3">
                    <label for="title" class="form-label"><?php echo $message['title']?></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title']?>">
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label"><?php echo $message['body']?></label>
                    <textarea class="form-control" id="body" name="body" rows="5"><?php echo $post['body']?></textarea>
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label"><?php echo $message['image']?></label>
                    <input type="file" class="form-control-file" id="image" name="image" >
                </div>
                 <div class="m-3">
                    <img src="uploads/<?php echo $post['image']?>" alt="" width="100px">
                 </div>                
                <button type="submit" class="btn btn-primary" name="submit"><?php echo $message['update']?></button>
            </form>
        </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>