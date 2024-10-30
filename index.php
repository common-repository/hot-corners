<?php
/*
Plugin name: Hot Corners
Plugin URI: 
Author: Richard Keller
URI: http://richardkeller.net
Version: 1.1
Description: Replace the WP Admin bar with invisible corner menus. 
*/
require('activation.php');
require('_hc-settings.php'); 	// Setting page output and scripts
require('_hc-functions.php'); 	// Functions to assist: ajax, other
require('_hc-output.php'); 		// Adds corners and items to page
?>