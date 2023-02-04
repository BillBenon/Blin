<?php
if(!file_exists("status.txt")) {
    $file = fopen("status.txt", "w");
    fwrite($file, "OFF");
    fclose($file);
}
?>