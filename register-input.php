<?php
// this is not include from fwd 
    require("config.php");
        
    $email = $_POST["userEmail"];
    $name = $_POST["userName"];
    $password = $_POST["userPass"];

    if($email == true && $name == true && $password == true ){
            $sql = $pdo->prepare("SELECT count(email) AS num FROM users WHERE email=:email");
            $sql ->bindValue(":email",$email);
        //   $sql->bindParam(":email",$email,PDO::PARAM_STR);
            $sql->execute();

            $row = $sql->fetch(PDO::FETCH_ASSOC);

            if($row["num"] > 0 ){
                echo "<script> alert('This User email already exists')</script>";
                header("Location:register.php");
            }else{
                $passHash = password_hash($password,PASSWORD_BCRYPT);

                $query = $pdo->prepare("INSERT INTO users(name,email,password) VALUES(:name,:email,:password)");
                $query->bindValue(":name",$name);
                $query->bindValue(":email",$email);
                $query->bindValue(":password",$passHash);
            //  $query->execute();

                if($query->execute()){
                    echo " Registeration is Successful";
                }else{
                    echo " not successful";
                }
            } 

    }else {
        echo " Fill ";
    
    }

 ?>