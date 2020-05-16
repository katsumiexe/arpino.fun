<?php
require_once( ABSPATH . WPINC . '/wp-db.php' );
class my_wpdb extends wpdb {
	var $tables = array( 'posts', 'comments', 'links', 'options', 'postmeta', 'terms', 'term_taxonomy', 'term_relationships', 'termmeta', 'commentmeta' , 'table_name' , '0cast');
}

if ( ! isset($wpdb) ) {
    $wpdb = new my_wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
}