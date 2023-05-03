// Get the study ID from the URL parameter
$study_id = $_GET['id'];

// Update the status of the study to "complete" in the database
$update_query = "UPDATE studies SET Status='complete' WHERE Id=$study_id";
mysqli_query($con, $update_query);

// Redirect the user to the existing studies page
header('Location: existing-studies.php');
