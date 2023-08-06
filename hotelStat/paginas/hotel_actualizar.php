<?php
include('includes/utilerias.php');
// Obtener los datos del formulario
$idhotel = $_POST['idHotel'];
$nombrehotel = $_POST['nombre_hotel'];
$categoriahotel = $_POST['categoria'];
$nohabitacioneshotel = $_POST['noHabitaciones'];
//PARA ASIGNAR EL ROL A UN NÚMERO PARA LA INSERCIÓN
actualizarHotel($idHotel, $nombrehotel, $categoriahotel, $nohabitacioneshotel);

// Conectarse a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'hotel_stat');

// Verificar si la conexión fue exitosa
if (!$conexion) {
  die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}

//Preparar la consulta SQL para insertar los datos
$consulta = "UPDATE hotel SET nombre_hotel = '$nombrehotel',
                                 categoria = '$categoriahotel',
                                 noHabitaciones = '$nohabitacioneshotel'
                                  WHERE idHotel = '$idhotel';";

// Ejecutar la consulta
if (mysqli_query($conexion, $consulta)) {
  header("Location: hoteles.php");
} else {
  echo "Error al actualizar hotel: " . mysqli_error($conexion);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
