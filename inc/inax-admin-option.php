<?php
/**
 * admin options page
 */
global $inax_option;
?>

<div class="wrap">
    <h2><?php _e('wp persian option', 'inax'); ?></h2>
    <div class="inax_option_logo">
        <a href="http://wp-persian.com" target="_BLANK" title="وردپرس فارسی">
            <img src="<?php echo plugins_url('/assets/img/inax-80x80.png', dirname(__FILE__)); ?>" />
        </a>
    </div>

    <form method="post">
        <?php wp_nonce_field('inax_save_options'); ?> 
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="username">نام کاربری</label></th>
                    <td>
						<input type="text" name="username" dir="ltr" size="35" value="<?php echo ( esc_attr($inax_option['username'] ) ); ?>" />
                    </td>
                </tr> 
				<tr>
                    <th scope="row"><label for="password">پسورد</label></th>
                    <td>
						<input type="text" name="password" dir="ltr" size="35" value="<?php echo esc_attr( $inax_option['password'] ); ?>" />
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" value="ذخیره تغییرات" class="button button-primary" id="save_wper_options" name="save_wper_options">
        </p>
    </form>
</div>
<?php 
/*
function inax_admin_page_fn1() {
?>
<div class="wrap">
	<h1>تنظیمات آینکس</h1>
	<!-- action="options.php" -->
	<form method="post" >
		<?php settings_fields( 'inax-settings-group' ); ?>
		<?php do_settings_sections( 'inax-settings-group' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">نام کاربری وب سرویس</th>
				<td><input type="text" name="username" value="<?php echo esc_attr( get_option('username') ); ?>" /></td>
			</tr>
			 
			<tr valign="top">
				<th scope="row">پسورد وب سرویس</th>
				<td><input type="text" name="password" value="<?php echo esc_attr( get_option('password') ); ?>" /></td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php }*/

/*function inax_admin_save_option_page_fn2() {
    global $inax_admin_page;
    $screen = get_current_screen();
    if ($screen->id != $inax_admin_page)
        return;
    
    //remove admin notices in first check options
    delete_option('inax_do_activation');
    remove_action('admin_notices', 'inax_admin_message');
    
    if (isset($_POST['save_wper_options'])) {
        global $inax_option;
        check_admin_referer('inax_save_options');
        $inax_option = array(
            'username' => $_POST['username'],
            'password' => $_POST['password'],
        );
		print_r($_POST);
		
        update_option('inax_options', json_encode($inax_option)) OR add_option('inax_options', json_encode($inax_option));
    }
}*/


function inax_help_page_fn() {
//    wp_enqueue_style( 'wp-pointer' );
//    wp_enqueue_script( 'wp-pointer' );
    include INAX_DIR . 'inc' . DIRECTORY_SEPARATOR . 'inax-help-page.php';
}

?>