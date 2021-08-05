<?php
    /* This function handles ther registration of a new user */
    header('Content-type: text/html; charset=utf-8');
    session_start();

    // For Debug purposes, we can print the version in use:
    // echo phpversion();
    
    
    if(isset($_POST['email']) ){
        //We can get the variables from the post method
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST["password"]);
    
        include("dbc.php");

        // First, is there another user using the same email?
        $sql = "SELECT * FROM `users` WHERE `email` = '".$email."'"; //Query
        $result = $conn->query($sql); //this runs the query
        if (!$result) { // If this runs there's a problem with the query
            trigger_error('Invalid query: ' . $conn->error);
        }
        if ($result->num_rows == 1) { // to see wheter the email is already in use, we check if there are results matching the above query
            //Looks like the email is already in use. 
            while($row = $result->fetch_assoc()) {
                $salt = $row["salt"];
                $password = crypt($password, '$5$rounds=5000$'.$salt.'$');
                if(utf8_encode($password) == utf8_encode($row['pwd'])){
                    $_SESSION["email"] = $email;
                    $_SESSION["userid"] = $row['ID'];
                    $_SESSION['role'] = $row['role'];
                    echo 1;
                    exit();
                }else{
                    echo 'Wrong Username or Password';
                }
            }
            
        } else {
            // No one is using that email!
            echo "The email address you provided is not associated to an account on our platform.";
        }
    }else{
        echo "You are not supposed to be here. EXTERMINATE!";
    }
?> 