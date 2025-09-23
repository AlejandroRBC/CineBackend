document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.estrella-seleccionable');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {

            stars.forEach((s, i) => {
                if (i <= index) {
                    s.classList.add('seleccionada');
                } else {
                    s.classList.remove('seleccionada');
                }
            });

            document.querySelectorAll('input[name="calificacion"]').forEach((radio, i) => {
                radio.checked = (i === index);
            });
        });
    });
});

function verResenas(idPelicula) {
    window.location.href = 'Capa_Presentacion/PHP/Modulo-Cartelera/resenas.php?id=' + idPelicula;
}