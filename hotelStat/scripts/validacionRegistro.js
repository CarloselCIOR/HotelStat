
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//OCULTAR Y MOSTRAR VENTANAS
const botonInsertarRegistro = document.querySelector('.insertarRegistro');
const contenedorInsertarRegistro = document.querySelector('.contenedor-insertarRegistro');
const botonCerrarRegistro = document.querySelector('.cerrar-insertarRegistro');

const botonesEliminarRegistro = document.querySelectorAll('.eliminar-filaRegistro');
let textoEliminarRegistro = document.querySelector('.eliminar-mensajeRegistro');

const botonesActualizarRegistro = document.querySelectorAll('.actualizar-filaRegistro');
const contenedorActualizarRegistro = document.querySelector('.contenedor-actualizarRegistro');
const actualizarCerrarRegistro = document.querySelector('.cerrar-actualizarRegistro');
const actualizarFinalizado = document.querySelector('.actulizar-registro-boton');
const insertaFinalizado = document.querySelector('.insertar-Registro');
const tipoHabitacion = document.querySelector('#registro_habitacion');
const costo = document.querySelector('#registro_costodia');

let insertarRegistro = false;
let eliminarRegistro = false;
let actualizarRegistro = false;

botonesEliminarRegistro.forEach(botonRegistro => {
  botonRegistro.addEventListener('click', () => {
    const idRegistro = botonRegistro.parentElement.parentElement.querySelector('td:nth-child(1)').textContent;
    const confirmacion = confirm(`¿Seguro que quiere eliminar el registro ${idRegistro}?`);
    if (confirmacion) {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'registro_eliminar.php');
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
                //alert("No puedes eliminar Hoteles con Usuarios")
                alert(xhr.responseText);
          // aquí puedes actualizar la tabla con los datos actualizados
        }
      };
      xhr.send(`idCliente=${idRegistro}`);
    }
  });
});

//BLOQUE PARA ACTUALIZAR
botonesActualizarRegistro.forEach(botonRegistro => {
  botonRegistro.addEventListener('click', () => {
    const fila = botonRegistro.parentElement.parentElement;
    const idRegistro = fila.querySelector('td:nth-child(1)').textContent;
    const ingresoRegistro = fila.querySelector('td:nth-child(2)').textContent;
    const salidaRegistro = fila.querySelector('td:nth-child(3)').textContent;
    const origenRegistro = fila.querySelector('td:nth-child(4)').textContent;
    const motivoRegistro = fila.querySelector('td:nth-child(5)').textContent;
    const habitacionRegistro = fila.querySelector('td:nth-child(6)').textContent;
    const costoRegistro = fila.querySelector('td:nth-child(7)').textContent;
    const rfcRegistro = fila.querySelector('td:nth-child(8)').textContent;
    let numeroOrigen;
    let numeroMotivo;
    let numeroHabitacion;

    const inputidRegistro = document.querySelector('#actualizar-idRegistro');
    const inputingresoRegistro = document.querySelector('#actualizar-ingresoRegistro');
    const inputsalidaRegistro = document.querySelector('#actualizar-salidaRegistro');
    const inputorigenRegistro = document.querySelector('#actualizar-origenRegistro');
    const inputmotivoRegistro = document.querySelector('#actualizar-motivoRegistro');
    const inputhabitacionRegistro = document.querySelector('#actualizar-habitacionRegistro');
    const inputcostoRegistro = document.querySelector('#actualizar-registroCostodia');
    const inputrfcRegistro = document.querySelector('#actualizar-rfcRegistro');

    switch(origenRegistro) {
      case "Aguascalientes":
        numeroOrigen = 1;
        break;
      case "Baja California":
        numeroOrigen = 2;
        break;
      case "Baja California Sur":
        numeroOrigen = 3;
        break;
      case "Campeche":
        numeroOrigen = 4;
        break;
      case "Chiapas":
        numeroOrigen = 5;
        break;
      case "Chihuahua":
        numeroOrigen = 6;
        break;
      case "Ciudad de México":
        numeroOrigen = 7;
        break;
      case "Coahuila":
        numeroOrigen = 8;
        break;
      case "Colima":
        numeroOrigen = 9;
        break;
      case "Durango":
        numeroOrigen = 10;
        break;
      case "Estado de México":
        numeroOrigen = 11;
        break;
      case "Guanajuato":
        numeroOrigen = 12;
        break;
      case "Guerrero":
        numeroOrigen = 13;
        break;
      case "Hidalgo":
        numeroOrigen = 14;
        break;
      case "Jalisco":
        numeroOrigen = 15;
        break;
      case "Michoacán":
        numeroOrigen = 16;
        break;
      case "Morelos":
        numeroOrigen = 17;
        break;
      case "Nayarit":
        numeroOrigen = 18;
        break;
      case "Nuevo León":
        numeroOrigen = 19;
        break;
      case "Oaxaca":
        numeroOrigen = 20;
        break;
      case "Puebla":
        numeroOrigen = 21;
        break;
      case "Querétaro":
        numeroOrigen = 22;
        break;
      case "Quintana Roo":
        numeroOrigen = 23;
        break;
      case "San Luis Potosí":
        numeroOrigen = 24;
        break;
      case "Sinaloa":
        numeroOrigen = 25;
        break;
      case "Sonora":
        numeroOrigen = 26;
        break;  
      case "Tabasco":
        numeroOrigen = 27;
        break;
      case "Tamaulipas":
        numeroOrigen = 28;
        break;
      case "Tlaxcala":
        numeroOrigen = 29;
        break;  
      case "Veracruz":
        numeroOrigen = 30;
        break;  
      case "Yucatán":
        numeroOrigen = 31;
        break; 
      case "Zacatecas":
        numeroOrigen = 32;
        break;   
      case "Extranjero":
        numeroOrigen = 33;
        break;  
    }

    switch(motivoRegistro){
      case "TURISMO":
        numeroMotivo = 1;
        break;  
      case "LABORAL":
        numeroMotivo = 2;
        break;  
      case "ACADEMICO":
        numeroMotivo = 3;
        break;  
    }

    switch(habitacionRegistro){
      case "Sencilla":
        numeroHabitacion = 1;
        break;  
      case "Doble":
        numeroHabitacion = 2;
        break;  
      case "Suite presidencial":
        numeroHabitacion = 3;
        break;
    }
    


    inputidRegistro.setAttribute('value', idRegistro);
    inputingresoRegistro.setAttribute('value', ingresoRegistro);
    inputsalidaRegistro.setAttribute('value', salidaRegistro);
    inputorigenRegistro.value = numeroOrigen;
    inputmotivoRegistro.value = numeroMotivo;
    inputhabitacionRegistro.value = numeroHabitacion;
    inputcostoRegistro.setAttribute('value', costoRegistro);
    inputrfcRegistro.setAttribute('value', rfcRegistro);

  });

  botonRegistro.addEventListener('click', clicBotonActualizarRegistro);
});

botonInsertarRegistro.addEventListener('click', clicBotonInsertarRegistro);
botonCerrarRegistro.addEventListener('click', clicBotonCerrarRegistro);
actualizarCerrarRegistro.addEventListener('click', cerrarActualizarRegistro);

function clicBotonInsertarRegistro() {
    insertarRegistro = !insertarRegistro;

    if(contenedorInsertarRegistro){
        contenedorInsertarRegistro.style.display = "flex";
    } else {
        contenedorInsertarRegistro.style.display = "none";
    }
}

function clicBotonActualizarRegistro() {
  actualizarRegistro = !actualizarRegistro;

  if(contenedorActualizarRegistro){
    contenedorActualizarRegistro.style.display = "flex";
  } else {
    contenedorActualizarRegistro.style.display = "none";
  }
}

function clicBotonCerrarRegistro() {
    contenedorInsertarRegistro.style.display = "none";
}

function cerrarActualizarRegistro() {
  contenedorActualizarRegistro.style.display = "none";
}

/*BLOQUE DE VALIDACIÓN INSERTAR */
const insertaHotel = document.querySelector('.insertar-Hotel');
const inputcategoriaHotel = document.querySelector('#categoria');

actualizarFinalizado.addEventListener("click", () => {
  alert("Registro editado correctamente");
});

insertaFinalizado.addEventListener("click", () => {
  alert("Registro insertado correctamente");
});

//BLOQUE PARA DAR VALOR AL COSTO SEGÚN HABITACIÓN
tipoHabitacion.addEventListener('blur', function() {
  var habitacion = tipoHabitacion.value;
  console.log(habitacion)
  if(habitacion === "1") {
    costo.value = "800";
  } else if(habitacion === "2") {
    costo.value = "1400";
  } else if(habitacion === "3") {
    costo.value = "2500";
  }
  
});