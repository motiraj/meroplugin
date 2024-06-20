<?php
global $wpdb;
$table_name = $wpdb->prefix . 'wp_comments';

// Retrieve all feedback data
$results = $wpdb->get_results("SELECT * FROM wp_comments where comment_type='feedback'");

// Check if there are any results
if ($results) {
	echo '<table>';
	echo '<tr><th>Name</th><th>Email</th><th>Feedback</th></tr>';
	foreach ($results as $row) {
		echo '<tr>';
		echo '<td>' . esc_html($row->comment_author) . '</td>';
		echo '<td>' . esc_html($row->comment_author_email) . '</td>';
		echo '<td>' . esc_html($row->comment_content) . '</td>';
		echo '</tr>';
	}
	echo '</table>';
} else {
	echo '<p>No feedback found.</p>';
}