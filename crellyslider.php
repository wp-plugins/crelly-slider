<?php

/**
 * Plugin Name: Crelly Slider
 * Plugin URI: http://fabiorino1.altervista.org/projects/crellyslider
 * Description: The first free WordPress slider with elements animations.
 * Version: 0.6.8
 * Author: fabiorino
 * Author URI: http://fabiorino1.altervista.org
 * License: GPL2
 */

/*************/
/** GLOBALS **/
/*************/ 

define('CS_VERSION', '0.6.8');
define('CS_PATH', plugin_dir_path(__FILE__));
define('CS_PLUGIN_URL', plugins_url() . '/crelly-slider');

require_once CS_PATH . 'wordpress/common.php';
require_once CS_PATH . 'wordpress/tables.php';
require_once CS_PATH . 'wordpress/frontend.php';

// Create (or remove) 3 tables: the sliders settings, the slides settings and the elements proprieties. We will also store the current version of the plugin			
register_activation_hook(__FILE__, array('CrellySliderTables', 'setVersion'));			
register_activation_hook(__FILE__, array('CrellySliderTables', 'setTables'));
register_uninstall_hook(__FILE__, array('CrellySliderTables', 'removeVersion'));
register_uninstall_hook(__FILE__, array('CrellySliderTables', 'dropTables'));

// Languages
load_plugin_textdomain('crellyslider', false, basename(dirname(__FILE__)) . 'wordpress/languages');

/****************/
/** COMMON CODE**/
/****************/

// CSS and Javascript
CrellySliderCommon::setEnqueues();

CrellySliderFrontend::addShortcode();

/****************/
/* BACKEND CODE */
/****************/

if(is_admin()) {	
	require_once CS_PATH . 'wordpress/admin.php';
	
	// Tables
	if(CS_VERSION != get_option('cs_version')) {
		CrellySliderTables::setVersion();
		CrellySliderTables::setTables();
	}
	
	CrellySliderAdmin::setEnqueues();
	CrellySliderAdmin::showSettings();
	
	// Ajax functions
	require_once CS_PATH . 'wordpress/ajax.php';	
}

?>