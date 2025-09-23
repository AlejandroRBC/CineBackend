document.addEventListener('DOMContentLoaded', () => {
    const carrito = [];
    const tabla = document.getElementById("tabla-carrito");
    const QR = document.getElementById("QR");
    const metodoPago = document.getElementById("metodoPago");

    
    if (metodoPago) {
        metodoPago.addEventListener("change", () => {
            if (metodoPago.value === "QR") {
                QR.classList.remove("ocultarQR");
                QR.classList.add("mostrarQR");
            } else {
                QR.classList.remove("mostrarQR");
                QR.classList.add("ocultarQR");
            }
        });
    }




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

    // En carrito.js - mejorar la función cargarCarrito
function cargarCarrito(){
    tabla.querySelectorAll("tr:not(:first-child)").forEach(tr => tr.remove());
    
    let totalGeneral = 0;
    
    carrito.forEach((item, index) => {
        const fila = document.createElement("tr");
        const subtotal = item.precio * item.cantidad;
        totalGeneral += subtotal;

        fila.innerHTML = `
            <td>${item.tipo}</td>
            <td>${item.nombre}</td>
            <td>Bs. ${item.precio}</td>
            <td><input type="number" name="items[${index}][cantidad]" value="${item.cantidad}" min="1" onchange="actualizarSubtotal(${index})"></td>
            <td>Bs. ${subtotal.toFixed(2)}</td>
            <td>
                ${item.tipo === "pelicula" 
                    ? `<input type="text" name="items[${index}][asiento]" placeholder="Fila-Columna">` 
                    : "-"}
            </td>
            <td><button type="button" onclick="eliminarItem(${index})">Eliminar</button></td>
            <input type="hidden" name="items[${index}][tipo]" value="${item.tipo}">
            <input type="hidden" name="items[${index}][id]" value="${item.id}">
            <input type="hidden" name="items[${index}][nombre]" value="${item.nombre}">
            <input type="hidden" name="items[${index}][precio]" value="${item.precio}">
        `;

        tabla.appendChild(fila);
    });
    
    // Agregar fila de total
    const filaTotal = document.createElement("tr");
    filaTotal.innerHTML = `
        <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL:</td>
        <td style="font-weight: bold;">Bs. ${totalGeneral.toFixed(2)}</td>
        <td colspan="2"></td>
    `;
    tabla.appendChild(filaTotal);
}

function actualizarSubtotal(index) {
    // Lógica para actualizar subtotales en tiempo real
    cargarCarrito();
}

    window.eliminarItem = (i) => {
        carrito.splice(i, 1);
        cargarCarrito();
    };
});
