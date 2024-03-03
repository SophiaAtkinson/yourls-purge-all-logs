<?php
/*
Plugin Name: Purge All Logs
Plugin URI: https://github.com/SophiaAtkinson/yourls-purge-all-logs
Description: Purges all logs for YOURLS
Version: 1.0
Author: Sophia Atkinson
Author URI: https://sophia.wtf
*/

// Register the plugin admin page
yourls_add_action('plugins_loaded', 'purge_all_logs_add_page');

function purge_all_logs_add_page()
{
    yourls_register_plugin_page('purge_logs', 'Purge Logs', 'purge_all_logs_page_display');
}

// Display the plugin page content
function purge_all_logs_page_display()
{
    // Check if the form is submitted
    if (isset($_POST['purge_logs'])) {
        // Call the function to purge logs
        purge_all_logs();
    }

    echo '<h2>Purge <strong>All</strong> Logs</h2>';
    echo '<p><strong>Warning:</strong> This action is irreversible and will permanently delete all logs in Yourls. It is highly recommended to take a database snapshot before proceeding.</p>';
    echo '<form id="purge-logs-form" method="post">';
    echo '<input type="submit" name="purge_logs" value="Purge Logs" onclick="return confirmPurgeLogs();">';
    echo '</form>';
    echo '<script>
    function confirmPurgeLogs() {
        return confirm("This action is irreversible and will permanently delete ALL YOURLS logs. Are you sure you want to proceed?");
    }
    </script>';
}

// Function to purge all logs
function purge_all_logs()
{
    global $ydb;

    // Check if the user is authorized to perform this action (optional)
    // For example, you might check for admin privileges here

    // Purge all logs from the database
    $delete_logs = $ydb->query("DELETE FROM `" . YOURLS_DB_TABLE_LOG . "`");

    // Check if the logs were successfully purged
    if ($delete_logs) {
        yourls_add_notice('success', 'Logs purged successfully!');
    } else {
        yourls_add_notice('error', 'Failed to purge logs.');
    }
}
?>
