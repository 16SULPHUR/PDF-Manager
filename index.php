<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PDF merger</title>
    <link rel="stylesheet" href="style.css" />
    <script src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
</head>

<body>

    <!-- PHP Code Starts Here -->
    <?php
    if(isset($_POST["submit"])){

      $filenames = Array();

// Get input files
         $countfiles = count($_FILES['file']['name']);

         $totalFileUploaded = 0;
         for($i=0;$i<$countfiles;$i++){
              $filename = $_FILES['file']['name'][$i];

              ## Location
              $location = "PDFs to be Merged/".$filename;
              $extension = pathinfo($location,PATHINFO_EXTENSION);
              $extension = strtolower($extension);

              ## File upload allowed extensions
              $valid_extensions = array("pdf");

              $response = 0;
              ## Check file extension
              if(in_array(strtolower($extension), $valid_extensions)) {
                   ## Upload file
                   if(move_uploaded_file($_FILES['file']['tmp_name'][$i],$location)){

                         echo "file name : ".$filename."<br/>";
                         array_push($filenames,"$filename");

                         $totalFileUploaded++;
                   }
              }

         }
         echo "Total File uploaded : ".$totalFileUploaded;
        //  echo $filenames;


// Call API
  $FileHandle = fopen('result.pdf', 'w+');

$curl = curl_init();

$string = '';

foreach ($filenames as $filename) {
    $string .= '{"file":"' . $filename . '"},';
    // echo "filename loop !";
}

// Remove the trailing comma
$string = rtrim($string, ',');

$instructions = '{
  "parts": [
    '.$string.'
  ]
}';


// $testarray = array();
// foreach ($filenames as $filename) {
//     array_push($testarray,``.$filename.` => new CURLFILE('PDFs to be Merged/`.$filename.`.pdf')`);
//     // echo "testarray !";
// }
// echo $testarray[0];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.pspdfkit.com/build',
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_POSTFIELDS => array(
    'instructions' => $instructions,
    
    
    '1' => new CURLFILE('PDFs to be Merged/1.pdf'),
    '2 ' => new CURLFILE('PDFs to be Merged/2.pdf')
    // 'second_half' => new CURLFILE('PDFs to be Merged/second_half.pdf')
  ),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer pdf_live_ODXlKYntza6MjvMcjg3tLJzaEPYM2LskePuwoygQOcd'
  ),
  CURLOPT_FILE => $FileHandle,
));

$response = curl_exec($curl);

curl_close($curl);

fclose($FileHandle);
echo "Done !"; 
    }
    




?>

    <!-- PHP Code Ends Here -->



    <header>
        <nav>
            TTP PDf tools
        </nav>
    </header>
    <main>
        <div class="containor">
            <br />
            <p>PDF merger</p>
            <div class="drag">
                <img src="various-files.png" alt="Drag and Drop files" />
            </div>
            <form action="index.php" method="POST" enctype='multipart/form-data'>
                <div class="form-group">
                    <label for="exampleFormControlFile1"><b>File input :</b></label><br />
                    <!-- <input type="file" class="form-control-file" id="exampleFormControlFile1" multiple accept=".pdf" /> -->
                    <input type="file" name="file[]" id="file" multiple>
                </div><br><br>
                <!-- <input type="submit" value="Merge PDFs" class="submit" name="submit"> -->
                <input type='submit' class="submit" name='submit' value='Upload'>
            </form>
            <div class="process">
            </div>
        </div>
    </main>
    <script>
    const drag = document.querySelector(".drag");

    drag.addEventListener("dragover", (e) => {
        e.preventDefault();
        drag.classList.add("drag-hover");
    });

    drag.addEventListener("dragleave", () => {
        drag.classList.remove("drag-hover");
    });

    drag.addEventListener("drop", (e) => {
        drag.classList.remove("drag-hover");
        e.preventDefault();
        drag.innerText = "File added succefully. You can add more files.";
        drag.style.color = "green";
        let pdf1 = e.dataTransfer.files[0];
        let type1 = pdf1.type;
        console.log(pdf1 + type1);
        let pdf2 = e.dataTransfer.files[1];
        let type2 = pdf2.type;
        console.log(pdf1 + type1);
    });
    const submit = document.querySelector(".submit")
    const process = document.querySelector(".process")
    submit.addEventListener("click", () => {
        process.innerText = "Started merging PDFs..."
        process.style.color = "green"
        process.style.fontSize = "2.5rem"
    })
    </script>
</body>

</html>