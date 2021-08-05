<?php
    session_start();
    // https://www.cloudways.com/blog/import-export-csv-using-php-and-mysql/
    include("functions/dbc.php");

    // Check if image file is a actual image or fake image
    if(isset($_FILES["fileToUpload"]["name"])) {
        $target_dir = "../Data/Signals/"; //Target directory or where to upload the signal
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); #get the name of the file to upload
        
        $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
        if(in_array($_FILES['fileToUpload']['type'],$mimes)){
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $feedback = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
              
                $sql = "CREATE TABLE `".basename( $_FILES['fileToUpload']['name'])."` (Wavelength1 FLOAT, Wavelength2 FLOAT)";
                echo $sql;
                if ($conn->query($sql) === TRUE) {
                    
                    $sql = "LOAD DATA LOCAL INFILE '". basename($_FILES['fileToUpload']['tmp_name'])."' INTO TABLE `".basename( $_FILES['fileToUpload']['name'])."` FIELDS TERMINATED BY ','"; 

                    if ($conn->query($sql) === TRUE) {
                        $sql = "INSERT INTO `signals`(`SignalID`) VALUES ('".basename( $_FILES['fileToUpload']['name'])."')";
                        echo $sql;
                        if ($conn->query($sql) === TRUE) {
                            $feedbackcode = 1;
                            echo ('alert("DB")');
                        }else{
                            $feedback = "Sorry, there was an error uploading your file. (Error code U003)";
                            $feedbackcode = 0;
                        }
                    }else{
                        echo mysqli_query($conn);
                        $feedback = "Sorry, there was an error uploading your file. (Error code U002 - Can't import CSV)";
                        echo $sql;
                        $feedbackcode = 0;
                    }   
                }else{
                    $feedback = "Sorry, there was an error uploading your file.(Error code U004)";
                    $feedbackcode = 0;
                }

            } else {
                $feedback = "Sorry, there was an error uploading your file. (Error C0de U001 - Can't upload file)";
                echo $target_file;
                $feedbackcode = 0;
            }
        } else {
          $feedbackcode = 0;
          $feedback = ("Sorry, the file you are trying to upload is in a wrong format. Please upload a csv file.");
        }
        
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>fNIRS Quality Control</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/dashboard/">

    <!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">fNIRS QC</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="functions/logout.php">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
              <span data-feather="star"></span>
              Rate
            </a>
          </li>     
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <span data-feather="layers"></span>
              Upload Data <span class="sr-only">(current)</span>
            </a>
          </li>
        </ul>

      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <? 
        if(isset($feedbackcode)){
            if($feedbackcode == 0){
                echo '<br><div class="alert alert-danger"><strong>Error!</strong>'.$feedback.'.</div>';
            }elseif($feedbackcode == 1){
                echo '<br><div class="alert alert-success"><strong>Success!</strong>'.$feedback.'.</div>';
            }
        }
        
        ?>
       
        
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload a Signal</h1>
      </div>
        
     <!-- <form class="form-signin" id='uploadForm' method="post" enctype="multipart/form-data"  action="functions/uploadSignal.php"> -->
     <form class="form-signin" id='uploadForm' method="post" enctype="multipart/form-data" action="uploadPage.php">
        <div class="form-group">
        <label for="fileToUpload">Example file input</label>
        <input type="file" class="form-control-file" id="fileToUpload" name="fileToUpload" >
       </div>
      <div class="checkbox mb-3 mt-2">
        <label>
          <input type="checkbox" value="agreeEULA" id='legalStuff'> I confirm I have the right to upload the data <a href='#'>bla bla bla</a>
        </label>
      </div>
      <button class="col-md-5 btn btn-primary btn-block" type='submit'>upload</button>
    </form>
    


    </main>
  </div>
</div>
    <script src="../js/jquery-3.3.1.slim.min.js" ></script>
    <script>window.jQuery || document.write('<script src="../js/jquery-slim.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="../js/dashboard.js"></script>

    </body>

</html>
