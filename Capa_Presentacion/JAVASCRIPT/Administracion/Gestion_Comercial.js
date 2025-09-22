
function ValidarP(){
    let nom = document.querySelector("input[name='nom_pel']").value;
    let formato = document.querySelector("select[name='formato']").value;

    if(nom.trim() === ""){
        alert("Ingrese el nombre de la película");
        return false;
    }

    if(formato === ""){
        alert("Seleccione un formato válido");
        return false;
    }

    return true;
}

function ValidarPr(){
    let idPelicula = document.querySelector("input[name='idPelicula']").value;
    let nro_Sala = document.querySelector("input[name='nro_Sala']").value;
    let fecha = document.querySelector("input[name='fecha']").value;
    let hora = document.querySelector("input[name='hora']").value;

    if(idPelicula <= 0 || nro_Sala <= 0){
        alert("Ingrese un ID de película y número de sala válidos");
        return false;
    }

    if(fecha === "" || hora === ""){
        alert("Seleccione fecha y hora de la proyección");
        return false;
    }

    return true;
}

function validarPro() {
    const nombre = document.querySelector('input[name="nombre"]').value.trim();
    const precio = document.querySelector('input[name="precio"]').value.trim();
    const stock = document.querySelector('input[name="stock"]').value.trim();

    if (nombre === "") {
        alert("Ingrese el nombre del producto.");
        return false;
    }

    if (precio === "" || isNaN(precio) || parseFloat(precio) <= 0) {
        alert("Ingrese un precio válido mayor a 0.");
        return false;
    }

    if (stock === "" || isNaN(stock) || parseInt(stock) < 0) {
        alert("Ingrese un stock válido (0 o mayor).");
        return false;
    }

    return true;
}

