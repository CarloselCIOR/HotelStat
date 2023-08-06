<?php
//INICIAMOS LA SESIÓN
  
//INCLUIMOS LAS UTILERIAS
include('includes/utilerias.php');
//SI LA SESIÓN NO EXISTE, TE MANDA A INICIAR SESIÓN SI EXISTE ENTONCES TE MANDA A LA PÁGINA
if(session_status() == PHP_SESSION_NONE){
  session_start();
}
if(isset($_SESSION['usuario'])) {
  $rol = $_SESSION['rol'];//ROL
}

if (!isset($_SESSION['usuario'])) {
  redireccionar('Prohibido','index.php');
  return;
}else{
    include('includes/encabezado.php');
    $hotel = $_SESSION['idHotel'];//HOTEL
    $categoria = $_SESSION['categoria'];//CATEGORIA
  }

  list($valores, $lugOrigen, $can, $motivo, $can2, $fecha, $costoPro,
        $valores2, $lugOrigen2, $can3, $motivo2, $can4, $fecha2, $costoPro2,
        $valores3, $lugOrigen3, $can5, $motivo3, $can6, $fecha3, $costoPro3,
        $valores4, $lugOrigen4, $can7, $motivo4, $can8, $fecha4, $costoPro4) = conexionGraficar($hotel, $categoria);

  
/////////////////////////////////////////

// DATOS PARA EL DIV DE GRAFICAS 1

$categorias = ["Vacias", "Ocupadas"];

$data = array(
    "labels" => $categorias,
    "datasets" => array(
        array(
            "label" => "Ocupacion",
            "backgroundColor" => array(
                "#363432",
                "#196774"
            ),
            "data" => $valores
        )
    )
);

$data2 = array(
  "labels" => $lugOrigen,
  "datasets" => array(
      array(
          "label" => "Cantidad",
          "backgroundColor" => array(
            "#363432",
            "#196774",
            "#90A19D",
            "#F0941F",
            "#EF6024",
            "#e74c3c",
            "#34495e"
          ),
          "data" => $can
      )
  )
);

$data3 = array(
  "labels" => $motivo,
  "datasets" => array(
      array(
          "label" => "Cantidad",
          "backgroundColor" => array(
            "#363432",
            "#196774",
            "#90A19D"
          ),
          "data" => $can2
      )
  )
);

$data4 = array(
  "labels" => $fecha,
  "datasets" => array(
      array(
          "label" => "Tarifa Promedio",
          "backgroundColor" => array(
            "#363432"
          ),
          "data" => $costoPro
      )
  )
);

// DATOS PARA EL DIV DE GRAFICAS 2
$data5 = array(
  "labels" => $categorias,
  "datasets" => array(
      array(
          "label" => "Ocupacion",
          "backgroundColor" => array(
              "#363432",
              "#196774"
          ),
          "data" => $valores2
      )
  )
);

$data6 = array(
"labels" => $lugOrigen2,
"datasets" => array(
    array(
        "label" => "Cantidad",
        "backgroundColor" => array(
          "#363432",
          "#196774",
          "#90A19D",
          "#F0941F",
          "#EF6024",
          "#e74c3c",
          "#34495e"
        ),
        "data" => $can3
    )
)
);

$data7 = array(
"labels" => $motivo2,
"datasets" => array(
    array(
        "label" => "Cantidad",
        "backgroundColor" => array(
          "#363432",
          "#196774",
          "#90A19D"
        ),
        "data" => $can4
    )
)
);

$data8 = array(
"labels" => $fecha2,
"datasets" => array(
    array(
        "label" => "Tarifa Promedio",
        "backgroundColor" => array(
          "#363432"
        ),
        "data" => $costoPro2
    )
)
);

// DATOS PARA EL DIV DE GRAFICAS 3
$data9 = array(
  "labels" => $categorias,
  "datasets" => array(
      array(
          "label" => "Ocupacion",
          "backgroundColor" => array(
              "#363432",
              "#196774"
          ),
          "data" => $valores3
      )
  )
);

$data10 = array(
"labels" => $lugOrigen3,
"datasets" => array(
    array(
        "label" => "Cantidad",
        "backgroundColor" => array(
          "#363432",
          "#196774",
          "#90A19D",
          "#F0941F",
          "#EF6024",
          "#e74c3c",
          "#34495e"
        ),
        "data" => $can5
    )
)
);

$data11 = array(
"labels" => $motivo3,
"datasets" => array(
    array(
        "label" => "Cantidad",
        "backgroundColor" => array(
          "#363432",
          "#196774",
          "#90A19D"
        ),
        "data" => $can6
    )
)
);

$data12 = array(
"labels" => $fecha3,
"datasets" => array(
    array(
        "label" => "Tarifa Promedio",
        "backgroundColor" => array(
          "#363432"
        ),
        "data" => $costoPro3
    )
)
);

// DATOS PARA EL DIV DE GRAFICAS 4
$data13 = array(
  "labels" => $categorias,
  "datasets" => array(
      array(
          "label" => "Ocupacion",
          "backgroundColor" => array(
              "#363432",
              "#196774"
          ),
          "data" => $valores4
      )
  )
);

$data14 = array(
"labels" => $lugOrigen4,
"datasets" => array(
    array(
        "label" => "Cantidad",
        "backgroundColor" => array(
          "#363432",
          "#196774",
          "#90A19D",
          "#F0941F",
          "#EF6024",
          "#e74c3c",
          "#34495e"
        ),
        "data" => $can7
    )
)
);

$data15 = array(
"labels" => $motivo4,
"datasets" => array(
    array(
        "label" => "Cantidad",
        "backgroundColor" => array(
          "#363432",
          "#196774",
          "#90A19D"
        ),
        "data" => $can8
    )
)
);

$data16 = array(
"labels" => $fecha4,
"datasets" => array(
    array(
        "label" => "Tarifa Promedio",
        "backgroundColor" => array(
          "#363432"
        ),
        "data" => $costoPro4
    )
)
);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Graficos</title>
  <!-- <script src="../scripts/validacionRegistro.js" defer></script> -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Schibsted+Grotesk:wght@500&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Cabin&family=Schibsted+Grotesk:wght@500&display=swap');
    .contenedor-graficas {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: 1fr 1fr;
      gap: 15px;
      margin: 20px 0;
      padding: 0 40px 0 40px;
      height: 1200px;
    }

    .grafica {
      background-color: #F2F2F2;
      border-radius: 8px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      overflow: hidden;
      width: 100%;
      height: 100%;
      cursor: pointer;
      transition: box-shadow 0.4s;
    }

    .grafica:hover{
      box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
    }

    .grafica h2 {
      background-color: #0B3F53;
      border-bottom: 1px solid #cccccc;
      font-size: 1.2rem;
      margin: 0;
      padding: 12px;
      text-align: center;
      color: white;
      text-transform: uppercase;
      font-family: 'Schibsted Grotesk';
      letter-spacing: 1px;
    }

    .grafica canvas {
      padding: 20px;
      max-width: 100%;
      max-height: 550px;
    }

  .contenedor-check {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 10px;
    gap: 10px;
    font-size: 18px;
  }

  input[type="checkbox"] {
    display: none;
  }

  label {
    display: inline-block;
    padding: 10px 20px;
    border: 2px solid #ccc;
    border-radius: 5px;
    color: #555;
    cursor: pointer;
    transition: all 0.3s ease;
  } 

  input[type="checkbox"]:checked + label {
    background-color: #23AA6F;
    color: #fff;
  }

  .estrellas[type="checkbox"]:checked + label{
    background-color: #9CAE19;
    color: #fff;
  }

  #graficas-2, #graficas-3, #graficas-4 {
    display: none;
  }

  </style>
</head>
<body>

  <script>

    function seleccionarFiltro(checkbox, f) {
      let checkboxes = document.getElementsByName('f');

      checkboxes.forEach(function(cb) {
        if (cb !== checkbox){
          cb.checked = false;
          cb.disabled = false;
        }else{
          cb.disabled = true;
        }
      });

      switch (f) {
        case 1:
          grafica1.style.display = "grid";
          grafica2.style.display = "none";
          grafica3.style.display = "none";
          grafica4.style.display = "none";   
          break;
        
        case 2:            
          grafica1.style.display = "none";
          grafica2.style.display = "grid";
          grafica3.style.display = "none";
          grafica4.style.display = "none";
          break;
        case 3:
          grafica1.style.display = "none";
          grafica2.style.display = "none";
          grafica3.style.display = "grid";
          grafica4.style.display = "none";
          break;
      }
    }

    function seleccionarHotel(checkbox, m) {
      let checkboxes = document.getElementsByName('m');

      checkboxes.forEach(function(cb) {
        if (cb !== checkbox){
          cb.checked = false;
          cb.disabled = false;
        }else{
          cb.disabled = true;
        }
      });
      
      switch (m) {
        case 1:
          const check = document.getElementById("dia");
          const checks = document.getElementsByName("f");

          checks.forEach(function(c) {
            c.disabled = false;
          });
          check.disabled = true;

          grafica1.style.display = "grid";
          grafica2.style.display = "none";
          grafica3.style.display = "none";
          grafica4.style.display = "none";
        
          break;

        case 2:  
          const check2 = document.getElementById("dia");
          const checks2 = document.getElementsByName("f");

          checks2.forEach((c) => {
            c.disabled = true;
            c.checked = false;
          });
          check2.checked = true;

          grafica1.style.display = "none";
          grafica2.style.display = "none";
          grafica3.style.display = "none";
          grafica4.style.display = "grid";
        
          break;
      }

    }

    </script>

  <div class="contenedor-check">
    
    <input type="checkbox" id="dia" name="f" onchange="seleccionarFiltro(this, 1)" checked >
    <label for="dia">Diario</label>
    
    <input type="checkbox" id="semana" name="f" onchange="seleccionarFiltro(this, 2)">
    <label for="semana">Semanal</label>
    
    <input type="checkbox" id="mes" name="f" onchange="seleccionarFiltro(this, 3)">
    <label for="mes">Mensual</label>
    
  </div>

  <div class="contenedor-check">
    <div class="admin">
      <input type="checkbox" id="propias" name="m" class="estrellas" onchange="seleccionarHotel(this, 1)" checked>
      <label for="propias">Propias</label>

      <input type="checkbox" id="mc" name="m" class="estrellas" onchange="seleccionarHotel(this, 2)">
      <label for="mc">Misma Categoria</label>
    </div>
  </div>

  <!-- GRAFICAS 1 -->
  <div class="contenedor-graficas" id="graficas-1">
    <div class="grafica">
      <h2>Ocupación</h2>
      <canvas id="myChart"></canvas>
    </div>

    <div class="grafica">
      <h2>Origen</h2>
      <canvas id="myChart2"></canvas>
    </div>
    
    <div class="grafica">
      <h2>Motivo</h2>
      <canvas id="myChart3"></canvas>
    </div>
    
    <div class="grafica">
      <h2>Tarifa</h2>
      <canvas id="myChart4"></canvas>
    </div>
  </div>

  <!-- GRAFICAS 2 -->
  <div class="contenedor-graficas" id="graficas-2">
    <div class="grafica">
      <h2>Ocupación</h2>
      <canvas id="myChart5"></canvas>
    </div>

    <div class="grafica">
      <h2>Origen</h2>
      <canvas id="myChart6"></canvas>
    </div>
    
    <div class="grafica">
      <h2>Motivo</h2>
      <canvas id="myChart7"></canvas>
    </div>
    
    <div class="grafica">
      <h2>Tarifa</h2>
      <canvas id="myChart8"></canvas>
    </div>

  </div>


  <!-- GRAFICAS 3 -->
  <div class="contenedor-graficas" id="graficas-3">
    <div class="grafica">
      <h2>Ocupación</h2>
      <canvas id="myChart9"></canvas>
    </div>

    <div class="grafica">
      <h2>Origen</h2>
      <canvas id="myChart10"></canvas>
    </div>
    
    <div class="grafica">
      <h2>Motivo</h2>
      <canvas id="myChart11"></canvas>
    </div>
    
    <div class="grafica">
      <h2>Tarifa</h2>
      <canvas id="myChart12"></canvas>
    </div>
  </div>


  <!-- GRAFICAS 4 -->
  <div class="contenedor-graficas" id="graficas-4">
    <div class="grafica">
      <h2>Ocupación</h2>
      <canvas id="myChart13"></canvas>
    </div>

    <div class="grafica">
      <h2>Origen</h2>
      <canvas id="myChart14"></canvas>
    </div>
    
    <div class="grafica">
      <h2>Motivo</h2>
      <canvas id="myChart15"></canvas>
    </div>
    
    <div class="grafica">
      <h2>Tarifa</h2>
      <canvas id="myChart16"></canvas>
    </div>
  </div>
    
  	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  	<script>

      var grafica1 = document.getElementById("graficas-1");
      var grafica2 = document.getElementById("graficas-2");
      var grafica3 = document.getElementById("graficas-3");
      var grafica4 = document.getElementById("graficas-4");
      
      const filtro = document.getElementById('dia');
      filtro.disabled = true;

      const hotel = document.getElementById('propias');
      hotel.disabled = true; 


      // DATOS PARA EL DIV DE GRAFICAS 1
      var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'pie',
          data: <?php echo json_encode($data); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Ocupación de habitaciones'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx2 = document.getElementById('myChart2').getContext('2d');
      var myChart2 = new Chart(ctx2, {
          type: 'pie',
          data: <?php echo json_encode($data2); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Lugar de Origen'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx3 = document.getElementById('myChart3').getContext('2d');
      var myChart3 = new Chart(ctx3, {
          type: 'pie',
          data: <?php echo json_encode($data3); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Motivo de Estadia'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx4 = document.getElementById('myChart4').getContext('2d');
      var myChart4 = new Chart(ctx4, {
          type: 'bar',
          data: <?php echo json_encode($data4); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica de Tarifa Promedio'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });

     
      // DATOS PARA EL DIV DE GRAFICAS 2
      var ctx5 = document.getElementById('myChart5').getContext('2d');
      var myChart5 = new Chart(ctx5, {
          type: 'pie',
          data: <?php echo json_encode($data5); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Ocupación de habitaciones'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx6 = document.getElementById('myChart6').getContext('2d');
      var myChart6 = new Chart(ctx6, {
          type: 'pie',
          data: <?php echo json_encode($data6); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Lugar de Origen'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx7 = document.getElementById('myChart7').getContext('2d');
      var myChart7 = new Chart(ctx7, {
          type: 'pie',
          data: <?php echo json_encode($data7); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Motivo de Estadia'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx8 = document.getElementById('myChart8').getContext('2d');
      var myChart8 = new Chart(ctx8, {
          type: 'bar',
          data: <?php echo json_encode($data8); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica de Tarifa Promedio'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });

      // DATOS PARA EL DIV DE GRAFICAS 3
      var ctx9 = document.getElementById('myChart9').getContext('2d');
      var myChart9 = new Chart(ctx9, {
          type: 'pie',
          data: <?php echo json_encode($data9); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Ocupación de habitaciones'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx10 = document.getElementById('myChart10').getContext('2d');
      var myChart10 = new Chart(ctx10, {
          type: 'pie',
          data: <?php echo json_encode($data10); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Lugar de Origen'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx11 = document.getElementById('myChart11').getContext('2d');
      var myChart11 = new Chart(ctx11, {
          type: 'pie',
          data: <?php echo json_encode($data11); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Motivo de Estadia'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx12 = document.getElementById('myChart12').getContext('2d');
      var myChart12 = new Chart(ctx12, {
          type: 'bar',
          data: <?php echo json_encode($data12); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica de Tarifa Promedio'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });

      // DATOS PARA EL DIV DE GRAFICAS 4
      var ctx13 = document.getElementById('myChart13').getContext('2d');
      var myChart13 = new Chart(ctx13, {
          type: 'pie',
          data: <?php echo json_encode($data13); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Ocupación de habitaciones'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx14 = document.getElementById('myChart14').getContext('2d');
      var myChart14 = new Chart(ctx14, {
          type: 'pie',
          data: <?php echo json_encode($data14); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Lugar de Origen'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx15 = document.getElementById('myChart15').getContext('2d');
      var myChart15 = new Chart(ctx15, {
          type: 'pie',
          data: <?php echo json_encode($data15); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica Motivo de Estadia'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });
      var ctx16 = document.getElementById('myChart16').getContext('2d');
      var myChart16 = new Chart(ctx16, {
          type: 'bar',
          data: <?php echo json_encode($data16); ?>,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Gráfica de Tarifa Promedio'
          },
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      });

	  </script>
</body>
</html>