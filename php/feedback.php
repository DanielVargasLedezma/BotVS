<?php
require_once "../database/connect.php";

$getMessage = mysqli_real_escape_string($mysqli,$_POST['text']);

$query="INSERT INTO feedback(feedbackMess) VALUES('$getMessage')";
if($mysqli->query($query)){
    echo "Datos guardados"; 
}else{
    echo "Ocurrio un error"; 
}

$mysqli->close();
?>