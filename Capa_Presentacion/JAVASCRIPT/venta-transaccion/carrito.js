document.addEventListener('DOMContentLoaded', () => {
    const carrito = [];
    const tabla = document.getElementById("tabla-carrito");

    //  escuchar a Agregar al carrito
    document.body.addEventListener("click", e => {
        if(e.target.tagName === "BUTTON" && e.target.dataset.tipo){
            const tipo = e.target.dataset.tipo;
            const id = e.target.dataset.id;
            const nombre = e.target.dataset.nombre;
            const precio = e.target.dataset.precio || 0;

            const item = {tipo, id, nombre, precio, cantidad: 1};

            // Para películas, añadir campo asiento
            if(tipo === "pelicula"){
                item.asiento = "";
            }

            carrito.push(item);
            cargarCarrito();
        }
    });

    function cargarCarrito(){
        // Borrar filas anteriores (menos encabezado)
        tabla.querySelectorAll("tr:not(:first-child)").forEach(tr => tr.remove());

        carrito.forEach((item, index) => {
            const fila = document.createElement("tr");

            fila.innerHTML = `
                <td>${item.tipo}</td>
                <td>${item.nombre}</td>
                <td>${item.precio}</td>
                <td><input type="number" name="items[${index}][cantidad]" value="${item.cantidad}" min="1"></td>
                <td>
                    ${item.tipo === "pelicula" 
                        ? `<input type="text" name="items[${index}][asiento]" placeholder="Fila-Columna">` 
                        : "-"}
                </td>
                <td><button type="button" onclick="eliminarItem(${index})">elmiminar</button></td>
                <input type="hidden" name="items[${index}][tipo]" value="${item.tipo}">
                <input type="hidden" name="items[${index}][id]" value="${item.id}">
                <input type="hidden" name="items[${index}][nombre]" value="${item.nombre}">
                <input type="hidden" name="items[${index}][precio]" value="${item.precio}">
            `;

            tabla.appendChild(fila);
        });
    }

    window.eliminarItem = (i) => {
        carrito.splice(i, 1);
        cargarCarrito();
    };
});
