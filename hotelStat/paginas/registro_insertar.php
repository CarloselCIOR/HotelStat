<?php
  include('includes/utilerias.php');
  // Obtener los datos del formulario
  $registroingreso = $_POST['registro_fecha_ingreso'];
  $registrosalida = $_POST['registro_fecha_salida'];
  $registroorigen = $_POST['registro_origen'];
  $registromotivoestadia = $_POST['registro_motivo'];
  $registrohabitacion = $_POST['registro_habitacion'];
  $registrocosto = $_POST['registro_costodia'];
  $registropor = $_POST['registro_rfc'];
  
  // Conectarse a la base de datos
  insertarRegistro($registroingreso, 
    $registrosalida,
    $registroorigen,
    $registromotivoestadia,
    $registrohabitacion,
    $registrocosto,
    $registropor
);

?>
