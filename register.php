
    <?php 
    require("config.php");

    if(!empty($_POST)){
        $name = $_POST['userName'];
        $email = $_POST["userEmail"];
        $password = $_POST["userPass"];

        if($name == '' || $email == '' || $password == ''){
            echo "<script>alert('! Please Fill The Form data.') </script>";
        }else{
            // 1.query prepare
            $sql = $pdo->prepare("SELECT count(email) AS num FROM users WHERE email=:email");
            // 2.bind statement
              $sql->bindValue("email",$email);
          //  $sql->bindParam(":email",$email,PDO::PARAM_STR);
            // 3. execute statement 
            $sql->execute();

            // database ထဲကနေ associated array နဲ့ တစ်ကြောင်းချင်းပြန်ဆွဲထုတ်တာ
            $row= $sql->fetch(PDO::FETCH_ASSOC);  

            if($row["num"] > 0 ){
              echo "<script>alert('This User email Already exists .') </script>";
            }else{
               
                $passHash = password_hash($password,PASSWORD_BCRYPT);

                $sql=$pdo->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)");
                $sql->bindValue(":name",$name);
                $sql->bindValue(":email",$email);
                $sql->bindValue(":password",$passHash);
                
                $result=$sql->execute();

                if($result){
                    echo " <script>
                        alert('Registeration is Successful') ;
                        window.location.href='login.php';
                       </script> ";                   
               }
                 
            }
        }

    }

  ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Register Page </title>
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href= "bootstrap/style.css">
    </head>
    <body>
       <div class="container ">
           <div class="row ">
                <div class="col-3"></div>
                <div class="col bgc">
                    <h2 >Register</h2>

                    <form action="register.php" method="POST">

                        <div class="form-group">
                            <label for="userName"> Name </label>
                            <input  class="form-control bor" type="text" name="userName"   placeholder="Enter name" >
                        </div>

                        <div class="form-group ">
                            <label for="userEmail">Email address</label>
                                <input  class="form-control bor" type="email" name="userEmail"   placeholder="Enter email" >
                        </div>

                        <div class="form-group">
                            <label for="userPass">Password</label>
                            <input class="form-control bor" type="password"  name= "userPass"  placeholder="Password"   >
                        </div>

                        <input type="submit" class="btn btn-primary bor" name="" value="Register">
                         <button class="btn btn-success bor"> <a href="login.php">Login</a> </button>

                 </form>
                    
                </div>

                <div class="col-3"></div>
           </div>
       </div>
    </body>
    </html>


 