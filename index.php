<?php
require 'vendor/autoload.php';

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

$config =[
  'facebook' => [
      'token' => 'EAAEZCx2CsEDQBAAavEYYxCKrf34OhsupEbhmkyPNb0qEnUHnJjcfpVfqzqgeDasULP9oiTIzbyDGTuEPcbszgf3ijnZBAzZCIAxJchkYPFq0VYC8LNJAh5CZAyXR7NoLDlW1AY3uCxlu5MbUbCACZAMdDZBDvgxDApR2MdwNNooftyvOhWriJT',
      'app_secret' => 'a6d6f39f2882acb3fdfb2b0b2bf4d0f9',
      'verification'=>'abc_123',
  ]
  ];

  DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

  $botman = BotManFactory::create($config);
  
  $botman->hears('hello', function(BotMan $bot) {
    $bot->reply('Hello yourself.');
  });
  
  $botman->listen();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel=icon href="img/icon.png" sizes="50x26" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Bot interactivo</title>
</head>

<body>

  <nav class="d-flex flex-row justify-content-between align-items-center header">
    <div class="col-md-4 col-sm-5 col-4">
      <section class="d-flex flex-row justify-content-start align-items-center icono-titulo">
        <div class="col-md-3 col-sm-4 col-6 icono titulo">
          <img class="icono-pagina" src="img/icon.png" alt="">
        </div>
        <div class="col-md-3 col-sm-2 col-2 titulo">
          <h1>Prototipo</h1>
        </div>
      </section>
    </div>
    <div class="col-md-5 col-sm-5 col-4 enlaces">
      <ul class="d-flex flex-row justify-content-end navbar">
        <div class="col-md-3 col-sm-4 col-0 enlace"></div>
        <li class="col-md-3 col-sm-4 col-6 enlace">
          <a href="index.php"> Inicio </a>
        </li>
        <li class="col-md-3 col-sm-4 col-6 enlace activo">
          <a href="bot.php"> Bot </a>
        </li>
      </ul>
    </div>
  </nav>

  <main class="d-flex flex-md-column flex-sm-column flex-l-row flex-xl-row flex-column justify-content-center align-items-center">
    <section class="col-l-4 col-xl-4">
      <section class="d-flex flex-column justify-content-center align-items-center">
        <?php
        require_once "database/connect.php";

        if ($result = $mysqli->query("SELECT * FROM `preguntas_sin_respuesta` LIMIT 1")) {

          if ($obj = $result->fetch_object()) {
            echo '<section class="alert"><i class="alerta"></i><button id="boton-preguntas"><a href="revisar.php">Revisar Preguntas Sin Respuesta</a></button></section>';
          }
          $result->close();
        }
        $mysqli->close();
        ?>
      </section>
    </section>

    <section class="col-l-4 col-xl-4">
      <section class="d-flex flex-column justify-content-center align-items-center">
        <section class="col-l-8 col-xl-8 wrapper">
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

      </section>
    </section>

    <section class="col-l-4 col-xl-4">
      <section id="container">
        <input id="preg" type="text" required placeholder="Escriba una pregunta que desee agregar al sistema" />
        <input id="resp" type="text" required placeholder="Escriba la respuesta a su pregunta" />
        <button id="send-btn-2">Send</button>
      </section>

    </section>
  </main>
  <footer>
    <p>Todos los derechos reservados</p>
  </footer>
  <script>
    $(document).ready(function() {
      $("#send-btn").on("click", function() {

        $value = $("#data").val();
        //Message Start
        {
          $MESSAGE =
            '<section class="message-body-right"><div class="user-inbox inbox"><section class="msg-header"><p>' +
            $value +
            '</p></section><div class="icon"><i class="user"></i></div></div></section>';
          $(".form").append($MESSAGE);
          $("#data").val("");

          $.ajax({
            url: "php/message.php",
            type: "POST",
            data: "text=" + $value,
            success: function(result) {
              //
              $reply =
                '<section class="message-body"><div class="bot-inbox inbox"><div class="icon"><i class="bot"></i></div><section class="msg-header"><p>' +
                result +
                "</p></section></div></section>";
              //
              $(".form").append($reply);
              $(".form").scrollTop($(".form")[0].scrollHeight);

              //Feedback start
              {
                $mensaje = "¿Está contento con su resultado? Si no lo esta puede usar el apartado de la derecha para poner sus comentarios";
                $feedback = '<section><div class="bot-inbox inbox"><section class="message-body"><div class="bot-inbox inbox">' +
                  '<div class="icon"><i class="bot"></i></div><section class="msg-header"><p>' +
                  $mensaje +
                  '</p><div class="feedback"><textarea name="" id="feedback-text" cols="40" rows="5"></textarea><br><button id="send-feedback">Enviar</button></div>'
                "</div></section></section>";
                $(".form").append($feedback);
                $(".form").scrollTop($(".form")[0].scrollHeight);
                var array3 = document.querySelectorAll(".form button");
                var number = (array3.length) - 1;
                array3[number].addEventListener('click', funcion);
              }
              //Feedback ends
            },
          });
        }
        //Message End
      });

      $("#send-btn-2").on("click", function() {

        $preg = $("#preg").val();
        $resp = $("#resp").val();
        //Message Start
        {

          $.ajax({
            url: "php/guardar.php",
            type: "POST",
            data: "text=" + $preg + "~" + $resp,
            success: function(result) {
              $("#preg").val("");
              $("#resp").val("");
            },
          });
        }
        //Message End
      });

    });

    const funcion = () => {
      var array1 = document.querySelectorAll(".form textarea");
      var number1 = (array1.length) - 1;
      $value = array1[number1].value;
      //Message Start
      {
        var array2 = document.querySelectorAll(".form textarea");
        var number2 = (array2.length) - 1;
        array2[number2].disabled = true;
        var array3 = document.querySelectorAll(".form button");
        var number3 = (array3.length) - 1;
        array3[number3].disabled = true;
        $.ajax({
          url: "php/feedback.php",
          type: "POST",
          data: "text=" + $value,
          success: function(result) {
            console.log(data);
          },
        });
      }
      //Message End
    };
  </script>
</body>

</html>