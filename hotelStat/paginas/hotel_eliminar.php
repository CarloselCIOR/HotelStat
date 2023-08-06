<?php
  include('includes/utilerias.php');
  // Obtener el RFC del empleado a eliminar
  $nombreHotel = $_POST['nombre_hotel'];
  eliminarHotel($nombreHotel);
?>
