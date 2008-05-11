<?php
function loginbox_options() {
	// First, get the options from WordPress database
	$options = get_option('loginbox');

	// If Login-box options are empty, get the default values
	if ($options == '') {
		loginbox_set_default_options();
		$options = get_option('loginbox');
	}

	// If a from was sended, update the options
	if ($_POST['submit']) {
		$newoptions['theme'] = strip_tags(stripslashes($_POST['loginbox-theme']));
		$newoptions['key'] = strip_tags(stripslashes($_POST['loginbox-key']));
		$newoptions['ctrl'] = strip_tags(stripslashes($_POST['loginbox-ctrl']));
		$newoptions['backtopage'] = strip_tags(stripslashes($_POST['loginbox-backtopage']));
		$newoptions['fade'] = strip_tags(stripslashes($_POST['loginbox-fade']));

		// Merge new and old options
		// To use a unique database key for LB options and LB widget options
		$newoptions = array_merge($options, $newoptions);
		update_option('loginbox', $newoptions);

		// ...and show a nice message to user
		echo '<div class="updated"><p><strong>'.__('Options saved.').'</strong></p></div>';
	}

    echo '<div class="wrap">';
    echo '<h2>Login-box</h2>';
?>
<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">

<p>
<strong><?php _e('Login-box theme', 'login-box'); ?></strong>

<?php
function loginbox_get_themes() {
	$options = get_option('loginbox');
	$olddir = getcwd();
	chdir(ABSPATH.'/wp-content/plugins/login-box');
	if ($dh = opendir('.')) {
		while (($file = readdir($dh)) !== false) {
			if (is_file($file.'/style.css')) { ?>
				<br/>
				<label>
				<input type="radio" name="loginbox-theme" value="<?php echo $file; ?>"
				<?php if ($options['theme'] == $file) echo 'checked="checked"'; ?>
				>
				<?php echo $file; ?>
				</label>
				<?php
			}
		}
	closedir($dh);
	}
	chdir($olddir);
}

loginbox_get_themes();
?>
</p>

<p>
<label><?php _e('Open with <strong>Alt</strong> +', 'login-box'); ?> 
<input type="text" name="loginbox-key" value="<?php echo $options['key']; ?>" size="1">
</label>

<br/>
<label>
<input type="checkbox" name="loginbox-ctrl" value="1" <?php if ($options['ctrl']) echo 'checked="checked"'; ?>>
<?php printf(__('Also open with <strong>Ctrl</strong> + <span>%s</span>', 'login-box'), $options['key']); ?>
</label>
</p>

<p>
<strong><?php _e('When login', 'login-box'); ?></strong>,

<br/>
<label>
<input type="radio" name="loginbox-backtopage" value="1" <?php if ($options['backtopage']) echo 'checked="checked"'; ?>>
<?php _e('Back to page', 'login-box'); ?>
</label>

<br/>
<label>
<input type="radio" name="loginbox-backtopage" value="0" <?php if ($options['backtopage'] == 0) echo 'checked="checked"'; ?>>
<?php _e('Go to Dashboard', 'login-box'); ?>
</label>
</p>

<p>
<label>
<input type="checkbox" name="loginbox-fade" value="1" <?php if ($options['fade']) echo 'checked="checked"'; ?>>
<?php _e('Use <strong>fadeIn/fadeOut</strong> effects', 'login-box'); ?>
</label>
</p>

<hr />
<p class="submit">
<input type="submit" id="submit" name="submit" value="<?php _e('Update Options »') ?>" />
</p>

</form>
</div>

<?php
}

// Add the function above as a new page in WordPress panel
function loginbox_add_page() {
	add_submenu_page('themes.php', 'Login-box', 'Login-box', 'edit_themes', 'login-box', 'loginbox_options');
}

add_action('admin_menu', 'loginbox_add_page');

// Function to set default options and update in database
function loginbox_set_default_options() {
	$options['theme']      = 'wp25';
	$options['key']        = 'E';
	$options['ctrl']       = '1';
	$options['backtopage'] = '1';
	$options['fade']       = '1';

	update_option('loginbox', $options);
}

// Now, defines the options as constants, to be used by Login-box core
function loginbox_set_options() {
	$options = get_option('loginbox');

	if (!defined('LB_THEME'))      define("LB_THEME", $options['theme']);
	if (!defined('LB_KEY'))        define("LB_KEY", $options['key']);
	if (!defined('LB_CTRL'))       define("LB_CTRL", $options['ctrl']);
	if (!defined('LB_BACKTOPAGE')) define("LB_BACKTOPAGE", $options['backtopage']);
	if (!defined('LB_AUTO'))       define("LB_AUTO", true);
}

loginbox_set_options();
?>
