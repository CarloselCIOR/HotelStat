<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_SESSION['usuario'])) {
      $rol = $_SESSION['rol']; //ROL
      $nombre = $_SESSION['usuario'];//NOMBRE
      $usuario = $_SESSION['sys_usuario'];//USUARIO
      $rfc = $_SESSION['rfc'];//RFC
      $idHotel = $_SESSION['idHotel'];//RFC
      $nombre_hotel = $_SESSION['nombre_hotel'];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Stat</title>
    <link rel="stylesheet" href="../estilos/estiloEncabezado.css">
    <link rel="stylesheet" href="../estilos/estiloHotel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="../scripts/validaciones.js" defer></script>
</head>

<body>
<!-- ENCABEZADOS -->
  <!-- BLOQUE PARA INSERTAR -->
  <div class="contenedor-insertar">
    <button class="cerrar-insertar">Cerrar</button>
    <!-- FORMULARIO DE INSERTAR -->
    <form method="post" action="insertar_usuario.php" class="form-empleado">
      <h1>Insertar Usuario</h1>
      <input type="text" id="rfc" name="rfc" placeholder = "RFC" required id="rfc" maxlength="13"><br>
      <input type="text" id="nombre" name="nombre" placeholder = "Nombre" required><br>
      <input type="text" id="usuario" name="usuario" placeholder = "Usuario" required><br>
      <input type="text" id="clave" name="clave" placeholder = "Clave" required id="clave"><br> 
      <select id="rol" name="rol" required>
        <option value="rol" readonly>Seleccionar rol</option>
        <?php
         if ($rol =="JEFE"){
          $query = "SELECT nombre_rol FROM tipo_rol";
          $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);
  
          // Imprimir cada valor obtenido en un elemento option del select
          while($fila = mysqli_fetch_assoc($resultado)) {
            echo '<option value="' . $fila['nombre_rol'] . '">' . $fila['nombre_rol'] . '</option>';
          }
        }else{
          // Realizar una consulta para obtener los valores de la columna nombre_rol
          $query = "SELECT * FROM tipo_rol WHERE idRol <> 3;";
          $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);

          // Imprimir cada valor obtenido en un elemento option del select
          while($fila = mysqli_fetch_assoc($resultado)) {
            echo '<option value="' . $fila['nombre_rol'] . '">' . $fila['nombre_rol'] . '</option>';
          }
        }
       
      ?>
      </select><br>
      
      <select id="hotel" name="hotel" required>
        <option value="hotel" readonly>Seleccionar hotel</option>
        <?php
        if ($rol =="JEFE"){
          // Realizar una consulta para obtener los valores de la columna nombre_rol
          $query = "SELECT nombre_hotel FROM hotel";
          $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);

          // Imprimir cada valor obtenido en un elemento option del select
          while($fila = mysqli_fetch_assoc($resultado)) {
            echo '<option value="' . $fila['nombre_hotel'] . '">' . $fila['nombre_hotel'] . '</option>';
          }
        }else{
          echo '<option value="' . $nombre_hotel . '">' . $nombre_hotel . '</option>';
        }
        
      ?>
      </select><br>
      <button type="submit" name="insertar" class="insertar-empleado" id="insertar-empleado-boton">Insertar usuario</button>
      
    </form>
  </div>
  <!-- BLOQUE EDICION -->
  <div class="contenedor-actualizar">
    <button class="cerrar-actualizar">Cerrar</button>
    <!-- FORMULARIO DE ACTUALIZAR -->
    <form method="post" action="actualizar_usuario.php">
      <h1>Actualizar Usuario</h1>
      <input type="text" id="actualizar-rfc" name="rfc" placeholder = "RFC" readonly><br>
      <input type="text" id="actualizar-nombre" name="nombre" placeholder = "Nombre"><br>
      <input type="text" id="actualizar-usuario" name="usuario" placeholder = "Usuario"><br>
      <input type="text" id="actualizar-clave" name="clave" placeholder = "Clave"><br> 
      <button type="submit" name="insertar" id="actualizar-empleado-boton">Actualizar usuario</button>
    </form>
  </div>
  <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- BLOQUE PARA INSERTAR HOTEL -->
  <div class="contenedor-insertarHotel">
      <button class="cerrar-insertarHotel">Cerrar</button>
      <!-- FORMULARIO DE INSERTAR -->
      <form method="post" action="hotel_insertar.php" class="form-hotel">
        <h1>Insertar Hotel</h1>
        <input type="text" id="nombre_hotel" name="nombre_hotel" placeholder = "Nombre" required id="nombre_hotel"><br>
        <input type="text" id="categoria" name="categoria" placeholder = "Categoria" required><br>
        <input type="text" id="noHabitaciones" name="noHabitaciones" placeholder = "No. Habitaciones" required><br>
        
        <button type="submit" name="insertarHotel" class="insertar-Hotel">Insertar hotel</button>
        
      </form>
    </div>
    <!-- BLOQUE EDICION -->
    <div class="contenedor-actualizarHotel">
      <button class="cerrar-actualizarHotel">Cerrar</button>
      <!-- FORMULARIO DE ACTUALIZAR -->
      <form method="post" action="hotel_actualizar.php">
        <h1>Actualizar Hotel</h1>
        <input type="text" id="actualizar-id_hotel" name="idHotel" placeholder = "ID Hotel" readonly><br>
        <input type="text" id="actualizar-nombre_hotel" name="nombre_hotel" placeholder = "Nombre"><br>
        <input type="text" id="actualizar-categoria_hotel" name="categoria" placeholder = "Categoria"><br>
        <input type="text" id="actualizar-noHabitaciones_hotel" name="noHabitaciones" placeholder = "No. Habitaciones"><br>
        <button type="submit" name="insertarHotel" class="actulizar-hotel-boton">Actualizar hotel</button>
      </form>
    </div>

    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

  <!-- BLOQUE PARA INSERTAR REGISTRO -->
  <div class="contenedor-insertarRegistro">
    <button class="cerrar-insertarRegistro">Cerrar</button>
    <!-- FORMULARIO DE INSERTAR -->
    <form method="post" action="registro_insertar.php" class="form-registro">
      <h1>Insertar Registro</h1>
        <div class="bloque1">
          <label for="registro_fecha_ingres"">Fecha ingreso</label>
          <input type="date" id="registro_fecha_ingreso" name="registro_fecha_ingreso" required><br>
          <label for="registro_fecha_ingres">Fecha salida</label>
          <input type="date" id="registro_fecha_salida" name="registro_fecha_salida" placeholder = "Fecha de Salida" required><br>
          <label for="registro_origen">Origen</label>
          <select id="registro_origen" name="registro_origen" required>
            <option value="origen" readonly>Seleccionar Origen</option>
            <?php
            // Realizar una consulta para obtener los valores de la columna nombre_rol
            $query = "SELECT nombre_origen, idOrigen FROM lugar_origen";
            $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);
            // Imprimir cada valor obtenido en un elemento option del select
            while($fila = mysqli_fetch_assoc($resultado)) {
              echo '<option value="' . $fila['idOrigen'] . '">' . $fila['nombre_origen'] . '</option>';
            }
            ?>
          </select><br>
          
          <label for="registro_motivo">Motivo de estadía</label>
          <select id="registro_motivo" name="registro_motivo" required>
            <option value="origen" readonly>Motivo de estadia</option>
            <?php
            // Realizar una consulta para obtener los valores de la columna nombre_rol
            $query = "SELECT motivo_estadia, idEstadia FROM tipo_estadia";
            $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);
            // Imprimir cada valor obtenido en un elemento option del select
            while($fila = mysqli_fetch_assoc($resultado)) {
              echo '<option value="' . $fila['idEstadia'] . '">' . $fila['motivo_estadia'] . '</option>';
            }
            ?>
          </select><br>
        </div>
        
        <div class="bloque2">
          <label for="registro_habitacion">Habitación</label>
          <select id="registro_habitacion" name="registro_habitacion" required>
            <option value="habitacion" readonly>Seleccionar Habitacion</option>
            <?php
            // Realizar una consulta para obtener los valores de la columna nombre_rol
            $query = "SELECT nombre, idHabitacion FROM tipo_habitacion";
            $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);
            // Imprimir cada valor obtenido en un elemento option del select
            while($fila = mysqli_fetch_assoc($resultado)) {
              echo '<option value="' . $fila['idHabitacion'] . '">' . $fila['nombre'] . '</option>';
            }
            ?>
          </select><br>
          
          <label for="registro_costodia">Costo</label>
          <input type="number" name="registro_costodia" id="registro_costodia" placeholder = "Costo / Dia" required readonly>
          <label for="registro_rfc">Registrado por:</label>
          <input type="text" name="registro_rfc" id="registro_rfc" readonly="true" value="<?php echo $rfc?>">
        </div>
      <button type="submit" name="insertarRegistro" class="insertar-Registro">Insertar Registro</button>
    </form>
  </div>
  <!-- BLOQUE EDICION REGISTRO -->
  <div class="contenedor-actualizarRegistro">
    <button class="cerrar-actualizarRegistro">Cerrar</button> 
    <!-- FORMULARIO DE ACTUALIZAR -->
    <form method="post" action="registro_actualizar.php">
      <h1>Actualizar Registro</h1>
        <input type="text" readonly="true" id="actualizar-idRegistro" name="actualizar-idRegistro" placeholder = "ID Registro" required><br>
        <input type="date" id="actualizar-ingresoRegistro" name="actualizar-ingresoRegistro" placeholder = "Fecha de Ingreso" required><br>
        <input type="date" id="actualizar-salidaRegistro" name="actualizar-salidaRegistro" placeholder = "Fecha de Salida" required><br>
        <select id="actualizar-origenRegistro" name="actualizar-origenRegistro" required>
          <option value="origen" readonly>Seleccionar Origen</option>
          <?php
          // Realizar una consulta para obtener los valores de la columna nombre_rol
          $query = "SELECT nombre_origen, idOrigen FROM lugar_origen";
          $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);
          // Imprimir cada valor obtenido en un elemento option del select
          while($fila = mysqli_fetch_assoc($resultado)) {
            echo '<option value="' . $fila['idOrigen'] . '">' . $fila['nombre_origen'] . '</option>';
          }
        ?>
        </select><br>

        <select id="actualizar-motivoRegistro" name="actualizar-motivoRegistro" required>
          <option value="origen" readonly>Motivo de estadia</option>
          <?php
          // Realizar una consulta para obtener los valores de la columna nombre_rol
          $query = "SELECT motivo_estadia, idEstadia FROM tipo_estadia";
          $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);
          // Imprimir cada valor obtenido en un elemento option del select
          while($fila = mysqli_fetch_assoc($resultado)) {
            echo '<option value="' . $fila['idEstadia'] . '">' . $fila['motivo_estadia'] . '</option>';
          }
        ?>
        </select><br>

        <select id="actualizar-habitacionRegistro" name="actualizar-habitacionRegistro" required>
          <option value="habitacion" readonly>Seleccionar Habitacion</option>
          <?php
          // Realizar una consulta para obtener los valores de la columna nombre_rol
          $query = "SELECT nombre, idHabitacion FROM tipo_habitacion";
          $resultado = mysqli_query(mysqli_connect('localhost', 'root', '', 'hotel_stat'), $query);
          // Imprimir cada valor obtenido en un elemento option del select
          while($fila = mysqli_fetch_assoc($resultado)) {
            echo '<option value="' . $fila['idHabitacion'] . '">' . $fila['nombre'] . '</option>';
          }
        ?>
        </select><br>
        <input type="number" name="actualizar-registroCostodia" id="actualizar-registroCostodia" placeholder = "Costro / Dia" required>
        <input type="text" name="actualizar-rfcRegistro" id="actualizar-rfcRegistro" readonly="true">

        <button type="submit" name="insertarRegistro" class="actulizar-registro-boton">Actualizar Registro</button>
    </form>
  </div> 
<!-- FIN ENCABEZADOS -->


<!-- /////////////////////////////////// -->
<!-- HEADER -->
  <div class="nav-contenedor">
      <nav>
        <div class="logo">
            <div class="fondoLogo"></div>
        </div>
        <h2 id="menu-boton">&#9776;</h2>
        <ul id="menu">  
          <?php
            if($rol == "CAPTURISTA"){
              echo '
                <li><a href="index.php">Inicio</a></li>
                <li><a href="registros.php">Registros</a></li>
              ';
            } else if($rol == "ADMINISTRADOR"){
                echo '
                <li><a href="index.php">Inicio</a></li>
                <li><a href="empleados.php">Empleados</a></li>
                <li><a href="estadisticas.php">Estadísticas</a></li>
                ';
            }else if($rol == "JEFE"){
              echo '
                <li><a href="index.php">Inicio</a></li>
                <li><a href="hoteles.php">Hoteles</a></li>
                <li><a href="empleados.php">Empleados</a></li>
                <li><a href="estadisticasJefe.php">Estadísticas</a></li>
              ';
            }
          ?>   
            <?php 
                if(isset($_SESSION['usuario'])){
                    //echo '<li><a href="../paginas/includes/salir.php">Salir</a></li>';
                    echo '
                    <li><a href="../paginas/includes/salir.php">Cerrar Sesión</a></li>
                    <li>
                      <div class="contenedor-informacion">
                        <i class="fa-solid fa-user"></i>
                        <h4>',$usuario,'</h4>
                        <h4>',$rol,'</h4>
                        <h4>',$nombre_hotel,'</h4>
                      </div>
                    </li>
                    </ul>
                    ';
                }
                else {
                    echo '<li><a href="../paginas/includes/salir.php">Iniciar</a></li> </ul>';
                    
                }
            ?>        
        </ul>
      </nav>
  </div>
<!-- FIN HEADER -->
  <main>
<body>