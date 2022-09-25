<?php
session_start();
unset($_SESSION['runs']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="trains.css" rel="stylesheet" type="text/css" />
    <title>Train Exercise</title>
</head>

<body>
    <h1 class="center">
        Please upload a CSV file that contains a list of train runs.
    </h1>
    <div class="center">
        <form action="show_runs.php" enctype="multipart/form-data" method="post">
            <input name="file_name" id="file_name" accept=".csv" type="file" />
            <button type="submit" name="submit" id="submit">Upload File</button>
        </form>
    </div>
</body>

</html>