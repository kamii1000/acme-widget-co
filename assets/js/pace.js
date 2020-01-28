// import pace.js
window.paceOptions = {
    ajax: {
        trackMethods: ['POST', 'GET']
    }
};
import 'pace-js/themes/blue/pace-theme-minimal.css';

const pace = require('pace-js');
pace.start();
