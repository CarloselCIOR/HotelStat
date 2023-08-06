<?php
    include('includes/encabezado.php');
    require_once 'includes/utilerias.php';
    
    $conexion = conectar();
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    //PRIMERO VERIFICAMOS QUE LA VARIABLE DE LA SESIÓN USUARIO NO SERA NULA
    if(isset($_SESSION['usuario'])){
        //EN CASO DE NO SER NULA QUIERE DECIR QUE YA INICIAMOS SESIÓN POR EL LOGIN
        //ENTONCES OBTENEMOS EL NOMBRE Y EL ROL DEL USUARIO LOGEADO
        $rol = $_SESSION['rol']; //ROL
        $nombre = $_SESSION['usuario'];//NOMBRE
        $rfc = $_SESSION['rfc'];
        $idHotel = $_SESSION['idHotel'];
        
    } else {
        echo "Inicia sesión para continuar";
    }
?>
    
<?php
    include('includes/pie.php');
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cabin&family=DM+Sans&family=Mogra&family=Mukta&family=Poppins&family=Quicksand&family=Schibsted+Grotesk:wght@500&family=Ubuntu&display=swap');
    body{
        background: url('../imagenes/bg.jpg');
    }

    .log-div{
        width: 600px;
        height: 300px;
        background: rgba(0,0,0,0.4);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-radius: 10px;
        box-shadow: 8px 8px 12px rgba(0, 0, 0, 0.5);
        transition: box-shadow 0.5s;
        background-position: 100% 0;
        cursor: pointer;
    }

    .log-div:hover {
    box-shadow: 14px 14px 12px rgba(0, 0, 0, 0.5);
    background-position: 0 0;
    }

    .log-div h1{
        font-family: 'Quicksand', cursive;
        letter-spacing: 1px;
        font-size: 5.5rem;
    }

    .log-div h3 {
        font-family: 'Poppins', sans-serif;
        font-size: 1.6rem;
    }
</style>

<body>
    <div class="log-div">
       <h1>HOTELSTAT</h1> 
       <h3>Chiquitibum bombita</h3>
    </div>
</body>