<?php
/*
Plugin Name: WP Calculator App
Version: 0.1
Plugin URI: https://github.com/yumashev/simple-calcx
Description: Just insert shortcode [simple-calcx] to any page. Calculcator based on jQuery Calx.
Author: Anatoly Yumashev
Author URI: https://github.com/yumashev/
*/

class UDP_Calculator_App {

  public function __construct(){
      add_shortcode( 'simple-calcx', array($this, 'make_shortcode') );
      add_action( 'wp_enqueue_scripts', array($this, 'load_scripts'), $priority = 10, $accepted_args = 1 );
  }

  /**
   * Load scripts
   */
  public function load_scripts(){

    //Can be add has_shortcode() for load scripts only for specific pages

    $script_url = plugin_dir_url( __FILE__ ) . 'inc/jquery-calx/jquery-calx-2.2.6.min.js';
    wp_enqueue_script( 'calx', $script_url, $deps = array('jquery'), $ver = '1.0', $in_footer = true );

    wp_add_inline_script( 'calx', $this->init_calc());

  }

  /**
   * Display script content for init Calx
   *
   * @return inline script content
   */
  public function init_calc(){
    return
    "jQuery( function( $ ) {
      $('#sheet').calx();
    });
    ";
  }

  /**
   * Make shortcode [udp_calc_test]
   *
   * @return return HTML for display
   */
  public function make_shortcode($attr)
  {
    ob_start();
    ?>
    <form id="sheet">

      <p>Use this simple calculator</p>

      <fieldset title="Calculate sum">
        <legend>Sum</legend>
        <input type="text" data-cell="A1" /><span>+</span>
        <input type="text" data-cell="A2" /><span>=</span>
        <input type="text" data-cell="A3" data-formula="SUM(A1:A2)" readonly />
      </fieldset>

      <fieldset title="Calculate Division">
        <legend>Division</legend>
        <input type="text" data-cell="B1" /><span>/</span>
        <input type="text" data-cell="B2" /><span>=</span>
        <input type="text" data-cell="B3" data-formula="B1/B2" readonly />
      </fieldset>

      <fieldset title="Calculate Multiplication">
        <legend>Multiplication</legend>
        <input type="text" data-cell="C1" /><span>x</span>
        <input type="text" data-cell="C2" /><span>=</span>
        <input type="text" data-cell="C3" data-formula="C1*C2" readonly />
      </fieldset>

    </form>
    <?php
    return ob_get_clean();
  }

}

$GLOBALS['udp_calculator_app'] = new UDP_Calculator_App;
