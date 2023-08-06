<?php
  include('includes/utilerias.php');
  // Obtener el RFC del empleado a eliminar
  $idCliente = $_POST['idCliente'];
  eliminarRegistros($idCliente);

?>