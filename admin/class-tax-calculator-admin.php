<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       michalkowalik.pl
 * @since      1.0.0
 *
 * @package    Tax_Calculator
 * @subpackage Tax_Calculator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tax_Calculator
 * @subpackage Tax_Calculator/admin
 * @author     Michał Kowalik <kontakt@michalkowalik.pl>
 */
class Tax_Calculator_Admin {

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
	 * The short domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $short_domain    The short domain version of this plugin.
	 */
	private $short_domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $short_domain ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->short_domain = $short_domain;
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tax-calculator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tax-calculator-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function cpt_init(){
		/// registering post type "tc_calculation"
		register_post_type($this->short_domain.'_calculation', array(
			'labels' => array(
				'name'          => __('Calculations', 'maspex'),
				'singular_name' => __('Calculation', 'maspex'),
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'has_archive' => __('products', 'maspex'), 
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array( 'title' ),
			'menu_icon' => 'dashicons-calculator',
			)
		);
	}


	public function register_meta_box() {
		add_meta_box( $this->short_domain.'_calculation_meta_box', __( 'Calculation data', 'tc' ), array($this, 'display_calculation_data'), $this->short_domain.'_calculation' );
	}


	public function display_calculation_data(){
		global $post;
		echo '<p>' . __('Product name:') . ' <strong>' . get_post_meta($post->ID, 'product_name', true) . '</strong></p>';
		echo '<p>' . __('Net amount:') . ' <strong>' . get_post_meta($post->ID, 'net_amount', true) . '</strong></p>';
		echo '<p>' . __('Currency:') . ' <strong>' . get_post_meta($post->ID, 'currency', true) . '</strong></p>';
		echo '<p>' . __('VAT rate:') . ' <strong>' . get_post_meta($post->ID, 'vat_rate', true) . '</strong></p>';

		echo '<p>' . __('Client IP address:') . ' <strong>' . get_post_meta($post->ID, 'ip_address', true) . '</strong></p>';
	}

}
