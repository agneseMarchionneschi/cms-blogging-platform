<?php 
$conn = mysqli_connect("localhost", "root", "", "onblog_db");
if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error());
}
?>