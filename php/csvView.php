<?php
    include_once("process.php");
    // session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> Bug Ticket | WEB</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../image/favicon.png">
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
      <div class="wrapper">
        <h5 class="tittle">CSV File Data</h5>
        <form action="" method="get">
         <?= displayData($filePath); ?>
          <div class="pageCountWrapper">
            <?= getPages($filePath); ?>
          </div>
        </form>
      </div>
    </body>
</html>