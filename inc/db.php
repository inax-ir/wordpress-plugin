<?php
# https://codex.wordpress.org/Creating_Tables_with_Plugins
global $inax_db_version;
$inax_db_version = '1.0';

function inax_install() {
	global $wpdb;
	global $inax_db_version;

	$inax_charge = $wpdb->prefix . 'inax_charge';

	//$charset_collate = $wpdb->get_charset_collate();//DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
	$charset_collate = 'DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci';
	if($wpdb->get_var( "show tables like '$inax_charge'" ) != $inax_charge){
		$sql = "CREATE TABLE IF NOT EXISTS $inax_charge (
			id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			client_id int(10) UNSIGNED NOT NULL DEFAULT '0',
			type enum('','topup','pin','internet') COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			platform enum('','client_area','telegram') COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			mobile char(11) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			email varchar(100) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			product_type varchar(10) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			amount int(10) UNSIGNED NOT NULL DEFAULT '0',
			order_id int(10) UNSIGNED NOT NULL DEFAULT '0',
			check_charge varchar(10) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			payment_type enum('','online','credit') COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			ref_code varchar(100) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			res_code varchar(100) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			status enum('unpaid','paid') COLLATE utf8_persian_ci NOT NULL DEFAULT 'unpaid',
			date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			pay_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			pay_result text COLLATE utf8_persian_ci NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	$inax_bill = $wpdb->prefix . 'inax_bill';
	if($wpdb->get_var( "show tables like '$inax_bill'" ) != $inax_bill){
		$sql = "CREATE TABLE IF NOT EXISTS $inax_bill (
			id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			client_id int(10) UNSIGNED NOT NULL DEFAULT '0',
			bill_id varchar(100) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			pay_id varchar(100) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			mobile char(11) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			bill_type varchar(100) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			pay_type enum('','online','panel') COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			url text COLLATE utf8_persian_ci NOT NULL,
			amount int(10) UNSIGNED NOT NULL DEFAULT '0',
			date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			pay_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			refcode varchar(200) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
			check_bill_result text COLLATE utf8_persian_ci NOT NULL,
			pay_bill_result text COLLATE utf8_persian_ci NOT NULL,
			status enum('unpaid','paid') COLLATE utf8_persian_ci NOT NULL DEFAULT 'unpaid',
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	add_option( 'inax_db_version', $inax_db_version );
}
register_activation_hook( INAX_Main_File_Path , 'inax_install' );

//insert data to databse
/*
function inax_install_data() {
	global $wpdb;
	
	$welcome_name = 'Mr. WordPress';
	$welcome_text = 'Congratulations, you just completed the installation!';
	
	$table_name = $wpdb->prefix . 'inax_charge';
	
	$wpdb->insert(
		$table_name,
		array( 
			'time' => current_time( 'mysql' ), 
			'name' => $welcome_name, 
			'text' => $welcome_text, 
		) 
	);
}
register_activation_hook( INAX_Main_File_Path , 'inax_install_data' );
*/

//delete databse whene delete plugins
function inax_remove_database() {
    global $wpdb;
	$inax_charge = $wpdb->prefix . 'inax_charge';
    $wpdb->query( "DROP TABLE IF EXISTS $inax_charge" );
	
	$inax_bill = $wpdb->prefix . 'inax_bill';
    $wpdb->query( "DROP TABLE IF EXISTS $inax_bill" );
	
    delete_option("inax_options");
	delete_option("inax_version");
	delete_option("inax_db_version");
	delete_option("inax_do_activation");
}   
//register_deactivation_hook( INAX_Main_File_Path , 'inax_remove_database' );
register_uninstall_hook(INAX_Main_File_Path , 'inax_remove_database');


//update databse
function plugin_update() {
    global $wpdb, $inax_db_version;
    if ( get_option( 'inax_db_version' ) != $inax_db_version ){
		$inax_charge = $wpdb->prefix . 'inax_charge';
		$wpdb->query( "ALTER TABLE $inax_charge CHANGE date date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';");
		update_option( "inax_db_version", $inax_db_version );
	}
}
add_action( 'plugins_loaded', 'plugin_update' );

/*
global $wpdb;
$installed_ver = get_option( "inax_db_version" );
if ( $installed_ver != $inax_db_version ) {
	$inax_charge = $wpdb->prefix . 'inax_charge';
	$wpdb->query( "ALTER TABLE $inax_charge CHANGE date date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';");
	update_option( "inax_db_version", $inax_db_version );
}*/

 // change the global $inax_db_version variable
function myplugin_update_db_check() {
    global $inax_db_version;
    if ( get_site_option( 'inax_db_version' ) != $inax_db_version ) {
        jal_install();
    }
}
add_action( 'plugins_loaded', 'myplugin_update_db_check' );
