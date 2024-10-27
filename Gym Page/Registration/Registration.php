<?php 
    session_start();
    ?>
   <?php if (isset($_SESSION["logged"])) {
    echo "Hello ".$_SESSION["username"];
}  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

        .formparent, .error {text-align: center;}

        form {display: inline-block;
            position: relative;
            top: 170px;   
            background-image: url(background-form.jpg);
            border: 4px solid black;
            padding: 20px;}

        body {background: url(background.jpg) no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;}

        .error form {top: 190px;}

        span {color: #c20000;}

    </style>
</head>
<body>

    <div class="formparent">
    <form method="post" >
        
        <br>
        <strong>Name</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="name" autofocus>
        <br><br>
        <strong>Surname</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="surname" >
        <br><br>
        <strong>Username</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="username">
        <br><br>
        <strong>Password</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="password" name="password" >
        <br><br>
        <strong>Re-Password</strong>&nbsp;&nbsp;&nbsp;
        <input type="password" name="repassword">
        <br><br>
        <strong>Email</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="email" name="email">
        <br><br>
        <strong>City</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="city">
        <br><br>
        <strong>Terms of service</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="terms">
        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="submit" value="Submit">
       
    </form>
    </div>

</body>
</html> 

<?php

if (isset($_POST["submit"]) ){
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    $email = $_POST["email"];
    $city = $_POST["city"];


    if (empty($username) || empty($password) || empty($repassword) || empty($email) || empty($_POST["terms"]) ) {
        echo "
        <div class='error'>
            <form>
            <span>Fields marked with * are required <br></span> ";
    } else if ( $password != $repassword) {
        echo "
        <div class='error'>
            <form>
            <span>Confirm Password is NOT agreeded with Password <br></span>";
    } else {

        require "database.php";

        $conn = getDB();

   

        $sql = "SELECT username FROM gym_members WHERE username='$username' or email='$email' ";  

        $results = mysqli_query($conn, $sql);

        if ($results === false) {
            echo " mysqli_error($conn) ";
        } else {
            $user = mysqli_fetch_assoc($results);
        }

        if ($user) {
            echo "
            <div class='error'>
                <form>
                    <span>This Username or Email is alredy existed</span>
                </form>
            </div>";
        } else {

            $sql = "INSERT INTO gym_members (name, surname, username, password, email, city) VALUES('$name', '$surname', '$username', '$password', '$email', '$city'  ) ";     
        
            $results = mysqli_query($conn,$sql);

            
            if ($results) 
            {
                echo "
                <div class='error'>
                    <form>
                    Your registration was Successful !
                    </form>
                </div>
                "; 
            } 
            else {
                echo "<br> Error: $sql <br> mysqli_error($conn)
                    </form>
                </div>
                "; 
            }
        }
    }
}


?>