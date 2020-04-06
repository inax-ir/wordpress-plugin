<?php

/**
 * register admin menu
 * @see http://codex.wordpress.org/Administration_Menus
 */
add_action('admin_menu', 'inax_reg_admin_meun_fn');

function inax_reg_admin_meun_fn() {
    global $inax_admin_page;
    $inax_admin_page = add_menu_page(
            __('WP Jalali Options', 'inax'), // page title 
            __('WP Jalali', 'inax'), // menu title
            'manage_options', // user access capability
            'inax_admin_page', // menu slug
            'inax_admin_page_fn', //menu content function
            plugins_url('/assets/img/plugin-icon.png', dirname(__FILE__)), // menu icon
            82 // menu position
    );
    add_submenu_page('inax_admin_page', __('WP Jalali About', 'inax'), __('About', 'inax'), 'manage_options', 'inax_help_page', 'inax_help_page_fn1');
    add_action('load-' . $inax_admin_page, 'inax_admin_save_option_page_fn');
}

function inax_admin_page_fn() {
    include INAX_DIR . 'inc' . DIRECTORY_SEPARATOR . 'inax-admin-option.php';
}

function inax_help_page_fn1() {
//    wp_enqueue_style( 'wp-pointer' );
//    wp_enqueue_script( 'wp-pointer' );
    include INAX_DIR . 'inc' . DIRECTORY_SEPARATOR . 'inax-help-page.php';
}

function inax_admin_save_option_page_fn() {
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
        update_option('inax_options', json_encode($inax_option))
                OR add_option('inax_options', json_encode($inax_option));
    }
}

/**
 * after install actions
 */
add_action('admin_init', 'inax_after_install_actions');

function inax_after_install_actions() {
    $active = get_option('inax_do_activation');
    if ($active) {
        add_action('admin_notices', 'inax_admin_message');
    }
}

function inax_admin_message(){
    $Message=  sprintf( __('WP Jalali successful installed. please check %soptions%s','inax') ,'<a href="'.menu_page_url('inax_admin_page',FALSE).'">', '</a>' );
    echo '<div class="updated"><p>' . $Message . '</p></div>';
	//echo '<div class="error"><p>' . $Message . '</p></div>';
}



