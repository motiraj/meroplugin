<?php
global $wpdb;
$table_name = $wpdb->prefix . 'wp_comments';

// Retrieve all feedback data
$results = $wpdb->get_results("SELECT * FROM wp_comments where comment_type='feedback'");

// Check if there are any results
if ($results) {
	echo '<form method="post" action=""> <table>';
	echo '<tr><th>Comment ID </th><th>Name</th><th>Email</th><th>Feedback</th><th> Check the comment </th><th> Delete </th></tr>';
	foreach ($results as $row) {
		echo '<tr>';
		echo '<td>' . esc_html($row->comment_ID) . '</td>';
		echo '<td>' . esc_html($row->comment_author) . '</td>';
		echo '<td>' . esc_html($row->comment_author_email) . '</td>';
		echo '<td><input type="text" value="' . esc_html($row->comment_content) . '"</td>';
		echo '<td><input type="checkbox" id=" '.esc_html($row->comment_ID) .'" name="vehicle1" value="check"></td>';
		echo '<td><input type="submit" name="delete1" value="Delete-'.esc_html(($row->comment_ID)).'" </td>';
		echo '</tr>';
	}
	echo '</table></form>';

} else {
	echo '<p>No feedback found.</p>';
}


if (isset($_POST['delete1'])){
	$delete_id = preg_replace('/[^0-9]/', '', $_POST['delete1']);

$deleted_comment=wp_delete_comment($delete_id,true);
//var_dump($deleted_comment);
echo' Successfully  Deleted'. $delete_id;

}
