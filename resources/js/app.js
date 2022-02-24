require('./bootstrap');
try {
    window.bootstrap = require("bootstrap/dist/js/bootstrap.bundle.js");
} catch (e) { }
const feather = require('feather-icons');
feather.replace();
window.$ = window.jQuery = require("jquery");
require("jstree");
import { Notify } from 'notiflix/build/notiflix-notify-aio';
window.Notify = Notify;
