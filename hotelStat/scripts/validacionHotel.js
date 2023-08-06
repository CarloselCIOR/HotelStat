
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//OCULTAR Y MOSTRAR VENTANAS
const botonInsertarHotel = document.querySelector('.insertarHotel');
const contenedorInsertarHotel = document.querySelector('.contenedor-insertarHotel');
const botonCerrarHotel = document.querySelector('.cerrar-insertarHotel');

const botonesEliminarHotel = document.querySelectorAll('.eliminar-filaHotel');
let textoEliminarHotel = document.querySelector('.eliminar-mensajeHotel');

const botonesActualizarHotel = document.querySelectorAll('.actualizar-filaHotel');
const contenedorActualizarHotel = document.querySelector('.contenedor-actualizarHotel');
const actualizarCerrarHotel = document.querySelector('.cerrar-actualizarHotel');
const actualizarFinalizado = document.querySelector('.actulizar-hotel-boton');
const insertaFinalizado = document.querySelector('.insertar-Hotel');

let insertarHotel = false;
let eliminarHotel = false;
let actualizarHotel = false;

botonesEliminarHotel.forEach(botonHotel => {
  botonHotel.addEventListener('click', () => {
    const nombreHotel = botonHotel.parentElement.parentElement.querySelector('td:nth-child(2)').textContent;
    const confirmacion = confirm(`Esta acción es irrecuperable. TODOS LOS EMPLEADOS SERÁN DESLINDADOS, SEGURO DE ELIMINAR HOTEL: ${nombreHotel}?`);
    if (confirmacion) {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'hotel_eliminar.php');
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
                //alert("No puedes eliminar Hoteles con Usuarios")
                alert(xhr.responseText);
          // aquí puedes actualizar la tabla con los datos actualizados
        }
      };
      xhr.send(`nombre_hotel=${nombreHotel}`);
    }
  });
});


//BLOQUE PARA ACTUALIZAR
botonesActualizarHotel.forEach(botonHotel => {
  botonHotel.addEventListener('click', () => {
    const fila = botonHotel.parentElement.parentElement;
    const idHotel = fila.querySelector('td:nth-child(1)').textContent;
    const nombreHotel = fila.querySelector('td:nth-child(2)').textContent;
    const categoriaHotel = fila.querySelector('td:nth-child(3)').textContent;
    const categorianumero = categoriaHotel.split("(")[1].split(")")[0];
    const noHabitacionesHotel = fila.querySelector('td:nth-child(4)').textContent;

    const inputidHotel = document.querySelector('#actualizar-id_hotel');
    const inputnombreHotel = document.querySelector('#actualizar-nombre_hotel');
    const inputcategoriaHotel = document.querySelector('#actualizar-categoria_hotel');
    const inputnoHabitacionesHotel = document.querySelector('#actualizar-noHabitaciones_hotel');

    inputidHotel.setAttribute('value', idHotel);
    inputnombreHotel.setAttribute('value', nombreHotel);
    inputcategoriaHotel.setAttribute('value', categorianumero);
    inputnoHabitacionesHotel.setAttribute('value', noHabitacionesHotel);

  });

  botonHotel.addEventListener('click', clicBotonActualizarHotel);
});

botonInsertarHotel.addEventListener('click', clicBotonInsertarHotel);
botonCerrarHotel.addEventListener('click', clicBotonCerrarHotel);
actualizarCerrarHotel.addEventListener('click', cerrarActualizarHotel);

function clicBotonInsertarHotel() {
    insertarHotel = !insertarHotel;

    if(contenedorInsertarHotel){
        contenedorInsertarHotel.style.display = "flex";
    } else {
        contenedorInsertarHotel.style.display = "none";
    }
}

function clicBotonActualizarHotel() {
  actualizarHotel = !actualizarHotel;

  if(contenedorActualizarHotel){
    contenedorActualizarHotel.style.display = "flex";
  } else {
    contenedorActualizarHotel.style.display = "none";
  }
}

function clicBotonCerrarHotel() {
    contenedorInsertarHotel.style.display = "none";
}

function cerrarActualizarHotel() {
  contenedorActualizarHotel.style.display = "none";
}

/*BLOQUE DE VALIDACIÓN INSERTAR */
const insertaHotel = document.querySelector('.insertar-Hotel');
const inputcategoriaHotel = document.querySelector('#categoria');

inputcategoriaHotel.addEventListener('blur', function() {
  const valorCategoria = inputcategoriaHotel.value;
  if(valorCategoria > 5 || valorCategoria <= 0){
    inputcategoriaHotel.style.border = '2px solid red';
    insertaHotel.disabled = true;
    insertaHotel.style.border = "2px solid red"
  } else {
    inputcategoriaHotel.style.border = '2px solid green';
    insertaHotel.disabled = false;
    insertaHotel.style.border = "none";
  }
  
  // Aquí puedes hacer algo con el valor obtenido, como enviarlo a un servidor o procesarlo localmente
});

actualizarFinalizado.addEventListener("click", () => {
  alert("Usario editado correctamente");
});

insertaFinalizado.addEventListener("click", () => {
  alert("Usario insertado correctamente");
});