<?php
    // config.php should contain your database connection details
    include("config.php");

    $study_id = $_GET['study_id'];
    $query = mysqli_query($con,"SELECT * FROM participants WHERE Study_id=$study_id");
                                
    // Loop through participants data and write to CSV
    $delimiter = ",";
    $filename = "participants.csv";

    $f = fopen('php://memory', 'w');
    $fields = array('Name', 'Age', 'Gender', 'Image', 'X position', 'Y position', 'Timestamp');
    fputcsv($f, $fields, $delimiter);

    while($result = mysqli_fetch_assoc($query)) {

        $data = json_decode($result['Eye_data'], true);

        foreach ($data as $position) {
            
            $lineData = array($result['Name'], $result['Age'], $result['Gender'], $position['imgNum'], $position['x'], $position['y'], $position['timestamp']);
            fputcsv($f, $lineData, $delimiter);
        }

    }

    fseek($f, 0);

    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    fpassthru($f);

    exit;
    //mysqli_query($con, "INSERT INTO participants(Study_id, Name, Age, Gender) VALUES('113', 'Teste', '20, 'Male')") or die("Error Occured");
?>