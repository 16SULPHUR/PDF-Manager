<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple files upload at once with php</title>
</head>

<body>

    <span style='color: red;margin-bottom:8px; margin-top:10px;'>NOTE - Files not upload to the server only displaying
        names of file. </span><br />
    <form method='post' action='' enctype='multipart/form-data'>
        <input type="file" name="file[]" id="file" multiple><br /><br />

        <input type='submit' name='submit' value='Upload'>
    </form>
    <?php
    if(isset($_POST['submit'])){

         $countfiles = count($_FILES['file']['name']);

         $totalFileUploaded = 0;
         for($i=0;$i<$countfiles;$i++){
              $filename = $_FILES['file']['name'][$i];

              ## Location
              $location = "PDFs to be Merged/".$filename;
              $extension = pathinfo($location,PATHINFO_EXTENSION);
              $extension = strtolower($extension);

              ## File upload allowed extensions
              $valid_extensions = array("jpg","jpeg","png","pdf","docx");

              $response = 0;
              ## Check file extension
              if(in_array(strtolower($extension), $valid_extensions)) {
                   ## Upload file
                   if(move_uploaded_file($_FILES['file']['tmp_name'][$i],$location)){

                         echo "file name : ".$filename."<br/>";

                         $totalFileUploaded++;
                   }
              }

         }
         echo "Total File uploaded : ".$totalFileUploaded;
    }
    ?>
</body>

</html>