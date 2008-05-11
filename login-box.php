<?php
/*
Plugin Name: Login-box
Plugin URI: http://danillonunes.net/wordpress/login-box
Version: 2.0 alpha
Description: Inserts in all pages a hidden login box, that you can open pressing Ctrl + E (or Alt + E)
Author: Marcus Danillo
Author URI: http://danillonunes.net
*/

/*  Copyright 2008 Marcus Danillo  (email : mdanillo@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Get the Login-box definitions
@include "login-box-config.php";
include "login-box-options.php";

// The primary Login-box function
function loginbox($force = false) {

// Login-box is showed only if the user isn't logged, of course
// The constant
if (!is_user_logged_in() && (!defined("LB_USED") || $force)) {

?>


<!-- Start Login-Box -->
	<form id="loginbox" action="<?php bloginfo('wpurl'); ?>/wp-login.php" method="post">
		<fieldset>
			<legend id="loginbox_title"><?php _e('Login'); ?></legend>
			<p id="loginbox_username">
				<label><?php _e('Username:'); ?><br />
				<input type="text" name="log" id="user_login" class="loginbox_text" value="" /></label>
			</p>
			<p id="loginbox_password">
				<label><?php _e('Password:'); ?><br />
				<input type="password" name="pwd" id="user_pass" class="loginbox_text" value="" /></label>
			</p>
			<p id="loginbox_rememberme">
				<label><input name="rememberme" type="checkbox" id="rememberme" class="loginbox_checkbox" value="forever" /><?php _e('Remember Me'); ?></label>
			</p>
			<p id="loginbox_submit"><input type="submit" class="loginbox_button" value="<?php _e('Login'); ?> &raquo;" /></p>
			<input type="hidden" name="redirect_to" value="<?php if (LB_BACKTOPAGE) echo $_SERVER['REQUEST_URI']; else { bloginfo('wpurl'); echo '/wp-admin'; }?>" />
		</fieldset>
	</form>
<!-- End Login-Box -->


<?php
if (!defined("LB_USED")) define("LB_USED", true);
}
}

function loginbox_script() {
$scriptfile = LB_THEME."/scripts.js";
header("Content-type: text/javascript");
header("Cache-control: public");
header("Pragma: cache");

include "login-box-script.js";
if (file_exists($scriptfile)) include $scriptfile;
die();
}

function loginbox_style() {
$stylefile = LB_THEME."/style.css";
header("Content-type: text/css");
header("Cache-control: public");
header("Pragma: cache");
if (file_exists($stylefile)) include $stylefile;
die();
}

function loginbox_head() {
if (!is_user_logged_in()) { ?>


<!-- Start Login-Box -->
<?php wp_print_scripts('jquery'); ?>
<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/login-box/login-box.php?script=<?php echo LB_THEME; ?>"></script>
<link rel="stylesheet" href="<?php bloginfo('wpurl'); ?>/wp-content/plugins/login-box/login-box.php?style=<?php echo LB_THEME; ?>" type="text/css" media="screen" />
<!-- End Login-Box -->


<?php
}
}

if (empty($_COOKIE[TEST_COOKIE])) setcookie(TEST_COOKIE, 'WP Cookie check');

if (array_key_exists('script', $_GET)) {
if (defined("LB_WPDIR")) require LB_WPDIR . "wp-config.php";
else require "../../../wp-config.php";
	loginbox_script();
}
if (array_key_exists('style', $_GET)) {
if (defined("LB_WPDIR")) include LB_WPDIR . "wp-config.php";
else include "../../../wp-config.php";
	loginbox_style();
}

add_action('wp_head', 'loginbox_head');
add_action('wp_footer', 'loginbox');

include "login-box-widget.php";
?>