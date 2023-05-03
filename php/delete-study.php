<?php
    session_start();
    include("config.php");

    if(!isset($_SESSION['valid'])) {
        header("Location: index.php");
        exit();
    }

    if(isset($_POST['study_id'])) {

        $study_id = $_POST['study_id'];

        if(isset($_POST['delete-btn'])) {
            
            mysqli_query($con, "DELETE FROM studies WHERE Id='$study_id'");

        } else if(isset($_POST['update-btn'])) {

            $update_query = "UPDATE studies SET Status='complete' WHERE Id=$study_id";
            mysqli_query($con, $update_query) or die("Update Error");
        }

        header("Location: ../existing-studies.php");
        exit();
    }
?>
