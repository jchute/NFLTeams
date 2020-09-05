<?php
   /*
   Plugin Name: NFL Teams
   Plugin URI: 
   description: A plugin created to prove ability to code a solution to a problem.
   Version: 1.0
   Author: Jonathan Chute
   Author URI: https://www.linkedin.com/in/jonathan-chute-417482ba/
   License: 
   */

// Constants
define( '__NFLTEAMS_DIR_URL__', plugin_dir_url( __FILE__ ) );
define( '__NFLTEAMS_DIR_PATH__', plugin_dir_path( __FILE__ ) );

require_once( __NFLTEAMS_DIR_PATH__ . '/includes/admin-page.php' );
require_once( __NFLTEAMS_DIR_PATH__ . '/includes/shortcode.php' );
require_once( __NFLTEAMS_DIR_PATH__ . '/includes/helpers.php' );

// Enqueue scripts
function nflteams_enqueue() {

    wp_enqueue_style( 'nflteams-style', __NFLTEAMS_DIR_URL__ . '/resources/style.css' );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'nflteams-script', __NFLTEAMS_DIR_URL__ . '/resources/script.js', array(), false, true );

}
add_action( 'wp_enqueue_scripts', 'nflteams_enqueue' );
