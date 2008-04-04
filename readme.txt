=== Login-box ===
Tags: admin, login, signin
Requires at least: 2.2
Tested up to: 2.5
Stable tag: trunk

Login-box inserts in all your pages a "lightbox style" login form, that can be opened with Ctrl + E making faster the authentication process.

== Description ==

Login-box is a WordPress plugin that inserts in all your pages a login form, making faster the authentication process. As the Login-box is hidden, it doesn’t draws attention of your readers to this part of the blog that doesn’t interest them, but, for you (and the others editors of your blog), becomes quite practical to be opened with a simple combination of keys.

The Login-box presents a visual identical to the default login page of WordPress, but it can be easily modified with themes.

== Installation ==

This section describes how to install the plugin and get it working.

1. Extract the downloaded file and move the login-box folder to the plug-ins directory of WordPress (normally localized at <wordpress_direcorty>/wp-content/plugins/).
2. In the WordPress admin, access “Plug-ins” area and activate the Login-box plug-in.
3. Optional: if your WordPress theme doesn't have the wp_head hook, open *header.php* and put this code into &lt;head&gt; and &lt;/head&gt;: '&lt;?php wp_head(); ?&gt;'
4. Optional: if your WordPress theme doesn't have the wp_footer hook, open *footer.php* and put them: '&lt;?php wp_footer(); ?&gt;'

== Frequently Asked Questions ==

= Login-box don't be showed / Login-box appear in the footer without style =

Try logout. Login-box doesn't work if you are *already* logged.

= Can open/close the Login-box with a link? =

Yes. Just use the link syntax:

'&lt;a href="http://www.myblog.com/wp-login.php" **rel="loginbox-toggle"**&gt;Make the box!&lt;/a&gt;'

== Options ==

Open login-box.php in a text editor or in embbed WordPress Plug-in editor, and find this lines:

11. @define("LB_THEME", "**wpclassic**");

In this line, put the name of the theme that you like to use. You can download new themes on web or make your theme based in the default "wpclassic".

14. @define("LB_KEY", "**e**");

Choose the key (case insensitive) that will be open/close Login-box with Ctrl or Alt. Note that some keys executes especial functions in your browser (and in browser of your readers!). and them will be cancelled by Login-box. (e.g. Ctrl + A selects all). I recommend that you leave the default value "e".

19. @define("LB_CTRL", **true**);

Also, you can define false here and deactivate the Ctrl use of Login-box. So, you can put "a" in LB_KEY, and open Login-box with Alt + A. Ctrl + A will be selects all normally.

23. @define("LB_BACKTOPAGE", **true**);

Here, choose on you will be redirected when success login. If true, you will be back to the actual page; if false, you will be redirected to the WordPress Dashboard.