import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener("DOMContentLoaded", () => {

    const menuButton = document.getElementById("menuButton");

    const sidebar = document.getElementById("sidebar");

    menuButton?.addEventListener("click", () => {

        sidebar.classList.toggle("-translate-x-full");

    });

});
