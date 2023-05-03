<?php

    session_start();
    include("config.php");

    $data = json_decode(file_get_contents("php://input"), true);
    $eye_data = json_encode($data);
    $study_id = urldecode($_GET['id']);

    $participant_name = $_SESSION['participant_name'];
    $participant_age = $_SESSION['participant_age'];
    $participant_gender = $_SESSION['participant_gender'];


    mysqli_query($con, "INSERT INTO participants(Study_id, Name, Age, Gender, Eye_data) VALUES('$study_id', '$participant_name', '$participant_age', '$participant_gender', '$eye_data')") or die("Error Occured");
   // $query = "INSERT INTO participants (Eye_data) VALUES ()"
   // $query = "UPDATE participants SET Eye_data = '".json_encode($data)."' WHERE Id=$participant_id";

    /*
    foreach ($data as $position) {
        $x = $position['x'];
        $y = $position['y'];
        $timestamp = $position['timestamp'];
        $imgNum = $position['imgNum'];
        $participant_id = $_SESSION['participant_id'];
        
        //$query = "INSERT INTO participants (Study_id, Name, Age, Gender) VALUES ('48', 'Testee', '70', 'Male')";
       $query = "INSERT INTO eye_data (Participant_id, Img_number, X_position, Y_position, Timestamp) VALUES ('$participant_id', '$imgNum', '$x', '$y', '$timestamp')";
       mysqli_query($con, $query);
    } */
?>