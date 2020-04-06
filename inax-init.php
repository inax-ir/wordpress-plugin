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

add_action('admin_enqueue_scripts', 'inax_reg_admin_css_and_js');

function inax_reg_admin_css_and_js() {
	//global $inax_option;
    wp_register_style('inax_reg_admin_style', plugins_url('inc/templates/css/admin.css', __FILE__));
    wp_enqueue_style('inax_reg_admin_style');
}


/* =================================================================== */

//include css & js to wordpress header
add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
function callback_for_setting_up_scripts() {
    wp_register_style( 'bootstrap', plugins_url('/inc/templates/css/bootstrap.my.css',__FILE__ ) );
	wp_enqueue_style('bootstrap'); 
	
	wp_register_style( 'my_style',  plugins_url('/inc/templates/css/style.css',__FILE__ ) );
	wp_enqueue_style( 'my_style' );
	
	wp_register_style( 'font_awesome',  plugins_url('/inc/templates/font-awesome-4.7.0/css/font-awesome.min.css',__FILE__ ) );
	wp_enqueue_style( 'font_awesome' );
    
    //wp_enqueue_script( 'namespaceformyscript', plugins_url('/inc/templates/js/jquery-1.12.3.min.js',__FILE__ ) , array( 'jquery' ) );
	wp_enqueue_script( 'namespaceformyscript', plugins_url('/inc/templates/js/jquery-1.12.3.min.js',__FILE__ ) );
	wp_enqueue_script( 'inax_bootstrap', plugins_url('/inc/templates/js/bootstrap.min.js',__FILE__ ) );
}

//ajax js file
add_action( 'wp_enqueue_scripts', 'inax_ajax_scripts' );
function inax_ajax_scripts(){
	wp_register_script( 'ajaxHandle', plugins_url('/inc/templates/js/check_bill_ajax.js',__FILE__ ), array(), false, true );
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


/*
//create page in top of wordpress header
add_action( 'template_redirect', 'which_page_is' );
function which_page_is() {
	global $wpdb, $inax_option,$wp_query;
	if( is_page( array( 'topup', 'pin', 'internet', 'bill') ) ){
		require_once INAX_DIR.'inc'.DIRECTORY_SEPARATOR.'load.php';
		
		if( $inax_option['username']=='' || $inax_option['password']=='' ){
			$content .= 'لطفا ابتدا از تنظیمات پلاگین آینکس نام کاربری و پسورد خود را وارد نمائید.';
		}else{
			if( is_page('topup') ){
				require_once( dirname( __FILE__ ) . '/inc/topup.php' );
			}
			elseif( is_page('pin') ){
				require_once( dirname( __FILE__ ) . '/inc/pin.php' );
			}
			elseif( is_page('bill') ){
				require_once( dirname( __FILE__ ) . '/inc/bill.php' );
			}
			elseif( is_page('internet') ){
				require_once( dirname( __FILE__ ) . '/inc/internet.php' );
			}
		}
	}
}*/



/*
add_filter('template_include', 'my_page');
function my_page($template){
	global $wpdb, $inax_option,$wp_query;
	//print_r($wp_query);
	//echo $post_content = $wp_query->post->post_content;
	
	if( is_page( array( 'topup', 'pin', 'internet', 'bill') ) ){
		require_once INAX_DIR.'inc'.DIRECTORY_SEPARATOR.'load.php';
		
		if( $inax_option['username']=='' || $inax_option['password']=='' ){
			$content .= 'لطفا ابتدا از تنظیمات پلاگین آینکس نام کاربری و پسورد خود را وارد نمائید.';
		}else{
			get_header(); 
			if( is_page('topup') ){
				require_once( dirname( __FILE__ ) . '/inc/topup.php' );
			}
			elseif( is_page('pin') ){
				require_once( dirname( __FILE__ ) . '/inc/pin.php' );
			}
			elseif( is_page('bill') ){
				require_once( dirname( __FILE__ ) . '/inc/bill.php' );
			}
			elseif( is_page('internet') ){
				require_once( dirname( __FILE__ ) . '/inc/internet.php' );
			}
			get_footer(); 
		}
	}else{
		return $template;
	}
}*/

function inax_plugin( $content ){
	global $wpdb, $inax_option;
	
	//$mysqli = $wpdb;
	//global $wp_query;
	
	//عدم نمایش خرید شارژ در ویرایشگر مدیریت وردپرس
	//عدم ورود به این بخش در حین ذخیره نوشته
	/*$display_page = true;
	if( isset($_GET['action']) || (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'action=edit')===false) ){
		$display_page=false;
	}
	
	if( $display_page ){
	*/
	if( is_page() || is_single() ){
		//error_log(print_r($_SERVER,true) );

		//اگر در متن نوشته عبارت های زیر باشد
		if( ( strpos($content, '[topup]')!==false || strpos($content, '[pin]')!==false || strpos($content, '[bill]')!==false || strpos($content, '[internet]')!==false ) ){
			require_once INAX_DIR.'inc'.DIRECTORY_SEPARATOR.'load.php';

			if( $inax_option['username']=='' || $inax_option['password']=='' ){
				$content .= 'لطفا ابتدا از تنظیمات پلاگین آینکس نام کاربری و پسورد خود را وارد نمائید.';
			}else{
				if( strpos($content, '[topup]')!==false ){
					//print_r($smarty);
					require_once( dirname( __FILE__ ) . '/inc/topup.php' );
				}
				else if( strpos($content, '[pin]')!==false ){
					require_once( dirname( __FILE__ ) . '/inc/pin.php' );
				}
				else if( strpos($content, '[bill]')!==false ){
					require_once( dirname( __FILE__ ) . '/inc/bill.php' );
				}
				else if( strpos($content, '[internet]')!==false ){
					require_once( dirname( __FILE__ ) . '/inc/internet.php' );
				}
			}
			
			//remove [topup], ... from content
			$content = str_replace( array("[topup]","[pin]","[bill]","[internet]") ,array("","","",""), $content, $matches);
		}
	}
   return $content;
}
add_filter( 'the_content', 'inax_plugin' );
