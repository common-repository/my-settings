<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

function mys_delete_plugin() {
	global $wpdb;

	$table_name = $wpdb->prefix . "options";

	$wpdb->query( "DELETE FROM $table_name WHERE option_name LIKE 'mys_%'" );
}

mys_delete_plugin();

?>