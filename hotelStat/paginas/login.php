<?php 
session_start(); // Iniciamos la sesión
if (!isset($_SESSION['intentos'])) {
  $_SESSION['intentos'] = 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="../estilos/estiloLogin.css">
  <script src="../scripts/validaciones.js" defer></script>
</head>
<body>
    <!-- AQUÍ VOY A COLOCAR EL LOGO -->
    <div class="contenedor-logo"></div>
    <!-- BLOQUE DE CÓDIGO PARA EL LOGIN Y EL FORMULARIO -->
    <div class="contenedor-login">
        <h1>Iniciar sesión</h1>
        <form id="loginForm" action="entrar-validar.php" method="post" class="formulario-login">
          <label for="username">Usuario</label>
          <input type="text" id="usuario" name="usuario" required>
          <label for="password">Clave</label>
          <input type="password" id="password" name="password" required>
          <input type="submit" value="Iniciar sesión" class="boton-submit" id="submit-btn">
          <div id="error-msg"></div>
        </form>
      </div>

</body>
</html> 


