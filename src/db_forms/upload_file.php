<?php

function uploadFile() {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt)); 
 
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    $maxFileSize = 5 * 1024 * 1024;

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < $maxFileSize) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = '../../uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                return $fileNameNew;
            } else {
                echo "Error: The file size is more than 10mb.";
                die();
            }
        } else {
            echo "Error: There was an error uploading your file.";
            die();
        }
    } else {
        echo "Error: You cannot upload files of this type. " . $fileActualExt;
        die();
    }
}