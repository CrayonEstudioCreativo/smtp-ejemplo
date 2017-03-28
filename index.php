<?php
// Registramos el autoloader. Esto nos permite acceder a las clases de las
// dependencias y a las implementadas por nosotros.
$autoloader = include_once __DIR__ . '/vendor/autoload.php';
$mailer = NULL;
if($_POST){
  $mailer = new \CrayonEstudioCreativo\Tutorial\LibreriaSMTP(__DIR__ . "/configuration.yml.example");
  $mailer->sendMail();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Ejemplo minimo de envío de mensajes con SwiftMailer</title>
  <style>
    body {
      padding: 25px 0;
    }

    button[type=submit] {
      margin-top: 15px;
    }
  </style>
  <link rel="stylesheet"
        href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <div class="jumbotron">
    <h1>Ejemplo mínimo de envío con <strong>SwiftMailer</strong></h1>
    <h2>Rama old-school <em>includes</em></h2>
    <p>
      Para ver documentación visita
      <a href="http://swiftmailer.org/">SwiftMailer</a>
    </p>
  </div>
  <div class="panel panel-default">
    <div class="panel-body">
      <form method="post">
        <div class="form-group">
          <input name="email" type="email" class="form-control"
                 placeholder="E-mail">
        </div>
        <textarea name="mensaje" class="form-control" rows="3"
                  placeholder="Mensaje"></textarea>
        <button type="submit" class="btn btn-default">Enviar</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
