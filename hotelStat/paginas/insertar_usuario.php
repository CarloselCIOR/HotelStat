<?php
  include('includes/utilerias.php');
  // Obtener los datos del formulario
  $nombreRol = "";
  $rfc = $_POST['rfc'];
  $nombre = $_POST['nombre'];
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];
  $rol = $_POST['rol'];
  $hotel = $_POST['hotel'];
  //PARA ASIGNAR EL ROL A UN NÚMERO PARA LA INSERCIÓN
  switch($rol){
    case "CAPTURISTA":
        $rol = 1;
        break;
    case "ADMINISTRADOR":
        $rol = 2;
        break;
    case "JEFE":
        $rol = 2;
        break;
  }
  //MANDAMOS A LLAMAR LA FUNCIÓN PARA INSERTAR
  insertarUsuarios($rfc, $nombre, $usuario, $clave, $rol, $hotel);

?>
