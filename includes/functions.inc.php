<?php
function safeInt($int){
	return filter_var($int, FILTER_VALIDATE_INT);
}
function safeString($str){
	return filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
}
function safeFloat($float) {
	return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}
function uploadFile(){
    $currentDir = getcwd();
    $uploadDirectory = "../CONTENT/IMAGES/";

    $errors = []; // Store all foreseen and unforseen errors here

    $fileExtensions = ['jpeg', 'JPEG', 'JPG', 'jpg','png']; // Get all the file extensions

    $fileName = $_FILES['fileToUpload']['name'];
    $fileSize = $_FILES['fileToUpload']['size'];
    $fileTmpName  = $_FILES['fileToUpload']['tmp_name'];
    $fileType = $_FILES['fileToUpload']['type'];
    $temp = explode('.',$fileName);
    $fileExtension = end($temp);
    $uploadPath = $uploadDirectory . basename($fileName); 

    if (isset($_POST['submit'])) {
        if (! in_array($fileExtension,$fileExtensions)) {
            $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }
        if ($fileSize > 2000000) {
            $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
        }
        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) {
                return $fileName;
            } else {
                echo "An error occurred somewhere. Try again or contact the admin";
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "These are the errors" . "\n";
            }
        }
    }
}
?>