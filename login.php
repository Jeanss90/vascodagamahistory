<?php 

session_start(); 

include "database_users.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){

       $data = trim($data);

       $data = stripslashes($data);

       $data = htmlspecialchars($data);

       return $data;

    }

    $uname = validate($_POST['uname']);

    $pass = validate($_POST['password']);

    if (empty($uname) && empty($pass)) {
        
        header("Location: dev.php?error=Username and Password required!");
        
        exit();
    
    } else if (empty($uname)) {

        header("Location: dev.php?error=Username is required!");

        exit();

    }else if(empty($pass)){

        header("Location: dev.php?error=Password is required!");

        exit();

    }else{

        $sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['user_name'] === $uname && $row['password'] === $pass) {

                echo "Logged in!";

                $_SESSION['user_name'] = $row['user_name'];

                $_SESSION['name'] = $row['name'];

                $_SESSION['id'] = $row['id'];

                $_SESSION['start'] = time();

                $_SESSION['expire'] = $_SESSION['start'] + (120 * 60);

                header("Location: dev-options.php");

                exit();

            }else{

                header("Location: dev.php?error=Incorrect Username or Password!");

                exit();

            }

        }else{

            header("Location: dev.php?error=Incorrect Username or Password!");

            exit();

        }

    }

}else{

    header("Location: dev.php");

    exit();

}

