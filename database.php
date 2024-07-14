<?php
global $wpdb;
$table_name = $wpdb->prefix . 'wp_comments';

// Retrieve all feedback data
$results = $wpdb->get_results("SELECT * FROM wp_comments where comment_type='feedback'");

// Check if there are any results
if ($results) {
	echo '<form method="post" action=""> <table>';
	echo '<tr><th>Comment ID </th><th>Name</th><th>Email</th><th>Feedback</th><th> Check the comment </th><th> Best Feedback</th><th> Delete Feedback</th></tr>';
	foreach ($results as $row) {
		echo '<tr>';
		echo '<td>' . esc_html($row->comment_ID) . '</td>';
		echo '<td>' . esc_html($row->comment_author) . '</td>';
		echo '<td>' . esc_html($row->comment_author_email) . '</td>';
		echo '<td><input type="text" value="' . esc_html($row->comment_content) . '"</td>';
		echo '<td><input type="checkbox" id=" '.esc_html($row->comment_ID) .'" name="best[]" value="'.esc_html($row->comment_ID) .'"></td>';
		echo '<td><input type="submit" id=" '.esc_html($row->comment_ID) .'" name="'.esc_html($row->comment_ID) .'" value="Best Feedback"></td>';
		echo '<td><input type="submit" name="delete1" value="Delete-'.esc_html(($row->comment_ID)).'" </td>';
		echo '</tr>';
	}
	echo ' </table> <input type="submit" name="best_feedback" value="Update Best Feedback"></form>';

} else {
	echo '<p>No feedback found.</p>';
}


if (isset($_POST['delete1'])){
	$delete_id = preg_replace('/[^0-9]/', '', $_POST['delete1']);

$deleted_comment=wp_delete_comment($delete_id,true);
//var_dump($deleted_comment);
echo' Successfully  Deleted'. $delete_id;

}

// Add column in wp_comments table to update best comment
if(!isset($table_name->best_comment)){
	$wpdb->query("ALTER TABLE wp_comments ADD best_comment int(2) NOT NULL DEFAULT 0");
}
if (isset($_POST['best_feedback'])){
	//echo "Hello You are clicked on best feedback button";
	if(!empty($_POST['best'])) {

		foreach($_POST['best'] as $value){
			//echo "value : ".$value.'<br/>';
			$test_data  = $wpdb->query("UPDATE wp_comments SET best_comment = '1' WHERE comment_ID = '$value'");
			if(!$test_data){
				echo"unable to update data";
			}
			else{
				echo "Successfully Updated";
			}

		}

	}
}