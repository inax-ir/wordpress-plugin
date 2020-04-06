<?php
//require_once( dirname( __FILE__ ) .'/function.php' );
require_once( dirname( __FILE__ ) .'/validation.php' );
require_once( dirname( __FILE__ ) .'/smarty-3.1.33/libs/SmartyBC.class.php' );

$validate = new SimaNet_Validate;

$smarty = new SmartyBC;

/*ini_set("display_errors", 1);
error_reporting(E_ALL); 
$smarty->debugging = false;*/

$smarty->setTemplateDir( dirname( __FILE__ ) . '/templates');
$smarty->setCompileDir( dirname( __FILE__ ) . '/templates_c');

//$plugins_url 		= plugins_url('', __FILE__);
//$plugins_img_url 	= plugins_url('/templates/images', __FILE__);
//$smarty->assign('plugins_url', $plugins_url );
$smarty->assign('plugins_img_url', plugins_img_url );

//ایجاد یک اینپوت مخفی برای جلوگیری از حمله csrf
//$wordpress_csrf = wp_nonce_field( 'name_of_my_action', 'Token',true,true );
$wordpress_csrf = wp_nonce_field( 'name_of_my_action', 'Token' ,true,false);
$smarty->assign('wordpress_csrf',$wordpress_csrf);

$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($mysqli,"utf8");
date_default_timezone_set("Asia/Tehran");

//افزونه فارسی ساز نصب نشده باشد یا فعال نباشد
if( !in_array('wp-jalali/wp-jalali.php', apply_filters('active_plugins', get_option('active_plugins'))) ){ 
    require_once( dirname( __FILE__ ) .'/jdf.php' );
}
?>