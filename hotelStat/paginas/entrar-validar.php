<?php
    session_start();
    if(!isset($_SESSION['intentos'])){
        $_SESSION['intentos'] = 0;
    }

    include('includes/utilerias.php');
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    //INICIAR SESION
    validarUsuarioClave($usuario, $password);

?>