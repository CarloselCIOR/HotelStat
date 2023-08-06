<?php
//FUNCIÓN PARA REALIZAR LA CONEXIÓN CON LA BASE DE DATOS
    function conectar(){
        DEFINE('SERVIDOR','localhost');
        DEFINE('USUARIO','root');
        DEFINE('PASSWORD', '');
        DEFINE('BD','hotel_stat');

        $resultado = mysqli_connect(SERVIDOR, USUARIO, PASSWORD, BD);
        return $resultado;
    }
//FUNCION QUE VALIDA SI EL USUARIO INGRESÓ SUS CREDENCIALES
//CORRECTAMENTE Y EN CASO DE QUE NO, SE NOTIFICA
    function validarUsuarioClave($usuario, $clave){
        
        $conexion = conectar(); // Obtener la conexión a la base de datos
        // Escapar los valores para prevenir inyección SQL
        $usuario = mysqli_real_escape_string($conexion, $usuario);
        $clave = mysqli_real_escape_string($conexion, $clave);
    
        // Realizar la consulta para validar usuario y contraseña
        $query = "SELECT * FROM usuarios INNER JOIN tipo_rol ON usuarios.rol = tipo_rol.idRol WHERE usuario = '$usuario' AND clave = '$clave'";

        $resultado = mysqli_query($conexion, $query);
    
        // Verificar si la consulta tuvo resultados
        if (mysqli_num_rows($resultado) == 1) {
            // Usuario y contraseña son válidos, se ha iniciado sesión con éxito
            $fila = mysqli_fetch_assoc($resultado);//OBTENEMOS LA FILA DE LA CONSULTA
            //A CONTINUACIÓN SE OBTIENEN TODOS LOS DATOS NECESARIOS Y SE ALMACENAN EN VARIABLES
                $rfc = $fila['rfc'];
                $nombre = $fila['nombre'];
                $usuario = $fila['usuario'];
                $clave = $fila['clave'];
                $rol = $fila['nombre_rol'];
                $idhotel = $fila['idHotel'];  
            $query = "SELECT nombre_hotel, categoria FROM hotel WHERE idHotel = '$idhotel'";
            $resultadoHotel = mysqli_query($conexion, $query);
            $fila = mysqli_fetch_assoc($resultadoHotel);
            $nombre_hotel = $fila['nombre_hotel'];
            $categoria = $fila['categoria'];
            //AQUÍ ESTÁN LAS VARIABLES DE LAS SESSIONES.
            $_SESSION['intentos'] = 0;  
            $_SESSION['usuario'] = $nombre;//AQUÍ COMENZAMOS A TRABAJAR CON EL NOMBRE DEL USUARIO
            $_SESSION['sys_usuario'] = $usuario;
            $_SESSION['rol'] = $rol;  
            $_SESSION['rfc'] = $rfc; 
            $_SESSION['idHotel'] = $idhotel;   
            $_SESSION['nombre_hotel'] = $nombre_hotel; 
            $_SESSION['categoria'] = $categoria; 
            redireccionar("Bienvenido {$nombre}",'index.php');

        } else {
            // Usuario o contraseña son incorrectos
            $_SESSION['intentos']++;//AUMENTAN LOS INTENTOS
            if ($_SESSION['intentos'] >= 5) {
                echo '<script>sessionStorage.setItem("intentos", 5);</script>';
              }

            echo '<script>alert("Datos de inicio de sesión incorrectos"); window.location.href = "login.php";</script>';
        }
        
        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
    }
//FUNCIÓN QUE REDIRECCIONA CON UNA PANTALLA DE CARGA    
    function redireccionar($mensaje, $dir) { 
        include('entrar-salir.php');
        header('refresh:2,url='.$dir);
        //include('includes/pie.php');
    }
//FUNCIÓN QUE ACTUALIZA LOS USUARIOS
    function actualizarUsuario($rfc, $nombre, $usuario, $clave){
        $conexion = conectar();

        //PROTEGEMOS DE LA INSERCIÓN POR SQL
        $rfc = mysqli_real_escape_string($conexion, $rfc);
        $nombre = mysqli_real_escape_string($conexion, $nombre);
        $usuario = mysqli_real_escape_string($conexion, $usuario);
        $clave = mysqli_real_escape_string($conexion, $clave);

        $consulta = "UPDATE usuarios SET nombre = '$nombre',
                                usuario = '$usuario',
                                clave = '$clave'
                                WHERE rfc = '$rfc';";

        if (mysqli_query($conexion, $consulta)) {
            header("Location: empleados.php");
    
        } else {
            echo "Error al actualizar usuario: " . mysqli_error($conexion);
        }
  
        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);

    }
//FUNCIÓN PARA ELIMINAR USUARIOS
    function eliminarUsuarios($rfc){
        $conexion = conectar();
        //PROTEGEMOS DE LA INSERCIÓN POR SQL
        $rfc = mysqli_real_escape_string($conexion, $rfc);
        //CONSULRA ELIMINAR
        $consulta = "DELETE FROM usuarios WHERE rfc='$rfc'";

        if ($conexion->query($consulta) === TRUE) {
            echo "Eliminación exitosa";
          } else {
            echo "Error al eliminar el empleado: " . $conexion->error;
          }
        
        mysqli_close($conexion);
    }
//FUNCIÓN PARA INSERTAR USUARIOS
    function insertarUsuarios($rfc, $nombre, $usuario, $clave, $rol, $hotel){
        
        $conexion = conectar();
        //SEGURIDAD QUE EVITA
        $rfc = mysqli_real_escape_string($conexion, $rfc);
        $nombre = mysqli_real_escape_string($conexion, $nombre);
        $usuario = mysqli_real_escape_string($conexion, $usuario);
        $clave = mysqli_real_escape_string($conexion, $clave);
        $rol = mysqli_real_escape_string($conexion, $rol);
        $hotel = mysqli_real_escape_string($conexion, $hotel);
        //SELECCIONAMOS EL HOTEL
        $obtenerHotel = "SELECT idHotel FROM hotel WHERE nombre_hotel='$hotel'";
        $resultado = mysqli_query($conexion, $obtenerHotel);
        //AHORA VOY A OBTENER LA FILA
        $fila = mysqli_fetch_assoc($resultado);
        $obtenerHotel = $fila['idHotel'];

        $consulta = "INSERT INTO usuarios (rfc, nombre, usuario, clave, rol, idHotel) VALUES ('$rfc', '$nombre', '$usuario', '$clave', '$rol', '$obtenerHotel')";

        // Ejecutar la consulta
        if (mysqli_query($conexion, $consulta)) {
            header("Location: empleados.php");
        } else {
            echo "Error al insertar usuario: " . mysqli_error($conexion);
        }

        mysqli_close($conexion);
    }
//FUNCIÓN PARA ACTUALIZAR HOTELES
    function actualizarHotel($idHotel, $nombrehotel, $categoriahotel, $nohabitacioneshotel){
        $conexion = conectar();

        $idHotel = mysqli_real_escape_string($conexion, $idHotel);
        $nombrehotel = mysqli_real_escape_string($conexion, $nombrehotel);
        $categoriahotel = mysqli_real_escape_string($conexion, $categoriahotel);
        $nohabitacioneshotel = mysqli_real_escape_string($conexion, $nohabitacioneshotel);
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

        mysqli_close($conexion);
    }
//FUNCIÓN PARA ELIMINAR HOTELES
    function eliminarHotel($nombreHotel){
        $conexion = conectar();
        $nombreHotel = mysqli_real_escape_string($conexion, $nombreHotel);
        $sql = "UPDATE usuarios SET idHotel = NULL WHERE idHotel = (SELECT idHotel FROM hotel WHERE nombre_hotel = '$nombreHotel')";  
        if (!$conexion->query($sql)) {
            throw new Exception("Error al actualizar registros de usuarios: " . $conexion->error);
        }
        // Sentencia SQL para eliminar el empleado con el RFC especificado
        $sql = "DELETE FROM hotel WHERE nombre_hotel='$nombreHotel';";
        if ($conexion->query($sql) === TRUE) {
            echo "Eliminación exitosa";
          } else {
            echo "Error al eliminar el empleado: " . $conexion->error;
          }
        mysqli_close($conexion);
    }
//FUNCIÓN INSERTAR HOTELES
    function insertarHotel($nombrehotel, $categoriahotel, $nohabitacioneshotel){
        $conexion = conectar();
        //Preparar la consulta SQL para insertar los datos
        $consulta = "INSERT INTO hotel (nombre_hotel, categoria, noHabitaciones) VALUES ('$nombrehotel', '$categoriahotel', '$nohabitacioneshotel')";

        $nombrehotel = mysqli_real_escape_string($conexion, $nombrehotel);
        $categoriahotel = mysqli_real_escape_string($conexion, $categoriahotel);
        $nohabitacioneshotel = mysqli_real_escape_string($conexion, $nohabitacioneshotel);

        // Ejecutar la consulta
        if (mysqli_query($conexion, $consulta)) {
            header("Location: hoteles.php");

        } else {
        echo "Error al insertar hotel" ;//. mysqli_error($conexion)
        }

        mysqli_close($conexion);
    }
        /////////////////////////////////////////////registros//////////
    function insertarRegistro($registroingreso, $registrosalida, $registroorigen, $registromotivoestadia, $registrohabitacion, $registrocosto, $registropor){
            $conexion = conectar();
            //SEGURIDAD QUE EVITA
            $registroingreso = mysqli_real_escape_string($conexion, $registroingreso);
            $registrosalida = mysqli_real_escape_string($conexion, $registrosalida);
            $registroorigen = mysqli_real_escape_string($conexion, $registroorigen);
            $registromotivoestadia = mysqli_real_escape_string($conexion, $registromotivoestadia);
            $registrohabitacion = mysqli_real_escape_string($conexion, $registrohabitacion);
            $registrocosto = mysqli_real_escape_string($conexion, $registrocosto);
            $registropor = mysqli_real_escape_string($conexion, $registropor);

            $consulta = "INSERT INTO datos_cliente (fechaIngreso, fechaSalida, origen, motivoEstadia, costo, rfc,tipo_habitacion) 
            VALUES ('$registroingreso', '$registrosalida', '$registroorigen', '$registromotivoestadia', '$registrocosto', '$registropor','$registrohabitacion')";
    
            // Ejecutar la consulta
            if (mysqli_query($conexion, $consulta)) {
                header("Location: registros.php");
            } else {
                echo "Error al insertar registro: " . mysqli_error($conexion);
            }
    
            mysqli_close($conexion);
    }

    function eliminarRegistros($idCliente){
        $conexion = conectar();
        //PROTEGEMOS DE LA INSERCIÓN POR SQL
        $idCliente = mysqli_real_escape_string($conexion, $idCliente);
        //CONSULRA ELIMINAR
        $consulta = "DELETE FROM datos_cliente WHERE idCliente='$idCliente'";

        if ($conexion->query($consulta) === TRUE) {
            echo "Eliminación exitosa";
          } else {
            echo "Error al eliminar el Registro: " . $conexion->error;
          }
        
        mysqli_close($conexion);
    }

    function actualizarRegistro(
        $registroidRegistro, 
        $registroingreso, 
        $registrosalida, 
        $registroorigen,
        $registromotivoestadia,
        $registrohabitacion,
        $registrocosto,
        $registropor){

        $conexion = conectar();

        $registroidRegistro = mysqli_real_escape_string($conexion, $registroidRegistro);
        $registroingreso = mysqli_real_escape_string($conexion, $registroingreso);
        $registrosalida = mysqli_real_escape_string($conexion, $registrosalida);
        $registroorigen = mysqli_real_escape_string($conexion, $registroorigen);
        $registromotivoestadia = mysqli_real_escape_string($conexion, $registromotivoestadia);
        $registrohabitacion = mysqli_real_escape_string($conexion, $registrohabitacion);
        $registrocosto = mysqli_real_escape_string($conexion, $registrocosto);
        $registropor = mysqli_real_escape_string($conexion, $registropor);
        //Preparar la consulta SQL para insertar los datos
        $consulta = "UPDATE datos_cliente SET 
        idCliente = '$registroidRegistro',
        fechaIngreso = '$registroingreso',
        fechaSalida = '$registrosalida',
        origen = '$registroorigen',	
        motivoEstadia = '$registromotivoestadia',	
        costo = '$registrocosto',	
        rfc = '$registropor',	
        tipo_habitacion = '$registrohabitacion'
        WHERE idCliente = '$registroidRegistro';";

        // Ejecutar la consulta
        if (mysqli_query($conexion, $consulta)) {
            header("Location: registros.php");
        } else {

            echo "Error al actualizar registro: " . mysqli_error($conexion);
        }

        mysqli_close($conexion);
    }

    function conexionGraficar($hotel, $categoria) {
        $conexion = conectar();
        list($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro) = graficar($conexion, $hotel);
        list($valores2, $lugOrigen2, $can3, $motivo2, $can4, $fecha2, $costoPro2) = graficar2($conexion, $hotel);
        list($valores3, $lugOrigen3, $can5, $motivo3, $can6, $fecha3, $costoPro3) = graficar3($conexion, $hotel);
        list($valores4, $lugOrigen4, $can7, $motivo4, $can8, $fecha4, $costoPro4) = graficar4($conexion, $categoria);
        
        return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro,
        $valores2, $lugOrigen2, $can3, $motivo2, $can4, $fecha2, $costoPro2,
        $valores3, $lugOrigen3, $can5, $motivo3, $can6, $fecha3, $costoPro3,
        $valores4, $lugOrigen4, $can7, $motivo4, $can8, $fecha4, $costoPro4);
    }

    function conexionGraficarJefe() {
        $conexion = conectar();
        list($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro) = graficarJefe($conexion);
        list($valores2, $lugOrigen2, $can3, $motivo2, $can4, $fecha2, $costoPro2) = graficarJefe2($conexion);
        list($valores3, $lugOrigen3, $can5, $motivo3, $can6, $fecha3, $costoPro3) = graficarJefe3($conexion);
        list($valores4, $lugOrigen4, $can7, $motivo4, $can8, $fecha4, $costoPro4) = graficarJefe4($conexion);
        list($valores5, $lugOrigen5, $can9, $motivo5, $can10, $fecha5, $costoPro5) = graficarJefe5($conexion);
        list($valores6, $lugOrigen6, $can11, $motivo6, $can12, $fecha6, $costoPro6) = graficarJefe6($conexion);
        list($valores7, $lugOrigen7, $can13, $motivo7, $can14, $fecha7, $costoPro7) = graficarJefe7($conexion);
        list($valores8, $lugOrigen8, $can15, $motivo8, $can16, $fecha8, $costoPro8) = graficarJefe8($conexion);
        
        return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro,
        $valores2, $lugOrigen2, $can3, $motivo2, $can4, $fecha2, $costoPro2,
        $valores3, $lugOrigen3, $can5, $motivo3, $can6, $fecha3, $costoPro3,
        $valores4, $lugOrigen4, $can7, $motivo4, $can8, $fecha4, $costoPro4,
        $valores5, $lugOrigen5, $can9, $motivo5, $can10, $fecha5, $costoPro5,
        $valores6, $lugOrigen6, $can11, $motivo6, $can12, $fecha6, $costoPro6,
        $valores7, $lugOrigen7, $can13, $motivo7, $can14, $fecha7, $costoPro7,
        $valores8, $lugOrigen8, $can15, $motivo8, $can16, $fecha8, $costoPro8);
    }

    //////////////////////////////////////////
    function graficar($conexion, $hotel) {
        ///BLOQUER DE OCUPACION
            // Consulta SQL para obtener la ocupacion de las habitaciones
            $sql = "SELECT h.noHabitaciones as Habitaciones, COUNT(*) as Ocupadas FROM datos_cliente c 
            INNER JOIN usuarios u ON c.rfc = u.rfc
            INNER JOIN hotel h ON u.idHotel = h.idHotel
            WHERE h.idHotel = '$hotel' AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
            $result = mysqli_query($conexion, $sql);
            //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS Y EL NÚMERO DE HABITACIONES OCUPADAS
            while($row = mysqli_fetch_assoc($result)) {
                $vacio = $row["Habitaciones"] - $row["Ocupadas"];
                $ocupado = $row["Ocupadas"];
            }
            //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
            $valores = [$vacio, $ocupado];
        ///BLOQUER DE LUGARES
            $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN usuarios u ON c.rfc = u.rfc
                    INNER JOIN hotel h ON u.idHotel = h.idHotel
                    INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                    WHERE h.idHotel = '$hotel' AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                    GROUP BY o.nombre_origen";
            $result = mysqli_query($conexion, $sql);
            $lugOrigen = array();
            $can = array();

            while($row = mysqli_fetch_assoc($result)) {
                $lugOrigen[] = $row["ori"];
                $can[] = $row["cantidad"];
            }
        ///BLOQUER DE ESTADIA
            $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN usuarios u ON c.rfc = u.rfc
                    INNER JOIN hotel h ON u.idHotel = h.idHotel
                    INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                    WHERE h.idHotel = '$hotel' AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                    GROUP BY e.motivo_estadia";

            $result = mysqli_query($conexion, $sql);
            $motivo = array();
            $can2 = array();

            while($row = mysqli_fetch_assoc($result)) {
                $motivo[] = $row["estadia"];
                $can2[] = $row["cantidad"];
            }
        ///BLOQUER DE TARIFA
        $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                INNER JOIN usuarios u ON c.rfc = u.rfc
                INNER JOIN hotel h ON u.idHotel = h.idHotel
                WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND h.idHotel = '$hotel'
                GROUP BY c.fechaIngreso";

        $result = mysqli_query($conexion, $sql);
        $fecha = array();
        $costoPro = array();

        while($row = mysqli_fetch_assoc($result)) {
            $fecha[] = $row["fecha"];
            $costoPro[] = $row["costo"]/ $row["cantidad"];
        }
        return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
    }

    //////////////////////////////////////////
    function graficar2($conexion, $hotel) {
        ///BLOQUER DE OCUPACION
            // Consulta SQL para obtener la ocupacion de las habitaciones
            $sql = "SELECT h.noHabitaciones as Habitaciones, COUNT(*) as Ocupadas FROM datos_cliente c 
            INNER JOIN usuarios u ON c.rfc = u.rfc
            INNER JOIN hotel h ON u.idHotel = h.idHotel
            WHERE h.idHotel = '$hotel' AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
            $result = mysqli_query($conexion, $sql);
            //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS Y EL NÚMERO DE HABITACIONES OCUPADAS
            while($row = mysqli_fetch_assoc($result)) {
                $vacio = $row["Habitaciones"] - $row["Ocupadas"];
                $ocupado = $row["Ocupadas"];
            }
            //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
            $valores = [$vacio, $ocupado];
        ///BLOQUER DE LUGARES
            $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN usuarios u ON c.rfc = u.rfc
                    INNER JOIN hotel h ON u.idHotel = h.idHotel
                    INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                    WHERE h.idHotel = '$hotel' AND fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY o.nombre_origen";
            $result = mysqli_query($conexion, $sql);
            $lugOrigen = array();
            $can = array();

            while($row = mysqli_fetch_assoc($result)) {
                $lugOrigen[] = $row["ori"];
                $can[] = $row["cantidad"];
            }
        ///BLOQUER DE ESTADIA
            $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN usuarios u ON c.rfc = u.rfc
                    INNER JOIN hotel h ON u.idHotel = h.idHotel
                    INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                    WHERE h.idHotel = '$hotel' AND fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY e.motivo_estadia";

            $result = mysqli_query($conexion, $sql);
            $motivo = array();
            $can2 = array();

            while($row = mysqli_fetch_assoc($result)) {
                $motivo[] = $row["estadia"];
                $can2[] = $row["cantidad"];
            }
        ///BLOQUER DE TARIFA
        $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                INNER JOIN usuarios u ON c.rfc = u.rfc
                INNER JOIN hotel h ON u.idHotel = h.idHotel
                WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND h.idHotel = '$hotel'";

        $result = mysqli_query($conexion, $sql);
        $fecha = array();
        $costoPro = array();

        while($row = mysqli_fetch_assoc($result)) {
            $fecha[] = $row["fecha"];
            if($row["cantidad"] == 0) {
                $costoPro[] = 0;
            } else {
                $costoPro[] = $row["costo"]/ $row["cantidad"];
            }
        }
        return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
    }
    
    //////////////////////////////////////////
    function graficar3($conexion, $hotel) {
        ///BLOQUER DE OCUPACION
            // Consulta SQL para obtener la ocupacion de las habitaciones
            $sql = "SELECT h.noHabitaciones as Habitaciones, COUNT(*) as Ocupadas FROM datos_cliente c 
            INNER JOIN usuarios u ON c.rfc = u.rfc
            INNER JOIN hotel h ON u.idHotel = h.idHotel
            WHERE h.idHotel = '$hotel' AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
            $result = mysqli_query($conexion, $sql);
            //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS Y EL NÚMERO DE HABITACIONES OCUPADAS
            while($row = mysqli_fetch_assoc($result)) {
                $vacio = $row["Habitaciones"] - $row["Ocupadas"];
                $ocupado = $row["Ocupadas"];
            }
            //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
            $valores = [$vacio, $ocupado];
        ///BLOQUER DE LUGARES
            $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN usuarios u ON c.rfc = u.rfc
                    INNER JOIN hotel h ON u.idHotel = h.idHotel
                    INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                    WHERE h.idHotel = '$hotel' AND fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                    GROUP BY o.nombre_origen";
            $result = mysqli_query($conexion, $sql);
            $lugOrigen = array();
            $can = array();

            while($row = mysqli_fetch_assoc($result)) {
                $lugOrigen[] = $row["ori"];
                $can[] = $row["cantidad"];
            }
        ///BLOQUER DE ESTADIA
            $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN usuarios u ON c.rfc = u.rfc
                    INNER JOIN hotel h ON u.idHotel = h.idHotel
                    INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                    WHERE h.idHotel = '$hotel' AND fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                    GROUP BY e.motivo_estadia";

            $result = mysqli_query($conexion, $sql);
            $motivo = array();
            $can2 = array();

            while($row = mysqli_fetch_assoc($result)) {
                $motivo[] = $row["estadia"];
                $can2[] = $row["cantidad"];
            }
        ///BLOQUER DE TARIFA
        $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                INNER JOIN usuarios u ON c.rfc = u.rfc
                INNER JOIN hotel h ON u.idHotel = h.idHotel
                WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND h.idHotel = '$hotel'";

        $result = mysqli_query($conexion, $sql);
        $fecha = array();
        $costoPro = array();

        while($row = mysqli_fetch_assoc($result)) {
            $fecha[] = $row["fecha"];
            if($row["cantidad"] == 0) {
                $costoPro[] = 0;
            } else {
                $costoPro[] = $row["costo"]/ $row["cantidad"];
            }
        }
        return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
    }
    
    //////////////////////////////////////////
    function graficar4($conexion, $categoria) {
        ///BLOQUER DE OCUPACION
            // Consulta SQL para obtener la ocupacion de las habitaciones
            $sql = "SELECT COUNT(*) as Ocupadas FROM datos_cliente c 
            INNER JOIN usuarios u ON c.rfc = u.rfc
            INNER JOIN hotel h ON u.idHotel = h.idHotel
            WHERE h.categoria = '$categoria' AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
            $result = mysqli_query($conexion, $sql);
            //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
            while($row = mysqli_fetch_assoc($result)) {
                $ocupado = $row["Ocupadas"];
            }

            // Consulta SQL para obtener la ocupacion de las habitaciones
            $sql = "SELECT SUM(noHabitaciones) AS Habitaciones FROM hotel
            WHERE categoria = '$categoria'";
            $result = mysqli_query($conexion, $sql);
            //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
            while($row = mysqli_fetch_assoc($result)) {
                $vacio = $row["Habitaciones"];
            }
            $vacio = $vacio - $ocupado;
            //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
            $valores = [$vacio, $ocupado];
        ///BLOQUER DE LUGARES
            $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN usuarios u ON c.rfc = u.rfc
                    INNER JOIN hotel h ON u.idHotel = h.idHotel
                    INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                    WHERE h.categoria = '$categoria' AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                    GROUP BY o.nombre_origen";
            $result = mysqli_query($conexion, $sql);
            $lugOrigen = array();
            $can = array();

            while($row = mysqli_fetch_assoc($result)) {
                $lugOrigen[] = $row["ori"];
                $can[] = $row["cantidad"];
            }
        ///BLOQUER DE ESTADIA
            $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN usuarios u ON c.rfc = u.rfc
                    INNER JOIN hotel h ON u.idHotel = h.idHotel
                    INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                    WHERE h.categoria = '$categoria' AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                    GROUP BY e.motivo_estadia";

            $result = mysqli_query($conexion, $sql);
            $motivo = array();
            $can2 = array();

            while($row = mysqli_fetch_assoc($result)) {
                $motivo[] = $row["estadia"];
                $can2[] = $row["cantidad"];
            }
        ///BLOQUER DE TARIFA
        $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                INNER JOIN usuarios u ON c.rfc = u.rfc
                INNER JOIN hotel h ON u.idHotel = h.idHotel
                WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND h.categoria = '$categoria'
                GROUP BY c.fechaIngreso";

        $result = mysqli_query($conexion, $sql);
        $fecha = array();
        $costoPro = array();

        while($row = mysqli_fetch_assoc($result)) {
            $fecha[] = $row["fecha"];
            $costoPro[] = $row["costo"]/ $row["cantidad"];
        }
        return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
    }

    //////////////////////////////////////////
    function graficarJefe($conexion) {
        $sql = "SELECT COUNT(*) as ocupadas FROM datos_cliente
                WHERE fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
        $result = mysqli_query($conexion, $sql);
        //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
        while($row = mysqli_fetch_assoc($result)) {
            $ocupado = $row["ocupadas"];
        }
        //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
        $sql = "SELECT SUM(noHabitaciones) as habitaciones FROM hotel";
        $result = mysqli_query($conexion, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $vacio = $row["habitaciones"];
        }
        $vacio = $vacio - $ocupado;
        //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
        $valores = [$vacio, $ocupado];
        ///BLOQUER DE LUGARES
            $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                    WHERE fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                    GROUP BY o.nombre_origen";
            $result = mysqli_query($conexion, $sql);
            $lugOrigen = array();
            $can = array();

            while($row = mysqli_fetch_assoc($result)) {
                $lugOrigen[] = $row["ori"];
                $can[] = $row["cantidad"];
            }
        ///BLOQUER DE ESTADIA
            $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                    WHERE fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                    GROUP BY e.motivo_estadia";

            $result = mysqli_query($conexion, $sql);
            $motivo = array();
            $can2 = array();

            while($row = mysqli_fetch_assoc($result)) {
                $motivo[] = $row["estadia"];
                $can2[] = $row["cantidad"];
            }
            ///BLOQUER DE TARIFA
            $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                    WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY c.fechaIngreso";

            $result = mysqli_query($conexion, $sql);
            $fecha = array();
            $costoPro = array();

            while($row = mysqli_fetch_assoc($result)) {
                $fecha[] = $row["fecha"];
                $costoPro[] = $row["costo"]/ $row["cantidad"];
            }
            return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
        }

        //////////////////////////////////////////
    function graficarJefe2($conexion) {
        $sql = "SELECT COUNT(*) as ocupadas FROM datos_cliente
                WHERE fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
        $result = mysqli_query($conexion, $sql);
        //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
        while($row = mysqli_fetch_assoc($result)) {
            $ocupado = $row["ocupadas"];
        }
        //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
        $sql = "SELECT SUM(noHabitaciones) as habitaciones FROM hotel";
        $result = mysqli_query($conexion, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $vacio = $row["habitaciones"];
        }
        $vacio = $vacio - $ocupado;
        //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
        $valores = [$vacio, $ocupado];
        ///BLOQUER DE LUGARES
            $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                    WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY o.nombre_origen";
            $result = mysqli_query($conexion, $sql);
            $lugOrigen = array();
            $can = array();

            while($row = mysqli_fetch_assoc($result)) {
                $lugOrigen[] = $row["ori"];
                $can[] = $row["cantidad"];
            }
        ///BLOQUER DE ESTADIA
            $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                    INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                    WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY e.motivo_estadia";

            $result = mysqli_query($conexion, $sql);
            $motivo = array();
            $can2 = array();

            while($row = mysqli_fetch_assoc($result)) {
                $motivo[] = $row["estadia"];
                $can2[] = $row["cantidad"];
            }
            ///BLOQUER DE TARIFA
            $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                    WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";

            $result = mysqli_query($conexion, $sql);
            $fecha = array();
            $costoPro = array();

            while($row = mysqli_fetch_assoc($result)) {
                $fecha[] = $row["fecha"];
                $costoPro[] = $row["costo"]/ $row["cantidad"];
            }
            return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
        }

        //////////////////////////////////////////
        function graficarJefe3($conexion) {
            $sql = "SELECT COUNT(*) as ocupadas FROM datos_cliente
                    WHERE fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
            $result = mysqli_query($conexion, $sql);
            //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
            while($row = mysqli_fetch_assoc($result)) {
                $ocupado = $row["ocupadas"];
            }
            //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
            $sql = "SELECT SUM(noHabitaciones) as habitaciones FROM hotel";
            $result = mysqli_query($conexion, $sql);
            while($row = mysqli_fetch_assoc($result)) {
                $vacio = $row["habitaciones"];
            }
            $vacio = $vacio - $ocupado;
            //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
            $valores = [$vacio, $ocupado];
            ///BLOQUER DE LUGARES
                $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                        INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                        WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                        GROUP BY o.nombre_origen";
                $result = mysqli_query($conexion, $sql);
                $lugOrigen = array();
                $can = array();
    
                while($row = mysqli_fetch_assoc($result)) {
                    $lugOrigen[] = $row["ori"];
                    $can[] = $row["cantidad"];
                }
            ///BLOQUER DE ESTADIA
                $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                        INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                        WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                        GROUP BY e.motivo_estadia";
    
                $result = mysqli_query($conexion, $sql);
                $motivo = array();
                $can2 = array();
    
                while($row = mysqli_fetch_assoc($result)) {
                    $motivo[] = $row["estadia"];
                    $can2[] = $row["cantidad"];
                }
                ///BLOQUER DE TARIFA
                $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                        WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    
                $result = mysqli_query($conexion, $sql);
                $fecha = array();
                $costoPro = array();
    
                while($row = mysqli_fetch_assoc($result)) {
                    $fecha[] = $row["fecha"];
                    $costoPro[] = $row["costo"]/ $row["cantidad"];
                }
                return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
            }

            //////////////////////////////////////////
            function graficarJefe4($conexion) {
                $sql = "SELECT COUNT(*) as ocupadas FROM datos_cliente c
                        INNER JOIN usuarios u ON c.rfc = u.rfc
                        INNER JOIN hotel h ON u.idHotel = h.idHotel
                        WHERE h.categoria = 1 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
                $result = mysqli_query($conexion, $sql);
                //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
                while($row = mysqli_fetch_assoc($result)) {
                    $ocupado = $row["ocupadas"];
                }
                //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
                $sql = "SELECT SUM(noHabitaciones) as habitaciones FROM hotel
                        WHERE categoria = 1";
                $result = mysqli_query($conexion, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    $vacio = $row["habitaciones"];
                }
                $vacio = $vacio - $ocupado;
                //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
                $valores = [$vacio, $ocupado];
                ///BLOQUER DE LUGARES
                    $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                            WHERE h.categoria = 1 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY o.nombre_origen";
                    $result = mysqli_query($conexion, $sql);
                    $lugOrigen = array();
                    $can = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $lugOrigen[] = $row["ori"];
                        $can[] = $row["cantidad"];
                    }
                ///BLOQUER DE ESTADIA
                    $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                            WHERE h.categoria = 1 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY e.motivo_estadia";
        
                    $result = mysqli_query($conexion, $sql);
                    $motivo = array();
                    $can2 = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $motivo[] = $row["estadia"];
                        $can2[] = $row["cantidad"];
                    }
                    ///BLOQUER DE TARIFA
                    $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND h.categoria = 1
                            GROUP BY c.fechaIngreso";
        
                    $result = mysqli_query($conexion, $sql);
                    $fecha = array();
                    $costoPro = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $fecha[] = $row["fecha"];
                        $costoPro[] = $row["costo"]/ $row["cantidad"];
                    }
                    return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
                }

            //////////////////////////////////////////
            function graficarJefe5($conexion) {
                $sql = "SELECT COUNT(*) as ocupadas FROM datos_cliente c
                        INNER JOIN usuarios u ON c.rfc = u.rfc
                        INNER JOIN hotel h ON u.idHotel = h.idHotel
                        WHERE h.categoria = 2 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
                $result = mysqli_query($conexion, $sql);
                //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
                while($row = mysqli_fetch_assoc($result)) {
                    $ocupado = $row["ocupadas"];
                }
                //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
                $sql = "SELECT SUM(noHabitaciones) as habitaciones FROM hotel
                        WHERE categoria = 2";
                $result = mysqli_query($conexion, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    $vacio = $row["habitaciones"];
                }
                $vacio = $vacio - $ocupado;
                //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
                $valores = [$vacio, $ocupado];
                ///BLOQUER DE LUGARES
                    $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                            WHERE h.categoria = 2 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY o.nombre_origen";
                    $result = mysqli_query($conexion, $sql);
                    $lugOrigen = array();
                    $can = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $lugOrigen[] = $row["ori"];
                        $can[] = $row["cantidad"];
                    }
                ///BLOQUER DE ESTADIA
                    $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                            WHERE h.categoria = 2 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY e.motivo_estadia";
        
                    $result = mysqli_query($conexion, $sql);
                    $motivo = array();
                    $can2 = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $motivo[] = $row["estadia"];
                        $can2[] = $row["cantidad"];
                    }
                    ///BLOQUER DE TARIFA
                    $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND h.categoria = 2
                            GROUP BY c.fechaIngreso";
        
                    $result = mysqli_query($conexion, $sql);
                    $fecha = array();
                    $costoPro = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $fecha[] = $row["fecha"];
                        $costoPro[] = $row["costo"]/ $row["cantidad"];
                    }
                    return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
                }

            //////////////////////////////////////////
            function graficarJefe6($conexion) {
                $sql = "SELECT COUNT(*) as ocupadas FROM datos_cliente c
                        INNER JOIN usuarios u ON c.rfc = u.rfc
                        INNER JOIN hotel h ON u.idHotel = h.idHotel
                        WHERE h.categoria = 3 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
                $result = mysqli_query($conexion, $sql);
                //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
                while($row = mysqli_fetch_assoc($result)) {
                    $ocupado = $row["ocupadas"];
                }
                //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
                $sql = "SELECT SUM(noHabitaciones) as habitaciones FROM hotel
                        WHERE categoria = 3";
                $result = mysqli_query($conexion, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    $vacio = $row["habitaciones"];
                }
                $vacio = $vacio - $ocupado;
                //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
                $valores = [$vacio, $ocupado];
                ///BLOQUER DE LUGARES
                    $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                            WHERE h.categoria = 3 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY o.nombre_origen";
                    $result = mysqli_query($conexion, $sql);
                    $lugOrigen = array();
                    $can = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $lugOrigen[] = $row["ori"];
                        $can[] = $row["cantidad"];
                    }
                ///BLOQUER DE ESTADIA
                    $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                            WHERE h.categoria = 3 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY e.motivo_estadia";
        
                    $result = mysqli_query($conexion, $sql);
                    $motivo = array();
                    $can2 = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $motivo[] = $row["estadia"];
                        $can2[] = $row["cantidad"];
                    }
                    ///BLOQUER DE TARIFA
                    $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND h.categoria = 3
                            GROUP BY c.fechaIngreso";
        
                    $result = mysqli_query($conexion, $sql);
                    $fecha = array();
                    $costoPro = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $fecha[] = $row["fecha"];
                        $costoPro[] = $row["costo"]/ $row["cantidad"];
                    }
                    return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
                }

            //////////////////////////////////////////
            function graficarJefe7($conexion) {
                $sql = "SELECT COUNT(*) as ocupadas FROM datos_cliente c
                        INNER JOIN usuarios u ON c.rfc = u.rfc
                        INNER JOIN hotel h ON u.idHotel = h.idHotel
                        WHERE h.categoria = 4 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
                $result = mysqli_query($conexion, $sql);
                //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
                while($row = mysqli_fetch_assoc($result)) {
                    $ocupado = $row["ocupadas"];
                }
                //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
                $sql = "SELECT SUM(noHabitaciones) as habitaciones FROM hotel
                        WHERE categoria = 4";
                $result = mysqli_query($conexion, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    $vacio = $row["habitaciones"];
                }
                $vacio = $vacio - $ocupado;
                //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
                $valores = [$vacio, $ocupado];
                ///BLOQUER DE LUGARES
                    $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                            WHERE h.categoria = 4 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY o.nombre_origen";
                    $result = mysqli_query($conexion, $sql);
                    $lugOrigen = array();
                    $can = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $lugOrigen[] = $row["ori"];
                        $can[] = $row["cantidad"];
                    }
                ///BLOQUER DE ESTADIA
                    $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                            WHERE h.categoria = 4 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY e.motivo_estadia";
        
                    $result = mysqli_query($conexion, $sql);
                    $motivo = array();
                    $can2 = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $motivo[] = $row["estadia"];
                        $can2[] = $row["cantidad"];
                    }
                    ///BLOQUER DE TARIFA
                    $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND h.categoria = 4
                            GROUP BY c.fechaIngreso";
        
                    $result = mysqli_query($conexion, $sql);
                    $fecha = array();
                    $costoPro = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $fecha[] = $row["fecha"];
                        $costoPro[] = $row["costo"]/ $row["cantidad"];
                    }
                    return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
                }

            //////////////////////////////////////////
            function graficarJefe8($conexion) {
                $sql = "SELECT COUNT(*) as ocupadas FROM datos_cliente c
                        INNER JOIN usuarios u ON c.rfc = u.rfc
                        INNER JOIN hotel h ON u.idHotel = h.idHotel
                        WHERE h.categoria = 5 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()";
                $result = mysqli_query($conexion, $sql);
                //OBTENEMOS EL NÚMERO DE HABITACIONES OCUPADAS
                while($row = mysqli_fetch_assoc($result)) {
                    $ocupado = $row["ocupadas"];
                }
                //OBTENEMOS EL NÚMERO DE HABITACIONES VACÍAS
                $sql = "SELECT SUM(noHabitaciones) as habitaciones FROM hotel
                        WHERE categoria = 5";
                $result = mysqli_query($conexion, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    $vacio = $row["habitaciones"];
                }
                $vacio = $vacio - $ocupado;
                //CREAMOS UN ARREGLO DONDE LE PASAMOS LA OCUPACIÓN
                $valores = [$vacio, $ocupado];
                ///BLOQUER DE LUGARES
                    $sql = "SELECT o.nombre_origen as ori, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN lugar_origen o ON c.origen = o.idOrigen
                            WHERE h.categoria = 5 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY o.nombre_origen";
                    $result = mysqli_query($conexion, $sql);
                    $lugOrigen = array();
                    $can = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $lugOrigen[] = $row["ori"];
                        $can[] = $row["cantidad"];
                    }
                ///BLOQUER DE ESTADIA
                    $sql = "SELECT e.motivo_estadia as estadia, COUNT(*) as cantidad FROM datos_cliente c 
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            INNER JOIN tipo_estadia e ON c.motivoEstadia = e.idEstadia
                            WHERE h.categoria = 5 AND fechaSalida >= CURDATE() AND fechaIngreso <= CURDATE()
                            GROUP BY e.motivo_estadia";
        
                    $result = mysqli_query($conexion, $sql);
                    $motivo = array();
                    $can2 = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $motivo[] = $row["estadia"];
                        $can2[] = $row["cantidad"];
                    }
                    ///BLOQUER DE TARIFA
                    $sql = "SELECT c.fechaIngreso as fecha, SUM(c.costo) as costo, COUNT(*) as cantidad FROM datos_cliente c
                            INNER JOIN usuarios u ON c.rfc = u.rfc
                            INNER JOIN hotel h ON u.idHotel = h.idHotel
                            WHERE fechaIngreso <= CURDATE() AND fechaIngreso >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND h.categoria = 5
                            GROUP BY c.fechaIngreso";
        
                    $result = mysqli_query($conexion, $sql);
                    $fecha = array();
                    $costoPro = array();
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $fecha[] = $row["fecha"];
                        $costoPro[] = $row["costo"]/ $row["cantidad"];
                    }
                    return array($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro);
                }
?>