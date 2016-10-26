<?php
/*
    code from: http://www.w3schools.com/php/php_file_upload.asp
 */

function uploadImage($image, $target_file)
{
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $rejectMessage = "";
    $success = false;
    // Check if image file is a actual image or fake image

    $check = getimagesize($image["tmp_name"]);
    if ($check !== false)
    {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else
    {
        $rejectMessage = "File is not an image.";
        $uploadOk = 0;
    }

// Check file size
    if ($image["size"] > 500000)
    {
        $rejectMessage = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" /*&& $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"*/)
    {
        $rejectMessage = "Sorry, only .jpg files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0)
    {
        //echo "Sorry, your file was not uploaded.";
        $rejectMessage = "$rejectMessage Please Try again. If problem persists, contact system administrator!";
    } else // if everything is ok, try to upload file
    {
        if (move_uploaded_file($image["tmp_name"], $target_file))
        {
            //echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            $success = true;
        } else
        {
            $rejectMessage = "There was an error uploading your image. Please try again! If problem persists, contact system administrator!";
        }
    }
    if(!$success)
    {
        return $rejectMessage;
    }
}

