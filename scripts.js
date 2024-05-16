function cerrarSesion(){
    Swal.fire({
        icon: 'success',
        title: 'Sesión finalizada correctamente',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        theme: 'bootstrap-4'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'CerrarSesion.php';
        }
    });
}

function confirmarDelete(id){
    let form = "deleteForm" + id;
    Swal.fire({
        icon: 'warning',
        title: 'Esta seguro que desea eliminar',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        theme: 'bootstrap-4'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(form).submit();
        }
    });
}

function confirmarValidacion(){
    Swal.fire({
        icon: 'success',
        title: 'Procederemos a validar su cuenta, espere a la respuesta de un administrador',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        theme: 'bootstrap-4'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("validarForm").submit();
        }
    });
}

function confirmarModificacion(){
    Swal.fire({
        icon: 'success',
        title: 'El usuario ha sido de modificado correctamente',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        theme: 'bootstrap-4'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("modificarForm").submit();
        }
    });
}

function confirmarCompra(id){
    let form = "compraForm" + id;
    Swal.fire({
        icon: 'success',
        title: 'El juego ha sido añadido al carrito',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        theme: 'bootstrap-4'
    }).then((result) => {
        if (result.isConfirmed) {
            
            document.getElementById(form).submit();
        }
    });
}

function subidaNivel(){
    Swal.fire({
        icon: 'success',
        title: '¡Enhorabuena! Ha subido de nivel',
        showCloseButton: true,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'No volver a mostrar',
        theme: 'bootstrap-4'
    }).then((result) => {
        document.getElementById("levelUpForm").submit();
    });
}

function participarSorteo(bool) {
    
    if (bool == 'true') {
                // El usuario ya está participando en el sorteo
        participadoSorteo();
    } else {
                // El usuario no está participando en el sorteo
        confirmarSorteo();
     }
    
}

function confirmarSorteo(){
    Swal.fire({
        icon: 'success',
        title: 'Ha participado en el sorteo',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        theme: 'bootstrap-4'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("formularioSorteo").submit();
        }
    });
}

function participadoSorteo(){
    Swal.fire({
        icon: 'error',
        title: 'Ya está participando en el sorteo',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        theme: 'bootstrap-4'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(form).submit();
        }
    });
}