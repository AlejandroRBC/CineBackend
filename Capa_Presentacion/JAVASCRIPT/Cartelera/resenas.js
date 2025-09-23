document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.estrella-seleccionable');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            // Marcar la estrella clickeada y todas las anteriores
            stars.forEach((s, i) => {
                if (i <= index) {
                    s.classList.add('seleccionada');
                } else {
                    s.classList.remove('seleccionada');
                }
            });
            
            // Actualizar el valor del radio button
            document.querySelectorAll('input[name="calificacion"]').forEach((radio, i) => {
                radio.checked = (i === index);
            });
        });
    });
});

function verResenas(idPelicula) {
    window.location.href = 'Capa_Presentacion/PHP/Modulo-Cartelera/resenas.php?id=' + idPelicula;
}