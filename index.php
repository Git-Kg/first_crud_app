<?php 
    session_start();
    require("config.php");

    if(empty($_SESSION['user_id'] )|| empty($_SESSION['logged_in'])){
        echo "<script> alert('Please Login to Continue !')
             window.location.href='login.php';
             </script>";
    }
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
   <link rel="stylesheet" href= "bootstrap/style.css">
</head>
<body>

    <?php 

        $sql=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC ");  
        $sql->execute();  
        $result=$sql->fetchALL(PDO::FETCH_ASSOC);

    ?>
   
    <div class="container">
        <div class="row">
          <div class="col-1"> </div>

          <div class="col mt-30">

          <div class="row justify-content-between mr-ml-0">
            
             <a href="post-add.php" class="btn btn-success">Add Post</a>
             <h2> Post Management </h2>
             <a href="logout.php" class="btn btn-primary">Logout</a>
              
          </div>
         
         <div class="tb mt-30 table-responsive">
            <table class="table table-striped">

                <thead class="table-info ">
                    <tr >
                        <th scope="col">No</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col"> Created At</th>
                        <th scope="col"> Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                if($result){
                        $count=0;
                    foreach($result as $show){     
                        $count+=1; ?>                  
                     <tr >
                        <td> <?php echo $count ?> </td>
                        <td> <img width=100px; src="images/<?php echo $show['image']?>" >  </td>                        
                        <td> <?php echo $show['title'] ?> </td>
                        <td> <?php echo $show['description'] ?> </td>
                        <td> <?php echo date('d-m-Y',strtotime($show['created_at'])) ?> </td>
                        <td> 
                            <a href="edit.php?id=<?php echo $show['id'] ?>" class="btn btn-success">Edit</a>
                            <a href="delete.php?id=<?php echo $show['id'] ?>" class="btn btn-danger">Delete</a>
                       </td>
                    </tr>
                <?php
               
                    }
                }
            ?>
            </tbody>

          </table>

        </div>
          
         </div>

          <div class="col-1"> </div>
        </div>
    </div>
</body>
</html>