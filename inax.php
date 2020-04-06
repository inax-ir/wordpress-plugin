<?php
/*
Plugin Name: افزونه خرید شارژ و پرداخت قبض آینکس
Plugin URI:  https://inax.ir/wordpress-plugin
Description: توسط این پلاگین میتوانید امکان خرید شارژ، بسته اینترنت و پرداخت قبض را به وب سایت خود اضافه کرده و کسب درآمد کنید.
Version:     1.0
Author:      Mohammad Moradpour
Author URI:  https://inax.ir
Text Domain: inax
Domain Path: /languages
*/

# Copyright 2005-2020  Wordpress inax  (email : info@inax.ir)
# 
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
# 
# 
# Contributors:
#
# Since 1.0:
#       Mohamamd Moradpour
#

/*
 * define plugin dir
 */
defined('INAX_DIR') or define('INAX_DIR',  dirname(__FILE__).DIRECTORY_SEPARATOR);
defined('INAX_DIR2') or define('INAX_DIR2',  dirname(__FILE__));
defined('INAX_Main_File_Path') or define('INAX_Main_File_Path',  __FILE__ );//inc/db.php
//echo $plugins_url 		= plugins_url('/inc', __FILE__);


defined('plugins_img_url') or define('plugins_img_url',  plugins_url('/inc/templates/images', __FILE__ ));
/* =================================================================== */

/**
 * include structor
 */
include INAX_DIR.'inax-functions.php';
include INAX_DIR.'inax-config.php';
include INAX_DIR.'inax-init.php';
/* =================================================================== */

/**
 * include libs
 */
include INAX_DIR.'inc'.DIRECTORY_SEPARATOR.'db.php';
//require_once( dirname( __FILE__ ) .'/db.php' );
/* =================================================================== */

/**
 * initialize...
 */
inax_init();
register_activation_hook(__FILE__, 'inax_installer');
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'inax_add_settings_link' );
/* =================================================================== */

/**
 * include admin stuff
 */
include INAX_DIR.'inc'.DIRECTORY_SEPARATOR.'inax-admin.php';
/* =================================================================== */
?>