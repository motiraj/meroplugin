<?php
/*
Plugin Name:  Mero Plugin
Plugin URI:   https://www.meroplugin.com
Description:  Mero plugin is belogngs to me. It is the practice plugin to enhance knowledge of PHP and Plubin
Version:      1.0
Author:       Moti Raj Gautam
Author URI:   https://www.meroplugin.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpb-tutorial
Domain Path:  /languages
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function my_enqueued_assets() {
	//wp_enqueue_script('my-js-file', plugin_dir_url(__FILE__) . '/js/script.js', '', time());
	wp_enqueue_style('my-css-file', plugin_dir_url(__FILE__) . '/css/style.css', '', time());
}
add_action('wp_enqueue_scripts', 'my_enqueued_assets');
function my_plugin_menu() {

    // Add the new admin menu and page and save the returned hook suffix
    $hook_suffix = add_menu_page('Mero Plugin', 'Mero Plugin Dashboard', 'manage_options', 'my-plugin', 'myplugin');

    // Add a submenu to the main menu
    add_submenu_page('my-plugin', 'Feedback Data', 'Feedback Data', 'manage_options', 'my-plugin-settings', 'pgsetting');
}

add_action('admin_menu', 'my_plugin_menu');
global $wpdb;
Global $duplicate_comment;
$table_name = $wpdb->prefix . 'wp_comments';

function myplugin()
{
	echo ("This is my Plugin Page");
}
function pgsetting()
{
	include ('database.php');
	//echo "This is my Plugin Settings  Page";
}


function my_custom_shortcode() {
ob_start();
	echo '<div> <h1> Feedback </h1></div>';
	echo'<div id="userform" nam="userform"> <form method="POST" action="">';
	echo'<label for="user_name"> Name: </label><br>';
	echo'<input type="text" id="user_name" name="user_name"><br>';
	echo'<label for="user_email"> Email ID : </label><br>';
	echo'<input type="email" id="user_email" name="user_email" ><br>';
	echo'<label for="story"> Feedback: </label><br>';
	echo'<textarea id="story" name="story" rows="5" cols="33"> Your Valuable Feedback</textarea><br>';
	echo'<input type="submit" name="submitt" value="SUBMIT">';
	echo'</form> </div>';
	//=====================================================================
	if (isset($_POST['submitt'])){
		$username= trim($_POST['user_name']);
		$useremail= trim($_POST['user_email']);
		$userfeedback= trim($_POST['story']);
//-----------------------------------------------------
		$commentdata = array(
			'comment_post_ID' => 0, // Use 0 if you are not associating this with a specific post
			'comment_author' => $username,
			'comment_author_email' => $useremail,
			'comment_author_url' => '',
			'comment_content' => $userfeedback,
			'comment_type' => 'feedback', // Custom comment type
			'comment_parent' => 0,
			'user_id' => get_current_user_id(),
		);
//================================================================

// Retrieve all feedback data
		$results = $wpdb->get_results("SELECT * FROM wp_comments where comment_type='feedback'");
		// Check in existing data in database
		foreach ($results as $comment) {
			if (trim($comment->comment_content) == trim($userfeedback) and trim($comment->comment_author_email) == trim($useremail) ) {
				$duplicate_comment==TRUE;
				echo"Duplicate Record Found";
				return ob_get_clean();
				break;
		}
		}

		if (empty($username) || empty($useremail) || empty($userfeedback)) {
			echo "<p style='color: red;'>All fields are required. There was a problem saving your feedback. Please try again.</p>";
		}

			elseif( $duplicate_comment == FALSE ) {
			$comment_id = wp_insert_comment($commentdata);
			$duplicate_comment==TRUE;
			echo "<p style='color: green;'>Thank you for your feedback!</p>";
		}
		else
		{
			echo $duplicate_comment;
		//	echo "<p style='color: red;'>Duplicate Feedback form Same User</p>";
		}
	}
	return ob_get_clean();
	}




add_shortcode('my_shortcode', 'my_custom_shortcode');

//add_action('init',save_feedback());

function my_testimoinals() {
	ob_start();

	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM wp_comments WHERE comment_type='feedback' AND best_comment='1'");
		if ($results) {
		echo '<div class="testimonial-container">';
		foreach ($results as $row) {
			echo '<div class="testimonial">';
			echo '<p>' . esc_html($row->comment_author) . '</p>';
			echo '<p>' . esc_html($row->comment_content) .'</p>';
			echo '</div>';
		}
		echo '</div>';
		return ob_get_clean();
	}
}






add_shortcode('testimonials', 'my_testimoinals');


