<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loading</title>
  <link rel="stylesheet"../../estilos/cargando.css">
</head>
<body>
    <h1>Cargando...</h1>
    <div class="loader">
      <div class="cube"></div>
    </div>
</body>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cabin&family=Schibsted+Grotesk:wght@500&display=swap');

body {
  background-color: #032b3d;
}

h1  {
  text-align: center;
  color: white;
  font-size: 2.2rem;
  letter-spacing: 2px;
  padding: 100px 0 0 0;
  font-family: 'Schibsted Grotesk';
}

.loader {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  align-self: center;
  margin-top:30vh;
}

.cube {
  width: 50px;
  height: 50px;
  border: 5px solid white;
  border-top: 5px solid transparent;
  border-radius: 50%;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

  </style>

</html>

