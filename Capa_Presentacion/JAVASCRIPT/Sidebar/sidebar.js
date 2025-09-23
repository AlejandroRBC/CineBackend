document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.sidebar-menu a');
    const sidebar = document.querySelector('.sidebar');
    
    const toggleBtn = document.getElementById('toggleSidebar');
    const toggleBtn2 = document.getElementById('toggleSidebar_2');

    toggleBtn2.addEventListener('click', () => {
        sidebar.classList.remove('oculto');
    });

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('oculto');
    });
    menuItems.forEach(item => {
        item.addEventListener('click', function() {

            menuItems.forEach(i => i.classList.remove('seleccion_activa'));

            this.classList.add('seleccion_activa');
        });
    });
});