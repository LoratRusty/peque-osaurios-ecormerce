import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init({
  duration: 800,
  easing: 'ease-in-out',
  once: true,
});


import $ from 'jquery';
import 'datatables.net-dt';  // JS DataTables

$(document).ready(function () {
  $('.datatable').DataTable({
    responsive: true,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
    }
  });
});
