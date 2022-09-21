<?php 
//groza session izveido



function pieteicies(){
    if(isset($_COOKIE['lietotajs'])){
        if($_COOKIE['pieteicies'] == TRUE){
            $_SESSION['lietotajs']=$_COOKIE['lietotajs'];
            $_SESSION['pieteicies']=$_COOKIE['pieteicies'];
            $ielagojies = true;
            return $ielagojies;
        }
    }
    $ielagojies = false;
    if(isset($_SESSION['pieteicies'])){
        $ielagojies = true;
    }
    return $ielagojies;
}

function imgupload(){
    
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    //noņem dir pirmos 2 simbolus
    $imgdir = substr($target_file, 2);
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
    } else {
    echo "File is not an image.";
    $uploadOk = 0;
    }

    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
        echo "Sorry, there was an error uploading your file.";
        }
    }
    return $imgdir;
  }




  if(!isset($_SESSION['grozs'])){
    $_SESSION['grozs']=array();
}


function printsnagls(){
    echo "snagls";
}
?>

