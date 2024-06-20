// control_insumos.js

function mostrarFormularioAgregar() {
    const formulario = document.getElementById('formulario-agregar');
    formulario.style.display = 'block';
}

function ocultarFormularioAgregar() {
    const formulario = document.getElementById('formulario-agregar');
    formulario.style.display = 'none';
}

// Toggle para mostrar/ocultar formulario de agregar insumo
function toggleFormularioAgregar() {
    const formulario = document.getElementById('formulario-agregar');
    formulario.style.display = formulario.style.display === 'none' ? 'block' : 'none';
}

// Función para buscar insumo por nombre
function buscarInsumo() {
    const query = document.getElementById('search').value.trim().toLowerCase();

    const rows = document.getElementById('tabla-insumos').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let row of rows) {
        const nombre = row.cells[1].innerText.trim().toLowerCase();
        if (nombre.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Función para actualizar la lista de insumos
function actualizarInsumos() {
    cargarInsumos();
}

// Resto de tu código para agregar insumo, modificar cantidad, etc.

// Código para cargar inicialmente los insumos al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    cargarInsumos();
});

function agregarInsumo() {
    const nombre = document.getElementById('nombre').value.trim();
    const cantidad = document.getElementById('cantidad').value.trim();
    const unidad = document.getElementById('unidad').value.trim();

    if (nombre === '' || cantidad === '' || unidad === '') {
        alert('Por favor completa todos los campos.');
        return;
    }

    const data = { nombre, cantidad, unidad };

    fetch('../../modelo/administrador/insumos/modeloAgregarInsumo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Insumo agregado correctamente');
            cargarInsumos();
            ocultarFormularioAgregar();
        } else {
            alert('Error al agregar insumo');
        }
    })
    .catch(error => console.error('Error:', error));
}

function modificarCantidad(id, accion, cantidadMod) {
    const data = { id, accion, cantidadMod };

    fetch('../../modelo/administrador/insumos/modeloModificarCantidad.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cantidad modificada correctamente');
            cargarInsumos();
        } else {
            alert('Error al modificar cantidad');
        }
    })
    .catch(error => console.error('Error:', error));
}

function cargarInsumos() {
    fetch('../../modelo/administrador/insumos/modeloConsultarInsumos.php')
    .then(response => response.json())
    .then(data => {
        const tbody = document.getElementById('tabla-insumos').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        data.insumos.forEach(insumo => {
            const row = tbody.insertRow();
            row.insertCell(0).innerText = insumo.ID_INSUMO;
            row.insertCell(1).innerText = insumo.NOMBRE;
            row.insertCell(2).innerText = insumo.CANTIDAD;
            const modificarCell = row.insertCell(3);
            const input = document.createElement('input');
            input.type = 'number';
            modificarCell.appendChild(input);
            const accionCell = row.insertCell(4);
            const botonSumar = document.createElement('button');
            botonSumar.innerText = 'Sumar';
            botonSumar.className = 'btn editar-btn';
            botonSumar.onclick = () => modificarCantidad(insumo.ID_INSUMO, 'sumar', input.value);
            accionCell.appendChild(botonSumar);
            const botonRestar = document.createElement('button');
            botonRestar.innerText = 'Restar';
            botonRestar.className = 'btn eliminar-btn';
            botonRestar.onclick = () => modificarCantidad(insumo.ID_INSUMO, 'restar', input.value);
            accionCell.appendChild(botonRestar);
            row.insertCell(5).innerText = insumo.UNIDAD;
        });
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', () => {
    cargarInsumos();
});
