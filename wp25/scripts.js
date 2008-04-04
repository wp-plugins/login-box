jQuery(document).keydown(function() {
	/* works if  Login-box is showed */
	if (lbcrentd != true && jQuery("#loginbox").css("display") != "none") {
		lbboxwidth = 310;
		lbboxheight = 280;
		/* Centralizes the position of the box
		with the respectives width and height (in pixels) */	
		/* Made with a bit of jQuery plugin Dimensions */
		windowwidth = self.innerWidth ||
			jQuery.boxModel && document.documentElement.clientWidth ||
			document.body.clientWidth;
		windowheight = self.innerHeight ||
			jQuery.boxModel && document.documentElement.clientHeight ||
			document.body.clientHeight;
		lbposx = (windowwidth - lbboxwidth) /2;
		lbposy = (windowheight - lbboxheight) /2;
		jQuery("#loginbox").css({ left: lbposx + "px", top: lbposy + "px" });
		alert("ABROBRINHA");
		lbcrentd = true;
	}
});