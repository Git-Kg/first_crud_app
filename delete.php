<?php 
    session_start();
    require('config.php');

    if(empty($_SESSION['user_id'] )|| empty($_SESSION['logged_in'])){
        echo "<script> alert('Please Login to Continue !')
             window.location.href='login.php';
             </script>";        
     }else{
       //  $id=$_GET['id'];
         $id=(int)htmlspecialchars(stripslashes(trim($_GET['id'])));
         $sql=$pdo->prepare("DELETE FROM posts WHERE id=:id");
         $sql->bindParam(':id',$id,PDO::PARAM_INT);
         $result=$sql->execute();
          
         header('Location:index.php');

     }
?>