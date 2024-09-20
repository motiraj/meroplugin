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
	wp_enqueue_style('my-css-file', plugin_dir_url(__FILE__) . 'css/style.css', '', time());

}
add_action('wp_enqueue_scripts', 'my_enqueued_assets');
function my_plugin_menu() {

    // Add the new admin menu and page and save the returned hook suffix
  add_menu_page('Mero Plugin', 'Mero Plugin Dashboard', 'manage_options', 'my-plugin', 'myplugin');

    // Add a submenu to the main menu
    add_submenu_page('my-plugin', 'Feedback Data', 'Feedback Data', 'manage_options', 'my-plugin-settings', 'pgsetting');
}

add_action('admin_menu', 'my_plugin_menu');

global $wpdb;
Global $duplicate_comment;
$table_name = $wpdb->prefix . 'wp_comments';
global $testimonial_height;
// Testimoinals layout  setting in dashboard
 function testimonials_settings() {
	 echo '<h2>Testimonials Layout and Color Settings</h2>';
	 echo '<p>Testimonials Background Color</p>';
	 echo '<div class ="color_picker_background" id="color_picker_background"><input type="color" id="testimonial_background_color" name="testimonial_background_color"  value="#e66465" /> </div> ';
	 echo '<div>
  	<input type="range" id="testimonial_height" name="testimonial_height" min="0" max="1000" step="10" />
  	<label for="testimonial_height">Testimonial Height</label>
	</div>';
	 echo '<div>
  	<input type="range" id="testimonial_width" name="testimonial_width" min="0" max="1000"step="10" />
  	<label for="testimonial_height">Testimonial Width</label>
	</div>';
	 echo "<script>document.getElementById('testimonial_height').value</script>";
	 echo "<script>console.log(document.getElementById('testimonial_height').value)</script>";
 }

 // Short code page in dashboard
function myplugin()
{
	echo ("<h2>Feedback Form Short Code</h2>");
	echo ('<div class="shortcode" id="shortcode" name="shortcode"><h2>[my_shortcode]</h2></div><hr>');
	echo"<h2> Testimonials Short Code</h2>";
	echo "<h2>[testimonials]</h2><hr>'";
	testimonials_settings();
	echo'<div class="testimonials-container">';
	$image_path = plugin_dir_url( __FILE__ ) . 'img/image.png';
		echo '<div class="testimonials">';
		echo '<div class="testimonial">';
		echo '<div class="picture"> <img src='.$image_path.'></div>';
		echo '<p align="center"><b>' . ucwords('Mr. Same Sample') . '</b></p>';
		echo '<p> The Quick Brown Fox Jump Over the Lazy Dog. The Quick Brown Fox Jump Over the Lazy Dog. The Quick Brown Fox Jump Over the Lazy Dog. The Quick Brown Fox Jump Over the Lazy Dog.  </p>';
		echo '</div>';
		echo'</div>';


	echo '<style>
.testimonials-container {
   display:contents;
    }
.testimonials {
    width: 270px;
    height:300px;
    display: inline-flex;
    flex-wrap: wrap;
    background-color: #ffffff;
    border-radius: 20px;
    margin: 14px;
    /*box-shadow: 0 0 20px rgba(0,0,0,0.1);*/
}
.testimonial {
    border-bottom: 1px solid #eee;
    width: 270px;
    height:300px;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(12, 1, 1, 0.1);
}
.testimonial:hover{
    box-shadow: 0 0 15px rgba(17, 16, 16, 0.3);
    cursor: context-menu;
}
.picture {
    padding-top: 15px;
    text-align: center;
    image-rendering: crisp-edges;
}
.testimonial p {
    font-size: 15px;
    margin: 10px;
    line-height: 1.5;
    color: #333;
}
.testimonial img{
    height: 70px;
}
</style>';
}
// Testimonials layout css for dashboard setting
function custom_dashboard_css() {
	echo '<style>
.testimonials-container {
   display:contents;
    }
.testimonials {
    width: 270px;
    height:300px;
    display: inline-flex;
    flex-wrap: wrap;
    background-color: #ffffff;
    border-radius: 20px;
    margin: 14px;
    /*box-shadow: 0 0 20px rgba(0,0,0,0.1);*/
}
.testimonial {
    border-bottom: 1px solid #eee;
    width: 270px;
    height:300px;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(12, 1, 1, 0.1);
}
.testimonial:hover{
    box-shadow: 0 0 15px rgba(17, 16, 16, 0.3);
    cursor: context-menu;
}
.picture {
    padding-top: 15px;
    text-align: center;
    image-rendering: crisp-edges;
}
.testimonial p {
    font-size: 15px;
    margin: 10px;
    line-height: 1.5;
    color: #333;
}
.testimonial img{
    height: 70px;
}
</style>';
}

// Hook into the admin_head action to inject CSS into the admin dashboard
//add_action('admin_head', 'custom_dashboard_css');
//=========================================================================
function pgsetting()
{
	include ('database.php');
	//echo "This is my Plugin Settings  Page";
}

// Feedback Plugin Shordcode function
function my_custom_shortcode() {
	ob_start();
//	echo '<div> <h1> Feedback </h1></div>';
	echo '<div id="userform" name="userform"> <form method="POST" action="">';
	echo '<label for="author"> Name: </label><br>';
	echo '<input type="text" id="author" name="author"><br>';
	echo '<label for="email"> Email ID : </label><br>';
	echo '<input type="email" id="email" name="email" ><br>';
	echo '<label for="comment"> Feedback: </label><br>';
	//echo'<textarea class ="comment-form-comment"  id="comment" name="story" > Your Valuable Feedback</textarea><br>';
	echo '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="300" required=""></textarea>';
	echo '<br><input type="submit"  id="submit" class="wp-block-button__link wp-element-button"   name="submitt" value="SUBMIT">';
	echo '</form> </div>';
	if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
		$username     = trim( $_POST['author'] );
		$useremail    = trim( $_POST['email'] );
		$userfeedback = trim( $_POST['comment'] );
		//=====================================================================
		if ( isset( $_POST['submitt'] ) ) {

//-----------------------------------------------------
			$commentdata = array(
				'comment_post_ID'      => 0, // Use 0 if you are not associating this with a specific post
				'comment_author'       => $username,
				'comment_author_url'   => '',
				'comment_author_email' => $useremail,
				'comment_content'      => $userfeedback,
				'comment_type'         => 'feedback', // Custom comment type
				'comment_parent'       => 0,
				'user_id'              => get_current_user_id(),
			);
//================================================================
		}
// Retrieve all feedback data
		$results = $GLOBALS['wpdb']->get_results( "SELECT * FROM wp_comments where comment_type='feedback'" );
		// Check in existing data in database
		foreach ( $results as $comment ) {
			if ( trim( $comment->comment_content ) == trim( $userfeedback ) and trim( $comment->comment_author_email ) == trim( $useremail ) ) {
				$GLOBALS ['duplicate_comment'] == true;
				echo "Duplicate Record Found";

				return ob_get_clean();
				break;
			}
		}

		if ( empty( $username ) || empty( $useremail ) || empty( $userfeedback ) ) {
			echo "<p style='color: red;'>All fields are required. There was a problem saving your feedback. Please try again.</p>";
		} elseif ( $GLOBALS ['duplicate_comment'] == false ) {
			$comment_id = wp_insert_comment( $commentdata );
//			header("Location: " . $_SERVER['PHP_SELF']);
//			exit();
			$GLOBALS ['duplicate_comment'] == true;
			echo "<p style='color: green;'>Thank you for your feedback!</p>";
		} else {
			echo $GLOBALS ['duplicate_comment'];
			echo "<p style='color: red;'>Duplicate Data Found!</p>";
		}
	}
		return ob_get_clean();
	}

add_shortcode('my_shortcode', 'my_custom_shortcode');

//add_action('init',save_feedback());

// Testimonials shortcode function
function my_testimoinals() {
	ob_start();

	global $wpdb;

	$results = $wpdb->get_results("SELECT * FROM wp_comments WHERE comment_type='feedback' AND best_comment='1'");
		if ($results) {
			echo'<div class="testimonials-container">';

			$image_path = plugin_dir_url( __FILE__ ) . 'img/image.png';
		foreach ($results as $row) {
			echo '<div class="testimonials">';
			echo '<div class="testimonial">';
			echo '<div class="picture"> <img src='.$image_path.'></div>';
			echo '<div class="username" align="center"><b>' . ucwords( esc_html($row->comment_author) ). '</b></div>';
			echo '<p>' . esc_html($row->comment_content) .'</p>';
			echo '</div>';
			echo'</div>';

			}
			echo '</div>';
		return ob_get_clean();
	}
}
add_shortcode('testimonials', 'my_testimoinals');



