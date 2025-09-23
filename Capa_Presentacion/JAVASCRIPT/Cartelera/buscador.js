document.addEventListener("DOMContentLoaded", function() {
    const inputBuscar = document.getElementById("inputBuscar");
    const btnLimpiar = document.getElementById("btnLimpiar");
    const cartelera = document.getElementById("cartelera");
    const cards = Array.from(cartelera.getElementsByClassName("card"));
    const contador = document.getElementById("contadorResultados");
    const filtros = Array.from(document.getElementsByClassName("filtro-btn"));
    let filtroActivo = '';

    function filtrarCartelera() {
        const query = inputBuscar.value.toLowerCase().trim();
        let visibles = 0;

        cards.forEach(card => {
            const titulo = card.dataset.titulo;
            const categoria = card.dataset.categoria;
            const lenguaje = card.dataset.lenguaje;

            const pasaFiltro = filtroActivo ? categoria === filtroActivo : true;
            const pasaBusqueda = titulo.includes(query) || categoria.includes(query) || lenguaje.includes(query);

            if (pasaBusqueda && pasaFiltro) {
                card.style.display = "block";
                visibles++;
            } else {
                card.style.display = "none";
            }
        });

        contador.textContent = "Resultados encontrados: " + visibles;
    }


    inputBuscar.addEventListener("input", filtrarCartelera);
    btnLimpiar.addEventListener("click", function() {
        inputBuscar.value = "";
        filtroActivo = '';
        filtros.forEach(f => f.classList.remove("activo"));
        filtrarCartelera();
    });

    filtros.forEach(filtroBtn => {
        filtroBtn.addEventListener("click", function() {
            filtros.forEach(f => f.classList.remove("activo"));
            this.classList.add("activo");
            filtroActivo = this.dataset.filtro.toLowerCase();
            filtrarCartelera();
        });
    });

    filtrarCartelera();
});