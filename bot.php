<?php 
 $mysqli = new mysqli("localhost", "root", "", "bot");

if ($result = $mysqli->query("SELECT * FROM `preguntas_sin_respuesta` LIMIT 1"))
{

    if ($obj = $result->fetch_object())
    {
      echo '<section class="alert"><i class="alerta"></i><button id="boton-preguntas"><a href="revisar.php">Revisar Preguntas Sin Respuesta</a></button></section>';
    }
    $result->close();

}
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Hola</title>
  </head>
  <body>
    <section class="wrapper">
      <div class="title">Bot</div>
      <div class="form">
        <section class="message-body">
        <div class="bot-inbox inbox">
          <div class="icon">
            <i class="bot"></i>
          </div>
          <section class="msg-header">
            <p>Hello</p>
          </section>
        </div>
        </section>
      </div>
      <section class="typing-field">
        <div class="input-data">
          <input id="data" type="text" required placeholder="Type Something" />
          <button id="send-btn">Send</button>
        </div>
      </section>
    </section>
    <script>
      $(document).ready(function () {
        $("#send-btn").on("click", function () {
          
          $value = $("#data").val();
          //Message Start
          {          
            $MESSAGE =
              '<section class="message-body-right"><div class="user-inbox inbox"><section class="msg-header"><p>' +
              $value 
              + '</p></section><div class="icon"><i class="user"></i></div></div></section>';
            $(".form").append($MESSAGE);
            $("#data").val("");

            $.ajax({
              url: "message.php",
              type: "POST",
              data: "text=" + $value,
              success: function (result) {
                //
                $reply =
                  '<section class="message-body"><div class="bot-inbox inbox"><div class="icon"><i class="bot"></i></div><section class="msg-header"><p>' +
                  result 
                  + "</p></section></div></section>";
                //
                $(".form").append($reply);
                $(".form").scrollTop($(".form")[0].scrollHeight);
              },
            });
          }
          //Message End
        });
      });
    </script>
  </body>
</html>
