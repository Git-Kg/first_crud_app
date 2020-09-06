<?php 
        session_start();
        require("config.php");

        if(!empty($_POST)){
            $email = $_POST['userEmail'];
            $password = $_POST['userPass'];

            $sql=$pdo->prepare("SELECT * FROM users WHERE email=:email");
            $sql->bindValue(":email",$email);
            $sql->execute();

            $user=$sql->fetch(PDO::FETCH_ASSOC);
           
            if(empty($user)){
                echo" <script> alert('Incorrect Credentials, Please Try Again ')</script>";
            }else{
               // password တိုက်စစ်တာ password_verify(ရိုက်လိုက်တဲ့ pass, dbase ထဲက pass);
               $validPass = password_verify($password,$user["password"]); 
               
                if($validPass){
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['logged_in'] = time();
                    header("Location:index.php"); 
                    exit(); 
               }else{
                echo" <script> alert(' Please Try Again ')</script>";
               } 

           }
           
        }
    
    ?>


 <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Login Page </title>
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href= "bootstrap/style.css">
    </head>
    <body>
       <div class="container ">
           <div class="row ">
                <div class="col-3"></div>
                <div class="col bgc">
                    <h2 >Login</h2>

                    <form action="login.php" method="POST">

                        <div class="form-group ">
                            <label for="userEmail">Email address</label>
                                <input  class="form-control bor" type="email" name="userEmail"   placeholder="Enter email" >
                        </div>

                        <div class="form-group">
                            <label for="userPass">Password</label>
                            <input class="form-control bor" type="password"  name= "userPass"  placeholder="Password"   >
                        </div>

                        <input type="submit" class="btn btn-primary bor" name="" value="Login">
                      
                       <a href="register.php" class="btn btn-success bor">Register</a>
                 </form>

                </div>

                <div class="col-3"></div>
           </div>
       </div>
    </body>
    </html>


  