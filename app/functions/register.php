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
        $expertise = htmlspecialchars($_POST["expertise"]);
    
        include("dbc.php");

        // First, is there another user using the same email?
        $sql = "SELECT * FROM `users` WHERE `email` = '".$email."'"; //Query
        $result = $conn->query($sql); //this runs the query
        if (!$result) { // If this runs there's a problem with the query
            trigger_error('Invalid query: ' . $conn->error);
        }
        if ($result->num_rows > 0) { // to see wheter the email is already in use, we check if there are results matching the above query
            //Looks like the email is already in use. 
            echo "This email is already in use. Please <a href=''>Log In</a>"; // TODO: link to login
        } else {
            // No one is using that email. We can proceed!
            
            //Cooking the password 
            $salt = utf8_encode(random_bytes(16));
            $password = crypt($password, '$5$rounds=5000$'.$salt.'$');
            //$sql = ("set names 'utf8'");
            $conn->query($sql);
            $sql = "INSERT INTO `users`(`email`, `pwd`, `salt`, `expertise`) VALUES ('".$email."', '".$password."', '".$salt."', '".$expertise."')";
            // echo "<script>console.log(\" . $sql . \")</script>";
            
            if ($conn->query($sql) === TRUE) {
                echo 1;
            } else {
                //Something went wrong. 
                // $conn->error
                echo "An error has accoured. Please try again.";
            }   
        }
    }else{
        
        echo "You are not supposed to be here. EXTERMINATE!";
    }
    
        

    
?> 