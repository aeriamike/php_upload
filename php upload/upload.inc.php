<?php


if (isset($_POST['submit'])){

  //filename
  $newfilename =   $_POST['filename'];
  if(empty($_POST['filename'])){

    $_POST['filename'] = "gallery";

  }else{
    $_POST['filename'] = strtolower(str_replace(" ",".",$newFileName));
  }

  //imagetitle
    $imageTitle =   $_POST['filetitle'];
    $imageDesc = $_POST['filedesc'];
    $file = $_FILES['file'];

    $fileName = $file["name"];
    $fileType = $file["type"];
    $fileTempName = $file["tmp_name"];
    $fileError = $file["error"];
    $fileSize = $file["size"];

    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array("jpg", "jpeg", "png");



    if(in_array($fileActualExt, $allowed)){

      if($fileError == 0){


          if($fileSize<2000000){




            $imageFullName = $fileName;

              $fileDestination = "" . $imageFullName;

              include_once "";

              if(empty($imageTitle) || empty($imageDesc)){

                  header("Location:../sfuanime_post.php?upload=empty");
                  exit();

              }else{

                 $sql = "SELECT * FROM gallery;";
                 $stmt = mysqli_stmt_init($conn);
                 if (!mysqli_stmt_prepare($stmt, $sql)){
                   //check if sql is fine
                    echo "SQL statement failed";

                 }else{
                  //if fine, execute sql statement
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  $rowCount = mysqli_num_rows($result);

                  $setImageOrder = $rowCount + 1;
                  $sql = "INSERT INTO gallery (titleGallery, descGallery,
                    imgFullNameGallery, orderGallery) VALUES ('$imageTitle','$imageDesc','$fileName','$rowCount');";


                if (!mysqli_stmt_prepare($stmt, $sql)){
                  //check if sql is fine
                   echo "SQL statement failed2";

                }  else{
                  mysqli_stmt_bind_param($stmt, "ssss",$imageTitle, $imageDesc, $imageFullName, $setImageOrder);
                  mysqli_stmt_execute($stmt);

                  move_uploaded_file($fileTempName,$fileDestination);

                  header("");
                }

              }
            }
          }else{
            echo "File size is too big!";
            exit();
          }
      }else{

        echo "you had an error!";
        exit();

      }
    }else{

      echo "you need to upload a proper file type!";
      exit();
    }


}

?>
