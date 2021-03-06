<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              michalkowalik.pl
 * @since             1.0.0
 * @package           Tax_Calculator
 *
 * @wordpress-plugin
 * Plugin Name:       Tax Calculator
 * Plugin URI:        tax-calculator.michalkowalik.pl
 * Description:       Simple plugin for the calculation of VAT. Prepared as the recruitment task.
 * Version:           1.0.0
 * Author:            Michał Kowalik
 * Author URI:        michalkowalik.pl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tax-calculator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TAX_CALCULATOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tax-calculator-activator.php
 */
function activate_tax_calculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tax-calculator-activator.php';
	Tax_Calculator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tax-calculator-deactivator.php
 */
function deactivate_tax_calculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tax-calculator-deactivator.php';
	Tax_Calculator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tax_calculator' );
register_deactivation_hook( __FILE__, 'deactivate_tax_calculator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tax-calculator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tax_calculator() {

	$plugin = new Tax_Calculator();
	$plugin->run();

}
run_tax_calculator();
