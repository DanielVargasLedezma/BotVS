<?php
	if(isset($_GET['id'])){
		require_once "database/connect.php";

		$id=$_GET['id'];
		$query="DELETE FROM preguntas_sin_respuesta WHERE ide='$id'";
		
		if($mysqli->query($query)){
			echo "Registro eliminado";
		}else{
			echo "Error no se pudo eliminar el registro";
		}
	}else{
		echo "Error no se pudo procesar la peticion";
	}

	$mysqli->close();	
?>