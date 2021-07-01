<?php
include_once "../database/connect.php";

$getMessage = mysqli_real_escape_string($mysqli,$_POST['text']);

$text =  explode ( "~", $getMessage);

$mensaje1 = $text[0];
$mensaje2 = $text[1];

$query="INSERT INTO chatbot(queries,replies) VALUES('$mensaje1','$mensaje2')";
if($mysqli->query($query)){
    echo "Datos guardados"; 
}else{
    echo "Ocurrio un error"; 
}

?>