<?php
  include('includes/utilerias.php');
  // Obtener los datos del formulario
  $nombrehotel = $_POST['nombre_hotel'];
  $categoriahotel = $_POST['categoria'];
  $nohabitacioneshotel = $_POST['noHabitaciones'];
  // Conectarse a la base de datos
  insertarHotel($nombrehotel, $categoriahotel, $nohabitacioneshotel);

?>
