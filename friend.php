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


// Register the main plugin function,
//  which will be called when the plugin is activated. 
//  This function should register any custom post types,
//   taxonomies, and other functionality that your plugin provides. Here's an example:
function my_friend_plugin_init() {
	// Register a custom post type for friends
	register_post_type( 'friend', array(
	  'labels' => array(
		'name' => 'Friends',
		'singular_name' => 'Friend'
	  ),
	  'public' => true,
	  'has_archive' => true,
	  'supports' => array( 'title', 'editor', 'thumbnail' )
	) );
  }
  add_action( 'init', 'my_friend_plugin_init' );

  
/**
 * Implement the plugin functionality. In the case of a "Friend WordPress Plugin",
 *  this might involve creating a new "Add Friend" button on user profiles,
 *  or a form for searching and adding friends. Here's an example of how to 
 * create a shortcode that displays a list of a user's friends:
 */
  function my_friend_list_shortcode( $atts ) {
	$user_id = get_current_user_id(); // Get the ID of the current user
	$friends = get_posts( array(
	  'post_type' => 'friend',
	  'meta_query' => array(
		array(
		  'key' => 'friend_user_id',
		  'value' => $user_id,
		  'compare' => '='
		)
	  )
	) );
	ob_start(); // Start output buffering
	if ( $friends ) :
	?>
	<ul>
	  <?php foreach ( $friends as $friend ) : ?>
		<li><?php echo $friend->post_title; ?></li>
	  <?php endforeach; ?>
	</ul>
	<?php endif;
	$output = ob_get_clean(); // End output buffering and return the output
	return $output;
  }
  add_shortcode( 'my-friend-list', 'my_friend_list_shortcode' );
  

  /**
   * Create a new function to handle the "Add as Friend" button. This function will be responsible for creating a new "friend" post and adding the current user's ID as a custom field. Here's an example:
   */

   function my_add_friend() {
	if ( isset( $_GET['add_friend'] ) ) {
	  $friend_name = get_the_title(); // Get the name of the current post
	  $friend_id = wp_insert_post( array(
		'post_type' => 'friend',
		'post_title' => $friend_name,
		'post_status' => 'publish'
	  ) );
	  add_post_meta( $friend_id, 'friend_user_id', get_current_user_id() ); // Add the current user's ID as a custom field
	}
  }
  add_action( 'template_redirect', 'my_add_friend' );
  

  /**
   * Modify the template for the single post view to include an "Add as Friend" button. This button will include a query string parameter (?add_friend=1) that will trigger the my_add_friend function when clicked. Here's an example:

   */

   
  
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
