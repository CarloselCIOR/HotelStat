document.addEventListener('DOMContentLoaded', function() {
// Establecer la variable de sesión 'intentos' en cero si no existe
if (!sessionStorage.getItem('intentos')) {
    sessionStorage.setItem('intentos', 0);
}

// Obtener el botón de envío y el elemento div para el mensaje de error
const submitBtn = document.getElementById('submit-btn');
const errorMsg = document.getElementById('error-msg');
var formulario = document.querySelector('.contenedor-login');
// Verificar si se han realizado más de cinco intentos fallidos
if (sessionStorage.getItem('intentos') >= 5) {
    submitBtn.disabled = true;
    formulario.style.height = '380px';
    errorMsg.innerHTML = 'Has fallado demasiadas veces, espera un momento';
    errorMsg.style.padding = '15px 0 0 0';
    errorMsg.style.color= 'red';

// Llamar a la función para habilitar el botón de envío después de 30 segundos
    setTimeout(function() {
        enableSubmitBtn();
    }, 15000);
}

// Función para habilitar el botón de envío y reiniciar el conteo de intentos
function enableSubmitBtn() {
    sessionStorage.setItem('intentos', 0);
    submitBtn.disabled = false;
    errorMsg.innerHTML = '';
    formulario.style.height = '320px';
    }
});



