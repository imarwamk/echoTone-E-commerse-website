<?php 
$host = "sql212.infinityfree.com";      
$user = "if0_40368981";                
$pass = "imarwa1996joj";           
$dbname = "if0_40368981_XXX";          

$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
} 
?>
