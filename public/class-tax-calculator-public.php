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
		$errorMessage = '';
		$successMessage = '';
		if ( isset( $_POST['submit'] ) ) {

			$validate = $this->validate_form_data($_POST);
			if($validate === true){
				$post = array(
					'post_type' => $this->short_domain.'_calculation',
					'post_title'   => strip_tags($_POST['product_name']),
					'post_status' => 'publish'
				);
				$postID = wp_insert_post( $post);

				$netAmount = strip_tags($_POST['net_amount']);
				$currency = strip_tags($_POST['currency']);
				$vatRate = strip_tags($_POST['vat_rate']);

				$grossAmount = number_format((float)($vatRate / 100 * $netAmount + $netAmount), 2, ',', '');
				$vatAmount = number_format((float)($vatRate / 100 * $netAmount), 2, ',', '');

				add_post_meta($postID, 'net_amount', $netAmount);
				add_post_meta($postID, 'currency', $currency);
				add_post_meta($postID, 'vat_rate', $vatRate);

				add_post_meta($postID, 'ip_address', Tax_Calculator_Helpers::get_current_ip_address());


				if($postID){
					$successMessage .= __('Gross product price is '. 'tc') . $grossPrice . ' ' . $currency;
					$successMessage .= ', ';
					$successMessage .= ', Vat amount is: '.$vatAmount . ' ' . $currency;
				}

			}else{
				$errorMessage = $validate;
			}


			
		}
		?>

		<?php if(!empty($successMessage)): ?>
			<div class="tc-form__msg--success"><?= $successMessage; ?></div>
		<?php else: ?>
		<form class="tc-form" method = "post">
			<div class="tc-form__row">
				<label><?= __('Product name', 'tc'); ?></label>
				<input type="text" name="product_name" required>
			</div>
			<div class="tc-form__row">
				<label><?= __('Net amount', 'tc'); ?></label>
				<input type="number" name="net_amount" required>
			</div>
			<div class="tc-form__row">
				<label><?= __('Currency', 'tc'); ?></label>
				<input type="text" name="currency" value="PLN" readonly>
			</div>
			<div class="tc-form__row">
				<label><?= __('VAT rate', 'tc'); ?></label>
				<select name="vat_rate" required>
					<option value="23">23%</option>
					<option value="22">22%</option>
					<option value="8">8%</option>
					<option value="7">7%</option>
					<option value="5">5%</option>
					<option value="3">3%</option>
					<option value="0">0%</option>
					<option value="vat-exempt"><?= __('VAT exempt', 'tc'); ?></option>
				</select>
			</div>
			<div class="tc-form__row">
				<input type="submit" name="submit" value="<?= __('Calculate', 'tc'); ?>">
			</div>

			<?php if(!empty($errorMessage)): ?>
			<div class="tc-form__msg--error"><?= $errorMessage; ?></div>
			<?php endif; ?>

		</form>
		<?php endif; ?>
		<?php
	}



	private function validate_form_data($data){
		if(!isset($data['product_name']) && !strip_tags($data['product_name'])){
			return __('the product_name field cannot be empty', 'tc');
		}
		if(!isset($data['net_amount']) && !strip_tags($data['net_amount'])){
			return __('the net_amount field cannot be empty', 'tc');
		}
		if(!isset($data['currency']) && !strip_tags($data['currency'])){
			return __('the currency field cannot be empty', 'tc');
		}
		if(!isset($data['vat_rate']) && !strip_tags($data['vat_rate'])){
			return __('the vat_rate field cannot be empty', 'tc');
		}

		return true;

	}

}
