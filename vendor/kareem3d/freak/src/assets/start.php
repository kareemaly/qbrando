<?php

// bootstrap
Asset::add('bootstrap', 'bootstrap/css/bootstrap.min.css', '', false, 'all');

// uniform
Asset::add('uniform', 'plugins/uniform/css/uniform.default.css');

// jquery ui
Asset::add('jquery-ui', 'assets/jui/css/jquery-ui.css');
Asset::add('jquery-ui-custom', 'assets/jui/jquery-ui.custom.css');
Asset::add('jquery-ui-timepicker', 'assets/jui/timepicker/jquery-ui-timepicker.css');


////////////////////////////////////////////////////////////////////////////////////////////


// Core scripts
Asset::add('jquery', 'assets/js/libs/jquery-1.8.3.min.js');
Asset::add('jquery', 'bootstrap/js/bootstrap.min.js');
Asset::add('jquery', 'assets/js/libs/jquery.placeholder.min.js');
Asset::add('jquery', 'assets/js/libs/jquery.mousewheel.min.js');


//Customizer, remove if not needed
Asset::add('customizer', 'assets/js/customizer.js');

//Uniform Script
Asset::add('uniform', 'plugins/uniform/jquery.uniform.min.js');
    
//jquery-ui Scripts
Asset::add('jquery-ui', 'assets/jui/js/jquery-ui-1.9.2.min.js');
Asset::add('jquery-ui-custom', 'assets/jui/jquery-ui.custom.min.js');
Asset::add('jquery-ui-timepicker', 'assets/jui/timepicker/jquery-ui-timepicker.min.js');
Asset::add('jquery-ui-touch-punch', 'assets/jui/jquery.ui.touch-punch.min.js');