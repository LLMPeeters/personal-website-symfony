import './styles/bootstrap.scss';
import 'jquery';
import 'bootstrap';
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
// const $ = require('jquery');
// require('bootstrap');

const navLinks = document.querySelectorAll(`.nav-link`);

for(const navLink of navLinks) {
    if(navLink.getAttribute(`href`) === window.location.pathname) {
        navLink.classList.add(`active`, `bg-light`, `border`, `border-info`, `rounded-1`);
    }
}