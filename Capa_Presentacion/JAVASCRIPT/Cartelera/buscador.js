class BuscadorPeliculas {
    constructor() {
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.cargarPeliculasIniciales();
    }
    
    setupEventListeners() {
        // Buscar al enviar el formulario
        document.getElementById('formBuscar').addEventListener('submit', (e) => {
            e.preventDefault();
            this.buscarPeliculas();
        });
        
        // Buscar en tiempo real (opcional)
        document.getElementById('inputBuscar').addEventListener('input', (e) => {
            clearTimeout(this.timeoutBusqueda);
            this.timeoutBusqueda = setTimeout(() => {
                this.buscarPeliculas();
            }, 500);
        });
        
        // Filtros rápidos
        document.querySelectorAll('.filtro-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.aplicarFiltro(e.target.dataset.filtro);
            });
        });
        
        // Limpiar búsqueda
        document.getElementById('btnLimpiar').addEventListener('click', () => {
            this.limpiarBusqueda();
        });
    }
    
    async buscarPeliculas() {
        const termino = document.getElementById('inputBuscar').value.trim();
        const btnBuscar = document.getElementById('btnBuscar');
        const originalText = btnBuscar.innerHTML;
        
        // Mostrar loading
        btnBuscar.innerHTML = '<div class="loading"></div> Buscando...';
        btnBuscar.disabled = true;
        
        try {
            const formData = new FormData();
            formData.append('termino', termino);
            formData.append('accion', 'buscar');
            const response = await fetch('Capa_Negocio/Modulo-Cartelera/buscador.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.text();
            document.getElementById('resultadosPeliculas').innerHTML = data;
            
            this.actualizarContadorResultados(termino);
            
        } catch (error) {
            console.error('Error en la búsqueda:', error);
            this.mostrarError('Error al realizar la búsqueda');
        } finally {
            btnBuscar.innerHTML = originalText;
            btnBuscar.disabled = false;
        }
    }
    
    async cargarPeliculasIniciales() {
        try {
            const response = await fetch('Capa_Negocio/Modulo-cartelera/buscador.php?accion=inicial');
            const data = await response.text();
            document.getElementById('resultadosPeliculas').innerHTML = data;
            
            this.actualizarContadorResultados();
            
        } catch (error) {
            console.error('Error cargando películas:', error);
        }
    }
    
    aplicarFiltro(categoria) {
        document.getElementById('inputBuscar').value = categoria;
        this.buscarPeliculas();
        
        // Resaltar filtro activo
        document.querySelectorAll('.filtro-btn').forEach(btn => {
            btn.classList.remove('activo');
        });
        event.target.classList.add('activo');
    }
    
    limpiarBusqueda() {
        document.getElementById('inputBuscar').value = '';
        document.querySelectorAll('.filtro-btn').forEach(btn => {
            btn.classList.remove('activo');
        });
        this.cargarPeliculasIniciales();
    }
    
    actualizarContadorResultados(termino = '') {
        const contador = document.getElementById('contadorResultados');
        const total = document.querySelectorAll('.pelicula-card').length;
        
        if (termino) {
            contador.innerHTML = `${total} película${total !== 1 ? 's' : ''} encontrada${total !== 1 ? 's' : ''} para "${termino}"`;
        } else {
            contador.innerHTML = `Mostrando ${total} película${total !== 1 ? 's' : ''} en cartelera`;
        }
    }
    
    mostrarError(mensaje) {
        const resultados = document.getElementById('resultadosPeliculas');
        resultados.innerHTML = `
            <div class="sin-resultados">
                <div>X</div>
                <h3>Error</h3>
                <p>${mensaje}</p>
            </div>
        `;
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new BuscadorPeliculas();
});