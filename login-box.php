<?php
/*
Plugin Name: Login-box
Plugin URI: http://danillonunes.net/wordpress/login-box
Version: 1.0
Description: Inserts in all pages a hidden login box, that you can open pressing Ctrl + E (or Alt + E)
Author: Marcus Danillo
Author URI: http://danillonunes.net
*/
// /* UNCOMMENT HERE (REMOVE THIS LINE) TO EDIT OPTIONS MANUALLY
@define("LB_THEME", "wp25");
// Type the Login-box theme

@define("LB_KEY", "e");
// Choose the key (case insensitive) that will be open/close Login-box with Ctrl or Alt
// Note that this will be cancel the default function of the Ctrl/Alt + key of the browser
// Ex: If you choose A, users cannot use Ctrl + A to select all texts in your blog

@define("LB_CTRL", true);
// Also, you can disable Ctrl + key functions in Login-box defining this as false
// So, Login-box only will be open with Alt + key

@define("LB_BACKTOPAGE", true);
// true: When login, you will be redirected to the actual page
// false: When login, you will be redirected to the WordPress Dashboard

@define("LB_FADE", true);
// true: Show/hide Login-box with fadeIn/fadeOut
// false: Without fadeIn/fadeOut
// */


// YOU CAN STOP EDIT BELOW THIS LINE

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

function loginbox($force = false) {
if (!is_user_logged_in() && (!defined("LB_USED") || $force)) { ?>


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
				<label><input name="rememberme" type="checkbox" id="rememberme" class="loginbox_checkbox" value="forever" /><?php _e('Remember me'); ?></label>
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
header("Pragma: cache"); ?>

/* Show and hide */
function loginbox_show() {
	<?php if (LB_FADE)	echo 'jQuery("#loginbox").fadeIn();';
	else						echo 'jQuery("#loginbox").show();'; ?>

	jQuery("#user_login").focus();
}
function loginbox_hide() {
	<?php if (LB_FADE)	echo 'jQuery("#loginbox").fadeOut();';
	else						echo 'jQuery("#loginbox").hide();'; ?>

}
function loginbox_toggle() {
	if (jQuery("#loginbox").css("display") == "none") {
		loginbox_show();
	}
	else {
		loginbox_hide();
	}
}

/* The close button */
/* This button is added with javascript because without javascript we not need him ;) */
jQuery(function() {
	jQuery("#loginbox").prepend("<p id='loginbox_close'><input type='button' value='<?php _e("close"); ?>' class='loginbox_button'/></p>");
	jQuery("#loginbox_close input").click(function() {
		loginbox_hide();
	});
});

/* On key press... */
/* Made with a bit of Visual jQuery (http://visualjquery.com) */
jQuery(document).keydown(function(e) {
	var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	key = "["+key+"]";
	lbkey = "[<?php echo ord(strtolower(LB_KEY)) ?>][<?php echo ord(strtoupper(LB_KEY)) ?>]";
	lbauxkey = e.altKey<?php if (LB_CTRL) echo " || e.ctrlKey" ?>;
	lbkey.indexOf(key) != -1 ? keye = true : keye = false;
	if (keye && lbauxkey) {
		loginbox_toggle();
		return false;
	};
});

/* On link[rel=loginbox-toggle] clicked... */
jQuery(function() {
	jQuery("[rel*='loginbox-toggle']").click(function(){
		loginbox_toggle();
		return false;
	});
});
<?php
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
	@include "../../../wp-config.php";
	loginbox_script();
}
if (array_key_exists('style', $_GET)) {
	@include "../../../wp-config.php";
	loginbox_style();
}

add_action('wp_head', 'loginbox_head');
add_action('wp_footer', 'loginbox');
?>