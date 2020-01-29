/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// import main scss file which includes globally needed scss e.g. bootstrap,etc
import '../scss/app.scss';

// Set jQuery globally
const $ = require('jquery');
global.$ = global.jQuery = $;

// import pace.js
import 'pace-js/themes/blue/pace-theme-minimal.css';

const pace = require('pace-js');
pace.start();

/************ Import Libraries ************/
require('bootstrap');
import 'select2';
import './custom';


