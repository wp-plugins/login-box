/* Show and hide */
function loginbox_show() {
	<?php if (LB_FADE) echo 'jQuery("#loginbox").fadeIn();';
	else echo 'jQuery("#loginbox").show();'; ?>

	jQuery("#user_login").focus();
}
function loginbox_hide() {
	<?php if (LB_FADE) echo 'jQuery("#loginbox").fadeOut();';
	else echo 'jQuery("#loginbox").hide();'; ?>

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
