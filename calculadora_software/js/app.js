
document.addEventListener('DOMContentLoaded', function(){cargarSoftwares();});
/*usamos fetch para comunicarnos con el servidor*/
//funciones para cargar desde de la API
function cargarSoftwares(){
    fetch('api/software.php')
    .then(response => response.json()) //convertir respuesta a un Json
    .then(softwares => {
        const lista = document.getElementById('listSoftware');//obtener el contenedor
        lista.innerHTML = ''; //limpiar lista
        softwares.forEach(software => {//recorrer cada software
            lista.innerHTML +=`
            <div id="software-${software.id}" data-costo=${software.costo}>
                <strong>${software.nombre}</strong> - $${software.costo}
                <p>${software.descripcion}</p>
                <div id="modulos-${software.id}"></div>
                <select id="select-${software.id}"></select>
                <button onclick="activarModulo(${software.id})">Activar Modulo</button>
                <span id="total-${software.id}">Total: $${software.costo}</span>
                <br>
                <button onclick="eliminarSoftware(${software.id})">Eliminar</button>
                <button onclick="editarSoftware(${software.id})">Editar</button>
            </div>
            `;
            cargarModulosDisponibles(software.id);
            cargarActivaciones(software.id, software.costo);
        });

    });
}

document.getElementById('btnGuardar').addEventListener('click', function(){
    //obtener los valores del formulario
    const nombre = document.getElementById('nombre').value;
    const descripcion = document.getElementById('descripcion').value;
    const costo = document.getElementById('costo').value;

    const id = this.dataset.id; //verificar si tiene un id en el evento editar
    const method = id ? 'PUT' : 'POST';
    const url = id ? 'api/software.php?id=' + id: 'api/software.php'
    //enviar los datos a la API con fetch
    fetch(url, {
        method: method, //indica que es una peticion de envio
        headers: {'Content-Type': 'application/json'},//indicar que enviamos un json
        body: JSON.stringify({nombre, descripcion, costo})
    })
    .then(response => response.json())//convertir respuesta
    .then(data => {
        alert(id ? 'Software actualizado ': 'Software creado con id: ' + data.id);// mostrar mensaje
        //limpiar formulario
        document.getElementById('nombre').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('costo').value = '';
        //regresar el boton a guardar
        this.textContent = 'Guardar';
        delete this.dataset.id;
        cargarSoftwares();//recargar la lista
    });
});

function eliminarSoftware(id){
    if(confirm('¿Eliminar software?')){
        fetch('api/software.php?id=' + id, {
            method: 'DELETE' //Para indicar que es una peticion de eliminar
        })
        .then(response => response.json())
        .then(data => {
            alert('Software eliminado');
            cargarSoftwares();
        });
    }
}

function editarSoftware(id){
    fetch('api/software.php?id='+id)
    .then(response => response.json())
    .then(software => {
        //cargar datos en el formulario
        document.getElementById('nombre').value = software.nombre;
        document.getElementById('descripcion').value = software.descripcion;
        document.getElementById('costo').value = software.costo;
        //cambiar el nombre de boton de guardar a actualizar
        const btn = document.getElementById('btnGuardar');
        btn.textContent='Actualizar';
        btn.dataset.id = id;
    });
}
//cargar los modulos en el selector
function cargarModulosDisponibles(id_software){
    fetch('api/modulo.php')
    .then(response => response.json())
    .then(modulos => {
        const select = document.getElementById('select-' + id_software);
        select.innerHTML ='';
        modulos.forEach(modulo => {
            select.innerHTML += `<option value="${modulo.id}" data-costo="${modulo.costo_adicional}">${modulo.nombre} (+$${modulo.costo_adicional})</option>`;
        });

    });
}

function cargarActivaciones(id_software, costo_base){
    fetch('api/activacion.php?id_software='+id_software)
    .then(response => response.json())
    .then(activaciones => {
        const contenedor = document.getElementById('modulos-'+id_software);
        contenedor.innerHTML = '';
        let total = parseFloat(costo_base);
        activaciones.forEach(activacion => {
            const select = document.getElementById('select-'+id_software);
            const option = select.querySelector(`option[value="${activacion.id_modulo}"]`);
            const costoModulo = option ? parseFloat(option.dataset.costo): 0;
            total += costoModulo;
            contenedor.innerHTML += `
            <span> ${option ? option.text: activacion.id_modulo}
            <button onclick="desactivarModulo(${activacion.id}, ${id_software}, ${costo_base})">X</button>
            </span>
            `;
        });
        document.getElementById('total-'+id_software).textContent = 'Total -$'+ total.toFixed(2);
    });

}

function activarModulo(id_software){
    const  id_modulo = document.getElementById('select-'+id_software).value;
    fetch ('api/activacion.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json' },
        body: JSON.stringify({id_software, id_modulo})

    })
    .then(response => response.json())
    .then(() => {
     const costo_base = document.getElementById('software-'+id_software).dataset.costo;
     cargarActivaciones(id_software, costo_base);  
    }

    );

}

function desactivarModulo(id, id_software, costo_base){
    fetch('api/activacion.php?id=' + id, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(() => {
        const costo_base = document.getElementById('software-'+id_software).dataset.costo;
        cargarActivaciones(id_software, costo_base);
    });

}


