<?php
include('php/process.php');
?>
<!DOCTYPE html>
<html lang="en">
        <meta charset="UTF-8">
        <title> Bug Ticket | WEB</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="./image/favicon.png">
        <link rel="stylesheet" href="./css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/jquery.min.js" defer></script>
        <script src="js/jquery-ui-1.13.2/jquery-ui.min.js" defer></script>
        <script src="js/index.js" defer></script>
    </head>
    <body>
      <div class="wrapper">
        <h5 class="tittle">Excel to HTML with Pagination</h5>
<?=
        isset($_SESSION['msg'])? $_SESSION['msg'] : false;
?>
        <p class="dl">Down load the format <a href="format.csv">here.</a></p>
        <form enctype="multipart/form-data"  autocomplete="off" class="form" action="php/process.php" method="post">
          <div class="row">
            <label for="formFileMultiple" class="col-sm-2 col-form-label">Upload File</label>
            <div class="col-sm-10">
              <input type="hidden" name="uploadAction" value="up">
              <input name="fileUpload" type="file" hidden>
<?=
                isset($_SESSION['fileVal'])? $val = $_SESSION['fileVal'] : $val = false;
?>
<?=
"              <input value='" .$val."' class='upload form-control' name='file' placeholder='Click to select file...'>"."\r\n";
?>
<?=
              isset($_SESSION['file'])? $_SESSION['file'] : false;
?>
            </div>
          </div>
          <div div class="row">
            <input type="submit" class="col-md-6 btn btn-lg" value="Upload">
          </div>
        </form>
        <div class="uploaded">
          <p>Uploaded Files:</p>
          <ol>
<?=
            showUploaded();
?>
          </ol>
        </div>
      </div>
      <form action="php/csvView.php" method="post">
        <input class="fileName" type="hidden" name="fileName">
        <input class="gotoPrev" type="submit" hidden>
      </form>
    </body>
</html>
