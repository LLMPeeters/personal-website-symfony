import './styles/bootstrap.scss';
import 'jquery';
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
const bootstrap = require('bootstrap');
const navLinks = document.querySelectorAll(`.nav-link`);

for(const navLink of navLinks) {
    if(navLink.getAttribute(`href`) === window.location.pathname) {
        navLink.classList.add(`active`, `bg-light`, `border`, `border-info`, `rounded-1`);
    }
}

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});