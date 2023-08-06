<?php
session_start();
include('includes/utilerias.php');
if (!isset($_SESSION['usuario'])) {
    redireccionar('Prohibido','index.php');
    return;
}else{
  include('includes/encabezado.php');
}
$idhotel = $_SESSION['idHotel']; 
$rol = $_SESSION['rol'];

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_stat";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Habilitar excepciones para errores de PDO
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  if($rol == "JEFE"){
      // Consulta SQL para obtener los empleados desded JEFE
    $sql = "SELECT rfc, nombre, usuario, clave, nombre_rol, nombre_hotel 
          FROM usuarios INNER JOIN tipo_rol ON usuarios.rol = tipo_rol.idRol 
          INNER JOIN hotel ON usuarios.idHotel = hotel.idHotel";
  }else{
      // Consulta SQL para obtener los empleados
    $sql = "SELECT rfc, nombre, usuario, clave, nombre_rol, nombre_hotel 
          FROM usuarios INNER JOIN tipo_rol ON usuarios.rol = tipo_rol.idRol 
          INNER JOIN hotel ON usuarios.idHotel = hotel.idHotel
          WHERE usuarios.idHotel = $idhotel";
  }
  $stmt = $conn->query($sql);
  $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
// Cerrar la conexión a la base de datos
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Lista de empleados</title>
  <script src="../scripts/validacionEmpleado.js" defer></script>
  <style>
    body {
      background-color: #24414D;
      color: white;
      font-family: Arial, sans-serif;
      font-size: 16px;
      line-height: 1.5;
      margin: 0;
      padding: 0;
    }

    button{
      cursor: pointer;
    }

    h1 {
      font-size: 2rem;
      font-weight: bold;
      margin: 2rem;
      text-align: center;
      text-transform: uppercase;
    }

    table {
      border-collapse: collapse;
      margin: 2rem auto;
      width: 80%;
    }

    th,
    td {
      border: 1px solid white;
      padding: 1rem;
      text-align: left;
    }

    th {
      color: black;
      background-color: #fff;
      font-weight: bold;
      text-transform: uppercase;
      text-align: center;
    }

    .no-border{
    }

    .no-border button {
      border: none;
      border-radius: 5px;
      height: 30px;
      padding: 5px;
      width: 90%;
      cursor: pointer;
      transition: background-color 0.3s, box-shadow 0.3s;
    }

    .buscar-contenedor {
      display: grid;
      width: 500px;
      height: 40px;
      margin: 0 auto;
      place-items: center;
      grid-template-columns: 180px 320px;
      grid-template-rows: 1fr;
    }

    .buscar-contenedor button {
      height: 30px;
      width: 170px;
      border: none;
      padding 12px;
      border-radius: 5px;
      transition: background-color 0.3s, box-shadow 0.3s;
    }

    .buscar-contenedor button:hover {
      color: white;
      background-color: #005779; 
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); 
    }

    .buscar-contenedor input {
      border: none;
      border-radius: 4px;
      height: 30px;
      width: 310px;
      padding: 5px 10px 5px 10px;
    }

    .no-border button:hover {
      color: white;
      background-color: #005779; 
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); 
    }

    .eliminar button:hover {
      color: white;
      background-color: #9b4b4a; 
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); 
    }

    button:hover {
    box-shadow: 1px 2px 10px rgba(0, 0, 0, 0.5); 
    }

    tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.1);
    }

    tr:hover {
      background: rgba(0,0,0,0.3);
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>Lista de empleados</h1>
  <div class="buscar-contenedor">
    <button class="insertar">Agregar empleado</button>
    <input type="text" id="buscar" placeholder="Buscar...">
  </div>
  <table id="tabla-empleados">
    <thead>
      <tr>
        <th>RFC</th>
        <th>Nombre</th>
        <th>Usuario</th>
        <th>Contraseña</th>
        <th>Rol</th>
        <th>Hotel</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($empleados as $empleado) { ?>
        <tr>
          <td><?php echo $empleado['rfc']; ?></td>
          <td><?php echo $empleado['nombre']; ?></td>
          <td><?php echo $empleado['usuario']; ?></td>
          <td><?php echo $empleado['clave']; ?></td>
          <td><?php echo $empleado['nombre_rol']; ?></td>
          <td><?php echo $empleado['nombre_hotel']; ?></td>
          <td class="no-border"> <button class="actualizar-fila">Editar</button> </td>
          <td class="no-border eliminar"> <button class="eliminar-fila">Eliminar</button> </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <script>
    const inputBuscar = document.getElementById('buscar');
    const tablaEmpleados = document.getElementById('tabla-empleados');
    const filasEmpleados = tablaEmpleados.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    inputBuscar.addEventListener('input', function(event) {
      const textoBuscar = event.target.value.toLowerCase();

      for (let i = 0; i < filasEmpleados.length; i++) {
        const filaEmpleado = filasEmpleados[i];

        let seEncontro = false;

        for (let j = 0; j < filaEmpleado.getElementsByTagName('td').length; j++) {
          const textoCelda = filaEmpleado.getElementsByTagName('td')[j].textContent.toLowerCase();

          if (textoCelda.includes(textoBuscar)) {
            seEncontro = true;
            break;
          }
        }

        if (seEncontro) {
          filaEmpleado.style.display = '';
        } else {
          filaEmpleado.style.display = 'none';
        }
      }
    });
  </script>
</body>
</html>
