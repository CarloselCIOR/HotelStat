
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//OCULTAR Y MOSTRAR VENTANAS
const botonInsertar = document.querySelector('.insertar');
const contenedorInsertar = document.querySelector('.contenedor-insertar');
const botonCerrar = document.querySelector('.cerrar-insertar');

const botonesEliminar = document.querySelectorAll('.eliminar-fila');
let textoEliminar = document.querySelector('.eliminar-mensaje');

const botonesActualizar = document.querySelectorAll('.actualizar-fila');
const contenedorActualizar = document.querySelector('.contenedor-actualizar');
const actualizarCerrar = document.querySelector('.cerrar-actualizar');
const actualizarFinalizado = document.querySelector('#actualizar-empleado-boton');
const insertaFinalizado = document.querySelector('.insertar-empleado');

let insertar = false;
let eliminar = false;
let actualizar = false;

botonesEliminar.forEach(boton => {
  boton.addEventListener('click', () => {
    const rfc = boton.parentElement.parentElement.querySelector('td:first-child').textContent;
    const confirmacion = confirm(`¿Estás seguro de que deseas eliminar el RFC ${rfc}?`);
    if (confirmacion) {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'eliminar.php');
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          alert(xhr.responseText);
          window.location.replace("empleados.php");
          // aquí puedes actualizar la tabla con los datos actualizados
        }
      };
      xhr.send(`rfc=${rfc}`);
    }
  });
});


insertaFinalizado.addEventListener("click", () => {
  alert("Usario insertado correctamente");
});

//BLOQUE PARA ACTUALIZAR
botonesActualizar.forEach(boton => {
  boton.addEventListener('click', () => {
    const fila = boton.parentElement.parentElement;
    const rfc = fila.querySelector('td:first-child').textContent;
    const nombre = fila.querySelector('td:nth-child(2)').textContent;
    const apellido = fila.querySelector('td:nth-child(3)').textContent;
    const email = fila.querySelector('td:nth-child(4)').textContent;
    // const rol = fila.querySelector('td:nth-child(5)').textContent;
    // const hotel = fila.querySelector('td:nth-child(6)').textContent;

    const inputRfc = document.querySelector('#actualizar-rfc');
    const inputNombre = document.querySelector('#actualizar-nombre');
    const inputApellido = document.querySelector('#actualizar-usuario');
    const inputEmail = document.querySelector('#actualizar-clave');

    inputRfc.setAttribute('value', rfc);
    inputNombre.setAttribute('value', nombre);
    inputApellido.setAttribute('value', apellido);
    inputEmail.setAttribute('value', email);

  });

  boton.addEventListener('click', clicBotonActualizar);
});

botonInsertar.addEventListener('click', clicBotonInsertar);
botonCerrar.addEventListener('click', clicBotonCerrar);
actualizarCerrar.addEventListener('click', cerrarActualizar);
actualizarFinalizado.addEventListener("click", () => {
  alert("Usario editado correctamente");
});

function clicBotonInsertar() {
    insertar = !insertar;

    if(contenedorInsertar){
        contenedorInsertar.style.display = "flex";
    } else {
        contenedorInsertar.style.display = "none";
    }

}

function clicBotonActualizar() {
  actualizar = !actualizar;

  if(contenedorActualizar){
    contenedorActualizar.style.display = "flex";
  } else {
    contenedorActualizar.style.display = "none";
  }

  const inputClave = document.querySelector('#actualizar-clave');
  const insertaUsuario = document.querySelector('#actualizar-empleado-boton');

    inputClave.addEventListener('blur', function() {
        const valorClave = inputClave.value;
        if(valorClave.length < 8){
            inputClave.style.border = '2px solid red';
            insertaUsuario.disabled = true;
        } else {
            inputClave.style.border = '2px solid green';
            insertaUsuario.disabled = false;
        }
        
        // Aquí puedes hacer algo con el valor obtenido, como enviarlo a un servidor o procesarlo localmente
      });
}

function clicBotonCerrar() {
    contenedorInsertar.style.display = "none";
}

function cerrarActualizar() {
  contenedorActualizar.style.display = "none";
}

/*BLOQUE DE VALIDACIÓN INSERTAR */
const insertaEmpleado = document.querySelector('.insertar-empleado');
const inputRFC = document.querySelector('#rfc');
const inputClave = document.querySelector('#clave');
const insertaUsuario = document.querySelector('#insertar-empleado-boton');


inputRFC.addEventListener('blur', function() {
  const valorRFC = inputRFC.value;
  if(valorRFC.length < 13){
    inputRFC.style.border = '2px solid red';
    insertaUsuario.disabled = true;
  } else if(!isNaN(valorRFC.charAt(0))){
    inputRFC.style.border = '2px solid red';
    insertaUsuario.disabled = true;
  } else {
    inputRFC.style.border = '2px solid green';
    insertaUsuario.disabled = false;
  }
  
  // Aquí puedes hacer algo con el valor obtenido, como enviarlo a un servidor o procesarlo localmente
});

inputClave.addEventListener('blur', function() {
  const valorClave = inputClave.value;
  if(valorClave.length < 8){
    inputClave.style.border = '2px solid red';
    insertaUsuario.disabled = true;
  } else {
    inputClave.style.border = '2px solid green';
    insertaUsuario.disabled = false;
  }
  
  // Aquí puedes hacer algo con el valor obtenido, como enviarlo a un servidor o procesarlo localmente
});

