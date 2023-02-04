<?php
    require_once "create_file.php";
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $file = fopen("pattern.txt", "r");
        $pattern = fread($file, filesize("pattern.txt"));
        fclose($file);
        echo $pattern;
    }
?>