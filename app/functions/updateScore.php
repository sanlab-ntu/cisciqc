<?php
    session_start();
    include("dbc.php");

    $email = $_SESSION['email'];
    $userid = $_SESSION['userid'];
    $fileid = $_REQUEST['fileID'];
    $score = $_REQUEST['score'];
    $rt = $_REQUEST['rt'];

    $sql = 'UPDATE `signals` SET `ratedBy` = `ratedBy` + 1 WHERE `SignalID`="'.$fileid.'"';
    if($conn->query($sql) === TRUE){   
        $sql = 'INSERT INTO `ratings` (`SignalID`, `userID`, `score`,`rt`) VALUES ("'.$fileid.'","'.$userid.'","'.$score.'","'.$rt.'")'; 
        if($conn->query($sql) === TRUE){
            $sql = "UPDATE `users` SET `counter` = `counter` + 1 WHERE `email` = '".$email."'";
                if($conn->query($sql) === TRUE){   
                    echo 1;
                }else{
                    echo "'An error has occured in updating your number of ratings (ErrorCode UP003)";
                    echo 0;
                }
        }else{
            echo $sql."</br>";
            echo "There was an error uploading the score (ErrorCode UP001)";
            echo 0;
        }
    }else{
        echo "There was an error uploading the score (ErrorCode UP002)";
        echo 0;
    }
    
?>