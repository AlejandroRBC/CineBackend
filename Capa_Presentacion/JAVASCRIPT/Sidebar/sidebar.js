document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.sidebar-menu a');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remover clase seleccion_activa de todos los items
            menuItems.forEach(i => i.classList.remove('seleccion_activa'));
            // Agregar clase seleccion_activa al item clickeado
            this.classList.add('seleccion_activa');
        });
    });
});