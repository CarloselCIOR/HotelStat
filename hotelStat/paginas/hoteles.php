<?php
session_start();
include('includes/utilerias.php');
if (!isset($_SESSION['usuario'])) {
    redireccionar('Prohibido','index.php');
    return;
}else{
  include('includes/encabezado.php');
}
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_stat";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Habilitar excepciones para errores de PDO
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Consulta SQL para obtener los hoteles
  $sql = "SELECT idHotel, nombre_hotel, categoria, noHabitaciones FROM hotel;";
  $stmt = $conn->query($sql);
  $hoteles = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <title>Lista de Hoteles</title>
  <script src="../scripts/validacionHotel.js" defer></script>

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
    }

    .no-border button {
      border: none;
      border-radius: 5px;
      height: 30px;
      padding: 5px;
      width: 90%;
      cursor: pointer;
      transition: background-color 0.3s, box-shadow 0.3s, color 0.4s;
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
      padding: 5px 10px 5px 10px;
      width: 300px;
    }

    tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .estrellado{
      color: yellow;
    }
  </style>
</head>
<body>
  <h1>Lista de Hoteles</h1>
  <div class="buscar-contenedor">
    <button class="insertarHotel">Agregar Hotel</button>
    <input type="text" id="buscar" placeholder="Buscar...">
  </div>
  <table id="tabla-hoteles">
    <thead>
      <tr>
        <th>ID Hotel</th>
        <th>Nombre</th>
        <th>Categoria</th>
        <th>No. Habitaciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($hoteles as $hoteles) { ?>
        <tr>
          <td><?php echo $hoteles['idHotel']; ?></td>
          <td><?php echo $hoteles['nombre_hotel']; ?></td>
          <td>
            <?php
              $clasificacion = $hoteles['categoria']; // Este valor debería ser recuperado de la base de datos

              $estrellas = '';
              for ($i = 1; $i <= $clasificacion; $i++) {
                  $estrellas .= '★';
              }
              for ($i = $clasificacion + 1; $i <= 5; $i++) {
                  $estrellas .= '☆';
              }
              ?>

              <div class="estrellado"><?php echo $estrellas . ' (' . $hoteles['categoria'] . ')' ; ?></div>

          </td>
          <td><?php echo $hoteles['noHabitaciones']; ?></td>
          <td class="no-border"> <button class="actualizar-filaHotel">Editar</button> </td>
          <td class="no-border eliminar"> <button class="eliminar-filaHotel">Eliminar</button> </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <script>
    const inputBuscar = document.getElementById('buscar');
    const tablaHoteles = document.getElementById('tabla-hoteles');
    const filasHoteles = tablaHoteles.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    inputBuscar.addEventListener('input', function(event) {
      const textoBuscar = event.target.value.toLowerCase();

      for (let i = 0; i < filasHoteles.length; i++) {
        const filaHoteles = filasHoteles[i];

        let seEncontro = false;

        for (let j = 0; j < filaHoteles.getElementsByTagName('td').length; j++) {
          const textoCelda = filaHoteles.getElementsByTagName('td')[j].textContent.toLowerCase();

          if (textoCelda.includes(textoBuscar)) {
            seEncontro = true;
            break;
          }
        }

        if (seEncontro) {
          filaHoteles.style.display = '';
        } else {
          filaHoteles.style.display = 'none';
        }
      }
    });
  </script>
</body>
</html>
