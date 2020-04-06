<?php

/**
 * plugin installer
 */
function inax_installer() {

    $default_options = include INAX_DIR . 'inax-config.php';
    add_option('inax_options', json_encode($default_options));
    
    $current_version = inax_get_plugin_version();
    add_option('inax_version',$current_version ) OR update_option('inax_version', $current_version );
    add_option('inax_do_activation', true) OR update_option('inax_do_activation', true );
}
/* =================================================================== */

add_action('upgrader_process_complete','inax_updater');

/**
 * plugin update
 */
function inax_updater() {
    $current_ver = inax_get_plugin_version();
    if($current_ver != get_option('inax_version')){
        inax_installer();
    }
}
/* =================================================================== */

/**
 * init function
 * @global type $inax_option
 */
function inax_init() {
    global $inax_option;
    $db_options 	= get_option('inax_options');
    $inax_option 	= json_decode($db_options, TRUE);
}
/* =================================================================== */

/**
 * Setup language text domain
 */
load_plugin_textdomain('inax', false, basename(dirname(__FILE__)).'/languages');
/* =================================================================== */

/**
 * Setup plugin page option link
 */
function inax_add_settings_link( $links ) {
    $settings_link = '<a href="'.menu_page_url('inax_admin_page',FALSE).'">'.__('setting','inax').'</a>';
    Array_unshift( $links, $settings_link );
    return $links;
}
/* =================================================================== */

/**
 * Enqueue styles & scripts
 * @see http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
 */
// site -------------------------
//add_action('wp_enqueue_scripts', 'inax_reg_css_and_js');
//function inax_reg_css_and_js() {
//    wp_register_style('inax_reg_style', plugins_url('assets/css/style.css', __FILE__));
//    wp_enqueue_style('inax_reg_style');
//    wp_enqueue_script('inax_reg_js', plugins_url('assets/js/js.js', __FILE__), array('jquery'));
//}
//admin -------------------------
/*
add_action('admin_enqueue_scripts', 'inax_reg_admin_css_and_js');

function inax_reg_admin_css_and_js() {
    global $inax_option;
    wp_register_style('inax_reg_admin_style', plugins_url('assets/css/admin.css', __FILE__));
    wp_enqueue_style('inax_reg_admin_style');
    
    if (isset($inax_option['inax_admin_style']) && $inax_option['inax_admin_style']){
        wp_register_style('inax_reg_custom_admin_style', plugins_url('assets/css/admin_style.css', __FILE__));
        wp_enqueue_style('inax_reg_custom_admin_style');
    }
    
    add_editor_style(plugins_url('assets/css/wysiwyg.css', __FILE__));
    wp_enqueue_script('inax_reg_date_js', plugins_url('assets/js/date.js', __FILE__));
    if (isset($inax_option['afghan_month_name']) && $inax_option['afghan_month_name'])
        wp_enqueue_script('inax_reg_admin_js', plugins_url('assets/js/admin-af.js', __FILE__), array('jquery'));
    else
        wp_enqueue_script('inax_reg_admin_js', plugins_url('assets/js/admin-ir.js', __FILE__), array('jquery'));
}

//theme editiong style -----------------
add_action('admin_print_styles-plugin-editor.php', 'inax_reg_theme_editor_css_and_js', 11);
add_action('admin_print_styles-theme-editor.php', 'inax_reg_theme_editor_css_and_js', 11);

function inax_reg_theme_editor_css_and_js() {
    wp_register_style('inax_reg_theme_editor_style', plugins_url('assets/css/theme_editing.css', __FILE__));
    wp_enqueue_style('inax_reg_theme_editor_style');
}*/

/* =================================================================== */

//include css & js to wordpress header
add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
function callback_for_setting_up_scripts() {
    wp_register_style( 'namespace',  plugins_url('/inc/templates/css/bootstrap.my.css',__FILE__ ) );
	wp_register_style( 'my_style',  plugins_url('/inc/templates/css/style.css',__FILE__ ) );
    wp_enqueue_style( 'namespace' ); 
	wp_enqueue_style( 'my_style' );
	
    //wp_enqueue_script( 'namespaceformyscript', plugins_url('/inc/templates/js/jquery-1.12.3.min.js',__FILE__ ) , array( 'jquery' ) );
	wp_enqueue_script( 'namespaceformyscript', plugins_url('/assets/js/jquery-1.12.3.min.js',__FILE__ ) );
	wp_enqueue_script( 'inax_bootstrap', plugins_url('/assets/js/bootstrap.min.js',__FILE__ ) );
}

//ajax js file
add_action( 'wp_enqueue_scripts', 'inax_ajax_scripts' );
function inax_ajax_scripts(){
	wp_register_script( 'ajaxHandle', plugins_url('/assets/js/check_bill_ajax.js',__FILE__ ), array(), false, true );
	wp_enqueue_script( 'ajaxHandle' );
	wp_localize_script('ajaxHandle', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

//string check_bill at the end of wp_ajax_check_bill & wp_ajax_nopriv_check_bill must be some as in check_bill_ajax.js action parameter value
add_action( "wp_ajax_check_bill", "check_ajax_function" );
add_action( "wp_ajax_nopriv_check_bill", "check_ajax_function" );
function check_ajax_function(){ 
	require_once INAX_DIR.'inc'.DIRECTORY_SEPARATOR.'ajax_check_bill.php';
	//echo json_encode( array( "error_msg"=>'ddddddddddddddd' ) ); 
	wp_die(); // ajax call must die to avoid trailing 0 in your response
}
//ajax

function inax_plugin( $content ){
	global $wpdb, $inax_option;
	
	//$mysqli = $wpdb;
	//global $wp_query;
	//print_r($wp_query);
	//$post_id	= $wp_query->post->ID;
	//$pagename 	= $wp_query->pagename;
	
	/*
	///if ( is_page() || is_archive() )
			
		$post = get_post();
 		if ( is_page() ) {
			echo 'aaaaaaaaaaaaaaaaaaa';
		} else {
			echo 'bbbbbbbbbbbbbbbbbbbbb';
		}
	*/
	/*$srvr ='';
	foreach($_SERVER as $key => $server){
		$srvr .= "$key = $server" . "<br/>";
	}*/
	//error_log( ' -------- SERVER -------- '. print_r($srvr,true) ) ;
	
		
	//عدم نمایش خرید شارژ در ویرایشگر مدیریت وردپرس
	//عدم ورود به این بخش در حین ذخیره نوشته
	if( !isset($_GET['action']) && (strpos($_SERVER['HTTP_REFERER'], 'action=edit')===false) ){

		//اگر در متن نوشته عبارت های زیر باشد
		if( ( strpos($content, '[topup]')!==false || strpos($content, '[pin]')!==false || strpos($content, '[bill]')!==false || strpos($content, '[internet]')!==false ) ){
			//require_once( dirname( __FILE__ ) .'/load.php' );
			require_once INAX_DIR.'inc'.DIRECTORY_SEPARATOR.'load.php';

			if( $inax_option['username']=='' || $inax_option['password']=='' ){
				$content .= 'لطفا ابتدا از تنظیمات پلاگین آینکس نام کاربری و پسورد خود را وارد نمائید.';
			}else{
				if( strpos($content, '[topup]')!==false ){
					include( dirname( __FILE__ ) . '/inc/topup.php' );
				}
				else if( strpos($content, '[pin]')!==false ){
					include( dirname( __FILE__ ) . '/inc/pin.php' );
				}
				else if( strpos($content, '[bill]')!==false ){
					include( dirname( __FILE__ ) . '/inc/bill.php' );
				}
				else if( strpos($content, '[internet]')!==false ){
					include( dirname( __FILE__ ) . '/inc/internet.php' );
				}
			}
			
			//remove [topup], ... from content
			$content = str_replace( array("[topup]","[pin]","[bill]","[internet]") ,array("","","",""), $content, $matches);
		}
	}
    return $content;
}
add_filter( 'the_content', 'inax_plugin' );