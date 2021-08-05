<?php
    /* This function handles the search of new content to rate */
    // header('Content-type: text/html; charset=utf-8');
    $email = $_SESSION["email"];    
    $userid = $_SESSION["userid"];
    
    include("dbc.php");
    
    $sql = "SELECT `counter` FROM `users` WHERE `email` = '".$email."'";
    $conn->query($sql);
    $result = $conn->query($sql); 
    while($row = $result->fetch_assoc()) {
                    $counter = $row["counter"];
    };
    if($counter < 100){
        $nextStep = 100;
        $level = 1;
    }elseif($counter >= 100 && $counter < 250){
        $nextStep = 250;
        $level = 2;
    }else{
        $nextStep = 500;
        $level = 3;
    }


    $sql = "SELECT `SignalID` FROM `signals` ORDER BY `ratedBy` ASC";
    $conn->query($sql);
    $result = $conn->query($sql); 
    $AllSignals = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($AllSignals, $row['SignalID']);
    }
    $sql = "SELECT `SignalID` FROM `ratings` WHERE  `userID` = '".$userid."'";
    $conn->query($sql);
    $result = $conn->query($sql); 
    $voted = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($voted, $row['SignalID']);
    }

    // echo(count(array_diff($AllSignals, $voted)));
    if(count(array_diff($AllSignals, $voted)) >= 0){
        $signalID = array_values(array_diff($AllSignals, $voted))[rand(0, sizeof(array_values(array_diff($AllSignals, $voted))))]; 
        $sql = "SELECT * FROM `".$signalID."`";
        $result = $conn->query($sql); 
        $wave1 = array();
        $wave2 = array();
        while($row = mysqli_fetch_assoc($result)){
            array_push($wave1, (float) $row['Wavelength1']);
            array_push($wave2, (float) $row['Wavelength2']);
        }
        $wave1 = json_encode($wave1);
        $wave2 = json_encode($wave2);
        
        echo '<div class="row mx-auto">';
        echo '<div class="mx-auto">';
        echo '<p style="text-align: center">Rating</p>';
        echo '<button type="button" id="reject" class="btn btn-danger mr-2" onclick="updateScore(\'reject\')">Reject</button>';
        echo '<button type="button" id="keepcorrection" class="btn btn-warning mr-2" onclick="updateScore(\'keepcorrection\')">Keep after corrections</button>';
        echo '<button type="button" id="keep" class="btn btn-success mr-2" onclick="updateScore(\'keep\')">Keep</button>';
        echo '</div>';
        echo '</div>';
        
        echo '<canvas class="my-4 w-100" id="myChart1" width="900" height="200" ></canvas>';

        echo '<canvas class="my-4 w-100" id="myChart2" width="900" height="200" ></canvas>';
        echo '<script>var data1 = '.$wave1.'</script>';
        echo '<script>var data2 = '.$wave2.'</script>';

        echo "<script>var signalID = '".$signalID."'</script>";
        
        echo '<div class="mb-4">';
        echo '<h2 style="float:right">'.$counter.'/'.$nextStep.' - Level '.$level.'</h2>';
        echo '</div>';
        

        
    }else{
        echo "You don't have any new content to rate.";
    }
    //chiamare updateScore2()
?>                      

