<?php 
    session_start();
    require("config.php");

    if(empty($_SESSION['user_id'] ) || empty($_SESSION['logged_in'])){
        echo "<script> alert('Please Login to Continue !')
             window.location.href='login.php';
             </script>";
    }else{
       
        if(!empty($_POST)){
          
            $title=$_POST['title'];
            $description=$_POST['description'];

            $image=$_FILES['image']['name'];
            $type=$_FILES['image']['tmp_name'];
            $ext=pathinfo($image,PATHINFO_EXTENSION);
            $valid=array("png","jpg","jpeg");
            $uniFile=uniqid().".".$ext;

            if(in_array($ext,$valid)){    //find extension or upload extension 
        
                move_uploaded_file($type,"images/$uniFile") ; 
                                                    
                $sql=$pdo->prepare("INSERT INTO posts (image,title,description) VALUES (:image,:title,:description)");
                $sql->bindValue(":image",$uniFile);
                $sql->bindValue(":title",$title);
                $sql->bindValue(":description",$description);
                $result=$sql->execute();
            
                if($result){
                    echo "<script> alert('New Post is Successful Added'); 
                        window.location.href='index.php';
                        </script>";
                    }
            } else{
            echo "<script> alert('Invalid File extension. Must be jpg,png or jpeg') </script> ";
           } 
        } 
    }

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Post Add</title>
     <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
     <link rel="stylesheet" href= "bootstrap/style.css">
 </head>
 <body>
 <div class="container ">
           <div class="row ">
                <div class="col-3"></div>
                <div class="col bgc">
                    <h2 > Add New Record </h2>

                    <form action="post-add.php" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="title"> Title </label>
                            <input  class="form-control bor" type="text" name="title"  >
                        </div>

                        <div class="form-group ">
                            <label for="description"> Description </label>
                            <textarea name="description" class="form-control " rows="6"> </textarea>
                        </div>

                        <div class="form-group">
                            <label for = "iamge">Image </image>
                            <input type="file" name="image" > 
                        </div>

                         <button  class="btn btn-success bor" type="submit"> Add Post </button>
                         <button class="btn btn-danger bor"> <a href="index.php">Back</a> </button>


                 </form>
                    
                </div>

                <div class="col-3"></div>
           </div>
       </div>
 </body>
 </html>