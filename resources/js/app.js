import './bootstrap';
import './carousel'
import '../vendor/fontawesome/js/all';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
 // If you use Bootstrap 5
import './../../vendor/power-components/livewire-powergrid/dist/bootstrap5.css'
import flatpickr from "flatpickr";

document.addEventListener("DOMContentLoaded", function (event) {
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId),
            navName = document.querySelectorAll('.nav_icon')

        // Validate that all variables exist
        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener('click', () => {
                // show navbar
                nav.classList.toggle('show-nav')
                // change icon
                toggle.classList.toggle('bx-x')
                // add padding to body
                bodypd.classList.toggle('body-pd')
                // add padding to header
                headerpd.classList.toggle('body-pd')
                // show navbar
                navName.forEach(l => l.classList.toggle('tooltips'))
            })
        }
    }

    showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link')

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'))
            this.classList.add('active')
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink))

    document.querySelectorAll('.nav_icon').forEach(l => l.classList.add('tooltips'))
    // Your code to run since DOM is loaded and ready
});
