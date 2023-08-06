<?php
include('includes/utilerias.php');
// Obtener los datos del formulario
$registroidRegistro = $_POST['actualizar-idRegistro'];
$registroingreso = $_POST['actualizar-ingresoRegistro'];
$registrosalida = $_POST['actualizar-salidaRegistro'];
$registroorigen = $_POST['actualizar-origenRegistro'];
$registromotivoestadia = $_POST['actualizar-motivoRegistro'];
$registrohabitacion = $_POST['actualizar-habitacionRegistro'];
$registrocosto = $_POST['actualizar-registroCostodia'];
$registropor = $_POST['actualizar-rfcRegistro'];
  
//PARA ASIGNAR EL ROL A UN NÚMERO PARA LA INSERCIÓN
actualizarRegistro(
  $registroidRegistro, 
  $registroingreso, 
  $registrosalida, 
  $registroorigen,
  $registromotivoestadia,
  $registrohabitacion,
  $registrocosto,
  $registropor,
);

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
