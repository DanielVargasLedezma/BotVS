<?php
require_once "../database/connect.php";


$getMessage = mysqli_real_escape_string($mysqli,$_POST['text']);
$getMessage = substr($getMessage, 2);



for($i = 0; $i < strlen($getMessage); $i++)
{
    if($getMessage[$i] != " ")
    {
        $getMessage = substr($getMessage, $i, strlen($getMessage));
        break;
    }
}

$text =  explode ( "~", $getMessage);

$mensaje1 = $text[0];
$mensaje2 = $text[1];
$mensaje3 = $text[2];

$check_data = "SELECT ide FROM preguntas_sin_respuesta WHERE pregunta = '$mensaje1'";
$run_query = mysqli_query($mysqli, $check_data) or die("Error");

if(mysqli_num_rows($run_query) > 0)
{
    $fetch_data = mysqli_fetch_assoc($run_query);
		$id= $fetch_data['ide'];
		$query="DELETE FROM preguntas_sin_respuesta WHERE ide='$id'";
		if($mysqli->query($query)){
			echo "Registro eliminado";
		}else{
			echo "Error no se pudo eliminar el registro";
		}
}

//guardar las respuestas y preguntas

$query="INSERT INTO chatbot(queries,replies) VALUES('$mensaje2','$mensaje3')";
if($mysqli->query($query)){
    echo "Datos guardados"; 
}else{
    echo "Ocurrio un error"; 
}

$mysqli->close();
?>