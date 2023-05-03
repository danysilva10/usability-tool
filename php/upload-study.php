<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Uploaded</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/form.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/bd6b28b390.js" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php
                session_start();

                include("config.php");
                if(!isset($_SESSION['valid'])){
                 header("Location: index.php");
                }
                if(isset($_POST['submit'])){
                    
                    $user_id = $_SESSION['id'];
                    $title = $_POST['title'];
                    $instructions = htmlspecialchars($_POST['instructions'], ENT_QUOTES);
                    $screens = json_decode($_POST['selectedOptionsInput']);
                    $currentDate = date("Y-m-d");
                    $status = "on going";
                    
                    do {
                        $code = substr(uniqid(), -6);
                        $result = mysqli_query($con, "SELECT * FROM studies WHERE Code='$code'");
                    } while (mysqli_num_rows($result) > 0);
                    
                    mysqli_query($con, "INSERT INTO studies(Title, Instructions, User_id, CurrentDate, Code, Status) VALUES('$title', '$instructions', '$user_id', '$currentDate', '$code', '$status')") or die("Error Occured");
                    
                    $study_id = mysqli_insert_id($con);
                    
                    for ($i = 0; $i < count($screens); $i++) {
                        
                        $screen_time = $_POST['screenTime-'.($i+1)];
                        $screen_order = $screens[$i]->id;
                        $screen_type = $screens[$i]->selection;

                        mysqli_query($con, "INSERT INTO screens(Study_id, Screen_order, Screen_type, Screen_time) VALUES('$study_id', '$screen_order', '$screen_type', '$screen_time')") or die("Error Occured");
                        $screen_id = mysqli_insert_id($con);

                        if($screen_type === 'Text') {
                            $screen_text = htmlspecialchars($_POST['textInput-'.($i+1)], ENT_QUOTES);
                            
                            mysqli_query($con, "INSERT INTO screen_contents(Screen_id, Screen_text) VALUES('$screen_id', '$screen_text')") or die("Error Occured");
                            
                        } else if ($screen_type === 'Image') {

                            $img_name = $_FILES['imageInput-'.($i+1)]['name'];
                            $img_size = $_FILES['imageInput-'.($i+1)]['size'];
                            $tmp_name = $_FILES['imageInput-'.($i+1)]['tmp_name'];
                            $error = $_FILES['imageInput-'.($i+1)]['error'];

                            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                            $img_ex_lc = strtolower($img_ex);

                            $allowed_exs = array("jpg", "jpeg", "png");

                            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                            $img_upload_path = 'uploads/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
            
                            mysqli_query($con, "INSERT INTO screen_contents(Screen_id, Screen_image) VALUES('$screen_id', '$new_img_name')") or die("Error Occured");
                            
                        }
                    }
                    echo "<div class='message'>
                                <p>Study successfully created!</p>
                                <p>This is your study code: <b>$code</b></p>
                            </div> <br>";
                    echo  "<a href='../home.php'><button class='btn'>Home</button> ";
                }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>

</body>
</html>

