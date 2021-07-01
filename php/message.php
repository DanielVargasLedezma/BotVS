<?php
require_once "../database/connect.php";
$getMessage = mysqli_real_escape_string($mysqli,$_POST['text']);
$searchInfo = "";

//CODIGO

$palabras_clave1 = array("matricula","matricular","matriculacion","beca","creditos","credito","potencia","becas");
$palabras_clave2 = array("fecha","fechas","tipos", "horario de atencion","costo","cuesta","valor");

$getMessage = strtolower($getMessage);
$searchInfo = $getMessage;

foreach ($palabras_clave1 as $word)
{
    if (str_contains($getMessage, $word))
    {
        $searchInfo = $word;
        foreach ($palabras_clave2 as $word2)
        {
            if (str_contains($getMessage, $word2))
            {
                $searchInfo = $word .= " ";
                $searchInfo .= $word2;
                debug_to_console(strval( $searchInfo ) );
                break;
            }
        }
    }
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}


$check_data = "SELECT replies FROM chatbot WHERE queries LIKE '%$searchInfo%'";
$run_query = mysqli_query($mysqli, $check_data) or die("Error");

if(mysqli_num_rows($run_query) > 0)
{
    $fetch_data = mysqli_fetch_assoc($run_query);
    echo $fetch_data['replies'];
}
else 
{
    echo "No te entiendo, pero te amo";

    $query="INSERT INTO preguntas_sin_respuesta(pregunta) VALUES('$getMessage')";
    if($mysqli->query($query)){
        debug_to_console(strval( "Datos guardados" ) ); 
    }else{
        debug_to_console(strval( "Ocurrio un error" ) ); 
    }
}

$mysqli->close();
?>