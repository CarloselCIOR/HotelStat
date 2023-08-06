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
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_stat";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Habilitar excepciones para errores de PDO
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Consulta SQL para obtener los REGISTROS
  $sql = "SELECT datos_cliente.idCliente, datos_cliente.fechaIngreso, datos_cliente.fechaSalida, lugar_origen.nombre_origen, tipo_estadia.motivo_estadia, tipo_habitacion.nombre, datos_cliente.costo, datos_cliente.rfc
          FROM datos_cliente  
          INNER JOIN tipo_habitacion ON datos_cliente.tipo_habitacion = tipo_habitacion.idHabitacion
          INNER JOIN lugar_origen ON datos_cliente.origen = lugar_origen.idOrigen
          INNER JOIN tipo_estadia ON datos_cliente.motivoEstadia = tipo_estadia.idEstadia
          INNER JOIN usuarios ON datos_cliente.rfc = usuarios.rfc
          INNER JOIN hotel ON usuarios.idHotel = hotel.idHotel
          WHERE hotel.idHotel = $idhotel
          ORDER BY idCliente";

  $stmt = $conn->query($sql);
  $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <title>Lista de Registros</title>
  <script src="../scripts/validacionRegistro.js" defer></script>
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
  <h1>Lista de Registros</h1>
  <div class="buscar-contenedor">
    <button class="insertarRegistro">Agregar Registro</button>
    <input type="text" id="buscar" placeholder="Buscar...">
  </div>
  <table id="tabla-registros">
    <thead>
      <tr>
        <th>ID</th>
        <th>Ingreso</th>
        <th>Salida</th>
        <th>Origen</th>
        <th>Motivo Estadia</th>
        <th>Habitacion</th>
        <th>Costo/Dia</th>
        <th>RFC</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($registros as $registros) { ?>
        <tr>
          <td><?php echo $registros['idCliente']; ?></td>
          <td><?php echo $registros['fechaIngreso']; ?></td>
          <td><?php echo $registros['fechaSalida']; ?></td>
          <td><?php echo $registros['nombre_origen']; ?></td>
          <td><?php echo $registros['motivo_estadia']; ?></td>
          <td><?php echo $registros['nombre']; ?></td>
          <td><?php echo $registros['costo']; ?></td>
          <td><?php echo $registros['rfc']; ?></td>

          <td class="no-border"> <button class="actualizar-filaRegistro">Editar</button> </td>
          <td class="no-border eliminar"> <button class="eliminar-filaRegistro">Eliminar</button> </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <script>
    const inputBuscar = document.getElementById('buscar');
    const tablaRegistros = document.getElementById('tabla-registros');
    const filasRegistros = tablaRegistros.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    inputBuscar.addEventListener('input', function(event) {
      const textoBuscar = event.target.value.toLowerCase();

      for (let i = 0; i < filasRegistros.length; i++) {
        const filaRegistro = filasRegistros[i];

        let seEncontro = false;

        for (let j = 0; j < filaRegistro.getElementsByTagName('td').length; j++) {
          const textoCelda = filaRegistro.getElementsByTagName('td')[j].textContent.toLowerCase();

          if (textoCelda.includes(textoBuscar)) {
            seEncontro = true;
            break;
          }
        }

        if (seEncontro) {
          filaRegistro.style.display = '';
        } else {
          filaRegistro.style.display = 'none';
        }
      }
    });
  </script>
</body>
</html>
