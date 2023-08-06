<?php
  include('includes/utilerias.php');
  // Obtener los datos del formulario
  $rfc = $_POST['rfc'];
  $nombre = $_POST['nombre'];
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];
  //LLAMAMOS LA CLASE
  actualizarUsuario($rfc, $nombre, $usuario, $clave);
?>
