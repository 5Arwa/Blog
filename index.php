<?php require_once('inc/header.php'); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/navbar.php'); ?>
<?php require_once('inc/functions.php'); ?>

<?php

if(! isset($_SESSION['user_id'])){
    header("location:login.php");

}
 if(isset($_GET['page'])){
        $page =(int) $_GET['page'];
    }else{
        $page = 1;
    }

    $limit = 2;
    $offset = ($page-1)*$limit;

    // echo $page , $limit , $offset;
    $query  =" select count(`id`) as total from posts  ";
     $countResult =   mysqli_query($conn , $query);

     if(mysqli_num_rows($countResult)==1){
       $post = mysqli_fetch_assoc($countResult);
       $count = $post['total'];
     }
    $numberOfPages = ceil($count /$limit); 
     if(! test($page,$numberOfPages)){
        header("location:".$_SERVER['PHP_SELF']."?page=1");
     }

$query="SELECT id, title , created_at from posts limit $limit offset $offset";
$result=mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
$posts=mysqli_fetch_all($result,MYSQLI_ASSOC);

}else{
    echo 'no data founded';
}
?>
<?php if(! empty($_SESSION['success'])):?>
    <div class="alert alert-success">
        <?php  echo $_SESSION['success'];?>
    </div>
<?php endif;
   unset($_SESSION['success']);
?>

<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3> <?php echo $message['All posts']?></h3>
                </div>
                <div>
                    <a href="create-post.php" class="btn btn-sm btn-success"><?php echo $message['add new post']?></a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><?php echo $message['title']?></th>
                        <th scope="col"><?php echo $message['Published At']?></th>
                        <th scope="col"><?php echo $message['Actions']?></th>
                    </tr>
                </thead>
                <tbody>

                 <?php  foreach($posts as $post):?>

                    <tr>
                        <td><?php echo $post['title']?></td>
                        <td><?php echo $post['created_at']?></td>
                        <td>
                            <a href="show-post.php?id=<?php echo $post['id']?>" class="btn btn-sm btn-primary"><?php echo $message['show']?></a>
                            <a href="edit-post.php?id=<?php echo $post['id']?>" class="btn btn-sm btn-secondary"><?php echo $message['edit']?></a>
                            <a href="handle/delete-post.php?id=<?php echo $post['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('do you really want to delete post?')"><?php echo $message['delete']?></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="d-flex justify-content-center">
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item <?php if($page==1) echo "disabled" ?> ">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page-1 ?>" tabindex="-1" aria-disabled="true"><?php echo $message['Previous']?></a>
    </li>
    <li class="page-item">
        <a class="page-link" href="#">
            <?php 
      if($_SESSION['lang'] == 'ar'){
          echo $message['page'] . ' ' . $page . ' ' . $message['page_of'] . ' ' . $numberOfPages;
      }else{
          echo $message['page'] . ' ' . $page . ' ' . $message['page_of'] . ' ' . $numberOfPages;
      }
    ?>
        
    </a>
    </li>
    <li class="page-item  <?php if($page==$numberOfPages) echo "disabled" ?>">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page+1 ?>"><?php echo $message['Next']?></a>
    </li>
  </ul>
</nav>
</div>
<?php require('inc/footer.php'); ?> 
                 