<?php
global $wpdb;
$table_name = $wpdb->prefix . 'wp_comments';


// Retrieve all feedback data

$results = $wpdb->get_results("SELECT * FROM wp_comments where comment_type='feedback'");

// Check if there are any results
if ($results) {
	echo"<div class='mero_fb' id='mero-fb'>";
	echo '<form method="post" action=""> <table class="output_table">';
	echo '<tr><th>Comment ID </th><th>Name</th><th>Email</th><th>Feedback</th><th> Please Tick for Testimonials </th></tr>';
	foreach ($results as $row) {
		echo '<tr>';
		echo '<td>' . esc_html($row->comment_ID) . '</td>';
		echo '<td>' . esc_html($row->comment_author) . '</td>';
		echo '<td>' . esc_html($row->comment_author_email) . '</td>';
		echo '<td><input type="text" value="' . esc_html($row->comment_content) . '"</td>';
// *************** Check if best comment to display in checkbox ************************************************
		if ($row->best_comment){
			echo '<td><input type="checkbox" checked="checked" id=" '.esc_html($row->comment_ID) .'" name="best[]" value="'.esc_html($row->comment_ID) .' "></td>';
			}
		else{
		echo '<td><input type="checkbox" id=" '.esc_html($row->comment_ID) .'" name="best[]" value="'.esc_html($row->comment_ID) .'"></td>';
		}

		//echo '<td><input type="submit" id=" '.esc_html($row->comment_ID) .'" name="'.esc_html($row->comment_ID) .'" value="Best Feedback"></td>';
		//echo '<td><input type="submit" name="delete1" value="Delete-'.esc_html(($row->comment_ID)).'" </td>';
		echo '</tr>';
	}

	echo ' </table> <h3>Please Choose the Comment for Testimonials</h3> <br><input type="submit" name="best_feedback" value="Update for Testimonials "></form></div>';

} else {
	echo '<p> FEEDBACK RECORD NOT FOUND </p>';
}

//************************* Delete comment*****************************************
//if (isset($_POST['delete1'])){
//	$delete_id = preg_replace('/[^0-9]/', '', $_POST['delete1']);
//
//$deleted_comment=wp_delete_comment($delete_id,true);
////var_dump($deleted_comment);
//echo' Successfully  Deleted'. $delete_id;
//
//}
// **********************  Add column in wp_comments table to update best comment  *************************
if(!isset($table_name->best_comment)){
	$wpdb->query("ALTER TABLE wp_comments ADD best_comment int(2) NOT NULL DEFAULT 0");
}
//**********************************************************************************************************
// ************************* Update for the testimonials ***************************
if (isset($_POST['best_feedback'])){
	$test_data  = $wpdb->query("UPDATE wp_comments SET best_comment = '0'");
	echo '<script>location.reload();</script>';
	if(!empty($_POST['best'])) {
		foreach($_POST['best'] as $value){
			echo 'checked on'. $value;
			$test_data  = $wpdb->query("UPDATE wp_comments SET best_comment = '1' WHERE comment_ID = '$value'");
		}
	}
	echo '<script>location.reload();</script>';
}