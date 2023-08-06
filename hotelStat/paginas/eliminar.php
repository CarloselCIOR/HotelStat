<?php
  include('includes/utilerias.php');
  // Obtener el RFC del empleado a eliminar
  $rfc = $_POST['rfc'];
  eliminarUsuarios($rfc);
?>
