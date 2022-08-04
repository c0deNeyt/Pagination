<?php
    session_start();
    //assign file name from the index.php clicked filename.
    if(isset($_POST['fileName']) && !empty($_POST['fileName'])){
        $_SESSION['csvFileName'] =  $_POST['fileName'];
        $filePath = "../uploads/".$_SESSION['csvFileName'];
    }
    // assign default filename
    if(!isset( $_SESSION['csvFileName'])){
        $filePath = "../format.csv";
    }
    //assign filename from the session (if exist)
    if(isset($_SESSION['csvFileName'])){
        $filePath = "../uploads/".$_SESSION['csvFileName'];
    }
    function formatData($f){
        $fileName = fopen($f, "r");
        $data = [];
        if ($fileName === false) {
            die();
        }
        // read each line in CSV file at a time
        while (($row = fgetcsv($fileName)) !== false) {
            $data[] = $row;
        }
        // close the file
        fclose($fileName);
        return $data;
    }
    // DISPLAY data into a table
    function displayData($f){
        $x = formatData($f);
        //Set the index if the get method not initiated
        $index = 0;
        // override index value if get method initiated
        if(isset($_GET['page'])){
            $index = $_GET['page'] * 50;
        }
        //loop to count the from the start index and check
        // if count can reach 50
        $e2eCount = 0;
        for($i=$index;$i<count($x) && ($e2eCount <= 50);$i++){
            $e2eCount++;
        }
        // LOOP 50 times to get available result;
        for($c=0;$c<=50;$c++){
            if($c == 0){
                echo "             <tr class='head'>
                <th>#</th>
                <th>".$x[$c][0]."</th>
                <th>".$x[$c][1]."</th>
                <th>".$x[$c][2]."</th>
                <th>".$x[$c][3]."</th>
              </tr>"."\r\n";
            //this will validate if the index is existed
            }else if ($c < $e2eCount){
                echo "              <tr class='head'>
                <td>".$index+$c."</td>
                <td>".$x[$index+$c][0]."</td>
                <td>".$x[$index+$c][1]."</td>
                <td>".$x[$index+$c][2]."</td>
                <td>".$x[$index+$c][3]."</td>
                </tr>"."\r\n";
            }
        }
    }
    // this will display the clickable page count under the table
    function getPages($f){
        $x = formatData($f);
        for($c=0;$c<(count($x)/50);$c++){
            echo "              <input class='pageCount' type='submit' name='page' value=".$c.">"."\r\n";
        }
    }
    //list of uploaded files
    function showUploaded(){
        $path    = 'uploads';
        $files =  array_diff(scandir($path), array('.', '..'));
        foreach ($files as $key => $value) {
            echo "              <li><a class='fileName' href='#'>" .$value. "</a></li>"."\r\n";
        }
      }
    //Generate status message when uploading
    function validationMsg(){
        $uploadsDir = '../uploads';
        // get the existing files
        $files =  array_diff(scandir($uploadsDir), array('.', '..'));
        // get details of uploaded file
        $name = basename($_FILES["fileUpload"]["name"]);
        $tmp_name = $_FILES["fileUpload"]["tmp_name"];
        // asterisk mark
        $errorMark = "              <p class='errorMark'>*</p>"."\r\n";
        //initialize the error status
        $error = false;
        // message field
        $msgBox = "            <div class='errorField'>"."\r\n";
        // File validation
        $mimetype = $_FILES['fileUpload']['type'];
        if ((trim($_POST['file'] == "")) || ($mimetype != 'text/csv')){
            $msgBox .= '              <p>* Please select a valid csv file.</p>'."\r\n";
            $_SESSION['file'] =  $errorMark;
            $error = true;
        }
        //validate the new file heder count
        if(isset($_FILES["fileUpload"]) && ($mimetype == 'text/csv')){
            $newFile = formatData($tmp_name);
            if(count($newFile[0]) > 4){
                $msgBox .= '              <p>* File contains invalid format!</p>'."\r\n";
                $_SESSION['file'] =  $errorMark;
                $error = true;
            }
        }
        //check filename  if already exist
        foreach ($files as $key => $value) {
            if($value == $name){
                $msgBox .= '              <p>* File Already Exist.</p>'."\r\n";
                $_SESSION['file'] =  $errorMark;
                $error = true;
            }
        }
        $msgBox .= '            </div>'."\r\n";
        //Populating message box
         $_SESSION['fileVal'] = $_POST['file'];
        if($error == true){
            return $msgBox;
        }
        else{
            $_SESSION['fileVal'] = false;
            unset($_FILES);
            move_uploaded_file($tmp_name, "$uploadsDir/$name");
            return "<div class='successMsg'>File Upload Successful!</div>";
        }
    }
    // Display validation Message
    if(isseT($_FILES["fileUpload"])){
        $_SESSION['msg'] = validationMsg();
        header("location: ../index.php");
        die();
    }

?>