<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ericsonweah.dev
 * @since             1.0.0
 * @package           Friend
 *
 * @wordpress-plugin
 * Plugin Name:       Friend
 * Plugin URI:        https://https://github.com/plugins-wordpress/friend
 * Description:       Social Network Friend Plugin
 * Version:           1.0.0
 * Author:            Ericson Weah Dev
 * Author URI:        https://ericsonweah.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       friend
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
define( 'FRIEND_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-friend-activator.php
 */
function activate_friend() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-friend-activator.php';
	Friend_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-friend-deactivator.php
 */
function deactivate_friend() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-friend-deactivator.php';
	Friend_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_friend' );
register_deactivation_hook( __FILE__, 'deactivate_friend' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-friend.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_friend() {

	$plugin = new Friend();
	$plugin->run();

}
run_friend();
