const qr = document.querySelector('.qr_image');
var delay = 0;
const ruta_pdf = 'http://localhost/inventario/src/pdfs/'

setInterval(() => {
    delay += 1;
}, 1000);

// REGISTRO DE ACTIVOS
if (document.querySelector('form.registro')) {

    const formulario = document.querySelector('form.registro');
    var producto = {};

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        // ADJUNTANDO DATOS PARA EL PDF
        producto.nombre = formulario.querySelector('[name="nombre_producto"]').value;
        producto.cantidad = parseInt(formulario.querySelector('[name="cantidad_inicial"]').value);
        producto.tipo = formulario.querySelector('[name="id_tipo"]').selectedOptions[0].textContent;
        producto.posicion = formulario.querySelector('[name="posicion"]').selectedOptions[0].textContent;
        producto.fecha = document.querySelector('[name="fecha"]').value;
        // ADJUNTANDO DATOS PARA EL PDF

        const formSend = new FormData(formulario);
        formSend.append('delay', delay);
        formSend.append('ruta_pdf', ruta_pdf+producto.nombre+'.pdf');

        for (const value of formSend.values()) {
            if (value == "") {
                invalid();
                return
            }
        }

        fetch('src/views/resources/ajax/inventario.php', {
            method: "POST",
            body: formSend
        })
        .then(res => res.json())
        .then(data => {
            delay = 0;

            if(data == 'activo_repetido'){
                formulario.reset();
                Toast.fire({
                    icon: 'error',
                    title: 'Este activo ya se encuentra registrado en el sistema'
                })
                return
            }
            if(data == 'ubigeo_lleno'){
                formulario.reset();
                Toast.fire({
                    icon: 'error',
                    title: 'El ubigeo se encuentra lleno, cambiar de ubicación'
                })
                return
            }

            
            formulario.reset();
            Toast.fire({ icon: 'success', title: 'El activo se registró correctamente' })
            
            //generacion del pdf
            pdfExport(producto);

        })
    })
}

async function pdfExport(producto){
    let formulario = new FormData();
    formulario.append('nombre', producto.nombre);
    formulario.append('cantidad', producto.cantidad);
    formulario.append('tipo', producto.tipo);
    formulario.append('posicion', producto.posicion);
    formulario.append('fecha', producto.fecha);
    let resp = await fetch(`src/views/resources/ajax/pdf.php`, {
        method : "POST",
        body : formulario
    });
    let pdf = await resp.json();

    makeQr(`${ruta_pdf}${pdf.name}`)
}

function makeQr(url){
    console.log(url);
    var options = {
        text: url,
        width: 300,
        height: 300,
        drawer: 'svg',
        utf8WithoutBOM: true,
        colorDark : `#000000`,
        colorLight : `#ffffff`,
        timing: `#ffffff`,
        binary: false,
        tooltip: false,
    }
    new QRCode(qr, options);
}

// REPOSICION DE ACTIVOS
if (document.querySelector('form.reposicion')) {
    let repoForm = document.querySelector('form.reposicion'),
        typeProduct = repoForm.querySelector('#type_product'),
        product = repoForm.querySelector('#product'),
        quantity = repoForm.querySelector('#quantity'),
        quantityAll = repoForm.querySelector('#quantity_all'),
        quantityHelp = repoForm.querySelector('#quantityHelp'),
        repoButton = repoForm.querySelector('button[type="submit"]'),
        alert = repoForm.querySelector('.alert');

    var cantidadSeleccionada = 0;

    typeProduct.addEventListener('change', (e) => {

        Array.from(product.querySelectorAll(`.option`)).forEach(l => {
            if (!l.classList.contains('disabled')) { l.classList.add('disabled') }
        })
        quantity.disabled = true;
        quantityAll.disabled = true;

        var type = parseInt(e.currentTarget.value)
        if (!isNaN(type)) {
            if (product.querySelector(`.tipo-${type}`)) {
                product.disabled = false;
                Array.from(product.querySelectorAll(`.tipo-${type}`)).forEach(opt => {
                    if (opt.classList.contains('disabled')) { opt.classList.remove('disabled') }
                })
            } else {
                product.disabled = true;
            }
        }
    })

    product.addEventListener('change', (e) => {
        var qty = parseInt(e.currentTarget.selectedOptions[0].getAttribute('data-cantidad'))
        cantidadSeleccionada = qty;

        quantity.disabled = false; quantityAll.disabled = false; quantity.max = qty;
        quantityHelp.innerHTML = `El activo cuenta con ${qty} existencia(s) retirada(s)`;
    })

    quantityAll.addEventListener('click', (e) => {
        e.preventDefault();
        quantity.value = cantidadSeleccionada
    })

    repoButton.addEventListener('click', (e) => {
        e.preventDefault();
        if (!validarFormulario(repoForm.elements)) {
            invalid()
        } else {
            if (cantidadSeleccionada != 0 && parseInt(quantity.value) <= cantidadSeleccionada) {

                const formulario = new FormData()
                formulario.append("id_tipo", parseInt(typeProduct.value))
                formulario.append("cantidad", parseInt(quantity.value))
                formulario.append("id_egreso", parseInt(product.value))
                formulario.append("validar", "reponerActivo")
                fetch('src/views/resources/ajax/inventario.php', {
                    method: "POST",
                    body: formulario
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Se repusó el producto correctamente',
                                showConfirmButton: false,
                                timer: 5000
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.backdrop || result.dismiss === Swal.DismissReason.timer) {
                                    location.reload();
                                }
                            })
                        } else {
                            errorSystem()
                        }
                    })

            } else {
                quantity.classList.add('is-invalid')
                setTimeout(() => {
                    quantity.classList.remove('is-invalid')
                }, 1000);
            }
        }
    })
}

// SALIDA DE ACTIVOS
if (document.querySelector('form.egreso')) {
    let egresoForm = document.querySelector('form.egreso'),
        nameProduct = egresoForm.querySelector('#name_product'),
        quantity = egresoForm.querySelector('#quantity'),
        quantityAll = egresoForm.querySelector('#quantity_all'),
        quantityHelp = egresoForm.querySelector('#quantityHelp'),
        typeProduct = egresoForm.querySelector('#type_product'),
        egresoButton = egresoForm.querySelector('button[type="submit"]'),
        alert = egresoForm.querySelector('.alert');

    const contenedor_opciones = document.querySelector('#options');
    let cantidadSeleccionada = 0;

    typeProduct.addEventListener('change', (e) => {
        nameProduct.innerHTML = ''; quantity.value = '';
        quantity.disabled = true; quantityAll.disabled = true;

        var type = `.tipo-${e.currentTarget.selectedIndex}`

        var optionDefault = document.createElement('OPTION')
        optionDefault.textContent = 'Escoger el producto a egresar'
        optionDefault.selected = true

        if (contenedor_opciones.querySelector(type)) {
            nameProduct.appendChild(optionDefault)

            Array.from(contenedor_opciones.querySelectorAll(type)).forEach(opt => {
                var option = document.createElement('OPTION')
                option.textContent = opt.textContent
                option.value = (opt.classList[0]).replace('id', '')

                nameProduct.appendChild(option)
            })
            nameProduct.disabled = false
        } else {
            nameProduct.appendChild(optionDefault)
            nameProduct.disabled = true
        }
    })

    nameProduct.addEventListener('change', (e) => {
        quantity.value = ''
        var id = `.id${e.currentTarget.value}`;

        if (contenedor_opciones.querySelector(`p${id}`)) {
            var stock = contenedor_opciones.querySelector(`p${id}`).getAttribute('data-cantidad');
            quantityHelp.innerHTML = `El activo cuenta con ${stock} existencias en el inventario`

            quantity.disabled = false; quantityAll.disabled = false;
            quantity.max = stock
            cantidadSeleccionada = stock
        } else {
            quantityHelp.innerHTML = ''
            quantity.disabled = true; quantityAll.disabled = true;
        }
    })

    quantityAll.addEventListener('click', (e) => {
        e.preventDefault();
        quantity.value = cantidadSeleccionada;
    })

    egresoButton.addEventListener('click', (e) => {
        e.preventDefault()
        if (!validarFormulario(egresoForm.elements)) {
            invalid()
        } else {
            if (cantidadSeleccionada != 0 && parseInt(quantity.value) <= cantidadSeleccionada) {
                const formulario = new FormData()
                formulario.append("name", nameProduct.value)
                formulario.append("quantity", parseInt(quantity.value))
                formulario.append("type", parseInt(typeProduct.value))
                formulario.append("validar", "egresarActivo")
                fetch('src/views/resources/ajax/inventario.php', {
                    method: "POST",
                    body: formulario
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Se retiró el producto correctamente',
                                showConfirmButton: false,
                                timer: 5000
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.backdrop || result.dismiss === Swal.DismissReason.timer) {
                                    location.reload();
                                }
                            })
                        } else {
                            errorSystem()
                        }
                    })
            } else {
                quantity.classList.add('is-invalid')
                setTimeout(() => {
                    quantity.classList.remove('is-invalid')
                }, 1000);
            }

        }
    })
}

// REGISTRO DE USUARIOS
if (document.querySelector('form.registro_usuario')) {

    let formulario = document.querySelector('form.registro_usuario'),
        alert = formulario.querySelector('.alert');

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        const formSend = new FormData(formulario)

        let correo = formulario.querySelector('#correo').value.toString().replace(/\s/g, "");
        formSend.append('correo', correo + '@gmail.com')

        for (const value of formSend.values()) {
            if (value == "") {
                invalid();
                return
            }
        }

        fetch('src/views/resources/ajax/usuario.php', {
            method: "POST",
            body: formSend
        })
            .then(res => res.json())
            .then(data => {
                if (data) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Usuario registrado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.backdrop || result.dismiss === Swal.DismissReason.timer) {
                            formulario.reset();
                            window.location.href = '?view=login'
                        }
                    })
                } else {
                    formulario.reset();
                    Toast.fire({
                        icon: 'error',
                        title: 'El usuario ya se encuentra registrado'
                    })
                }
            })

    })

}

// LOGIN DE USUARIOS
if (document.querySelector('form.login_usuario')) {

    let formulario = document.querySelector('form.login_usuario');

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        const formSend = new FormData(formulario)

        let correo = formulario.querySelector('#correo').value.toString().replace(/\s/g, "");
        formSend.append('correo', correo + '@gmail.com')

        for (const value of formSend.values()) {
            if (value == "") {
                invalid();
                return
            }
        }

        fetch('src/views/resources/ajax/usuario.php', {
            method: "POST",
            body: formSend
        })
        .then(res => res.json())
        .then(data => {
            if (data == 'clave_incorrecta') {
                formulario.reset();
                Toast.fire({
                    icon: 'error',
                    title: 'La clave no es la correcta'
                })
                return
            }

            if (data) {
                window.location.href = '?view=home'
            } else {
                formulario.reset();
                Toast.fire({
                    icon: 'error',
                    title: 'El usuario no se encuentra registrado'
                })
            }
        })
    })

}


function validarFormulario(arr) {
    var validar = 0;
    Array.from(arr).forEach(el => {
        if (el.type == 'text') {
            el.value != '' ? validar = 1 : validar = 0;
        } else if (el.type == 'number') {
            el.value != '' ? validar = 1 : validar = 0;
        } else if (el.type == 'select-one') {
            el.selectedIndex != 0 ? validar = 1 : validar = 0;
        }
    })
    return validar;
}

function invalid() {
    Toast.fire({
        icon: 'error',
        title: 'Completar todos los campos del formulario'
    })
}

function errorSystem() {
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Error en el sistema',
        showConfirmButton: false,
        timer: 5000
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.backdrop || result.dismiss === Swal.DismissReason.timer) {
            window.location.href = 'http://localhost/inventario/?view=cerrar'
        }
    })
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})