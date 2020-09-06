<?php 
   session_start();
   require('config.php');

   if(empty($_SESSION['user_id'] )|| empty($_SESSION['logged_in'])){
      echo "<script> alert('Please Login to Continue !')
           window.location.href='login.php';
           </script>";
      }else{ // login session start
         
         if(!empty($_POST)){ //!empty start 
           
            $title=$_POST['title'];
            $description=$_POST['description'];
            $id=$_GET['id'];

            
            $image=$_FILES['image']['name'];
            $type=$_FILES['image']['tmp_name'];
            $ext=pathinfo($image,PATHINFO_EXTENSION);
            $valid=array("png","jpg","jpeg");
            $uniFile=uniqid().".".$ext;
            
            if($image){
                  
                if(in_array($ext,$valid)){    //find extension or upload extension 
        
                    move_uploaded_file($type,"images/$uniFile") ; 
                                                        
                    $sql=$pdo->prepare("UPDATE posts SET image=:image,title=:title, description=:description WHERE id=:id");
                    $sql->bindParam(':image',$uniFile,PDO::PARAM_STR);
                    $sql->bindParam(':title',$title,PDO::PARAM_STR);
                    $sql->bindParam(':description',$description,PDO::PARAM_STR);
                    $sql->bindParam(':id',$id,PDO::PARAM_INT);
                    $update=$sql->execute();

                    if($update){
                        echo "<script> alert('New Post Edit is Successful Added'); 
                            window.location.href='index.php';
                            </script>";
                        }
                } else{
                echo "<script> alert('Invalid File extension. Must be jpg,png or jpeg') </script> ";
               } 
               
            }else{
                $sql=$pdo->prepare("UPDATE posts SET title=:title, description=:description WHERE id=:id");
                $sql->bindParam(':title',$title,PDO::PARAM_STR);
                $sql->bindParam(':description',$description,PDO::PARAM_STR);
                $sql->bindParam(':id',$id,PDO::PARAM_INT);
                $update= $sql->execute();
            
                    if($update){
                        echo "<script> alert('Update Post is Successful Updated'); 
                        window.location.href='index.php';
                        </script>";
                    }
            }

           
         }  // !empty end
       
      }     // login session end

     
      
?>


<!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Post Edit</title>
     <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
     <link rel="stylesheet" href= "bootstrap/style.css">
 </head>
 <body>

   <?php

         $id=(int)htmlspecialchars(stripslashes(trim($_GET['id'])));

         $sql=$pdo->prepare("SELECT * FROM posts WHERE id=:id");
         $sql->bindParam(':id',$id,PDO::PARAM_INT);

         $sql->execute();

         $result=$sql->fetchAll(PDO::FETCH_ASSOC);

   ?>

    <div class="container ">
         <div class="row ">

            <div class="col-3"></div>

            <div class="col bgc">
               <h2 > Edit Posts </h2>

               <form action=" " method="POST" enctype="multipart/form-data">

                  <div class="form-group">
                     <label for="title"> Title </label>
                     <input  class="form-control bor" type="text" name="title" value="<?php echo $result[0]['title'] ?>" >
                  </div>

                  <div class="form-group ">
                     <label for="description"> Description </label>
                     <textarea name="description" class="form-control " rows="6"> <?php echo $result[0]['description'] ?></textarea>
                  </div>

                  
                  <div class="form-group">
                     <label for = "iamge">Image </image>
                     <img width=100px; heignt=100px; src="images/<?php echo $result[0]['image'] ?> ">
                     <input type="file" name="image" > 
                  </div>

                     <button  class="btn btn-success bor" type="submit"> Update Post </button>
                     <button class="btn btn-danger bor"> <a href="index.php">Back</a> </button>

               </form>
                    
            </div>

            <div class="col-3"></div>
         </div>
      </div>
 </body>
 </html>



 