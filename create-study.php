<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Study</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/create-study.css">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/bd6b28b390.js" crossorigin="anonymous"></script>
</head>
<body>
        <div class="nav">
            <?php 
                
                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_id = $result['Id'];
                }
            ?>

            <div class="row user-name">
                <p><b>Welcome, <?php echo $res_Uname?></b></p>
            </div>
            <div clas="row middle-links">
                <div class="middle-titles d-grid gap-2 d-flex justify-content-md-center">
                    <a href="home.php">Home</a>
                    <a class="current-link" href="create-study.php">New Study</a>
                    <a href="existing-studies.php">Previous Studies</a>
                </div>
                
            </div>
            <div class="right-links">
                <a href="php/logout.php"> <button class="btnLogOut">Log Out</button> </a> 
            </div>
        </div>
        
        <main>
            <form action="php/upload-study.php" method="post" enctype="multipart/form-data">
                <div id="containerId" class="container">
                    <div id="study-form" class="col-10 offset-1">
                        <div class="row create-study-row ">
                            <h1>Create New Study</h1>
                        </div>
                        
                        <div class="row">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>

                            <div class="mb-3">
                                <label for="instructions" class="form-label">Instructions</label>
                                <textarea class="form-control" id="instructions" name="instructions" rows="5" maxlength="400"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="title-input" class="form-label">Participant's data</label>
                                <div class="form-check participants-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">Name</label>
                                </div>
                                <div class="form-check participants-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">Age</label>
                                </div>
                                <div class="form-check participants-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">Gender</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="title-input" class="form-label">Number Screen</label>
                                <div class="row mb-3" id="add-screens"></div>
                                <div class="row">
                                    <div class="col-4 pe-0">
                                        <select class="form-select" id="type-select-1">
                                            <option selected>Choose type...</option>
                                            <option value="Text">Text</option>
                                            <option value="Image">Image</option>
                                        </select>
                                    </div>
                                    <div class="col p-0 mb-3">
                                        <button type="button" onclick="addSelection()" class="btn-type" id="add-btn"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="button" onclick="window.location.href='home.php'" class="btn btn-outline-danger">Cancel</button>
                                <button type="button" onclick="addScreensBtn()" class="btn btn-outline-success add-screens-btn">Add Screens</button>
                            </div>
                                
                        </div>

                        <input type="hidden" id="selectedOptionsInput" name="selectedOptionsInput" value="">
                        <input type="hidden" id="timeValue" name="timeValue" value="">
                    </div>
                    
                </div>
            </form>

        </main>
        
        <script>

            function goBack() {
                const removeForm = document.getElementById("form-div");
                removeForm.remove();
                document.getElementById('study-form').classList.remove('hidden');
            }

            function validateImage(input) {
                // Get the selected file
                const file = input.files[0];

                // Check if the file type is allowed
                const allowedTypes = ['image/jpeg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Only JPEG and PNG files are allowed.');
                    input.value = ''; // Clear the input field
                    return;
                }

                // Check if the file size is within the limit (in bytes)
                const maxSize = 5 * 1024 * 1024; // 5 MB
                if (file.size > maxSize) {
                    alert('The file size must be less than 5 MB.');
                    input.value = ''; // Clear the input field
                    return;
                }

                // The file is valid
                // Do something with it, like upload to the server
                console.log('File selected:', file.name);
            }

            
            function addScreensBtn() {
                //Check if there's a title 
                var titleInput = document.getElementById("title");
                var title = titleInput.value.trim();
                var instructionsTextarea = document.getElementById("instructions");
                var instructions = instructionsTextarea.value.trim();

                if (title === "" ) {
                    titleInput.classList.add("is-invalid");
                    return;
                } else if (instructions === ""){
                    instructionsTextarea.classList.add("is-invalid");
                    return;
                } else if (selectedOptions.length === 0) {
                    alert('Please select at least one screen');
                    return;
                }
                else {
                    titleInput.classList.remove("is-invalid");
                    instructionsTextarea.classList.remove("is-invalid");
                }

                //Post selectedOptions
                const selectedOptionsInput = document.getElementById("selectedOptionsInput");
                selectedOptionsInput.value = JSON.stringify(selectedOptions);
                console.log(selectedOptionsInput.value);

                document.getElementById('study-form').classList.add('hidden');
                console.log(selectedOptions);

                const containerDiv = document.getElementById("containerId")
                const formDiv = document.createElement('div');
                const titleDiv = document.createElement('div');
                const titleText = document.createElement('h1');
                const screensDiv = document.createElement('div');
                
                formDiv.className = "col-10 offset-1";
                formDiv.id = "form-div";
                titleDiv.className = "row create-study-row";
                titleText.innerHTML = 'Create New Study -> Add Screens';
                screensDiv.className = "row";

                containerDiv.appendChild(formDiv);
                formDiv.appendChild(titleDiv);
                titleDiv.appendChild(titleText);
                formDiv.appendChild(screensDiv);


                selectedOptions.forEach(function(selectedOption) {
                    const screenNumDiv = document.createElement('div');
                    const screenNum = document.createElement('h3');
                    const screenType = document.createElement('h6');
                    const screenTimeDiv = document.createElement('div');
                    const screenTime = document.createElement('h6');
                    const timeInput = document.createElement('input');
                    const secondsText = document.createElement('h6');
                    const screenTypeInputDiv = document.createElement('div');

                    screenNumDiv.className = "mb-3";
                    screenNum.innerHTML = 'Screen ' + selectedOption.id;
                    screenType.innerHTML = 'Type: <span style="font-weight: normal">' + selectedOption.selection + '</span>';
                    screenType.style.margin = "0px 0px 10px 20px";
                    screenTimeDiv.className = "gap-2 d-flex justify-content-md-start align-items-center";
                    screenTimeDiv.style.margin = "0px 0px 10px 20px";
                    screenTime.innerHTML = 'Time:';
                    screenTime.style.margin = "0";
                    timeInput.type = "number";
                    timeInput.min = '1';
                    timeInput.max = '60';
                    timeInput.step = '1';
                    timeInput.required = true;
                    timeInput.className = "form-control";
                    timeInput.name = "screenTime-" + selectedOption.id;
                    timeInput.style.width = "70px";
                    secondsText.innerHTML = '<span style="font-weight: normal">seconds </span>';
                    secondsText.style.margin = "0";
                    screenTypeInputDiv.className = "gap-2 d-flex justify-content-md-start";
                    screenTypeInputDiv.style.margin = "0px 0px 10px 20px";

                    screensDiv.appendChild(screenNumDiv);
                    screenNumDiv.appendChild(screenNum);
                    screenNumDiv.appendChild(screenType);
                    screenNumDiv.appendChild(screenTimeDiv);
                    screenTimeDiv.appendChild(screenTime);
                    screenTimeDiv.appendChild(timeInput);
                    screenTimeDiv.appendChild(secondsText);
                    screenNumDiv.appendChild(screenTypeInputDiv);


                    if(selectedOption.selection == 'Text') {
                        const typeText = document.createElement('h6');
                        const textInput = document.createElement('textarea');

                        typeText.innerHTML = 'Text:';
                        typeText.style.margin = "0";
                        textInput.className = "form-control";
                        textInput.rows = "5";
                        textInput.required = true;
                        textInput.maxLength = "400";
                        textInput.name = "textInput-" + selectedOption.id;

                        screenTypeInputDiv.appendChild(typeText);
                        screenTypeInputDiv.appendChild(textInput);

                    } else {
                        const typeText = document.createElement('h6');
                        const imageInput = document.createElement('input');

                        typeText.innerHTML = 'Image:';
                        typeText.style.margin = "0";
                        imageInput.type = "file";
                        imageInput.className = "form-control form-control-sm";
                        imageInput.required = true;
                        imageInput.name = "imageInput-" + selectedOption.id;
                        imageInput.onchange = function() {
                            validateImage(imageInput);
                        }

                        screenTypeInputDiv.appendChild(typeText);
                        screenTypeInputDiv.appendChild(imageInput);
                    }
                });
              
                const btnRow = document.createElement('div');
                const btnDiv = document.createElement('div');
                const btnGoBack = document.createElement('button');
                const btnCreate = document.createElement('button');

                btnRow.className = "row";
                btnDiv.className = "d-grid gap-2 d-md-flex justify-content-md-center";
                btnGoBack.type = "button";
                btnGoBack.className = "btn btn-outline-danger";
                btnGoBack.innerText = "Go Back";
                btnGoBack.onclick = goBack;
                btnCreate.type = "submit";
                btnCreate.name = "submit";
                btnCreate.className = "btn btn-outline-success add-screens-btn";
                btnCreate.innerText = "Create Study";

                formDiv.appendChild(btnRow);
                btnRow.appendChild(btnDiv);
                btnDiv.appendChild(btnGoBack);
                btnDiv.appendChild(btnCreate);
            }

            let selectedOptions = [];

            function saveSelection() {
                localStorage.setItem('selectedOptions', JSON.stringify(selectedOptions));  
            }

            function createSelection(selection) {
                
                selectedOptions.push({
                    selection: selection,
                    id: selectedOptions.length + 1
                });
                saveSelection();
            }

            function addSelection() {
                const addButton = document.getElementById('add-btn');
                const firstSelect = document.getElementById('type-select-1');
                const selection = firstSelect.value;
                

                if(selection === 'Text' || selection === 'Image') {
                    createSelection(selection);
                    render();
                }
                
            }

            function removeSelection(idToDelete) {
                selectedOptions = selectedOptions.filter(function (selectedOption) {
                    // If the id of this todo matches idToDelete, return false
                    // For everything else, return true 
                    if (selectedOption.id === idToDelete) {
                        return false;
                    } else {
                        return true;
                    }
                });

                selectedOptions.forEach(function (selectedOption, index) {
                    selectedOption.id = index + 1;
                });
                saveSelection();
            }

            function deleteSelection(event) {
                const deleteButton = event.target;
                const idToDelete = parseInt(deleteButton.id);
                removeSelection(idToDelete);

                render();
            }

            function render() {
                // reset our list
                document.getElementById('add-screens').innerHTML = '';
                
                selectedOptions.forEach(function(selectedOption) {
                    const textDiv = document.createElement('div'); // create a div for the text
                    const buttonDiv = document.createElement('div'); // create a div for the button
                    const typeText = document.createElement('p');

                    
                    typeText.innerHTML = '<strong>' + selectedOption.id + '. Type: </strong>' + selectedOption.selection;
                    typeText.style.backgroundColor = "white";
                    typeText.style.paddingLeft = "12px";
                    typeText.style.paddingTop = "6px";
                    typeText.style.paddingBottom = "6px";
                    typeText.style.margin = "0";
                    typeText.style.border = "1px";
                    typeText.style.borderColor = "rgba(222, 226, 230)";
                    typeText.style.borderStyle = "solid";
                    typeText.style.borderRadius = "6px 0px 0px 6px";
                    
                    textDiv.className = "col-4 pe-0";
                    buttonDiv.className = "col-8 pe-0";
                    buttonDiv.style.padding = "0";

                    const deleteButton = document.createElement('button');
                    deleteButton.className = "btn-type";
                    deleteButton.innerText = 'Delete';
                    deleteButton.onclick = deleteSelection;
                    deleteButton.id = selectedOption.id;
                    buttonDiv.appendChild(deleteButton);
                    
                    const selectionsList = document.getElementById('add-screens'); 
                    selectionsList.appendChild(textDiv); // append the text div to the main div
                    selectionsList.appendChild(buttonDiv); // append the button div to the main div
                    textDiv.appendChild(typeText);
                });
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
</body>
</html>