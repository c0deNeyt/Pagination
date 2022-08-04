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
        // var_dump($_SESSION);
        $data = [];
        if ($fileName === false) {
            die('Cannot open the file ' . $fileName);
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
            $index = ($_GET['page']-1) * 50;
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
            }else if ($c < $e2eCount){
                echo "              <tr class='head'>
                <td>".$c."</td>
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
        for($c=1;$c<=(count($x)/50);$c++){
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
        $_SESSION['file'] = false;
        $uploads_dir = '../uploads';
        $name = basename($_FILES["fileUpload"]["name"]);
        $tmp_name = $_FILES["fileUpload"]["tmp_name"];
        $errorMark = "              <p class='errorMark'>*</p>"."\r\n";
        $error = false;
        $msgBox = "            <div class='errorField'>"."\r\n";

        // File validation
        $mimetype = $_FILES['fileUpload']['type'];
        if ((trim($_POST['file'] == "")) || ($mimetype != 'text/csv')){
            $msgBox .= '              <p>* Please select a valid csv file.</p>'."\r\n";
            $_SESSION['file'] =  $errorMark;
            $error = true;
        }else{
            echo false;
        }
        //Populating message box
        $_SESSION['fileVal'] = $_POST['file'];
        $msgBox .= '            </div>'."\r\n";
        if($error == true){
            return $msgBox;
        }
        else{
            $_SESSION['fileVal'] = false;
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
            return "<div class='successMsg'>Ticket Submitted successfully!</div>";
        }
    }
    // Display validation Message
    if(isseT($_FILES["fileUpload"])){
        $_SESSION['msg'] = validationMsg();
        header("location: ../index.php");
        die();
    }

?>