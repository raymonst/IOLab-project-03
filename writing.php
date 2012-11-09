<?php
header('Access-Control-Allow-Origin: *');

$CSVstring= $_POST['tweetsString']; 

$my_file = 'Tweets2.txt';  //Note: The file permissions for the text file must be 777 i.e. rwxrwxrwx



//APPENDING TO FILE
$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
fwrite($handle, $CSVstring);
fclose($handle);



//READING FROM FILE
// $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
// $CSVdata = fread($handle,filesize($my_file));
// fclose($handle);


echo 'Pass CSVdata read from file here';

// echo $CSVstring;
?>