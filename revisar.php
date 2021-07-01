<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/revisar.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Revisar Preguntas Miedo</title>
</head>

<body>
  <section id="container">
    <div><a href="index.php" id="flechita"></a></div>
    <section id="table-sec">
      <table>
        <tbody>
          <tr id="bitch">
            <th></th>
          </tr>
          <?php
          require_once "database/connect.php";
          $query = "SELECT * FROM preguntas_sin_respuesta";
          $consulta1 = $mysqli->query($query);
          while ($fila = $consulta1->fetch_array(MYSQLI_ASSOC)) {
            echo "<tr>
						<th>" . $fila['pregunta'] . "</th>
						<th><a href='revisar.php?g=1 & id=" . $fila['ide'] . "'>Agregar Pregunta</a></th>
						<th><a href='revisar.php?g=2 & id=" . $fila['ide'] . "'>Eliminar</a></th>
					</tr>";
          }
          ?>
        </tbody>
      </table>
    </section>
    <section id="container2">
      <h1 id="pregunta" name="pregunta">
        <?php
        if (isset($_GET['g']) && $_GET['g'] == 1) {
          $query = "SELECT * FROM preguntas_sin_respuesta";
          $consulta1 = $mysqli->query($query);
          while ($fila = $consulta1->fetch_array(MYSQLI_ASSOC)) {
            if ($fila['ide'] == $_GET['id']) {
              echo $fila['pregunta'];
            }
          }
        }
        ?>
      </h1>
      <section class="typing-field">
        <div class="input-data">
          <input id="data1" type="text" required placeholder="Escriba las Palabras Clave" />
          <input id="data2" type="text" required placeholder="Escriba la Respuesta" />
          <button id="send-btn2">Send</button>
        </div>
      </section>
    </section>
  </section>
  <script>
    $(document).ready(function() {
      $("#send-btn2").on("click", function() {

        $Pregunta = $("#data1").val();
        $Respuesta = $("#data2").val();

        $ide_de_la_vara = "";
        if ($Pregunta != "" && $Respuesta != "") {
          $.ajax({
            url: 'php/funcion.php',
            type: "POST",
            data: "text=" + $("#pregunta").text() + "~" + $Pregunta + "~" + $Respuesta,
            success: function(data) {
              console.log(data);
            }
          });
          $("#pregunta").val("");
          $("#data1").val("");
          $("#data2").val("");
        }
      });
    });
  </script>
</body>

</html>

<?php
if (isset($_GET['g']) && $_GET['g'] == 2) {
  require_once "php/eliminar.php";
  header("Refresh:0; url=revisar.php");
}
?>