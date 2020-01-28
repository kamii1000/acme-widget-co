/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Set jQuery globally
const $ = require('jquery');
global.$ = global.jQuery = $;

/************ Import Libraries ************/

import './js/pace';

import 'bootstrap'; // Import Bootstrap JS

import '@fortawesome/fontawesome-free/js/all';

import 'select2';
import 'select2/dist/css/select2.css';

import 'animate.css/animate.min.css';

import './scss/app.scss';

import './js/custom'
