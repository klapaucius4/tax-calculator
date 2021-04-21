<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       michalkowalik.pl
 * @since      1.0.0
 *
 * @package    Tax_Calculator
 * @subpackage Tax_Calculator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tax_Calculator
 * @subpackage Tax_Calculator/public
 * @author     Michał Kowalik <kontakt@michalkowalik.pl>
 */
class Tax_Calculator_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	 /**
	 * The short domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $short_domain    The short domain version of this plugin.
	 */
	private $short_domain;


	public function __construct( $plugin_name, $version, $short_domain ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->short_domain = $short_domain;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tax_Calculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tax_Calculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tax-calculator-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tax_Calculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tax_Calculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tax-calculator-public.js', array( 'jquery' ), $this->version, false );

	}


	public function register_shortcode(){
		// var_dump($this->short_domain.'_calculator_form'); exit;
		add_shortcode($this->short_domain.'_calculator_form', array($this, 'calculator_form'));
	}


	public function calculator_form($atts, $content = null){
		if ( isset( $_POST['submit'] ) ) {
			$post = array(
				'post_type' => $this->short_domain.'_calculation',
				// 'post_content' => strip_tags($_POST['content']), 
				'post_title'   => $_POST['title'],
				'post_status' => 'publish'
			);
			$id = wp_insert_post( $post, $wp_error );
		}
		?> 
		<form class="tc-form" method = "post">
			<div class="tc-form__row">
				<input type="text" name="title">
			</div>
			<div class="tc-form__row">
				<input type="text" name="content">
			</div>
			<div class="tc-form__row">
				<input type="submit" name="submit">
			</div>
		</form>
		<?php
	}

}
