/**/ 

document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.querySelector('.toggle_btn');
    const toggleBtnIcon = document.querySelector('.toggle_btn i');
    const dropDownMenu = document.querySelector('.dropdown_menu');
    const menuItems = document.querySelectorAll('.dropdown_menu li');

    toggleBtn.addEventListener('click', function () {
        dropDownMenu.classList.toggle('open');
        const isOpen = dropDownMenu.classList.contains('open');
        toggleBtnIcon.className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
    });

    menuItems.forEach(item => {
        item.addEventListener('click', function () {
            dropDownMenu.classList.remove('open');
            toggleBtnIcon.className = 'fa-solid fa-bars';
        });
    });

    // Cerrar menú automáticamente al cambiar el tamaño de la pantalla
    window.addEventListener('resize', function () {
        if (window.innerWidth > 992) {
            dropDownMenu.classList.remove('open');
            toggleBtnIcon.className = 'fa-solid fa-bars';
        }
    });
});
